<?php

  error_reporting(E_ALL & ~E_NOTICE); 
  ini_set("display_errors", 1); 
  
  require_once(dirname(dirname(__FILE__)).'/mechatronika_net/illumiwifi/led/Connector.php');
  
  use mechatronika_net\illumiwifi\led\Connector;
  
  $illumi = new Connector();
  $illumi->Connect("10.0.0.236");
  
  var_dump($illumi->GetInfo());
  
?>