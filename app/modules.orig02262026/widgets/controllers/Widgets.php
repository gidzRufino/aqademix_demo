<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of widgets
 *
 * @author genesis
 */
class widgets extends MX_Controller {
    //put your code here
    
    function getWidget($widget_name = Null, $widget_type = Null, $data = NULL)
    {
        $widget = Modules::load('widgets/'.$widget_name, $data);
        
        $final_widget = $widget->$widget_type($data);
        
        return $final_widget;
        
    }
}

?>
