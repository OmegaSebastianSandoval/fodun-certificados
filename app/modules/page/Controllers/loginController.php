<?php

/**
 *  Controlador de la página  login, logout
 */

class Page_loginController extends Page_mainController
{
  private $domain;
  protected $certJson;
  public function init()
  {
    if (Session::getInstance()->get('user')) {
      header('Location: /page/index/certificados');
    }
    $this->domain = Config_Config::getInstance()->getValue('api/url');
    parent::init();
  }
  public function indexAction()
  {
    set_time_limit(0);
    $this->setLayout('blanco');
    $nit = $this->_getSanitizedParam('nit');
    $captcha = $this->_getSanitizedParam('g-recaptcha-response');
    $response = [];

    // Verifica el captcha
    if (!$this->verifyCaptcha($captcha)) {
      $response = [
        'status' => 'error',
        'error' => 'Captcha incorrecto',
        'message' => 'Captcha incorrecto'
      ];
      echo json_encode($response);
      return;
    }
    if (!$nit || !$this->validarNumerosYGuion($nit)) {
      $response = [
        'status' => 'error',
        'error' => 'Documento no válido',
        'message' => 'Documento no válido',
      ];
      echo json_encode($response);
      return;
    }
    $bloqueosModel = new Administracion_Model_DbTable_Bloqueos();
    // Obtiene información de bloqueos anteriores
    $infoBloqueo = $bloqueosModel->getList(
      "bloqueo_nit = '$nit' or bloqueo_ip = '" . $_SERVER['REMOTE_ADDR'] . "' ",
      "bloqueo_id DESC"
    )[0];

    // Manejo de intentos fallidos
    $intentos = (int)$infoBloqueo->bloqueo_intentosfallidos;
    $fechaUltimoIntento = $infoBloqueo->bloqueo_fechaintento;
    $fechaUltimoIntento = new DateTime($fechaUltimoIntento);
    $fechaActual = new DateTime();
    $diferencia = $fechaActual->getTimestamp() - $fechaUltimoIntento->getTimestamp();

    // Bloquea al usuario si excede los intentos permitidos
    if ($intentos >= 3 && $diferencia <= 900) {
      $response = [
        'status' => 'error',
        'message' => 'El usuario ha sido bloqueado durante 15 minutos por más de tres intentos fallidos'
      ];
      echo json_encode($response);
      return;
    }

    // Registra el intento fallido
    $dataBloque = array();
    $dataBloque['bloqueo_nit'] = $nit;
    $dataBloque['bloqueo_intentosfallidos'] = $this->getIntentos($nit, $_SERVER['REMOTE_ADDR']);
    $dataBloque['bloqueo_ip'] = $_SERVER['REMOTE_ADDR'];
    $bloqueosModel->insert($dataBloque);

    $data = $this->founUserApi($nit);

    if ($data == 'La cédula especificada no existe') {
      $response = [
        'status' => 'error',
        'error' => 'Documento no encontrado',
        'message' => 'Documento no encontrado',
      ];
      echo json_encode($response);
      return;
    }


    $email = $data->email;
    $nombreCompleto = $data->nombre;
    $otp = $this->generateOTP();
    $otpModel = new Administracion_Model_DbTable_Otpcodes();
    $otpData = array(
      'user' => $email,
      'code' => $otp,
      'nit' => $nit,
      'date' => date('Y-m-d H:i:s')
    );
    $otpId = $otpModel->insert($otpData);

    if (!$otpId) {
      $response['error'] = "Error al generar OTP";
      $response['status'] = "error";
      echo json_encode($response);
    }

    $mailModel = new Core_Model_Sendingemail($this->_view);
    $boolMail = $mailModel->enviarOTP($email, $nombreCompleto, $otp);
    if ($boolMail == 1) {
      $response = [
        'status' => 'success',
        'message' => 'Se ha enviado un correo con el código OTP',
        'email' => base64_encode($email),
        'name' => $nombreCompleto,
      ];
    } else {
      $response = [
        'status' => 'error',
        'message' => 'Ha ocurrido un error al enviar el correo'
      ];
    }

    echo json_encode($response);
    return;
  }

  public function otpAction()
  {
    $email = base64_decode($this->_getSanitizedParam('e'));

    $this->_view->emailHidden = $this->_getSanitizedParam('e');
    //Ocultar caracteres de correo
    $email = explode('@', $email);
    $email[0] = substr($email[0], 0, 5) . '***';
    $email = implode('@', $email);
    $this->_view->email = $email;
  }
  public function login2Action()
  {
    $this->setLayout('blanco');
    $response = [];
    $otp = '';
    for ($i = 1; $i <= 6; $i++) {
      $otp .= $this->_getSanitizedParam('otp' . $i);
    }
    $email = base64_decode($this->_getSanitizedParam('email'));

    $dateFifteenMinutesAgo = date('Y-m-d H:i:s', strtotime('-15 minutes'));
    $otpModel = new Administracion_Model_DbTable_Otpcodes();
    // $otpData = $otpModel->getList("code = '$otp' AND date >= DATE_SUB(NOW(), INTERVAL 15 MINUTE)", "");
    $otpData = $otpModel->getList("code = '$otp' AND date >= '$dateFifteenMinutesAgo'", "");

    $bloqueosModel = new Administracion_Model_DbTable_Bloqueos();
    // Obtiene información de bloqueos anteriores
    $infoBloqueo = $bloqueosModel->getList(
      "bloqueo_usuario = '$email' or bloqueo_ip = '" . $_SERVER['REMOTE_ADDR'] . "' ",
      "bloqueo_id DESC"
    )[0];

    // Manejo de intentos fallidos
    $intentos = (int)$infoBloqueo->bloqueo_intentosfallidos;
    $fechaUltimoIntento = $infoBloqueo->bloqueo_fechaintento;
    $fechaUltimoIntento = new DateTime($fechaUltimoIntento);
    $fechaActual = new DateTime();
    $diferencia = $fechaActual->getTimestamp() - $fechaUltimoIntento->getTimestamp();

    // Bloquea al usuario si excede los intentos permitidos
    if ($intentos >= 3 && $diferencia <= 900) {
      $response = [
        'status' => 'error',
        'message' => 'El usuario ha sido bloqueado durante 15 minutos por más de tres intentos fallidos'
      ];
      echo json_encode($response);
      return;
    }

    if (!$otpData) {

      // Registra el intento 
      $dataBloque = array();
      $dataBloque['bloqueo_usuario'] = $email;
      $dataBloque['bloqueo_intentosfallidos'] = $this->getIntentosEmail($email);
      $dataBloque['bloqueo_ip'] = $_SERVER['REMOTE_ADDR'];
      $bloqueosModel->insert($dataBloque);

      $response = [
        'status' => 'error',
        'message' => 'Código OTP inválido o expirado',
        'email' => $email
      ];
      echo json_encode($response);
      return;
    }


    $email = $otpData[0]->user;
    $nit = $otpData[0]->nit;
    $asociado = $this->founUserCompleteApi($nit);

    if (!$asociado) {
      // Registra el intento 
      $dataBloque = array();
      $dataBloque['bloqueo_usuario'] = $email;
      $dataBloque['bloqueo_intentosfallidos'] = $this->getIntentosEmail($email);
      $dataBloque['bloqueo_ip'] = $_SERVER['REMOTE_ADDR'];
      $bloqueosModel->insert($dataBloque);

      $response = [
        'status' => 'error',
        'message' => 'No se ha encontrado ningún asociado con ese correo'
      ];
      echo json_encode($response);
      return;
    }

    // Resetea los intentos fallidos al iniciar sesión correctamente
    $infoBloqueo = $bloqueosModel->getList("bloqueo_usuario = '$email'", "bloqueo_id DESC");
    if (count($infoBloqueo) > 0) {
      foreach ($infoBloqueo as $info) {
        $bloqueosModel->deleteRegister($info->bloqueo_id);
      }
    }

    Session::getInstance()->set("user", $asociado);


    $response = [
      'status' => 'success',
      'message' => 'Inicio de sesión exitoso',
      'user' => $email,
      'name' => $asociado->user_names,
    ];

    echo json_encode($response);
    return;
  }
  public function founUserApi($user)
  {
    try {
      $url = $this->domain . '/api/asociado/' . $user;
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
      ));
      $data = curl_exec($curl);
      curl_close($curl);
      if ($data == 'La cédula especificada no existe') {
        return $data;
      } else {
        $response = json_decode($data);
        // Crear un nuevo objeto con solo email y nombre
        return (object)[
          'email' => $response[0]->Email,
          'nombre' => $response[0]->NombreCompleto
        ];
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  public function founUserCompleteApi($user)
  {
    try {
      $url = $this->domain . '/api/asociado/' . $user;
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
      ));
      $data = curl_exec($curl);
      curl_close($curl);
      if ($data == 'La cédula especificada no existe') {
        return $data;
      } else {
        $response = json_decode($data);
        return  $response[0];
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }



  // Método privado para verificar el captcha
  private function verifyCaptcha($response)
  {
    // Clave secreta de reCAPTCHA
    $secretKey = '6LfFDZskAAAAAOvo1878Gv4vLz3CjacWqy08WqYP';

    // URL de verificación de reCAPTCHA
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
      'secret' => $secretKey,
      'response' => $response
    );

    // Configuración de la solicitud HTTP POST
    $options = array(
      'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
      )
    );

    // Realiza la solicitud y decodifica la respuesta
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);

    // Devuelve true si el captcha es válido
    return $response->success;
  }
  function validarNumerosYGuion($cadena)
  {
    // Elimina espacios en blanco al inicio y final
    $cadena = trim($cadena);

    // Si está vacía, retorna false
    if (empty($cadena)) {
      return false;
    }

    // Cuenta cuántos guiones hay
    $cantidadGuiones = substr_count($cadena, '-');

    // Si hay más de un guión, retorna false
    if ($cantidadGuiones > 1) {
      return false;
    }

    // Reemplaza el guión (si existe) por vacío
    $soloNumeros = str_replace('-', '', $cadena);

    // Verifica que solo queden números
    return ctype_digit($soloNumeros);
  }
  private function generateOTP($length = 6)
  {
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
      $otp .= random_int(0, 9);
    }
    return $otp;
  }

  // Método para obtener el número de intentos fallidos de un usuario
  public function getIntentos($nit, $ip)
  {
    $bloqueosModel = new Administracion_Model_DbTable_Bloqueos();

    // Obtiene el último registro de bloqueo del usuario
    $infoBloqueo = $bloqueosModel->getList("bloqueo_nit = '$nit' or bloqueo_ip ='$ip'", "bloqueo_id DESC")[0];

    // Incrementa el contador de intentos fallidos
    $intento = $infoBloqueo->bloqueo_intentosfallidos ?? 0;
    $intento = $intento + 1;

    // Devuelve el número de intentos
    return $intento;
  }
    // Método para obtener el número de intentos fallidos de un usuario
    public function getIntentosEmail($email)
    {
      $bloqueosModel = new Administracion_Model_DbTable_Bloqueos();
  
      // Obtiene el último registro de bloqueo del usuario
      $infoBloqueo = $bloqueosModel->getList("bloqueo_usuario = '$email'", "bloqueo_id DESC")[0];
  
      // Incrementa el contador de intentos fallidos
      $intento = $infoBloqueo->bloqueo_intentosfallidos ?? 0;
      $intento = $intento + 1;
  
      // Devuelve el número de intentos
      return $intento;
    }

  public function logOutAction()
  {
    Session::getInstance()->set('user', null);
    header('Location: /');
  }
}
