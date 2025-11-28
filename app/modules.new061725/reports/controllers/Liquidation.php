<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_card
 *
 * @author genesis
 */
class Liquidation extends MX_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
        
    }    
    public function post($value){
        return $this->input->post($value);
    }
    
    
}

?>
