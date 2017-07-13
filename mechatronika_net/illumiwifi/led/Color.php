<?php                

namespace mechatronika_net\illumiwifi\led;

class Color {  
  /**
	 *
	 * @var integer $r Value of red color
	 *
	 */
  public $r;
  
    
  /**
	 *
	 * @var integer $g Value of green color
	 *
	 */
  public $g;
  
  
  /**
	 *
	 * @var integer $b Value of blue color
	 *
	 */
  public $b;
  
  
  /**
	 *
	 * @var integer $w Value of white
	 *
	 */
  public $w;
    
    
  /**
   *      
	 * Construct
	 * 
   * @param integer $red Value of red color
   * @param integer $green Value of green color
   * @param integer $blue Value of blue color    
   * @param integer $white Value of white
   *       
   */
  public function __construct($red, $green, $blue, $white=null) {
    $this->r = $red;                                
    $this->g = $green;
    $this->b = $blue; 
    $this->w = $white;
  }
}

?>