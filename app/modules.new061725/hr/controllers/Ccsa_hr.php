<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ccsa_hr
 *
 * @author genesisrufino
 */
class Ccsa_hr extends MX_Controller {
    //put your code here
    
    
    public function __construct() {
        parent::__construct();
        $this->load->model('hr_model');
        $this->load->library('pagination');
        $this->load->library('Pdf');
        
    }
       
    function getManHours($timeIn, $timeOut, $date)
    {
        $date = date_create($date);

        $timeStart = strtotime(date_format($date, 'Y-m-d'). date('H:i:s', strtotime($timeIn)));
        $timeEnd = strtotime(date_format($date, 'Y-m-d'). date('H:i:s', strtotime($timeOut)));

        $timeDiff = $timeEnd - $timeStart;


        $totalTime = ($timeDiff/3600);
        $hours = round($totalTime, 0, PHP_ROUND_HALF_DOWN);
        if($hours>4):
            //$hours = $hours;
            $hours = 4;
        endif;
        $minutes = ($timeDiff % 3600)/60;
        if($minutes<0):
            $minutes = 0;
        endif;
        if($hours<0):
            $hours = 0;
        endif;
        $data = array(
            'totalTime' => $hours,
            'minutes' => $minutes,
            'start' => $timeIn,
            'end' => $timeEnd,
        );
     
        return $data;   
    }
    
}
