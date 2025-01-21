<?php

/**
 * Modelo del modulo Core que se encarga de  enviar todos los correos nesesarios del sistema.
 */
class Core_Model_Sendingemail
{
  /**
   * Intancia de la calse emmail
   * @var class
   */
  protected $email;

  protected $_view;

  public function __construct($view)
  {
    $this->email = new Core_Model_Mail();
    $this->_view = $view;
  }


  public function forgotpassword($user)
  {
    if ($user) {
      $code = [];
      $code['user'] = $user->user_id;
      $code['code'] = $user->code;
      $codeEmail = base64_encode(json_encode($code));
      $this->_view->url = "http://" . $_SERVER['HTTP_HOST'] . "/administracion/index/changepassword?code=" . $codeEmail;
      $this->_view->host = "http://" . $_SERVER['HTTP_HOST'] . "/";
      $this->_view->nombre = $user->user_names . " " . $user->user_lastnames;
      $this->_view->usuario = $user->user_user;
      /*fin parametros de la vista */
      //$this->email->getMail()->setFrom("desarrollo4@omegawebsystems.com","Intranet Coopcafam");
      $this->email->getMail()->addAddress($user->user_email,  $user->user_names . " " . $user->user_lastnames);
      $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/forgotpassword.php');
      $this->email->getMail()->Subject = "Recuperación de Contraseña Gestor de Contenidos";
      $this->email->getMail()->msgHTML($content);
      $this->email->getMail()->AltBody = $content;
      if ($this->email->sed() == true) {
        return true;
      } else {
        return false;
      }
    }
  }
  public function sendMailContact($data, $mail)
  {
    $this->_view->data = $data;
    $this->email->getMail()->addAddress($mail, "");
    $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/');
    $this->email->getMail()->Subject = '';
    $this->email->getMail()->msgHTML($content);
    $this->email->getMail()->AltBody = $content;
    // $this->email->getMail()->addBCC($informacion->info_pagina_correo_oculto);
    if ($this->email->sed() == true) {
      return 1;
    } else {
      return 2;
    }
  }
  public function enviarRegistro($user)
  {
    $this->_view->user = $user;
    $this->email->getMail()->addAddress($user->email, $user->razon_social);
    $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/enviarRegistro.php');
    $this->email->getMail()->Subject = 'Contraseña temporal Opain';
    $this->email->getMail()->msgHTML($content);
    $this->email->getMail()->AltBody = $content;
    // $this->email->getMail()->addBCC($informacion->info_pagina_correo_oculto);
    if ($this->email->sed() == true) {
      return 1;
    } else {
      return 2;
    }
  }
  public function enviarRecuperacion($user, $token)
  {
    $this->_view->user = $user;
    $this->_view->token = $token;
    $this->email->getMail()->addAddress($user->email, $user->razon_social);
    $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/enviarRecuperacion.php');
    $this->email->getMail()->Subject = 'Recuperación de contraseña Opain';
    $this->email->getMail()->msgHTML($content);
    $this->email->getMail()->AltBody = $content;
    // $this->email->getMail()->addBCC($informacion->info_pagina_correo_oculto);
    if ($this->email->sed() == true) {
      return 1;
    } else {
      return 2;
    }
  }
  public function sendForgot($mail, $URL)
  {
    $this->_view->URL = $URL;
    // $this->email->getMail()->addAddress($mail, "");
    $this->email->getMail()->addAddress('desarrollo2@omegawebsystems.com', 'Desarrollo');
    $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/sendForgot.php');
    $this->email->getMail()->Subject = 'Recuperación de contraseña';
    $this->email->getMail()->msgHTML($content);
    $this->email->getMail()->AltBody = $content;
    if ($this->email->sed() == true) {
      return 1;
    } else {
      return 2;
    }
  }

  public function enviarOTP($email, $nombreCompleto, $code)
  {
    $this->_view->email = $email;
    $this->_view->nombreCompleto = $nombreCompleto;
    $this->_view->code = $code;
    // $this->email->getMail()->addAddress($email, $nombreCompleto);
    $this->email->getMail()->addBCC("desarrollo8@omegawebsystems.com", "Inicio de sesión FODUN - Certificados");


    $content = $this->_view->getRoutPHP('/../app/modules/core/Views/templatesemail/enviarOTP.php');
    $this->email->getMail()->Subject = 'Ingreso FODUN - Certificados';
    $this->email->getMail()->msgHTML($content);
    $this->email->getMail()->AltBody = $content;
    if ($this->email->sed() == true) {
      return 1;
    } else {
      return 2;
    }
  }
}
