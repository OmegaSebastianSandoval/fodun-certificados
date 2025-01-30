<?php

/**
 *  Controlador de la página principal, incluye las acciones de la página de inicio, registro, olvido de contraseña, certificados, cambio de contraseña, login, logout, cambio de contraseña, búsqueda de archivos y recuperación de contraseña
 */

class Page_indexController extends Page_mainController
{
  private $domain;
  protected $certJson;
  public function init()
  {
    $this->domain = Config_Config::getInstance()->getValue('api/url');
    $jsonFile = FILE_PATH . 'cert.json';
    $jsonData = file_get_contents($jsonFile);

    if ($jsonData === false) {
      die('Error al leer el archivo JSON');
    }
    $data = json_decode($jsonData, true);

    $this->certJson = $data;
    parent::init();
  }
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

    $userNit = Session::getInstance()->get('user')->Cedula;
    $apiModel = new Page_Model_Api();
    $apiData = array();
    $apiData['basic'] = $apiModel->getAsociado($userNit)[0];
    $apiData['saving-accounts'] = $apiModel->getSavingAccountsOptions($userNit);
    $apiData['credit-accounts'] = $apiModel->getCreditAccountsOptions($userNit);
    // print_r($apiData['credit-accounts']);
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
    $this->getLayout()->setTitle("Certificado");
    $id = $this->_getSanitizedParam('id');
    $json = $this->certJson;
    $json = $json[$id];
    $title = $json["title"];
    $cert_option = $this->_getSanitizedParam('cert_option');
    $dataModel = new Page_Model_Data();
    $data = $dataModel->returnData($id, $cert_option);
    /* echo "<pre>";
    print_r($data);
    echo "</pre>"; 
    return; */

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
    $mpdf = new \Mpdf\Mpdf(['default_font' => 'Arial', 'tempDir' => ROOT . '..\vendor\mpdf\mpdf\tmp']);
    $content = $this->_view->getRoutPHP('modules/page/Views/index/certificado-' . $id . '.php');
    $mpdf->title = 'Certificado ' . $title;
    // Cuales son los margenes de la hoja?: array(left, top, right, bottom)
    $mpdf->WriteHTML($content);
    // Obtener la fecha actual en formato ymdhms
    $fechaActual = date('YmdHis');
    $userNit = Session::getInstance()->get('user')->Cedula;
    // Construir el nombre del archivo
    $nombreArchivo = 'Certificado_' . $title . '_' . $userNit . '_' . $fechaActual . '.pdf';


    // Guardar o mostrar el PDF con el nombre especificado
    $mpdf->Output($nombreArchivo, \Mpdf\Output\Destination::INLINE); // INLINE lo muestra en el navegador
  }
}
