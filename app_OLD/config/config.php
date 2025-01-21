<?php
define('DEFAULT_TITLE', 'Fodun Certificados');// titulo general para toda la pagina

$config = array(); //

$config ['production']= array();
$config ['production']['db'] = array();
$config ['production']['db']['host'] ='localhost';
$config ['production']['db']['name'] ='opain_certificados';
$config ['production']['db']['user'] ='root';
$config ['production']['db']['password'] ='vLPhXuExstXzmb6D';
$config ['production']['db']['port'] ='3306';
$config ['production']['db']['engine'] ='mysql';

$config ['staging']= array();
$config ['staging']['db'] = array();
$config ['staging']['db']['host'] ='localhost';
$config ['staging']['db']['name'] ='omegasol_xovis';
$config ['staging']['db']['user'] ='omegasol_xovis';
$config ['staging']['db']['password'] ='XovisOmega.2022';
$config ['staging']['db']['port'] ='3306';
$config ['staging']['db']['engine'] ='mysql';

$config ['development']= array();
$config ['development']['db'] = array();
$config ['development']['db']['host'] ='localhost';
$config ['development']['db']['name'] ='certificados';
$config ['development']['db']['user'] ='root';
$config ['development']['db']['password'] = 'O8Rz.79yYI1?';
$config ['development']['db']['port'] ='3306';
$config ['development']['db']['engine'] ='mysql';

