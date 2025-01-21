<?php

class Page_Model_Data
{
  protected $certJson;
  //Constructor
  public function __construct()
  {
    $jsonFile = FILE_PATH . 'cert.json';
    $jsonData = file_get_contents($jsonFile);

    if ($jsonData === false) {
      die('Error al leer el archivo JSON');
    }
    $data = json_decode($jsonData, true);

    $this->certJson = $data;
  }
  public function returnData($nit, $optionSelected = null)
  {
    $data = array();
    $userNit = Session::getInstance()->get('user')->asociado_nit;
    $json = $this->certJson;
    $json = $json[$nit];
    // echo '<pre>';
    //   print_r($json);
    // echo '</pre>';
    foreach ($json['required-data'] as $require) {
      switch ($require) {
        case 'date':
          setlocale(LC_TIME, 'es_ES.UTF-8');

          $data['date'] = date('d/m/Y');
          $data['date-day'] = date('d');
          $data['date-month'] = date('m');
          $data['date-year'] = date('Y');
          $data['date-day-in-letter'] = strftime('%A');
          $data['date-month-in-letter'] = strftime('%B');
          $data['date-year-in-letter'] = $this->numeroEnLetras(date('Y'));
          $data['date-in-letter'] = strftime('%A, %d de %B de %Y');
          $data['date-in-letter'] = $this->getFecha();
          break;
        case 'basic':
          $apiModel = new Page_Model_Api();
          $data['basic'] = $apiModel->getAsociado($userNit)[0];
          setlocale(LC_TIME, 'es_ES.UTF-8');
          $timestamp = strtotime($data['basic']->FechaIngreso);
          $data['basic']->FechaIngresoLetra = strftime('%e de %B de %Y', $timestamp);
          break;
        case 'saving-account':
          $apiModel = new Page_Model_Api();
          if ($optionSelected >= 0) {
            $account = $apiModel->getSavingAccounts($userNit)[$optionSelected];
            $data['account'] = $account;
            $data['saving-account'] = $apiModel->getSavingAccount($userNit, $account->CuentaAhorros, $account->CodigoAhorro) ? 'true' : 'false';
            if ($data['saving-account'] == 'false') {
              $data['error'] = 'true';
              $data['error-message'] = 'No se encontró la cuenta de ahorros';
            }
          }
          break;
        case 'credit-account':
          $apiModel = new Page_Model_Api();
          if ($optionSelected >= 0) {
            $account = $apiModel->getCreditAccounts($userNit)[$optionSelected];
            $data['account'] = $account;
            $data['credit-account'] = $apiModel->getCreditAccount($userNit, $account->CuentaAhorros, $account->CodigoAhorro) ? 'true' : 'false';
            if ($data['credit-account'] == 'false') {
              $data['error'] = 'true';
              $data['error-message'] = 'No se encontró la cuenta de ahorros';
            }
          }
          break;
        case 'saving-accounts':
          $apiModel = new Page_Model_Api();
          $account = $apiModel->getSavingAccounts($userNit);
          $data['saving-accounts'] = $account;
          break;
        case 'credit-accounts':
          $apiModel = new Page_Model_Api();
          $data['credit-accounts'] = $apiModel->getCreditAccounts($userNit);
          break;
        case 'canceled-credit-account':
          $apiModel = new Page_Model_Api();
          $data['canceled-credit-accounts'] = $apiModel->getCanceledCreditAccounts($userNit)[$optionSelected];
          break;
      }
    }
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    return $data;
  }
  // Funcion pra obtener fecha actual en formato: 10 de abril 2024
  public function getFecha()
  {
    $meses = array(
      'enero',
      'febrero',
      'marzo',
      'abril',
      'mayo',
      'junio',
      'julio',
      'agosto',
      'septiembre',
      'octubre',
      'noviembre',
      'diciembre'
    );
    $fecha = date('d') . ' de ' . $meses[date('n') - 1] . ' ' . date('Y');
    return $fecha;
  }
  private function numeroEnLetras($numero) {
    $f = new NumberFormatter("es", NumberFormatter::SPELLOUT);
    return $f->format($numero);
  }
}