<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of search
 *
 * @author genesis
 */
class search extends MX_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('search_model');
        //$device = new Mobile_Detect();
    }
    
    function getRawProfile($year_id)
    {
        $year = Modules::run('financemanagement/yearConverter', base64_decode($year_id));
        $students = $this->search_model->getRawProfile($year);
        foreach($students as $s):
            ?>
                <option value="<?php echo base64_encode($s->uid); ?>"><?php echo $s->lastname.',&nbsp;'.$s->firstname; ?></option>
            <?php
        endforeach;
    }
    
    function getStudents($option, $value, $year=NULL)
    {
        $settings = Modules::run('main/getSet');
        $student = $this->search_model->getPreviousStudent($option, $value, $year, $settings);
        $data['grade'] = Modules::run('registrar/getGradeLevel');
            //echo $option;
        $data['year'] = ($year==NULL?$this->session->userdata('school_year'):$year);
        $data['students'] = $student;
        if (file_exists(APPPATH . 'modules/search/views/' . strtolower($settings->short_name) . '_studentTable.php')):
            $this->load->view(strtolower($settings->short_name) . '_studentTable', $data);
        else:
            $this->load->view('studentTable', $data);
        endif;
	//print_r($student);
    }
    
    function assignToATeam($user_id, $team_id)
    {
        $success = $this->search_model->assignToATeam($user_id,$team_id);
        if($success):
            echo 'Successfully Assigned';
        else:
            echo 'Sorry Something went wrong';
        endif;
    }
    
    function getCollegeStudents($option, $value, $year=NULL, $sem=NULL)
    {
        $settings = Modules::run('main/getSet');
        $student = $this->search_model->getCollegeStudents($option, urldecode($value), $year, $sem);
        //echo $year;
        $data['students'] = $student;
        $data['year'] = $year;
        
        if (file_exists(APPPATH . 'modules/search/views/' . strtolower($settings->short_name) . '_searchCollegeStudentTable.php')):
            $this->load->view(strtolower($settings->short_name) . '_searchCollegeStudentTable', $data);
        else:
            $this->load->view('searchCollegeStudentTable', $data);
        endif;
	//print_r($student);
    }
    function getROStudents($value)
    {
        $student = $this->search_model->getStudent($value);
        $data['grade'] = Modules::run('registrar/getGradeLevel');
            //echo $option;
        $data['students'] = $student;
        $this->load->view('ro_studentTable', $data);
    }
    function getStudentBySection($section_id, $value=NULL, $year=NULL)
    {
        $student = $this->search_model->getStudentBySection($value, $section_id, $year=NULL);
            //echo $option;
        $data['students'] = $student;
        $this->load->view('studentTable', $data);
    }
    
    function exportStudentListToExcell($option, $value, $year=NULL)
    {
        $this->load->library('eskwela');
        $this->load->library('excel');
        $this->load->helper('download');
        $settings = $this->eskwela->getSet();
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $section = Modules::run('registrar/getSectionById', $value);
        
        $this->excel->getActiveSheet()->setTitle($section->level.'-'.$section->section);
        
        $adviser = Modules::run('academic/getAdvisory', NULL, $year, $value);
        
        $this->excel->getActiveSheet()->setCellValue('A10', $section->level.' - '.$section->section);
        $this->excel->getActiveSheet()->mergeCells('A10:I10');
        $this->excel->getActiveSheet()->getStyle('A10:I10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValue('A12', 'Moderator : '.$adviser->row()->firstname.' '.$adviser->row()->lastname);
        $this->excel->getActiveSheet()->mergeCells('A12:B12');
        $this->excel->getActiveSheet()->getStyle('A12:B12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        $this->excel->getActiveSheet()->setCellValue('A14', '#');
        $this->excel->getActiveSheet()->setCellValue('B14', 'Name');
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        
        $students = $this->search_model->getPreviousStudent($option, $value, $year, $settings);
        //$students = $this->get_registrar_model->getAllCollegeStudents(600, 0, $level_id, NULL, $sy);
        $column = 15;
        foreach ($students as $s):
            $column++;
            
            $this->excel->getActiveSheet()->setCellValue('A'.$column, ($column-15));
            $this->excel->getActiveSheet()->getStyle('A'.$column)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('B'.$column, strtoupper($s->lastname.', '.$s->firstname.' '.substr($s->middlename, 0,1).'. '));

        endforeach;
        
        $filename=$settings->short_name.'_'.$year.'_'.$s->level.'_'.$s->section.'.xls'; //save our workbook as this file name
       // $filename=$settings->short_name.'_'.$sy.'_'.$s->course_id.'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    function getStudentByGradeLevel($grade_id, $value=NULL, $year=NULL)
    {
        $student = $this->search_model->getStudentByGradeLevel($value, $grade_id, $year=NULL);
            //echo $option;
        $data['students'] = $student;
        $this->load->view('studentTable', $data);
    }
    
    function getStdByGradeLevel($grade_id, $value = NULL, $year = NULL) {
        $settings = Modules::run('main/getSet');
        $student = $this->search_model->getStdByGradeLevel($grade_id, $value, $year);
        //echo $option;
        $data['students'] = $student;

        if (file_exists(APPPATH . 'modules/search/views/' . strtolower($settings->short_name) . '_studentTable.php')):
            $this->load->view(strtolower($settings->short_name) . '_studentTable', $data);
        else:
            $this->load->view('studentTable', $data);
        endif;
    }
    
    function searchStudentAccounts($value, $year=NULL, $sem = NULL)
    {
        $student = $this->search_model->searchStudentAccounts($value, $year, $sem);
        echo '<ul>';
        foreach ($student as $s):
        ?>
           <li style="font-size:18px;" onclick="$('#searchName').hide(), $('#searchBox').val(&quot;<?php echo $s->firstname.' '.$s->lastname ?>&quot;), loadDetails('<?php echo base64_encode($s->st_id) ?>')" ><?php echo strtoupper($s->firstname.' '.$s->lastname) ?></li>   
        <?php        
        endforeach;
        echo '</ul>';
        
    }
    
    function searchStudentAccountsK12($value, $year=NULL, $semester = NULL)
    {
        $student = $this->search_model->searchStudentAccountsK12($value, $year, $semester);
        echo '<ul>';
        foreach ($student as $s):
        ?>
                <li style="font-size:18px;" onclick="$('#searchName').hide(), $('#searchBox').val(&quot;<?php echo $s->firstname.' '.$s->lastname.' - '.$s->lvl ?>&quot;), loadDetails('<?php echo base64_encode($s->st_id) ?>','<?php echo $year ?>','<?php echo $semester ?>')" ><?php echo strtoupper($s->lastname.', '.$s->firstname.' - '.$s->lvl) ?></li>   
        <?php        
        endforeach;
        echo '</ul>';
        
    }
    
    function sample2()
    {
        
    }
    
    function sample3()
    {
        echo 'hello';
    }
    
    
    
}
