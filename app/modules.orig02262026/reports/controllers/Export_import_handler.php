<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of export_import_handler
 *
 * @author genesis
 */
class export_import_handler extends MX_Controller {
    //put your code here
    
    function __construct() {
        parent::__construct();
        $this->load->model('ex_im_model');
        $this->load->helper('download');
    }
    
    function exportExcel($section_id, $subject_id, $cat_id)
    {
       //load our new PHPExcel library
        $this->load->library('excel');
        //activate worksheet number 1
        
        $columnData = $this->ex_im_model->getExpColumns($section_id);
        $category = Modules::run('gradingsystem/getAssessmentById', $cat_id);
        $section = Modules::run('registrar/getSectionById', $section_id);
        $subject = Modules::run('academic/getSpecificSubjects', $subject_id);
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($category->category_name.' Assessment');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->getDefaultColumnDimension()->setWidth(12);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getNumberFormat('General');
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        
        $this->excel->getActiveSheet()->setCellValue('A1', $cat_id);
        $this->excel->getActiveSheet()->setCellValue('B1', $category->category_name);
        
        $this->excel->getActiveSheet()->setCellValue('A2', $subject_id); 
        $this->excel->getActiveSheet()->setCellValue('B2', $subject->subject);
        
        $this->excel->getActiveSheet()->setCellValue('A3', $section->grade_level_id);
        $this->excel->getActiveSheet()->setCellValue('B3', $section->level);
        
        $this->excel->getActiveSheet()->setCellValue('A4', $section_id);
        $this->excel->getActiveSheet()->setCellValue('B4', $section->section);
        
        $this->excel->getActiveSheet()->setCellValue('C1', 'Title');
        $this->excel->getActiveSheet()->setCellValue('C2', 'Date');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Number Of Items');

        $this->excel->getActiveSheet()->setCellValue('A6', 'ID_Number');
        $this->excel->getActiveSheet()->setCellValue('B6', 'lastname');
        $this->excel->getActiveSheet()->setCellValue('C6', 'firstname');
        $this->excel->getActiveSheet()->setCellValue('D6', 'q1_raw_score');
        $this->excel->getActiveSheet()->setCellValue('E6', 'q2_raw_score');
        $this->excel->getActiveSheet()->setCellValue('F6', 'q3_raw_score');
        $this->excel->getActiveSheet()->setCellValue('G6', 'q4_raw_score');
        $this->excel->getActiveSheet()->setCellValue('H6', 'q5_raw_score');
                
        $countColumn = 6;
        foreach ($columnData->result() as $row)
        {
            $countColumn++;
                $this->excel->getActiveSheet()->setCellValue('A'.$countColumn, "$row->ID_Number");
                $this->excel->getActiveSheet()->setCellValue('B'.$countColumn, $row->lastname);
                $this->excel->getActiveSheet()->setCellValue('C'.$countColumn, $row->firstname);
        }
           

        $filename=$category->category_name.'_'.$section->section.'_'.$subject->subject.'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    function importExcel($details, $studentDetails)
    {
        
        $assess_id = Modules::run('gradingsystem/saveImportAssessment', $details);
        foreach ($studentDetails as $s)
        {
            //echo $s['raw_score'].'<br />';
            Modules::run('gradingsystem/recordImportScore',$s['ID_Number'],$s['raw_score'] , $details['no_items'], $assess_id);
        }
    }

    function exp($section_id, $subject_id, $cat_id)
    {
       $columnData = $this->ex_im_model->getExpColumns($section_id);
       $category = Modules::run('gradingsystem/getAssessmentById', $cat_id);
       $new_report = $this->dbutil->csv_from_result($columnData);
       $section = Modules::run('registrar/getSectionById', $section_id);
       $subject = Modules::run('academic/getSpecificSubjects', $subject_id);
       write_file('db_backup/'.$category->category_name.'_'.$section->section.'_'.$subject->subject.'.csv',$new_report);
        
        $newCsvData = array();
        if (($handle = fopen('db_backup/'.$category->category_name.'_'.$section->section.'_'.$subject->subject.'.csv', "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $data[] = 'subject_id';
                $data[] = 'KPUP_id';
                $data[] = 'q1_title';
                $data[] = 'q1_date';
                $data[] = 'q1_raw';
                $data[] = 'q1_total';
                $data[] = 'q2_title';
                $data[] = 'q2_date';
                $data[] = 'q2_raw';
                $data[] = 'q2_total';
                $data[] = 'q3_title';
                $data[] = 'q3_date';
                $data[] = 'q3_raw';
                $data[] = 'q3_total';
                $data[] = 'q4_title';
                $data[] = 'q4_date';
                $data[] = 'q4_raw';
                $data[] = 'q4_total';
                $data[] = 'q5_title';
                $data[] = 'q5_date';
                $data[] = 'q5_raw';
                $data[] = 'q5_total';
                $newCsvData[] = $data;
            }
            fclose($handle);
        }

        $handle = fopen('db_backup/'.$category->category_name.'_'.$section->section.'_'.$subject->subject.'.csv', 'w');
        $x=0;
        //print_r($newCsvData);
        foreach ($newCsvData as $line) {
           $x++;
           if($x==1):
               fputcsv($handle, $line);
           endif;  
        }
        foreach ($columnData->result() as $row)
        {
            $data[0] = $row->ID_Number;
            $data[1] = $row->lastname;
            $data[2] = $row->firstname;
            $data[3] = $row->middlename;
            $data[4] = $row->section_id;
            $data[5] = '';
            $data[7] = $subject_id;
            $data[8] = $cat_id;


            fputcsv($handle, $data);
        }
        $fileData = file_get_contents('db_backup/'.$category->category_name.'_'.$section->section.'_'.$subject->subject.'.csv');
        force_download($category->category_name.'_'.$section->section.'_'.$subject->subject.'.csv', $fileData); 
        fclose($handle);
        
        
        echo '<h6>csv is successfully exported</h6>';
    }
    
    function imp($csv_array)
    {
        $assess_id = '';
        $line = 0;
        foreach ($csv_array as $row) {
              $line++;
              if($line==1):
                for($x=1;$x<=5;$x++){
                    if($row['q'.$x.'_title']!=""):
                       // echo $row['ID_Number'].' | '.$row['q'.$x.'_title'].' | '.$row['q'.$x.'_date'].' | '.$row['q'.$x.'_raw'].'<br />';
                        $details = array(
                            'assess_title' => $row['q'.$x.'_title'],
                            'assess_date' => $row['q'.$x.'_date'],
                            'section_id' => $row['section_id'],
                            'subject_id' => $row['subject_id'],
                            'faculty_id' => $this->session->userdata('user_id'),
                            'no_items' => $row['q'.$x.'_total'],
                            'quiz_cat' => $row['KPUP_id'],
                            'term' => $this->session->userdata('term'),
                        );
                        
                        $assess_id[] = Modules::run('gradingsystem/saveImportAssessment', $details);
                        $total[] = $row['q'.$x.'_total'];
                        $rawScore[] = $row['q'.$x.'_raw'];
                        //echo 'success';
                    else:
                       // echo 'q'.$x.'_title is blank'.'<br />';
                    endif;                    
                }  
             endif;
                
                    for($x=1;$x<=5;$x++){
                       if($row['q'.$x.'_title']!=""):
                           //echo $row['ID_Number'].' | '.$row['q'.$x.'_raw'].' | '.$assess_id[$x-1].'<br />';
                           Modules::run('gradingsystem/recordImportScore',$row['ID_Number'],$row['q'.$x.'_raw'] , $row['q'.$x.'_total'], $assess_id[$x-1]);
                        endif;
                 
                    }
       }

    }
}

?>
