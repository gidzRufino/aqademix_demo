<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of division
 *
 * @author genesis
 */
class division extends MX_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('division_model');
    }
    
    function index()
    {
        $data['modules'] = "division";
        $data['main_content'] = 'default';
        echo Modules::run('templates/main_content', $data);
    }
    
    function topStudents()
    {
        $data['modules'] = "division";
        $data['main_content'] = 'topTen';
        echo Modules::run('templates/main_content', $data);
    }
    
    function topTen()
    {
        $grade_id = $this->input->post('grade_id');
        $section_id = $this->input->post('section_id');
        $subject_id = $this->input->post('subject_id');
        $term = $this->input->post('term');
        $school_year = $this->input->post('sy');
        $gs_tops = Modules::load('gradingsystem/gs_tops/');
        
        $data['grade_id'] = $grade_id;
        if($subject_id!='0'):
            $data['perSubject'] = true;
        else:
            $data['perSubject'] = false;
        endif;
        
        $data['topTen'] = $gs_tops->getTopTenByGradeLevel($grade_id, $term, $school_year, $subject_id, $section_id);
        $this->load->view('classTopTen', $data);
    }
    
}

?>
