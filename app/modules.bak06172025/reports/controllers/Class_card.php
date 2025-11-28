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
class class_card extends MX_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
        set_time_limit(300) ;
    }    
    public function post($value){
        return $this->input->post($value);
    }
    
    function printIndividual($st_id,$term, $school_year, $grade_level, $section)
    {
        $this->load->library('pdf');
        $settings = Modules::run('main/getSet');
        $data['section'] = $section;
        $data['gradeLevel'] = $grade_level;
        $data['sy'] = $school_year;
        $data['st_id'] = $st_id;
        $data['grading'] = $term;
        $this->load->view('newClassCard/'.strtolower($settings->short_name).'_cardDetails_individual', $data);
    }
    
    function printCCSH()
    {
        $settings = Modules::run('main/getSet');
        $gs_settings = Modules::run('gradingsystem/getSet');
        $this->load->view('newClassCard/'.strtolower($settings->short_name).'_frontPage_sh');
    }
    
    function ccgenerator($section_id)
    {
        $data['students'] = Modules::run('registrar/getAllStudentsForExternal','', $section_id);
        $data['modules'] = "reports";
        $data['main_content'] = 'classcard/default';
        echo Modules::run('templates/main_content', $data);
    }
    
    function generateCC($array=NULL)
    {
        $st_id = $this->post('st_id');
        $term = $this->post('term');
        $school_year = $this->post('school_year');
        $gs_settings = Modules::run('gradingsystem/getSet');
        $data['behavior'] = Modules::run('gradingsystem/getBH');
        $data['student'] = Modules::run('registrar/getSingleStudent', $st_id);
        $data['sy'] = $school_year;
        $data['term'] = $term;
        switch($gs_settings->gs_used):
                case 1:
                    $this->load->view('classCard/generateCC', $data);
                    break;
                case 2:       
                    $data['bh_group'] = $this->reports_model->getBhGroup(2);
                    $data['behavior'] = $this->reports_model->getBehaviorRate(2);
                    $this->load->view('newClassCard/generateCC', $data);
                    break;
                default :
                    $this->load->view('classCard/generateCC', $data);
                    break;
            endswitch;
    }
    
    function printCCFront($section_id) {
        $this->load->helper('file');
        $settings = Modules::run('main/getSet');
        $gs_settings = Modules::run('gradingsystem/getSet');
        $section = Modules::run('registrar/getSectionById', $section_id);
        switch ($gs_settings->gs_used):
            case 1:
                $this->load->view('classCard/frontPage');
                break;
            case 2:
                if (Modules::run('main/detect_column', 'esk_gs_settings', 'customized_mapeh')):
                    if ($gs_settings->customized_mapeh):
                        $this->load->view('newClassCard/' . strtolower($settings->short_name) . '_frontPage');
                    else:
                        if (file_exists(APPPATH . 'modules/reports/views/newClassCard/' . strtolower($settings->short_name) . '_frontPage_hs.php')):
                            if ($section->grade_id > 7):
                                $this->load->view('newClassCard/' . strtolower($settings->short_name) . '_frontPage_hs');
                            else:
                                $this->load->view('newClassCard/' . strtolower($settings->short_name) . '_frontPage');
                            endif;
                        elseif (file_exists(APPPATH . 'modules/reports/views/newClassCard/' . strtolower($settings->short_name) . '_frontPage.php')):
                            $this->load->view('newClassCard/' . strtolower($settings->short_name) . '_frontPage');
                        else:
                            $this->load->view('newClassCard/frontPage');
                        endif;
                    endif;
                endif;

                break;
            default :
                $this->load->view('classCard/frontPage');
                break;
        endswitch;
    }
    
//    function printCCFront($section_id)
//    {
//        $this->load->helper('file');
//       $settings = Modules::run('main/getSet');
//        $gs_settings = Modules::run('gradingsystem/getSet');
//        $section = Modules::run('registrar/getSectionById', $section_id); 
//        switch($gs_settings->gs_used):
//                case 1:
//                    $this->load->view('classCard/frontPage');
//                    break;
//                case 2:
//                    if(Modules::run('main/detect_column','esk_gs_settings', 'customized_mapeh')):
//                        if ($gs_settings->customized_mapeh):
//                            $this->load->view('newClassCard/'.strtolower($settings->short_name).'_frontPage');
//                        else:
//                            if(file_exists(APPPATH.'modules/reports/views/newClassCard/'. strtolower($settings->short_name).'_frontPage.php')):
//                                if($section->grade_id>7):
//                                    $this->load->view('newClassCard/'.strtolower($settings->short_name).'_frontPage_hs');
//                                else:
//                                    $this->load->view('newClassCard/'.strtolower($settings->short_name).'_frontPage');
//                                endif;
//                           else:
//                                $this->load->view('newClassCard/frontPage');
//                                
//                            endif;
//                        endif;
//                    endif;
//                    
//                    break;
//                default :
//                    $this->load->view('classCard/frontPage');
//                    break;
//            endswitch;
//    }
    
    function printCCBack($section_id)
    {
        $this->load->view('classCard/backPage');
    }
     
}

