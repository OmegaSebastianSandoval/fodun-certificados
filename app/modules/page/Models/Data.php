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
    $userNit = Session::getInstance()->get('user')->Cedula;
    $json = $this->certJson;
    $json = $json[$nit];
    /* echo '<pre>';
    print_r($json);
    echo '</pre>'; */
    foreach ($json['required-data'] as $require) {
      switch ($require) {
        case 'date':
          setlocale(LC_TIME, 'es_ES.UTF-8');



          // Fecha actual
          $fechaActual = new DateTime();

          // Usar IntlDateFormatter para formatear la fecha en español
          $formatoDiaSemana = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
          $formatoMes = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE);

          // Configurar qué parte de la fecha queremos
          $formatoDiaSemana->setPattern('EEEE'); // Nombre del día de la semana
          $formatoMes->setPattern('MMMM');      // Nombre del mes

          // Asignar datos
          $data['date'] = $fechaActual->format('d/m/Y');
          $data['date-day'] = $fechaActual->format('d');
          $data['date-month'] = $fechaActual->format('m');
          $data['date-year'] = $fechaActual->format('Y');
          $data['date-day-in-letter'] = mb_strtolower(ucfirst($formatoDiaSemana->format($fechaActual)));
          $data['date-month-in-letter'] = mb_strtolower(ucfirst($formatoMes->format($fechaActual)));
          $data['date-year-in-letter'] = $this->numeroEnLetras($fechaActual->format('Y'));

          // Fecha completa en español
          $formatoCompleto = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
          $data['date-in-letter'] = ucfirst($formatoCompleto->format($fechaActual));
          break;
        case 'basic':
          $apiModel = new Page_Model_Api();
          $data['basic'] = $apiModel->getAsociado($userNit)[0];

          // Configurar el idioma a español
          setlocale(LC_TIME, 'es_ES.UTF-8');

          // Convertir FechaIngreso en un objeto DateTime
          $timestamp = strtotime($data['basic']->FechaIngreso);
          $fechaIngreso = new DateTime("@$timestamp"); // Convertir timestamp a DateTime
          $fechaIngreso->setTimezone(new DateTimeZone(date_default_timezone_get())); // Ajustar la zona horaria

          // Usar IntlDateFormatter para formatear la fecha
          $formatoFechaIngreso = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
          $formatoFechaIngreso->setPattern('d \'de\' MMMM \'del\' yyyy'); // Formato: 1 de enero de 2025

          // Formatear y asignar la fecha en letra
          $data['basic']->FechaIngresoLetra = ucfirst($formatoFechaIngreso->format($fechaIngreso));

          break;
        case 'saving-account':
          $apiModel = new Page_Model_Api();
          if ($optionSelected >= 0) {
            $account = $apiModel->getSavingAccounts($userNit, false)[$optionSelected];

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
            $data['credit-account'] = $apiModel->getCreditAccount($userNit, $account->CuentaAhorros) ? 'true' : 'false';
            if ($data['credit-account'] == 'false') {
              $data['error'] = 'true';
              $data['error-message'] = 'No se encontró la cuenta de ahorros';
            }
          }
          break;
        case 'saving-accounts':
          $apiModel = new Page_Model_Api();
          $account = $apiModel->getSavingAccounts($userNit, true);
          $data['saving-accounts'] = $account;
          break;
        case 'credit-accounts':
          $apiModel = new Page_Model_Api();
          $data['credit-accounts'] = $apiModel->getCreditAccounts($userNit);
          break;
        case 'credit-accounts-peaces':
          $apiModel = new Page_Model_Api();
          $data['credit-accounts'] = $apiModel->getCreditAccounts($userNit);
          if (is_countable($data['credit-accounts']) && count($data['credit-accounts']) > 0) {
            $data['CuotasAtrasadas'] = array_sum(array_column($data['credit-accounts'], 'CuotasAtrasadas'))+1;
            $data['DiasAtraso'] = array_sum(array_column($data['credit-accounts'], 'DiasAtraso'));
            $data['ValorAtraso']  = array_sum(array_column($data['credit-accounts'], 'ValorAtraso'));
            if (
              $data['CuotasAtrasadas'] > 0 ||
              $data['DiasAtraso'] > 0 ||
              $data['ValorAtraso'] > 0
            ) {
              $data['error'] = 'true';
              $data['error-message'] = 'Certificado no disponible, por favor comuníquese con la oficina de su respectiva regional.';
            }
          }
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
  private function numeroEnLetras($numero)
  {
    $f = new NumberFormatter("es", NumberFormatter::SPELLOUT);
    return $f->format($numero);
  }
}
