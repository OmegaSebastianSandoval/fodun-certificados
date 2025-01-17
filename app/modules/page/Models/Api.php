<?php

class Page_Model_Api
{
  protected $API_URL;

  public function __construct()
  {
    $this->API_URL = Config_Config::getInstance()->getValue('api/url');
  }
  public function getAsociado($nit)
  {
    $url = $this->API_URL . '/api/asociado/' . $nit;

    $ch = curl_init($url);

    $headers = [
      'Content-Type: application/json',
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    } else {
      return json_decode($response);
    }

    curl_close($ch);
  }
  public function getSavingAccounts($nit)
  {
    $url = $this->API_URL . '/api/portafolio/ahorro/' . $nit;

    $ch = curl_init($url);

    $headers = [
      'Content-Type: application/json',
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    } else {
      return json_decode($response);
    }

    curl_close($ch);
  }
  public function getCreditAccounts($nit)
  {
    $url = $this->API_URL . '/api/portafolio/credito/' . $nit;

    $ch = curl_init($url);

    $headers = [
      'Content-Type: application/json',
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    } else {
      return json_decode($response);
    }

    curl_close($ch);
  }
  public function getSavingAccountsOptions($nit)
  {
    $url = $this->API_URL . '/api/portafolio/ahorro/' . $nit;

    $ch = curl_init($url);

    $headers = [
      'Content-Type: application/json',
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    } else {
      $dataResponse = array();
      foreach (json_decode($response) as $account) {
        $dataResponse[] = $account->NombreProducto . ' - ' . $account->CuentaAhorros . ' - ' . $account->CuentaCoopcentral;
      }
      return $dataResponse;
    }

    curl_close($ch);
  }
  public function getCreditAccountsOptions($nit)
  {
    $url = $this->API_URL . '/api/portafolio/credito/' . $nit;

    $ch = curl_init($url);

    $headers = [
      'Content-Type: application/json',
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    } else {
      $dataResponse = array();
      foreach (json_decode($response) as $account) {
        $dataResponse[] = $account->NombreProducto . ' - ' . $account->NumeroCredito . ' - ' . $account->CuentaCoopcentral;
      }
      return $dataResponse;
    }

    curl_close($ch);
  }
  public function getSavingAccount($nit, $accountNumber, $accountCode)
  {
    $url = $this->API_URL . '/api/portafolio/ahorro/' . $nit . '/' . $accountNumber . '/' . $accountCode;

    $ch = curl_init($url);

    $headers = [
      'Content-Type: application/json',
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    } else {
      return json_decode($response);
    }

    curl_close($ch);
  }
  public function getCreditAccount($nit, $accountNumber)
  {
    $url = $this->API_URL . '/api/portafolio/credito/' . $nit . '/' . $accountNumber;

    $ch = curl_init($url);

    $headers = [
      'Content-Type: application/json',
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    } else {
      return json_decode($response);
    }

    curl_close($ch);
  }
  public function getCreditCanceledAccountsOptions($nit)
  {
    $url = $this->API_URL . '/api/portafolio/creditoscancelados/' . $nit;

    $ch = curl_init($url);

    $headers = [
      'Content-Type: application/json',
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    } else {
      $dataResponse = array();
      foreach (json_decode($response) as $account) {
        $dataResponse[] = $account->NombreProducto . ' - ' . $account->NumeroCredito;
      }
      return $dataResponse;
    }

    curl_close($ch);
  }
  public function getCanceledCreditAccounts($nit)
  {
    $url = $this->API_URL . '/api/portafolio/creditoscancelados/' . $nit;

    $ch = curl_init($url);

    $headers = [
      'Content-Type: application/json',
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    } else {
      return json_decode($response);
    }

    curl_close($ch);
  }
  public function getCreditAccountsToPeace($nit)
  {
    $url = $this->API_URL . '/api/portafolio/movcxc/' . $nit;

    $ch = curl_init($url);

    $headers = [
      'Content-Type: application/json',
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    } else {
      return $response == 'El nit especificado no existe' ? true : false;
    }

    curl_close($ch);
  }
}
