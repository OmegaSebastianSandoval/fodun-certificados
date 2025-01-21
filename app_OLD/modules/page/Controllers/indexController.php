<?php

/**
 *  Controlador de la página principal, incluye las acciones de la página de inicio, registro, olvido de contraseña, certificados, cambio de contraseña, login, logout, cambio de contraseña, búsqueda de archivos y recuperación de contraseña
 */

class Page_indexController extends Page_mainController
{
  private $domain = 'http://186.29.192.82';
  public function indexAction()
  {
    if (Session::getInstance()->get('user')) {
      header('Location: /page/index/certificados');
    }
  }
  public function registroAction()
  {
    if (Session::getInstance()->get('user')) {
      header('Location: /page/index/certificados');
    }
  }
  public function certificadosAction()
  {
    if (!Session::getInstance()->get('user')) {
      header('Location: /');
    }
    //Generar Token
    Session::getInstance()->set('csrf_token_user', md5(uniqid(rand(), true)));
    $this->_view->csrf_token = Session::getInstance()->get('csrf_token_user');
    $this->_view->tipos = $this->getTipos();

    $userNit = Session::getInstance()->get('user')->asociado_nit;
    $apiModel = new Page_Model_Api();
    $apiData = array();
    $apiData['basic'] = $apiModel->getAsociado($userNit)[0];
    $apiData['saving-accounts'] = $apiModel->getSavingAccountsOptions($userNit);
    $apiData['credit-accounts'] = $apiModel->getCreditAccountsOptions($userNit);
    $apiData['canceled-credit-accounts'] = $apiModel->getCreditCanceledAccountsOptions($userNit);
    $apiData['credit-accounts-to-peace'] = $apiModel->getCreditAccountsToPeace($userNit);

    $this->_view->apiData = $apiData;
  }

  public function foundUserAction()
  {
    $user = $this->_getSanitizedParam('user');
    $res = array();
    $url = $this->domain . '/api/asociado/' . $user;
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $url,
      CURLOPT_USERAGENT => 'Consulta API desde PHP'
    ));
    $data = curl_exec($curl);
    curl_close($curl);
    if ($data == 'La cédula especificada no existe') {
      $res['status'] = 'not_found';
    } else {
      $asociados_model = new Administracion_Model_DbTable_Asociados();
      $validate_user = $asociados_model->getList("asociado_nit = '$user'", "");
      if (!$validate_user) {
        $res['status'] = 'found';
        $res['data'] = $data;
      } else {
        $res['status'] = 'exist';
        $res['message'] = 'Ya se encuentra un usuario registrado con este documento';
      }
    }
    die(json_encode($res));
  }
  public function createUserAction()
  {
    $asociados_model = new Administracion_Model_DbTable_Asociados();

    $user = $this->_getSanitizedParam('user');
    $password = $this->_getSanitizedParam('password');
    $res = array();
    $validate_user = $asociados_model->getList("asociado_nit = '$user'", "");

    if (!$validate_user) {
      $user_info = $this->searchUser($user);
      if ($user_info['status'] == 'found') {
        $user_info = json_decode($user_info['data'])[0];
        $data['asociado_nombre'] = $user_info->NombreCompleto;
        $data['asociado_nit'] = $user_info->Cedula;
        $data['asociado_clave'] = $password;
        $asociado_id = $asociados_model->insert($data);
        if ($asociado_id > 0) {
          $res['status'] = 'success';
          $res['message'] = 'Usuario creado correctamente';
        } else {
          $res['status'] = 'error';
          $res['message'] = 'Error al crear el usuario, intente nuevamente';
        }
      } else {
        $res['status'] = 'error';
        $res['message'] = 'No se encontró un usuario con este documento';
      }
    } else {
      $res['status'] = 'error';
      $res['message'] = 'Ya se encuentra un usuario registrado con este documento';
    }
    die(json_encode($res));
  }

  public function loginAction()
  {
    $nit = $this->_getSanitizedParam('nit');
    $password = $this->_getSanitizedParam('password');
    $res = array();
    $asociados_model = new Administracion_Model_DbTable_Asociados();
    $user = $asociados_model->getList("asociado_nit = '$nit'", "");
    if ($user) {
      $user = $user[0];
      if (password_verify($password, $user->asociado_clave)) {
        $res['status'] = 'success';
        $res['message'] = 'Usuario logueado correctamente';
        $res['name'] = $user->asociado_nombre;
        Session::getInstance()->set('user', $user);
        $res['data'] = $user;
      } else {
        $res['status'] = 'error';
        $res['message'] = 'Contraseña o documento incorrectos';
      }
    } else {
      $res['status'] = 'error';
      $res['message'] = 'No se encontró un usuario con este documento';
    }
    die(json_encode($res));
  }
  public function olvidoAction() {}
  public function logOutAction()
  {
    Session::getInstance()->set('user', null);
    header('Location: /');
  }

  public function sendForgotAction()
  {
    $user = $this->_getSanitizedParam('nit');
    $usuariosModel = new Administracion_Model_DbTable_Asociados();
    $userExist = $usuariosModel->getList("asociado_nit = '$user'", "")[0];
    if ($userExist) {
      $userInfo = json_decode($this->searchUser($user)['data'])[0];
      $URL = '';
      $token = '';
      $key = 'OM3G42024';
      $token = md5($key . $userInfo->Email);
      $URL .= 'http://' . $_SERVER['HTTP_HOST'] . '/page/index/recuperar?t=' . $token . '&d=' . $user;
      $usuariosModel->editField($userExist->asociado_id, 'token', $token);
      $usuariosModel->editField($userExist->asociado_id, 'token_date', date('Y-m-d H:i:s'));
      $mailModel = new Core_Model_Sendingemail($this->_view);
      $mailModel->sendForgot($userInfo->Email, $URL);
    }
    die(json_encode(array('status' => 'success')));
  }
  public function recuperarAction() {}
  public function changePasswordAction()
  {
    $password = $this->_getSanitizedParam('password');
    $secondPassword = $this->_getSanitizedParam('second_password');
    $token = $this->_getSanitizedParam('token');
    $document = $this->_getSanitizedParam('document');
    $asociadosModel = new Administracion_Model_DbTable_Asociados();
    $asociado = $asociadosModel->getList("asociado_nit = '$document'", "")[0];
    if ($asociado) {
      if ($token == $asociado->token && date('Y-m-d H:i:s', strtotime('-3 hours')) <= date('Y-m-d H:i:s', strtotime($asociado->token_date))) {
        if ($password == $secondPassword) {
          $asociadosModel->editField($asociado->asociado_id, 'asociado_clave', password_hash($password, PASSWORD_DEFAULT));
          $asociadosModel->editField($asociado->asociado_id, 'token', '');
          $asociadosModel->editField($asociado->asociado_id, 'token_date', '');
          header('Location: /page/index/?pass=1');
        } else {
          header('Location: /page/index/recuperar?t=' . $token . '&d=' . $document . '&error=3');
        }
      } else {
        header('Location: /page/index/recuperar?error=2');
      }
    } else {
      header('Location: /page/index/recuperar?error=1');
    }
  }

  private function getTipos()
  {
    $jsonFile = FILE_PATH . 'cert.json';
    $jsonData = file_get_contents($jsonFile);

    if ($jsonData === false) {
      die('Error al leer el archivo JSON');
    }
    $data = json_decode($jsonData, true);
    return $data;
  }
  public function generarAction()
  {
    $this->setLayout('blanco');
    $id = $this->_getSanitizedParam('id');
    $cert_option = $this->_getSanitizedParam('cert_option');
    $dataModel = new Page_Model_Data();
    $data = $dataModel->returnData($id, $cert_option);
    if ($this->_getSanitizedParam('addressee')) {
      $data['Addressee'] = $this->_getSanitizedParam('addressee');
    } else {
      $data['Addressee'] = 'a quien corresponda';
    }
    if ($data['error'] == 'true') {
      header('Location: /page/index/certificados?error=true&message=' . $data['error-message']);
      exit;
    }
    $this->_view->data = $data;
    $mpdf = new \Mpdf\Mpdf(['default_font' => 'Arial']);
    $content = $this->_view->getRoutPHP('modules/page/Views/index/certificado-' . $id . '.php');
    // Cuales son los margenes de la hoja?: array(left, top, right, bottom)
    $mpdf->WriteHTML($content);
    $mpdf->Output();
  }
}
