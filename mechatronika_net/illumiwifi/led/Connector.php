<?php                

namespace mechatronika_net\illumiwifi\led;

require_once('UdpConnection.php');
require_once('Color.php');

class Connector {   
  /**
	 *
	 * @var UdpConnection object $udp
	 *
	 */
  private $udp;
  
  
  /**
   *      
	 * Construct
	 *       
   */  
  public function __construct() {   
  }
                                                                                
  /**
   *      
	 * Create UDP connection
	 * 
   * @param string $host IP address of the illumi WiFi  
   *                                               
   * @return boolean
   *       
   */  
  public function Connect($host) { 
    return $this->udp = new UdpConnection($host);
  }
         
   /**
	 *
	 * Close the UDP connection      
   *                                               
   * @return boolean
	 *
	 */
  public function Disconnect() {
    return $this->udp->disconnect();
  }
  
  /**             
   *              
   * Sets new current color
   *    
   * @param Color object $rgb Color to set
   * 
   * @return boolean
   *           
   */ 
  public function SendColor($color) {        
    $input[0] = 0x01;      //set color
    $input[1] = $color->r;              
    $input[2] = $color->g;
    $input[3] = $color->b;
    
    return $this->udp->send($input);
  }
  
  /**
   *  
   * Sets new current color with fade      
   *    
   * @param Color object $rgb Color to set 
   * @param integer $fadeTime Time of color change   
   * 
   * @return boolean
   *    
   */ 
  public function SendFadeToColor($color, $fadeTime) { 
    $input[0] = 0x03;      //set color with fade
    $input[1] = $color->r;              
    $input[2] = $color->g;
    $input[3] = $color->b;  
    $input[4] = ($fadeTime / 0x100);
    $input[5] = ($fadeTime % 0x100);
    
    return $this->udp->send($input);
  }
  
  /**
   *  
   * Sets new default color   
   *    
   * @param Color object $rgb Default color to set
   * 
   * @return boolean
   *           
   */ 
  public function SendDefaultColor($color) { 
    $input[0] = 0x02;      //set default color
    $input[1] = $color->r;              
    $input[2] = $color->g;
    $input[3] = $color->b;
    
    return $this->udp->send($input);
  }
  
  /**                        
   *    
   * Gets colors from illumi WiFi  
   *    
   * @return array Color objects
   *     
   */ 
  public function GetColors() {
    $input[0] = 0x82;     //get colors      
      
    $this->udp->send($input);
    $reply = $this->udp->receive();
    
    if($reply) {
      $result['currentColor'] = new Color($reply[1], $reply[2], $reply[3]);
      $result['defaultColor'] = new Color($reply[4], $reply[5], $reply[6]);
      return $result;
    }
    return NULL;
  }
  
  /**                        
   *    
   * Gets info from illumi WiFi  
   *    
   * @return array
   *     
   */ 
  public function GetInfo() {
    $input[0] = 0x81;     //get info      
      
    $this->udp->send($input);
    $reply = $this->udp->receive();
    
    if($reply) {
      for($i = 1; $i <= 6; $i++) {
        $result['version'].= chr($reply[$i]);
      }                    
      for($i = 7; $i <= 18; $i++) {
        $result['mac'].= strtoupper(chr($reply[$i]));
        if(($i+1) % 2 && $i < 18) {
          $result['mac'].= ':';
        }
      }             
      return $result;
    }
    return NULL;
  } 
} 


?>