<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of attendance
 *
 * @author genesis
 */

class cueingsystem extends MX_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('cueingsystem_model');
    }
    
    function index()
    {
        $this->load->view('fullscreen');
        
    }
    
    function checkOnlineStation()
    {
        $online = $this->cueingsystem_model->checkOnlineStation();
        return $online;
    }
    
    function checkOnlineStationJson()
    {
        $online = $this->cueingsystem_model->checkOnlineStation();
        foreach ($online->result() as $ol):
     ?>
        <span class="list-group-item clearfix">
            <h2><i class="fa fa-user fa-fw"></i> <?php echo $ol->station_name; ?> <span class="text-danger pull-right">0001</span> </h2>
        </span>
    <?php endforeach; 
    }
    
    function checkCue($dept_id, $station_id=NULL)
    {
        $cue = $this->cueingsystem_model->checkCue($dept_id, $station_id);
        return $cue;
    }
    
    function nextStation($dept_id, $station_id = Null, $cue_number = NULL)
    {
        $checkStatus = $this->cueingsystem_model->checkCueNumber($cue_number, $station_id);
        if($checkStatus):
            $status = '1';
        else:
            $status = '0';
        endif;
        $serve = array(
            'cue_status' => $status,
            'station_id' => $station_id,
        );
        
       $nextCue = $this->cueingsystem_model->serve($cue_number, $serve, $status, $dept_id);
        
       // $onCue = $this->cueingsystem_model->checkWhosNext($dept_id);
        if($nextCue):
            $onCue = $this->addZero($nextCue->cue_number);
            
        else:
           
            $onCue = $this->addZero($nextCue->cue_number);
        endif;

        echo $onCue;
    }
    
    function getCueWidget()
    {
        
        $this->load->view('cue_widget');
    }
    
    function getStation()
    {
            $getStation = $this->cueingsystem_model->getStation();
            //print_r($getStation);
            return $getStation;
    }
    
    function getStationDrop()
    {
        $getStation = $this->getStation();
        foreach($getStation->result() as $gs): ?>
            <option value="<?php echo $gs->station_id;  ?>" ><?php echo $gs->station_name ?></option>
        <?php endforeach;  
    }
    
    function checkInStation($status, $station=Null)
    {
        if($status=='1'):
            $user_id = $this->session->userdata('user_id');
        else:
            $user_id = "";
        endif;
        
        $data = array(
            'online' => $status,
            'user_id' => $user_id
        );
        if($status=='1'):
             $this->cueingsystem_model->checkInStation($station, $data, 'station_id');
        else:
             $this->cueingsystem_model->checkInStation($this->session->userdata('user_id'), $data, 'user_id');
        endif;
       
    }
    
    function checkOnlineStatus($user_id)
    {
        $online = $this->cueingsystem_model->checkStatus($user_id);
        if(!$online):
            return FALSE;
        else:
            $data = array(
                'status' => TRUE,
                'data'  => $online,
            );
            return $data;
        endif;
    }
    
    function addZero($number)
    {
        if($number < 10 && $number>0):
            $onCue = '000'.$number;
        else:
            if($number >=10 && $number<100):
                 $onCue = '00'.$number;  
            else:   
                if($number>=100 && $number<1000):
                    $onCue = '0'.$number;
                else:
                    $onCue = '0000';
                endif;
            endif;

        endif;
        return $onCue;
    }
}