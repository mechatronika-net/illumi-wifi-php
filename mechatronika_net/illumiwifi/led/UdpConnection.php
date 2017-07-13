<?php      

namespace mechatronika_net\illumiwifi\led;

class UdpConnection {
  /**
	 *
	 * @var string $host IP address of the illumi WiFi
	 *
	 */
  private $host;
  
  
  /**
	 *
	 * @var integer $port The remote port number at which the data will be sent
	 *
	 */
  private $port = 5401;
  
  
  /**
	 *
	 * @var resource $sock The created socket resource
	 *
	 */
	private $socket;
  
  
  /**
   *  
	 * Construct
	 *         
   * @param string $host IP address of the illumi WiFi
   *    
	 */
  public function __construct($host) {
    $this->host = $host;         
    
    $this->connect();
  }
  
    
  /**
   *  
	 * Create the UDP socket
	 * 
   * @return boolean
   *       
	 */
  public function connect() {                            
    if(!($this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP))) {            
      $errorcode = socket_last_error();
      $errormsg = socket_strerror($errorcode);
       
      echo "Couldn't create socket: [$errorcode] $errormsg \n";
      return false;
    }    
    socket_set_option($this->socket, SOL_SOCKET, SO_RCVTIMEO, array("sec"=>1,"usec"=>0));
    return true;
  }
  
  
  /**
	 *
	 * Close the UDP socket  
   *                                               
   * @return boolean
	 *                        
	 */
  public function disconnect() {
    socket_close($this->socket);    
    return true;
  }
 
  
  /**                                 
   *        
   * Send the message to the illumi WiFi
   *    
   * @param array $input Message to the illumi WiFi 
   *                                               
   * @return boolean
   *    
   */ 
  public function send($input) {
    foreach($input as $i) {   
      $msg.= pack("C*",$i);
    }                  
                                                    
    if(!socket_sendto($this->socket, $msg, strlen($msg), 0, $this->host, $this->port)) {
      $errorcode = socket_last_error();
      $errormsg = socket_strerror($errorcode);
       
      echo "Couldn't send data: [$errorcode] $errormsg \n";
      return false;
    }
    return true;
  }
  
  /**                   
   *                
   * Receive reply from illumi WiFi
   *    
   * @return array The unpacked data  
   *    
   */ 
  public function receive() {
    if(socket_recv($this->socket, $reply, 1024, 0) === false) {
      $errorcode = socket_last_error();
      $errormsg = socket_strerror($errorcode);
       
      echo "Couldn't receive data: [$errorcode] $errormsg \n";
      return false;
    }
    return unpack("C*",$reply);
  }
}

?>