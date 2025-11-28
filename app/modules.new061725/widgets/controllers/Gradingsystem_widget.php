<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Gradingsystem_widget extends MX_Controller {
    
    
    public function currentAcademicStatus($data=Null)
    {
       $this->load->view('grading_system/currentAcademicStatus');
    }
    
    public function academicStatusPerSubject($data=Null)
    {
       $this->load->view('grading_system/academicStatusPerSubject');
    }
    
    public function currentGPA($data=Null)
    {
        $details['details'] = $data;
        $this->load->view('grading_system/currentGPA', $details);
    }
    
    public function acadInfo($data=null)
    {
        $details['details'] = $data;
        $details['ro_year'] = Modules::run('registrar/getROYear');
        $this->load->view('grading_system/academicInformationWidget', $details);
    }
    
    public function classRecordWidget($data=NULL)
    {
        $details['details'] = $data;
        $this->load->view('grading_system/classRecordWidget', $details);
    }
    
    public function individualProgressReport($data=NULL)
    {
        $details['details'] = $data;
       // print_r($data);
        $this->load->view('grading_system/individualProgressReport', $details);
    }
    
    public function topPerformer($data=NULL)
    {
        $details['subject'] = $data['subject'];
        $details['topTen']  = $data['topTen'];
        $this->load->view('grading_system/topPerformerWidget', $details);
    }
    
}
?>
