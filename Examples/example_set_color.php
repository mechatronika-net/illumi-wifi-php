<?php

  error_reporting(E_ALL & ~E_NOTICE); 
  ini_set("display_errors", 1); 
  
  require_once(dirname(dirname(__FILE__)).'/mechatronika_net/illumiwifi/led/Connector.php');
  require_once(dirname(dirname(__FILE__)).'/mechatronika_net/illumiwifi/led/Color.php');
  
  use mechatronika_net\illumiwifi\led\Connector;
  use mechatronika_net\illumiwifi\led\Color;
  
  $illumi = new Connector();
  $illumi->Connect("10.0.0.236");
  
  // set color to red (R=255, G=0, B=0)
  $rgb = new Color(255, 0, 0);
  $illumi->SendColor($rgb);
  
?>