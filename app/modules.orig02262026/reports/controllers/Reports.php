<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of print
 *
 * @author genesis
 */
class reports extends MX_Controller
{
    //put your code here

    protected $generate;


    public function __construct()
    {
        parent::__construct();
        $this->load->library('Pdf');
        $this->load->library('csvimport');
        $this->load->library('csvreader');
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->model('reports_model');
        //        set_time_limit(300) ;

    }

    public function getEnrollmentCount($grade_id = null, $type = null)
    {
        return $this->reports_model->getEnrollmentCount($grade_id, $type);
    }

    public function showEnrollmentCountList()
    {
        return $this->load->view('enrollmentCount');
    }

    public function checkIfGreater($data, $value)
    {
        if ($data > $value):
            return $value;
        else:
            return $data;
        endif;
    }

    public function getSubBH($bh)
    {
        $data = $this->reports_model->getSubBH($bh);
        return $data;
    }

    public function deportment($section, $term, $deportment, $sy)
    {
        $data['students'] = Modules::run('registrar/getAllStudentsForExternal', '', $section);
        $data['deport_desc'] = Modules::run('gradingsystem/getDeportmentByID', $deportment);
        //$data['deportment'] = Modules::run('gradingsystem/getBehaviorRate');
        $this->load->view('deportment', $data);
    }

    public function class_profile($section_id = null, $term = null, $school_year = null)
    {
        $settings = Modules::run('main/getSet');
        $gs_settings = Modules::run('gradingsystem/getSet', $school_year);
        $data['gs_settings'] = Modules::run('gradingsystem/getSet', $school_year);
        $data['school_year'] = $school_year;
        $data['students'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $section_id, null, "1", $school_year);
        if (file_exists(APPPATH . 'modules/reports/views/' . strtolower($settings->short_name) . '_classProfile.php')):
            $this->load->view(strtolower($settings->short_name) . '_classProfile', $data);
        else:
            $this->load->view('classProfile', $data);
        endif;
    }

    public function class_ranking($section_id = null, $grade_id = null, $term = null, $school_year = null)
    {
        $settings = Modules::run('main/getSet');
        $gs_settings = Modules::run('gradingsystem/getSet', $school_year);
        $data['gs_settings'] = Modules::run('gradingsystem/getSet', $school_year);
        $data['school_year'] = $school_year;
        $data['students'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $grade_id, null, "1", $school_year, null, $section_id);
        $data['getStudents'] = Modules::run('registrar/getAllStudentsForExternal', '', $section_id);
        if ($term != 0):
            if (file_exists(APPPATH . 'modules/reports/views/' . strtolower($settings->short_name) . '_classRanking.php')):
                $this->load->view(strtolower($settings->short_name) . '_classRanking', $data);
            else:
                $this->load->view('classRanking', $data);
            endif;
        else:
            if (file_exists(APPPATH . 'modules/reports/views/' . strtolower($settings->short_name) . '_classRanking_overAll.php')):
                $this->load->view(strtolower($settings->short_name) . '_classRanking_overAll', $data);
            else:
                $this->load->view('classRanking', $data);
            endif;
        endif;
    }

    // public function class_ranking($section_id=null, $term=NULL, $school_year=NULL )
    // {
    //     $settings = Modules::run('main/getSet');
    //     $gs_settings = Modules::run('gradingsystem/getSet', $school_year);
    //     $data['gs_settings'] = Modules::run('gradingsystem/getSet', $school_year);
    //     $data['school_year'] = $school_year;
    //     $data['students'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $section_id, NULL, "1", $school_year);
    //     $data['getStudents'] = Modules::run('registrar/getAllStudentsForExternal','', $section_id);
    //     if(file_exists(APPPATH.'modules/reports/views/'. strtolower($settings->short_name).'_classRanking.php')):
    //         $this->load->view(strtolower($settings->short_name).'_classRanking',$data);
    //     else:
    //         $this->load->view('classRanking',$data);
    //     endif;


    // }

    public function printRegistrationForm($st_id = null, $school_year = null)
    {
        $this->load->helper('file');
        $settings = Modules::run('main/getSet');
        $data['st_id'] = base64_decode($st_id);
        $data['student'] = Modules::run('registrar/getSingleStudent', base64_decode($st_id), $school_year);
        if (file_exists(APPPATH . 'modules/reports/views/' . strtolower($settings->short_name) . '_registration_form.php')):
            $this->load->view(strtolower($settings->short_name) . '_registration_form', $data);
        endif;
    }

    public function getLevelOfProficiency($school_year, $grading, $grade_level, $section = null, $subject = null)
    {
        if ($section == 'Select%20Section' || $section == 0):
            $section = null;
        endif;
        switch ($grading) {
            case 1:
                $data['term'] = 'first';
                break;
            case 2:
                $data['term'] = 'second';
                break;
            case 3:
                $data['term'] = 'third';
                break;
            case 4:
                $data['term'] = 'fourth';
                break;
        }
        $data['school_year'] = $school_year;
        $data['grading'] = $grading;
        $data['grade_id'] = $grade_level;
        $data['section_id'] = $section;
        $data['subject_id'] = $subject;

        $this->load->view('lopDetails', $data);
    }

    public function deleteINC($id)
    {
        $this->reports_model->deleteINC($id);
        return;
    }
    public function getINC($st_id, $sy)
    {
        $result = $this->reports_model->getINC($st_id, $sy);
        $last_key = end(array_keys($result->result()));
        //print_r($result->result());
        if ($result->num_rows() > 0):
            foreach ($result->result() as $backSub => $b):
                $grade_id = $b->grade_id - 1;
                if ($b->grade_id == 18):
                    $grade_id = 'IV';
                    if ($b->as_of == 0):
                        $grade_id = 'III';
                    endif;
                endif;

                if ($b->as_of == 0):
                    $backSubjectp .= $b->short_code . ' ' . $grade_id;
                    $bsp = 1;
                    if ($backSub != $last_key):
                        $backSubjectp .= ', ';
                    endif;
                else:
                    $backSubject .= $b->short_code . ' ' . $grade_id;
                    $bs = 1;
                    if ($backSub != $last_key):
                        $backSubject .= ',';
                    endif;
                endif;

            endforeach;
        else:
            $backSubjectp = '';
            $backSubject = '';
            $bsp = 0;
            $bs = 0;
        endif;
        $return = json_encode(array('backSubp' => $backSubjectp, 'backSubject' => $backSubject, 'bsp' => $bsp, 'bs' => $bs));
        return $return;
    }

    public function getRawINC($st_id, $sy)
    {
        $result = $this->reports_model->getINC($st_id, $sy);
        return $result;
    }

    public function saveINC()
    {
        $details = array(
            'subject' => $this->input->post('subject_id'),
            'st_id' => $this->input->post('st_id'),
            'grade_id' => $this->input->post('level_id'),
            'sy' => $this->session->userdata('school_year'),
            'as_of' => $this->input->post('option')
        );

        $result = $this->reports_model->saveINC($details, $this->input->post('st_id'), $this->input->post('subject_id'), $this->input->post('grade_id'));

        echo json_encode(array('subject' => $result->row()->subject, 'level' => $result->row()->level, 'id' => $result->row()->id));
    }



    public function getClassCardCount($section_id)
    {
        $count = Modules::run('registrar/getNumberOfStudentPerSection', $section_id, $this->session->userdata('school_year'), 1);
        $num = $count / 4;
        echo '<option >Select Page</option>';
        for ($x = 0; $x <= $num; $x++):
            $y = $y + 2;
?>
            <option value="<?php echo $y; ?>">Page <?php echo $x + 1 ?></option>
        <?php
        endfor;
    }

    public function getTopTen($section_id = null, $grade_id = null, $grading = null, $school_year = null, $subject_id = null)
    {
        $data['sy'] = $school_year;
        $data['gs_settings'] = Modules::run('gradingsystem/getSet', $school_year);
        if ($grading != 0):
            $generate = Modules::run('gradingsystem/getTopTenPerLevel');
            $section = Modules::run('registrar/getSectionById', $section_id);
            $data['getTopTen'] = $generate->getTopTenByGradeLevel($section_id, $section->grade_id, $grading, $school_year);
            $this->load->view('topTen', $data);
        else:
            $data['topTen'] = Modules::run('gradingsystem/gs_tops/getFinalTops', $grade_id, $school_year);
            //print_r($data['topTen']->result());
            $this->load->view('topTenFinal', $data);
        endif;
    }

    public function getTopTenRaw($section_id = null, $grade_id = null, $grading = null, $subject_id = null)
    {
        $generate = Modules::run('gradingsystem/getTopTenPerLevel');
        $topTen = $generate->getTopTenByGradeLevel($grade_id, $grading, $this->session->userdata('school_year'), $section_id);
        return $topTen;
    }


    public function post($value)
    {
        return $this->input->post($value);
    }

    public function rc_front()
    {
        return $this->load->view('reports/reportCard/pilgrimFront');
    }

    public function cc($function, $data = null)
    {
        $classCard = Modules::load('reports/class_card');
        $c_function = $classCard->$function($data);
        return $c_function;
    }

    public function export_to_excel()
    {
        //load our new PHPExcel library
        $this->load->library('excel');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('test worksheet');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->getDefaultColumnDimension()->setWidth(12);

        $this->excel->getActiveSheet()->setCellValue('A1', 'Assessment Category');
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);


        $this->excel->getActiveSheet()->setCellValue('B1', 'Knowledge');
        $this->excel->getActiveSheet()->setCellValue('C1', '1');
        $this->excel->getActiveSheet()->setCellValue('A2', 'Subject');
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);

        $this->excel->getActiveSheet()->setCellValue('B2', 'English');
        $this->excel->getActiveSheet()->setCellValue('C2', '1');
        $this->excel->getActiveSheet()->setCellValue('A3', 'Level');
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);

        $this->excel->getActiveSheet()->setCellValue('B3', 'Grade 7');
        $this->excel->getActiveSheet()->setCellValue('C3', '7');
        $this->excel->getActiveSheet()->setCellValue('A4', 'Section');
        $this->excel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('B4', 'Love');
        $this->excel->getActiveSheet()->setCellValue('C4', '3');

        $this->excel->getActiveSheet()->setCellValue('A6', 'ID_Number');
        $this->excel->getActiveSheet()->setCellValue('B6', 'lastname');
        $this->excel->getActiveSheet()->setCellValue('C6', 'firstname');

        //this is where loop begins
        $this->excel->getActiveSheet()->setCellValue('D6', 'q1_title');
        $this->excel->getActiveSheet()->setCellValue('E6', 'q1_date');
        $this->excel->getActiveSheet()->setCellValue('F6', 'q1_num_items');
        $this->excel->getActiveSheet()->setCellValue('G6', 'q1_raw_score');

        $this->excel->getActiveSheet()->setCellValue('H6', 'q2_title');
        $this->excel->getActiveSheet()->setCellValue('I6', 'q2_date');
        $this->excel->getActiveSheet()->setCellValue('J6', 'q2_num_items');
        $this->excel->getActiveSheet()->setCellValue('K6', 'q2_raw_score');


        $this->excel->getActiveSheet()->setCellValue('L6', 'q3_title');
        $this->excel->getActiveSheet()->setCellValue('M6', 'q3_date');
        $this->excel->getActiveSheet()->setCellValue('N6', 'q3_num_items');
        $this->excel->getActiveSheet()->setCellValue('O6', 'q3_raw_score');

        $this->excel->getActiveSheet()->setCellValue('P6', 'q4_title');
        $this->excel->getActiveSheet()->setCellValue('Q6', 'q4_date');
        $this->excel->getActiveSheet()->setCellValue('R6', 'q4_num_items');
        $this->excel->getActiveSheet()->setCellValue('S6', 'q4_raw_score');

        $this->excel->getActiveSheet()->setCellValue('T6', 'q5_title');
        $this->excel->getActiveSheet()->setCellValue('U6', 'q5_date');
        $this->excel->getActiveSheet()->setCellValue('V6', 'q5_num_items');
        $this->excel->getActiveSheet()->setCellValue('W6', 'q5_raw_score');

        $filename = 'Knowledge.xlsx'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    public function importAssessment()
    {
        //load library phpExcel
        $this->load->library("excel");
        //here i used microsoft excel 2007
        $processExport = Modules::load('reports/export_import_handler/');

        $data['error'] = ''; //initialize image upload error array to empty

        $config['upload_path'] = 'uploads';
        $config['overwrite'] = true;
        $config['allowed_types'] = '*';
        $config['max_size'] = '1000';

        $this->load->library('upload', $config);

        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
            print_r($data);
            //$this->load->view('csvindex', $data);
        } else {

            $file_data = $this->upload->data();
            $file_path = 'uploads/' . $file_data['file_name'];
            $term = $this->post('importTerm');

            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            //set to read only
            $objReader->setReadDataOnly(true);
            //load excel file
            $objPHPExcel = $objReader->load($file_path);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

            $num_rows = $objWorksheet->getHighestRow();

            // echo $objWorksheet->getCellByColumnAndRow(3,1)->getValue().'<br />';
            //echo $objWorksheet->getCellByColumnAndRow(3,2)->getValue().'<br />';

            for ($col = 3; $col <= 9; $col++) {
                //echo $col.' | '.$row.' | '.$objWorksheet->getCellByColumnAndRow($col,$row)->getValue().'<br />';
                echo '<br />';
                if ($objWorksheet->getCellByColumnAndRow($col, 1)->getValue() != ""):
                    $assess_details = array(
                        'assess_title'  => $objWorksheet->getCellByColumnAndRow($col, 1)->getValue(),
                        'assess_date'   => PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($col, 2)->getValue()),
                        'section_id'    => $objWorksheet->getCellByColumnAndRow(0, 4)->getValue(),
                        'subject_id'    => $objWorksheet->getCellByColumnAndRow(0, 2)->getValue(),
                        'faculty_id'    => $this->session->employee_id,
                        'no_items'      => $objWorksheet->getCellByColumnAndRow($col, 3)->getValue(),
                        'quiz_cat'      => $objWorksheet->getCellByColumnAndRow(0, 1)->getValue(),
                        'term'          => $term,
                        'school_year'   => $this->session->school_year,
                    );
                    for ($st = 7; $st <= ($num_rows); $st++) {

                        $student_details[] = array(
                            'ID_Number' => $objWorksheet->getCellByColumnAndRow(0, $st)->getValue(),
                            'raw_score' => $objWorksheet->getCellByColumnAndRow($col, $st)->getValue(),
                        );
                    }
                    $processExport->importExcel($assess_details, $student_details);
                endif;
            }
        ?>
            <script type="text/javascript">
                alert('Assessment successfully imported');
                document.location = '<?php echo base_url() . 'gradingsystem' ?>'
            </script>
            <?php
        }
    }

    // this next process is connection with form 137

    public function saveAcademicRecords($user_id = null)
    {
        $school_year = $this->post('school_year');
        $school = $this->post('school');
        $first = $this->post('first');
        $second = $this->post('second');
        $third = $this->post('third');
        $fourth = $this->post('fourth');
        $average = $this->post('average');
        $generalAverage = $this->post('generalAverage');
        $subject_id = $this->post('subject_id');
        $level_id = Modules::run('registrar/getGradeLevelByLevelCode', $this->post('grade_id'));
        $grade_id = $this->post('grade_id');
        $exist = $this->reports_model->checkAcad(base64_decode($user_id), $school_year);

        if (!$exist):

            $spr = array(
                'st_id'         => base64_decode($user_id),
                'grade_level_id'   => $level_id,
                'school_name'   => $school,
                'school_year'   => $school_year
            );

            $spr_id = $this->reports_model->saveSPR($spr);

            $ar = array(
                'spr_id'        => $spr_id,
                'subject_id'    => $subject_id,
                'first'         => $first,
                'second'        => $second,
                'third'         => $third,
                'fourth'        => $fourth,
                'avg'           => $average
            );

            $this->reports_model->saveAR($ar);
        else:
            $spr = array(
                'gen_ave'           => $average
            );
            $ar = array(
                'spr_id'        => $exist,
                'subject_id'    => $subject_id,
                'first'         => $first,
                'second'        => $second,
                'third'         => $third,
                'fourth'        => $fourth,
                'avg'           => $average
            );

            $this->reports_model->saveAR($ar);

            if ($generalAverage != ''):
                $this->reports_model->updateBasicSPR($exist, $spr);
            endif;


        endif;

        $data['acadRecords'] = $this->getAcadRecords(base64_decode($user_id), $school_year, $grade_id = null);

        $this->load->view('form137/academicRecordsModal', $data);
    }

    public function showAcadRecordsModal($user_id, $grade_id = null, $school_year = null)
    {
        $ar['acadRecords'] = $this->reports_model->getAcadRecords(base64_decode($user_id), $school_year, $grade_id);

        $this->load->view('form137/academicRecordsModal', $ar);
    }

    public function showAcadRecords($user_id, $grade_id = null, $school_year = null)
    {
        $ar['acadRecords'] = $this->reports_model->getAcadRecords(base64_decode($user_id), $school_year, $grade_id);

        $this->load->view('form137/academicRecords', $ar);
    }

    public function getAcadRecords($user_id, $school_year)
    {
        $acadRecords = $this->reports_model->getAcadRecords($user_id, $school_year);
        return $acadRecords;
    }

    public function deleteSingleRecord($spr_id)
    {
        $spr = $this->reports_model->deleteSingleRecord($spr_id);
        if ($spr):
            echo json_encode(array('status' => true));
        else:
            echo json_encode(array('status' => false));
        endif;
    }

    public function checkIfAcadExist($user_id, $levelCode)
    {
        $exist = $this->reports_model->checkIfAcadExist(base64_decode($user_id), $levelCode);
        if ($exist->num_rows() > 0):
            echo json_encode(array('status' => true, 'school' => $exist->row()->school_name, 'year' => $exist->row()->school_year, 'spr_id' =>  $exist->row()->spr_id));
        else:
            echo json_encode(array('status' => false));
        endif;
    }


    public function searchRecords()
    {
        //this will check the records in the spr
        $settings = Modules::run('main/getSet');
        $school_year = $this->post('school_year');
        $user_id = $this->post('user_id');
        $st_id = $this->post('st_id');
        $getLevel = Modules::run('registrar/getBasicStudent', $st_id, $school_year);
        $levelCode = $this->post('grade_level');
        $ifSave = $this->post('ifSave');
        $spr = $this->post('spr_id');

        $exist = $this->reports_model->checkIfAcadExist(base64_decode($user_id), $levelCode);
        $data['records'] = Modules::run('gradingsystem/getFinalCardByLevel', $user_id, $levelCode, $school_year);
        $data['st_id']           = $user_id;
        $data['school_year']     = $school_year;
        //print_r($data['records']->result());
        if (!$exist):
            if ($ifSave == '1'):
                $s = 0;
                foreach ($data['records']->result() as $records):

                    $firstGrading = Modules::run('gradingsystem/getFinalGrade', $st_id, $records->subject_id, 1, $school_year);
                    $secondGrading = Modules::run('gradingsystem/getFinalGrade', $st_id, $records->subject_id, 2, $school_year);
                    $thirdGrading = Modules::run('gradingsystem/getFinalGrade', $st_id, $records->subject_id, 3, $school_year);
                    $fourthGrading = Modules::run('gradingsystem/getFinalGrade', $st_id, $records->subject_id, 4, $school_year);
                    $aveGrading = Modules::run('gradingsystem/getFinalGrade', $st_id, $records->subject_id, 0, $school_year);
                    if ($records->is_validated != 0):
                        $s++;
                        $school_year = $data['records']->row()->school_year;

                        if ($s == 1):
                            $spr = array(
                                'st_id'         => base64_decode($user_id),
                                'grade_level_id' => $records->grade_id,
                                'school_name'   => $settings->set_school_name,
                                'school_year'   => $school_year
                            );

                            $spr_id = $this->reports_model->saveSPR($spr);

                        endif;
                        switch ($records->is_validated):
                            case '1':
                                $first = $records->first;
                                $second = '';
                                $third = '';
                                $fourth = '';
                                $ave = '';
                                break;
                            case '2':
                                $first = $records->first;
                                $second = $records->second;
                                $third = '';
                                $fourth = '';
                                $ave = '';
                                break;
                            case '3':
                                $first = $records->first;
                                $second = $records->second;
                                $third = $records->third;
                                $fourth = '';
                                $ave = '';
                                break;
                            case '4':
                                $first = ($records->first == 0 ? $firstGrading->row()->final_rating : $records->first);
                                $second = ($records->second == 0 ? $secondGrading->row()->final_rating : $records->second);
                                $third = ($records->third == 0 ? $thirdGrading->row()->final_rating : $records->third);
                                $fourth = ($records->fourth == 0 ? $fourthGrading->row()->final_rating : $records->fourth);
                                $ave = ($aveGrading->row()->final_rating == null ? ($first + $second + $third + $fourth) / 4 : $aveGrading->row()->final_rating);
                                break;
                        endswitch;

                        $ar = array(
                            'spr_id'        => $spr_id,
                            'subject_id'    => $records->s_id,
                            'first'         => $first,
                            'second'        => $second,
                            'third'         => $third,
                            'fourth'        => $fourth,
                            'avg'           => $ave
                        );

                        $this->reports_model->saveAR($ar);
                        $spr_id = $spr_id;

                    endif;
                endforeach;
            endif;

            $this->load->view('form137/autoFetchRecord', $data);
        else:
            if ($ifSave == '2'):
                foreach ($data['records']->result() as $records):

                    switch ($records->is_validated):
                        case '1':
                            $first = $records->first;
                            $second = '';
                            $third = '';
                            $fourth = '';
                            break;
                        case '2':
                            $first = $records->first;
                            $second = $records->second;
                            $third = '';
                            $fourth = '';
                            break;
                        case '3':
                            $first = $records->first;
                            $second = $records->second;
                            $third = $records->third;
                            $fourth = '';
                            break;
                        case '4':
                            $first = $records->first;
                            $second = $records->second;
                            $third = $records->third;
                            $fourth = $records->fourth;
                            break;
                    endswitch;

                    $this->updatedSPRecords($spr, $records->s_id, $first, $second, $third, $fourth);
                endforeach;
            else:
                //
?>
                <div class="alert alert-danger clearfix">
                    <h5 class="text-center">INFO: Record has already been processed. Do you want to repeat the process? Or Delete the Records <br /><br />
                        <span class="btn btn-success" onmouseover="$('#saveController').val('2')" onclick="getRecords()">Yes</span>&nbsp;<span data-dismiss="modal" class="btn btn-danger">No</span>&nbsp;<span onclick="deleteSPRecord('<?php echo $spr_id ?>')" data-dismiss="modal" class="btn btn-danger">Delete</span>
                    </h5>
                </div>
            <?php
            endif;
        //
        endif;
    }

    public function deleteSPRecords($spr_id)
    {
        $spr = $this->reports_model->deleteSPRecords($spr_id);
        if ($spr):
            echo json_encode(array('status' => true));
        else:
            echo json_encode(array('status' => false));
        endif;
    }

    public function updatedSPRecords($spr_id, $subject_id, $first, $second, $third, $fourth)
    {
        $ar = array(
            'first'         => $first,
            'second'        => $second,
            'third'         => $third,
            'fourth'        => $fourth
        );

        $this->reports_model->updateSPRecords($spr_id, $subject_id, $ar);
        return;
    }

    public function getSPRecords($user_id, $year_level, $subject_id = null)
    {
        $spr = $this->reports_model->getSPRecords($user_id, $year_level, $subject_id);
        return $spr;
    }

    public function lock_unlock_SPR()
    {
        $spr = $this->reports_model->lock_unlock_SPR($this->post('spr_id'), $this->post('option'));
        return $spr;
    }

    public function getCurrentSPR_level($st_id, $next)
    {
        $spr = $this->reports_model->getCurrentSPR_level($st_id, $next);
        return $spr;
    }


    public function updateBasicSPR()
    {
        $spr_id = $this->post('spr_id');
        $school = $this->post('school');
        $school_year = $this->post('school_year');

        $details = array(
            'school_name' => $school,
            'school_year' => $school_year
        );

        $spr = $this->reports_model->updateBasicSPR($spr_id, $details);
    }


    public function getGrade($subject)
    {
        $plg = Modules::run('gradingsystem/getLetterGrade', $subject);
        foreach ($plg->result() as $plg) {
            if ($subject >= $plg->from_grade && $subject <= $plg->to_grade) {


                $grade = $plg->letter_grade;

                if ($grade != ""):
                    $grade = $grade;
                else:
                    $grade = "";
                endif;
            }
        }

        return $grade;
    }



    public function checkSubject($subject_id, $spr_id)
    {
        $exist = $this->reports_model->checkSubject($subject_id, $spr_id);
        if ($exist):
            echo json_encode(array('status' => true, 'msg' => 'Sorry, Subject already Exist'));
        endif;
    }


    public function generateForm137($section_id, $school_year)
    {
        $data['subjects'] = Modules::run('academic/getSubjects');
        //print_r(Modules::run('registrar/getAllStudentsByLevel',NULL, $section_id, $school_year));
        $data['students'] = Modules::run('registrar/getAllStudentsByLevel', null, $section_id, $school_year);
        $data['modules'] = "f137";
        $data['main_content'] = 'generateForm137';
        echo Modules::run('templates/main_content', $data);
    }

    public function getSchoolDays($year = null, $dept_id = null)
    {
        if ($year == null):
            $year = $this->input->post('year');
        endif;
        $data['exist'] = $this->reports_model->getSchoolDays($year, $dept_id);
        $this->load->view('form137/schoolDays', $data);
    }

    public function getRawSchoolDays($year, $dept_id = null)
    {
        $schoolDays = $this->reports_model->getSchoolDays($year, $dept_id);
        return $schoolDays;
    }


    public function saveSchoolDays()
    {
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $days = $this->input->post('numOfSchoolDays');
        $dept = $this->input->post('dept');
        $monthName = Modules::run('main/getMonthName', $month);

        $exist = $this->reports_model->getSchoolDays($year, $dept);

        $values = array(
            'dept_id' => $dept,
            'school_year' => $year,
            $monthName => $days
        );

        if (!$exist):
            if ($this->reports_model->insertSchoolDays($values)):
                echo json_encode(array('month' => $monthName, 'days' => $days));
            endif;
        else:
            if ($this->reports_model->updateSchoolDays($year, $values, $dept)):
                echo json_encode(array('month' => $monthName, 'days' => $days));
            endif;
        endif;
    }

    public function insertNumSchoolDays($monthName, $year, $days, $dept)
    {
        $exist = $this->reports_model->getSchoolDays($year, $dept);

        $values = array(
            'dept_id' => $dept,
            'school_year' => $year,
            $monthName => $days
        );

        if (!$exist):
            $this->reports_model->insertSchoolDays($values);
        else:
            $this->reports_model->updateSchoolDays($year, $values, $dept);
        endif;
    }

    public function autoFetchDays()
    {
        $school_year = $this->input->post('year');
        for ($i = 1; $i <= 12; $i++):
            if ($i != 5 && $i != 6):
                if ($i < 6):
                    $year = $school_year + 1;
                else:
                    $year = $school_year;
                endif;
                $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $i, 10)), $year, 'first');
                $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $i, 10)), $year, 'last');
                $holiday = Modules::run('calendar/holidayExist', $i, $year);
                $school_days = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $i, $year);
                $sdays = ($school_days - $holiday->num_rows());


                $monthName = Modules::run('main/getMonthName', $i);
                $exist = $this->reports_model->getSchoolDays($school_year);

                $values = array(
                    'school_year' => $school_year,
                    $monthName => $sdays
                );

                if (!$exist):
                    if ($this->reports_model->insertSchoolDays($values)):
                    // $this->getSchoolDays($school_year);
                    endif;
                else:
                    if ($this->reports_model->updateSchoolDays($school_year, $values)):

                    endif;
                endif;
            endif;
        endfor;
        $this->getSchoolDays($school_year);
    }

    public function getDaysPresentRaw($spr_id)
    {

        $data['exist'] = $this->reports_model->getDaysPresent($spr_id);
        if (!$data['exist']):
            $data['schoolDays'] = "";
        else:
            $data['schoolDays'] = $this->getRawSchoolDays($data['exist']->row()->school_year);
        endif;


        return $data;
    }

    public function autoFetchDaysPresent()
    {
        $spr_id = $this->input->post('spr_id');
        $spr_details = $this->reports_model->getSPRById($spr_id);

        for ($i = 1; $i <= 12; $i++):
            if ($i != 5 && $i != 6):
                if ($i < 10):
                    $i = '0' . $i;
                endif;
                switch ($i):
                    case 1:
                    case 2:
                    case 3:
                        $school_year =  $spr_details->school_year + 1;
                        break;
                    default:
                        $school_year =  $spr_details->school_year;
                        break;
                endswitch;
                $present = Modules::run('attendance/getIndividualMonthlyAttendance', $spr_details->st_id, $i, $school_year);
                if ($present > 0):
                    $present = $present;
                else:
                    $present = 0;
                endif;
                //echo $spr_details->st_id.' - '.$present.'<br />';

                $monthName = Modules::run('main/getMonthName', $i);
                $exist = $this->reports_model->getDaysPresent($spr_details->spr_id);

                $values = array(
                    'spr_id' => $spr_details->spr_id,
                    $monthName => $present
                );

                if (!$exist):
                    if ($this->reports_model->insertDaysPresent($values)):
                    // $this->getSchoolDays($school_year);
                    endif;
                else:
                    if ($this->reports_model->updateDaysPresent($spr_details->spr_id, $values)):

                    endif;
                endif;
            endif;
        endfor;
        $this->getDaysPresentModal($spr_details->spr_id, $st_id);
    }

    public function getDaysPresent($spr_id = null)
    {
        if ($spr_id == null):
            $spr_id = $this->post('spr_id');
        endif;

        $data['exist'] = $this->reports_model->getDaysPresent($spr_id);
        if (!$data['exist']):
            $data['schoolDays'] = "";
        else:
            $data['schoolDays'] = $this->getRawSchoolDays($data['exist']->row()->school_year);
        endif;
        $data['spr_id'] = $spr_id;
        $this->load->view('form137/daysPresent', $data);
    }

    public function getDaysPresentModal($spr_id = null, $st_id = null)
    {
        if ($spr_id == null):
            $spr_id = $this->post('spr_id');
        endif;
        $data['rfid'] = $st_id;
        $data['exist'] = $this->reports_model->getDaysPresent($spr_id);
        $data['schoolDays'] = $this->getRawSchoolDays($data['exist']->row()->school_year);

        $this->load->view('form137/daysPresentModal', $data);
    }


    public function savePresentDays()
    {
        $month = $this->post('month');
        $days = $this->post('days');
        $spr_id = $this->post('spr_id');
        $monthName = Modules::run('main/getMonthName', $month);

        $exist = $this->reports_model->getDaysPresent($spr_id);

        $values = array(
            'spr_id' => $spr_id,
            $monthName => $days
        );

        if (!$exist):
            if ($this->reports_model->insertDaysPresent($values)):
                echo json_encode(array('month' => $monthName, 'days' => $days));
            endif;
        else:
            if ($this->reports_model->updateDaysPresent($spr_id, $values)):
                echo json_encode(array('month' => $monthName, 'days' => $days));
            endif;
        endif;
    }

    public function saveEdHistory()
    {
        $edHistory = array(
            'st_id'     => $this->input->post('st_id'),
            'name_of_school'     => $this->input->post('elemSchool'),
            'gen_ave'     => $this->input->post('genAve'),
            'school_year'     => $this->input->post('school_year'),
            'total_years'     => $this->input->post('yearsCompleted'),
            'curriculum'     => $this->input->post('curriculum'),
        );

        $checkEdHistory = $this->reports_model->getEdHistory($this->input->post('st_id'));
        if ($checkEdHistory->st_id != ""):
            $this->reports_model->updateEdHistory($this->input->post('st_id'), $edHistory);
            echo json_encode(array('status' => true, 'msg' => "Information Succesfully Updated"));
        else:
            if ($this->reports_model->saveEdHistory($edHistory)):
                echo json_encode(array('status' => true, 'msg' => "Information Succesfully added"));
            else:
                echo json_encode(array('status' => false, 'msg' => "Internal Error Occured"));
            endif;
        endif;
    }

    public function generateF137($st_id)
    {
        $student = Modules::run('registrar/getSingleStudent', $st_id);
        $data['edHistory'] = $this->reports_model->getEdHistory($st_id);
        $data['student'] = Modules::run('registrar/getSingleStudent', $st_id);

        if ($student->grade_level_id <= 7):
            $this->load->view('form137/formElementary', $data);
        else:
            $this->load->view('form137/formJuniorHigh', $data);
        endif;
    }

    public function printForm137($st_id)
    {
        $gs_settings = Modules::run('gradingsystem/getSet');
        $settings = Modules::run('main/getSet');
        $data['gs_settings'] = Modules::run('gradingsystem/getSet');
        $data['settings'] = Modules::run('main/getSet');
        $data['edHistory'] = $this->reports_model->getEdHistory(base64_decode($st_id));
        $data['student'] = Modules::run('registrar/getSingleStudent', base64_decode($st_id));
        if ($gs_settings->customized_f137):
            $this->load->view('form137/' . strtolower($settings->short_name) . '_main', $data);
        else:
            $this->load->view('form137/main', $data);
        endif;
    }

    public function printF137($st_id, $sy, $val)
    {
        $gs_settings = Modules::run('gradingsystem/getSet');
        $settings = Modules::run('main/getSet');
        $data['gs_settings'] = Modules::run('gradingsystem/getSet');
        $data['settings'] = Modules::run('main/getSet');
        $data['edHistory'] = $this->reports_model->getEdHistory(base64_decode($st_id));
        $data['year'] = $sy;
        $data['student'] = Modules::run('registrar/getSingleStudentSPR', base64_decode($st_id), $sy);
        if ($gs_settings->customized_f137):
            $this->load->view('form137/' . strtolower($settings->short_name) . '_main', $data);
        else:
            if ($val == 1):
                $this->load->view('form137/gs_main', $data);
            elseif ($val == 2):
                $this->load->view('form137/jhs_main', $data);
            elseif ($val == 3):
                $this->load->view('form137/shs_main', $data);
            else:
                $this->load->view('form137/kinder_main', $data);
            endif;
        endif;
    }

    public function printClassRecord($section_id, $subject_id, $term)
    {
        $data['section_id'] = $section_id;
        $data['subject_id'] = $subject_id;
        $data['term'] = $term;
        $this->load->view('printClassRecord');
    }

    public function generateReportCard($st_id, $term, $school_year = null)
    {
        $this->load->helper('file');
        $settings = Modules::run('main/getSet');
        $data['student'] = Modules::run('registrar/getSingleStudent', $st_id, $school_year);
        $gs_settings = Modules::run('gradingsystem/getSet', $school_year);
        $data['core_values'] = $this->getCoreValues();
        if ($data['student']->grade_id >= 2 && $data['student']->grade_id <= 7):
            $dept = 12;
        else:
            $dept = 0;
        endif;
        if ($gs_settings->customized_card):
            // $data['behavior'] = Modules::run('gradingsystem/getBH', 2, NULL);
            $data['behavior'] = Modules::run('gradingsystem/getCoreValues');
        else:
            // $data['behavior'] = Modules::run('gradingsystem/getBH', $gs_settings->gs_used, $dept);
            $data['behavior'] = Modules::run('reports/getCoreValues');
        endif;

        $data['sy'] = $school_year;
        $data['term'] = $term;
        $data['strand'] = $data['student']->str_id;
        $data['sname'] = file_exists(APPPATH . 'modules/reports/views/' . strtolower($settings->short_name) . '_generateReportCard.php');
        // print_r($school_year);
        switch (strtolower($settings->short_name)):
            case 'dpma':
                echo Modules::run('customize/generateReportCard', strtolower($settings->short_name), $data['student'], $term, $data['behavior'], $data['core_values'], $school_year);
                break;
            // case 'wiserkidz':
            //     echo Modules::run('customize/generateReportCard', strtolower($settings->short_name), $data['student'], $term, $data['behavior'], $data['core_values'], $school_year);
            //     break;
            default:
                echo $this->load->view('generateReportCard', $data);
                break;
        endswitch;
        //        if ($data['student']->grade_id == 12 || $data['student']->grade_id == 13):
        //            if (file_exists(APPPATH . 'modules/reports/views/' . strtolower($settings->short_name) . '_generateReportCard_sh.php')):
        //                $this->load->view(strtolower($settings->short_name) . '_generateReportCard_sh.php', $data);
        //            else:
        //                $this->load->view('generateReportCard_sh', $data);
        //            endif;
        //        else:
        //            if (strtolower($settings->short_name) == 'aac'):
        //                $this->load->view('aac_generateReportCard.php', $data);
        //            else:
        //                $this->load->view('generateReportCard', $data);
        //            endif;
        //        endif;
    }

    public function generateCard($section_id = null, $year = null, $strand = null)
    {
        $data['strand'] = $strand;
        $data['ro_year'] = Modules::run('registrar/getROYear');
        $data['students'] = Modules::run('registrar/getAllStudentsForExternal', '', $section_id, null, 1, $year);
        $data['modules'] = "reports";
        $data['main_content'] = 'generateCard';
        echo Modules::run('templates/main_content', $data);
    }

    public function getBhRate($group, $dept_id = null)
    {
        $bh = $this->reports_model->getBehaviorRate($group, $dept_id);
        return $bh;
    }

    public function getBehaviorStatement($id, $sy, $term, $stid)
    {
        $data['stid'] = $stid;
        $data['term'] = $term;
        $data['sy'] = $sy;
        // $data['bhrate'] = Modules::run('reports/getBhRate', $id, $dept_id);
        $data['bhrate'] = $this->getBhRate($id, 1);
        // $data['bhrate'] = Modules::run('reports/getBhRate', $id);
        $this->load->view('displayCoreValues', $data);
    }

    public function cardReview($student_id = null, $school_year = null, $grading = null, $strand = null)
    {
        $gs_settings = Modules::run('gradingsystem/getSet', $school_year);
        $data['sy'] = $school_year;
        $data['term'] = $grading;
        $data['student'] = Modules::run('registrar/getSingleStudent', base64_decode($student_id), $school_year);
        $data['behavior'] = $this->reports_model->getBehaviorRate(0);
        switch ($gs_settings->gs_used):
            case 2:
                $data['bh_group'] = $this->reports_model->getBhGroup(2);

                // no break
            default:
                break;
        endswitch;
        if ($strand != null):
            $data['strand'] = $strand;
            $this->load->view('reportCardPreviewData_sh', $data);
        else:
            $data['strand'] = 0;
            $this->load->view('reportCardPreviewData', $data);
        endif;
    }

    public function printReportCard($student_id = null, $school_year = null, $date_admitted = null, $grading = null, $strand = null, $admitted = null)
    {
        $this->load->helper('file');
        $gs_settings = Modules::run('gradingsystem/getSet', $school_year);
        $settings = Modules::run('main/getSet');
        $data['admitted'] = $admitted;
        $data['sy'] = $school_year;
        $data['term'] = $grading;
        $data['student'] = Modules::run('registrar/getSingleStudent', base64_decode($student_id), $school_year);
        switch ($gs_settings->gs_used):
            case 1:
                if ($gs_settings->customized_card):
                    $data['behavior'] = $this->reports_model->getBehaviorRate(0);
                    $this->load->view('reportCard/' . strtolower($settings->short_name) . '_front', $data);
                else:
                    $this->load->view('reportCard/reportCard', $data);
                endif;

                break;
            case 2:
                if ($gs_settings->customized_card):
                    switch (strtolower($settings->short_name)):
                        case 'wiserkidz':
                        case 'csfl':
                        case 'maclc':
                        case 'dpma':
                            echo Modules::run('customize/printReportCard', strtolower($settings->short_name), $data['student'], $admitted, $school_year, $grading);
                            break;
                        default:
                            $this->load->view('customMsge');
                            // $this->load->view('newReportCard/reportCard', $data);
                            break;
                    endswitch;
                else:
                    $this->load->view('newReportCard/reportCard', $data);
                endif;
                break;
            default:
                $this->load->view('reportCard/reportCard', $data);
                break;
        endswitch;
    }

    public function printIndividual($st_id, $term, $school_year, $grade_level, $section)
    {
        $this->load->library('pdf');
        $settings = Modules::run('main/getSet');

        if ($school_year == $this->session->school_year):
            $data['section'] = $section;
            $data['gradeLevel'] = $grade_level;
        else:
            $gradeSection = Modules::run('registrar/getGradeSectionByYear', $school_year, $st_id);
            $data['section'] = $gradeSection->section_id;
            $data['gradeLevel'] = $gradeSection->grade_level_id;
        endif;
        $data['sy'] = $school_year;
        $data['st_id'] = $st_id;
        $data['grading'] = $term;
        $this->load->view('reportCard/' . strtolower($settings->short_name) . '_cardDetails_individual_front', $data);
    }


    public function getSingleStudent($user_id, $year = null)
    {
        $student = $this->reports_model->getSingleStudent($user_id, $year);
        return $student;
    }



    public function depEdForm1($section_id = null, $school_year = null, $grade_id = null)
    {
        //        $students = Modules::run('registrar/getAllStudentsForExternal','', $section_id);
        //        print_r($students->result());
        $settings = Modules::run('main/getSet');
        $data['male'] = Modules::run('registrar/getAllStudentsByGender', $section_id, 'Male', null, $school_year);
        $data['female'] = Modules::run('registrar/getAllStudentsByGender', $section_id, 'Female', null, $school_year);
        $data['getStudents'] = Modules::run('registrar/getAllStudentsForExternal', '', $section_id, null, null, $school_year);
        if (file_exists(APPPATH . 'modules/reports/views/sf/' . strtolower($settings->short_name) . '_depEdForm1.php')):
            $this->load->view('sf/' . strtolower($settings->short_name) . '_depEdForm1', $data);
        else:
            $this->load->view('sf/depEdForm1', $data);
        endif;
    }

    public function depEdForm2($section_id = null, $date = null, $school_year = null, $grade_id = null)
    {
        //        $students = Modules::run('registrar/getAllStudentsForExternal','', $section_id);
        //        print_r($students->result());

        $data['male'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $grade_id, 'Male', "", $school_year, '', $section_id);
        $data['maleEoSY'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $grade_id, 'Male', "0", $school_year, '', $section_id);
        $data['femaleEoSY'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $grade_id, 'Female', "0", $school_year, '', $section_id);
        $data['female'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $grade_id, 'Female', "", $school_year, '', $section_id);
        if ($date != null):
            $data['month'] = $date;
        else:
            $data['month'] = date('F');
        endif;
        $data['CI'] = &get_instance();
        $data['getStudents'] = Modules::run('registrar/getAllStudentsForExternal', '', $section_id);
        $this->load->view('sf/depEdForm2', $data);
    }

    public function depEdForm4($date = null, $year = null)
    {
        //        $students = Modules::run('registrar/getAllStudentsForExternal','', $section_id);
        //        print_r($students->result());
        $settings = $this->eskwela->getSet();
        $data['gradeLevel'] = Modules::run('registrar/getGradeLevel', $settings->level_catered);
        $data['section'] = Modules::run('registrar/getAllSection', null, $settings->level_catered);
        $data['month'] = $date;
        $data['CI'] = &get_instance();
        $data['school_year'] = $year;

        if ($date == 06):
            $this->load->view('sf/depEdForm4', $data);
        else:
            $this->load->view('sf/depEdForm4', $data);
        endif;
        //$this->load->view('sf/sf4',$data);

    }

    public function depEdForm5($section_id = null, $year = null)
    {
        $data['CI'] = &get_instance();
        $data['sy'] = $year;
        $data['male'] = Modules::run('registrar/getAllStudentsByGender', $section_id, 'Male', 1, $year);
        $data['female'] = Modules::run('registrar/getAllStudentsByGender', $section_id, 'Female', 1, $year);
        $data['getStudents'] = Modules::run('registrar/getAllStudentsForExternal', '', $section_id, $year);
        $this->load->view('sf/depEdForm5', $data);
    }

    public function depEdForm6($year = null)
    {
        $data['CI'] = &get_instance();
        $data['sy'] = $year;
        $this->load->view('sf/depEdForm6', $data);
    }

    public function depEdForm7()
    {
        $data['getTeachers'] = Modules::run('hr/getEmployees');
        $this->load->view('sf/depEdForm7', $data);
    }

    public function enrollmentList($grade_id = null, $year = null, $strand = null, $section_id = null)
    {
        $settings = $this->eskwela->getSet();
        $data['str_id'] = $strand;
        if ($settings->short_name != 'aac'):
            $data['male'] = Modules::run('registrar/getAllStudentsByGender', $grade_id, 'Male', "1", $year, $strand);
            $data['female'] = Modules::run('registrar/getAllStudentsByGender', $grade_id, 'Female', "1", $year, $strand);
            $data['getStudents'] = Modules::run('registrar/getAllStudentsByGender', $grade_id, null, 1, $year, $strand);
        else:
            $data['male'] = $this->reports_model->getAllStudentsByGender(($strand == null || $strand == 0 ? $grade_id : $section_id), 'Male', "1", $year, $strand);
            $data['female'] = $this->reports_model->getAllStudentsByGender(($strand == null || $strand == 0 ? $grade_id : $section_id), 'female', "1", $year, $strand);
            $data['getStudents'] = $this->reports_model->getAllStudentsByGender(($strand == null || $strand == 0 ? $grade_id : $section_id), null, 1, $year, $strand);
        endif;
        if ($strand == null || $strand == 0):
            if (file_exists(APPPATH . 'modules/reports/views/' . strtolower($settings->short_name) . '_enrollmentList.php')):
                $this->load->view(strtolower($settings->short_name) . '_enrollmentList', $data);
            else:
                $this->load->view('enrollmentList', $data);
            endif;
        else:
            $this->load->view('enrollmentListSH', $data);
        endif;
    }

    //    public function enrollmentList($section_id=null, $year=NULL, $strand=NULL)
    //    {
    //        $settings = $this->eskwela->getSet();
    //       $data['str_id'] = $strand;
    //        $data['male'] = Modules::run('registrar/getAllStudentsByGender', $section_id, 'Male', "1", $year, $strand);
    //        $data['female'] = Modules::run('registrar/getAllStudentsByGender', $section_id, 'Female', "1", $year, $strand);
    //        $data['getStudents'] = Modules::run('registrar/getAllStudentsByGender',$section_id, NULL, 1, $year, $strand);
    //        if($strand==NULL || $strand==0):
    //            if(file_exists(APPPATH.'modules/reports/views/'. strtolower($settings->short_name).'_enrollmentList.php')):
    //                $this->load->view(strtolower($settings->short_name).'_enrollmentList',$data);
    //            else:
    //                $this->load->view('enrollmentList',$data);
    //            endif;
    //        else:
    //            $this->load->view('enrollmentListSH',$data);
    //       endif;

    //    }

    public function grading_sheet($section_id = null, $subject_id = null, $school_year = null, $strand = null, $grade_id = null)
    {
        $settings = Modules::run('main/getSet');
        $data['male'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $grade_id, 'Male', 1, $school_year, $strand, $section_id);
        $data['female'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $grade_id, 'Female', 1, $school_year, $strand, $section_id);
        $data['getStudents'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $section_id, null, $school_year);
        $data['subject_id'] = $subject_id;
        if (file_exists(APPPATH . 'modules/reports/views/' . strtolower($settings->short_name) . '_grading_sheet.php')):
            $this->load->view(strtolower($settings->short_name) . '_grading_sheet', $data);
        else:
            $this->load->view('grading_sheet', $data);
        endif;
    }

    public function master_sheet($section_id = null, $term = null, $school_year = null, $strand = null, $grade_id = null)
    {
        $settings = Modules::run('main/getSet');
        $gs_settings = Modules::run('gradingsystem/getSet', $school_year);
        $data['gs_settings'] = Modules::run('gradingsystem/getSet', $school_year);
        $data['school_year'] = $school_year;
        $data['male'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $grade_id, 'Male', "1", $school_year, $strand, $section_id);
        $data['female'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $grade_id, 'Female', "1", $school_year, $strand, $section_id);
        $data['getStudents'] = Modules::run('registrar/getAllStudentsForExternal', '', $section_id);
        switch (strtolower($settings->short_name)):
            case 'csfl':
                echo Modules::run('customize/master_sheet', strtolower($settings->short_name), $data, $term);
                break;
            default:
                if ($grade_id >= 12 && $grade_id <= 13):
                    $data['strand'] = $strand;
                    $data['gradeLevel'] = $grade_id;
                    if (file_exists(APPPATH . 'modules/reports/views/' . strtolower($settings->short_name) . '_master_sheet_sh.php')):
                        $this->load->view(strtolower($settings->short_name) . '_master_sheet_sh', $data);
                    else:
                        $this->load->view('master_sheet_sh', $data);
                    endif;
                else:
                    if (file_exists(APPPATH . 'modules/reports/views/' . strtolower($settings->short_name) . '_master_sheet.php')):
                        $this->load->view(strtolower($settings->short_name) . '_master_sheet', $data);
                    else:
                        $this->load->view('master_sheet', $data);
                    endif;
                endif;
                break;
        endswitch;
        //        if (file_exists(APPPATH . 'modules/reports/views/' . strtolower($settings->short_name) . '_master_sheet.php')):
        //            if ($grade_id >= 12 && $grade_id <= 13): // section id is change to grade level
        //                if ($strand != NULL):
        //                    $data['strand'] = $strand;
        //                    $data['gradeLevel'] = $grade_id;
        //                    $this->load->view(strtolower($settings->short_name) . '_master_sheet_sh', $data);
        //                else:
        //                    $this->load->view(strtolower($settings->short_name) . '_master_sheet', $data);
        //
        //                endif;
        //            else:
        //                $this->load->view(strtolower($settings->short_name) . '_master_sheet', $data);
        //            endif;
        //        else:
        //            $this->load->view('master_sheet', $data);
        //        endif;
    }

    public function preTestPerSubject($section_id = null, $subject_id = null)
    {
        $data['male'] = Modules::run('registrar/getAllStudentsByGender', $section_id, 'Male', "1");
        $data['female'] = Modules::run('registrar/getAllStudentsByGender', $section_id, 'Female', "1");
        $data['getStudents'] = Modules::run('registrar/getAllStudentsForExternal', '', $section_id);
        $this->load->view('preTest_perSubject', $data);
    }

    public function index()
    {
        $data['ro_year'] = Modules::run('registrar/getROYear');
        $settings = $this->eskwela->getSet();
        if ($this->session->userdata('is_admin') || $this->session->userdata('is_superAdmin')):
            $data['getAssignment'] = Modules::run('academic/mySubject');
        else:
            //            $data['getAssignment'] = Modules::run('academic/mySubject', $this->session->userdata('username'), $settings->school_year, 1);
            $data['getAssignment'] = Modules::run('academic/getSectionAssign', $this->session->userdata('username'), $settings->school_year);
        endif;
        $data['strand'] = Modules::run('subjectmanagement/getSHOfferedStrand');
        $data['gradeLevel'] = Modules::run('registrar/getGradeLevel', $settings->level_catered);
        $data['deportment'] = Modules::run('gradingsystem/getBehaviorRate');
        $data['modules'] = "reports";
        if (file_exists(APPPATH . 'modules/reports/views/' . strtolower($settings->short_name) . '_default.php')):
            $data['main_content'] = strtolower($settings->short_name) . '_default';
        else:
            $data['main_content'] = 'default';
        endif;
        echo Modules::run('templates/main_content', $data);
    }

    public function exportToCsv($grade_id = null, $section_id = null)
    {
        $data['report'] = $this->reports_model->getCSVData($grade_id, $section_id);
        $data['modules'] = "reports";
        $data['main_content'] = 'exportToCsv';
        echo Modules::run('templates/main_content', $data);
    }

    public function exportTeachersToCsv()
    {
        $data['report'] = $this->reports_model->getCSVDataForTeachers();
        $data['modules'] = "reports";
        $data['main_content'] = 'exportToCsv';
        echo Modules::run('templates/main_content', $data);
    }

    public function importUser()
    {
        $data['modules'] = "reports";
        $data['main_content'] = 'importCsv';
        echo Modules::run('templates/main_content', $data);
    }

    public function importTeachers()
    {
        $processProfile = Modules::load('registrar/registrardbprocess/');
        $processHr = Modules::load('hr/hrdbprocess/');

        $data['error'] = ''; //initialize image upload error array to empty

        $config['upload_path'] = 'uploads';
        $config['overwrite'] = true;
        $config['allowed_types'] = '*';
        $config['max_size'] = '1000';

        $this->load->library('upload', $config);


        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
            print_r($data);
            //$this->load->view('csvindex', $data);
        } else {

            $file_data = $this->upload->data();
            $file_path = 'uploads/' . $file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);

                foreach ($csv_array as $row) {

                    $st_id = $row['ID_Number'];
                    if (!Modules::run('hr/checkIfIDExist', $st_id)):
                        $rel_id = $processProfile->setReligion($row['religion']);
                        $items = array(
                            'rfid'             => '',
                            'lastname'         => $row['lastname'],
                            'firstname'        => $row['firstname'],
                            'middlename'       => $row['middlename'],
                            'add_id'           => 0,
                            'sex'              => $row['sex'],
                            'rel_id'           => $rel_id,
                            'bdate_id'         => 0,
                            'contact_id'       => 0,
                            'status'           => 0,
                            'nationality'      => $row['nationality'],
                            'account_type'     => $row['account_type'],
                            'avatar'           => $row['ID_Number'] . '.jpg'

                        );
                        //saves the basic info
                        $profile_id = $processProfile->saveProfile($items);

                        //saves more profile info

                        $profileInfo = array(
                            'employee_id'       => $st_id,
                            'user_id'           => $profile_id,
                            'position_id'       => $row['position_id'],
                            'awards_cert'       => 0,
                            'sss'               => $row['sss'],
                            'phil_health'       => $row['phil_health'],
                            'pag_ibig'          => $row['pag_ibig'],
                            'tin'               => $row['tin'],
                            'prc_id'            => 0,
                            'incase_name'       => $row['incase_name'],
                            'incase_contact'    => $row['incase_contact'],
                            'incase_relation'   => $row['incase_relation'],
                            'work_details'      => 0,
                            'date_hired'        => $row['date_hired'],
                            'em_status'         => 'Contractual',
                        );

                        $processHr->saveEmploymentDetails($profileInfo);

                        //saves the address
                        $barangay_id = $processProfile->setBarangay($row['barangay']);
                        $city = $processProfile->setCity($row['city_municipality']);

                        $add = array(
                            'street'                => $row['street'],
                            'barangay_id'           => $barangay_id,
                            'city_id'               => $city->id,
                            'province_id'           => $city->province_id,
                            'country'               => 'Philippines',
                            'zip_code'              => $row['zip_code'],
                        );

                        $address_id = $processProfile->setAddress($add, $profile_id);

                        //saves the basic contact
                        $processProfile->setContacts($row['contacts'], $row['email'], $profile_id);
                        //$processProfile->updateContact($row['contact_id'], $profile_id);

                        //saves the birthday
                        //$date = $row['birthday'];
                        $processProfile->setBdate($row['birthday'], $profile_id, 'bdate_id');

                        //saves the Academic Info
                        if ($row['course'] == '') {
                            $coursedata = array(
                                'course'  =>  $row['course'],
                            );

                            $course_id = $processHr->saveCourse($coursedata, $row['course']);
                        } else {
                            $course_id = 0;
                        }


                        // saves the College Information

                        $collegedata = array(
                            'school_name'  =>  $row['school_name'],
                            'school_add'  => $row['school_add'],
                        );

                        $college_id = $processHr->saveCollege($collegedata, $row['school_name']);

                        $details = array(
                            'eb_employee_id'    => $st_id,
                            'eb_level_id'       => 4,
                            'eb_school_id'      => $college_id,
                            'eb_course_id'      => $course_id,
                            'eb_year_grad'      => $row['year_graduated'],
                            'eb_highest_earn'   => 'Graduated',
                            'eb_dates_from'     => '',
                            'eb_dates_to'       => '',
                        );

                        Modules::run('hr/saveEducation', $details, $st_id);
                        $uname = $st_id;
                        $key = Modules::run('hr/passGenerator');
                        $accounts = array(
                            'u_id'          => $uname,
                            'uname'         => $uname,
                            'pword'         => md5($key),
                            'utype'         => $row['account_type'],
                            'secret_key'    => $key,
                            'isActive'    => 1,
                        );

                        $processHr->saveAccounts($accounts);
                    endif;

                    //$this->csv_model->insert_csv($insert_data);
                }
            ?>
                <script type="text/javascript">
                    alert('Uploaded Successfully')
                </script>
            <?php
            } else {
                $data['error'] = "Error occured";
            }
            print_r($data);
            //$this->load->view('csvindex', $data);
        }
    }

    public function export($section_id, $subject_id, $cat_id)
    {
        $processExport = Modules::load('reports/export_import_handler/');
        $processExport->exportExcel($section_id, $subject_id, $cat_id);
    }

    public function importAssessment1()
    {
        $processExport = Modules::load('reports/export_import_handler/');

        $data['error'] = ''; //initialize image upload error array to empty

        $config['upload_path'] = 'uploads';
        $config['overwrite'] = true;
        $config['allowed_types'] = '*';
        $config['max_size'] = '1000';

        $this->load->library('upload', $config);

        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
            print_r($data);
            //$this->load->view('csvindex', $data);
        } else {

            $file_data = $this->upload->data();
            $file_path = 'uploads/' . $file_data['file_name'];

            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
                $line = 0;
                $processExport->imp($csv_array);
            } else {
                $data['error'] = "Error occured";
                print_r($data);
                //$this->load->view('csvindex', $data);
            }
            ?>
            <script type="text/javascript">
                alert('Assessment successfully imported');
                document.location = '<?php echo base_url() . 'gradingsystem' ?>'
            </script>
        <?php
        }
    }

    public function importStudentsNew()
    {
        //load library phpExcel
        $this->load->library("excel");
        //here i used microsoft excel 2007

        $data['error'] = ''; //initialize image upload error array to empty

        $config['upload_path'] = 'uploads';
        $config['overwrite'] = true;
        $config['allowed_types'] = '*';
        $config['max_size'] = '1000';

        $this->load->library('upload', $config);

        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
            print_r($data);
            //$this->load->view('csvindex', $data);
        } else {
            $file_data = $this->upload->data();
            $file_path = 'uploads/' . $file_data['file_name'];

            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            //set to read only
            $objReader->setReadDataOnly(true);
            //load excel file
            $objPHPExcel = $objReader->load($file_path);

            $sheet_number = 0;
            $objWorksheet = $objPHPExcel->setActiveSheetIndex($sheet_number);

            $processAdmission = Modules::load('registrar/registrardbprocess/');

            $sy = $this->session->userdata('school_year');
            $settings = Modules::run('main/getSet');
            $num_rows = $objWorksheet->getHighestRow();

            for ($st = 2; $st <= ($num_rows); $st++) {
                if ($objWorksheet->getCellByColumnAndRow(0, $st)->getValue() != null):
                    $st_id = $objWorksheet->getCellByColumnAndRow(0, $st)->getValue();
                else:
                    Modules::run('registrar/getLatestIdNum', $objWorksheet->getCellByColumnAndRow(10, $st)->getValue());
                    $st_id = Modules::run('registrar/importLatestId');
                endif;

                $lastname = ($objWorksheet->getCellByColumnAndRow(1, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(1, $st)->getValue());
                $firstname = ($objWorksheet->getCellByColumnAndRow(2, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(2, $st)->getValue());
                $middlename = ($objWorksheet->getCellByColumnAndRow(3, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(3, $st)->getValue());
                $rfid = '';
                $birthdate = date("Y-m-d", ($objWorksheet->getCellByColumnAndRow(4, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(4, $st)->getValue()));
                $religion = ($objWorksheet->getCellByColumnAndRow(5, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(5, $st)->getValue());
                $street = ($objWorksheet->getCellByColumnAndRow(7, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(7, $st)->getValue());
                $barangay = ($objWorksheet->getCellByColumnAndRow(8, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(8, $st)->getValue());
                $mun_city = ($objWorksheet->getCellByColumnAndRow(9, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(9, $st)->getValue());
                $grade_id = ($objWorksheet->getCellByColumnAndRow(10, $st)->getValue() == null ? 0 : $objWorksheet->getCellByColumnAndRow(10, $st)->getValue());
                $section = ($objWorksheet->getCellByColumnAndRow(27, $st)->getValue() == null ? 0 : $objWorksheet->getCellByColumnAndRow(27, $st)->getValue());
                $f_lastname = ($objWorksheet->getCellByColumnAndRow(13, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(13, $st)->getValue());
                $f_firstname = ($objWorksheet->getCellByColumnAndRow(14, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(14, $st)->getValue());
                $f_middlename = ($objWorksheet->getCellByColumnAndRow(15, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(15, $st)->getValue());
                $f_occupation = '';
                $f_mobile = ($objWorksheet->getCellByColumnAndRow(12, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(12, $st)->getValue());
                $m_lastname = ($objWorksheet->getCellByColumnAndRow(18, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(18, $st)->getValue());
                $m_firstname = ($objWorksheet->getCellByColumnAndRow(19, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(19, $st)->getValue());
                $m_middlename = ($objWorksheet->getCellByColumnAndRow(20, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(20, $st)->getValue());
                $m_occupation = '';
                $m_mobile = ($objWorksheet->getCellByColumnAndRow(17, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(17, $st)->getValue());
                $ice_name = ($objWorksheet->getCellByColumnAndRow(24, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(24, $st)->getValue());
                $ice_contact = ($objWorksheet->getCellByColumnAndRow(25, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(25, $st)->getValue());
                $ice_relation = ($objWorksheet->getCellByColumnAndRow(26, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(26, $st)->getValue());

                $religion_id = $processAdmission->setReligion($religion);
                $basicInfo = array(
                    'user_id'          => $this->eskwela->codeCheck('profile', 'user_id', $this->eskwela->code()),
                    'rfid'             => $rfid,
                    'lastname'         => $lastname,
                    'firstname'        => $firstname,
                    'middlename'       => $middlename,
                    'add_id'           => 0,
                    'sex'              => '',
                    'rel_id'           => $religion_id,
                    'bdate_id'         => 0,
                    'contact_id'       => 0,
                    'nationality'      => 'Filipino',
                    'account_type'     => 5,
                    'ethnic_group_id'  => 0,
                    'occupation_id'    => 1,
                    'avatar'           => ''
                );

                $pid = $processAdmission->saveProfile($basicInfo);
                $profile_id = $pid->user_id;
                $processAdmission->setStudInfo($st_id, $profile_id, $section, $grade_id, '', '', $sy, '', '', '');

                //saves the address
                if ($barangay != null):
                    $barangay_id = $processAdmission->setBarangay($barangay, $sy);
                else:
                    $barangay_id = 0;
                endif;
                if ($street == null):
                    $street = '';
                endif;
                $city = Modules::run('main/getCities', $mun_city);

                $add = array(
                    'address_id'            => $this->eskwela->codeCheck('profile_address_info', 'address_id', $this->eskwela->code()),
                    'street'                => $street,
                    'barangay_id'           => $barangay_id,
                    'city_id'               => $city->cid,
                    'province_id'           => $city->province_id,
                    'country'               => 'Philippines',
                    'zip_code'              => 0,
                );

                $address_id = $processAdmission->setAddress($add, $profile_id, $sy);

                //saves the birthday
                $date = $birthdate;
                $processAdmission->setBdate($date, $profile_id, 'bdate_id');

                $parentsInfo = array(
                    'u_id' => $profile_id,
                    'p_id' => $this->eskwela->codeCheck('profile_parent', 'p_id', $this->eskwela->code()),
                    'f_lastname' => $f_lastname,
                    'f_firstname' => $f_firstname,
                    'f_middlename' => $f_middlename,
                    'f_mobile' => $f_mobile,
                    'f_occ' => $f_occupation,
                    'm_firstname' => $m_firstname,
                    'm_lastname' => $m_lastname,
                    'm_middlename' => $m_middlename,
                    'm_mobile' => $m_mobile,
                    'm_occ' => $m_occupation,
                    'ice_name' => $ice_name,
                    'ice_contact' => $ice_contact,
                    'ice_relation' => $ice_relation
                );

                $processAdmission->updateParentsInfo($profile_id, $parentsInfo, $sy);
            }
        ?>
            <script type="text/javascript">
                alert('Student Record successfully imported');
                document.location = '<?php echo base_url() . 'registrar/getAllStudents' ?>'
            </script>
        <?php
        }
    }

    public function importPrivateStudents()
    {
        //load library phpExcel
        $this->load->library("excel");
        //here i used microsoft excel 2007
        $processExport = Modules::load('reports/export_import_handler/');
        $sheet_number = $this->input->post('sheet_number');
        $data['error'] = ''; //initialize image upload error array to empty

        $config['upload_path'] = 'uploads';
        $config['overwrite'] = true;
        $config['allowed_types'] = '*';
        $config['max_size'] = '5000';

        $this->load->library('upload', $config);

        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
            print_r($data);
            //$this->load->view('csvindex', $data);
        } else {

            $file_data = $this->upload->data();
            $file_path = 'uploads/' . $file_data['file_name'];

            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            //set to read only
            $objReader->setReadDataOnly(true);
            //load excel file
            $objPHPExcel = $objReader->load($file_path);
            if ($sheet_number != ""):
                $sheet_number = $sheet_number;
            else:
                $sheet_number = 0;
            endif;
            $objWorksheet = $objPHPExcel->setActiveSheetIndex($sheet_number);

            $processAdmission = Modules::load('registrar/registrardbprocess/');

            $sy = $this->session->userdata('school_year');
            $settings = Modules::run('main/getSet');
            $num_rows = $objWorksheet->getHighestRow();
            //echo $num_rows;
            for ($st = 4; $st <= ($num_rows); $st++) {

                /*if($objWorksheet->getCellByColumnAndRow(0,$st)->getValue()!=NULL):
                            $st_id = ($objWorksheet->getCellByColumnAndRow(0,$st)->getValue()==NULL?"":$objWorksheet->getCellByColumnAndRow(0,$st)->getValue());
                        else:
                            $lastID = Modules::run('registrar/getLatestIdNum');
                            $lastID = json_decode($lastID);
                            $id = $lastID->id+1;
                        if($id<10)
                           {
                               $prefix='0000';
                           }else
                           {
                               if($id<100){
                                  $prefix='000';
                               }elseif(id<100){
                                  $prefix='00';
                               }

                           }
                           $st_id = $settings->school_id.  substr($sy, 2, 2).$prefix.$id;

                        endif; */
                if ($objWorksheet->getCellByColumnAndRow(0, $st)->getValue() != null):
                    $st_id = $objWorksheet->getCellByColumnAndRow(0, $st)->getValue();
                else:
                    Modules::run('registrar/getLatestIdNum', $objWorksheet->getCellByColumnAndRow(43, $st)->getValue());
                    $st_id = Modules::run('registrar/importLatestId');

                endif;

                $lastname = ($objWorksheet->getCellByColumnAndRow(1, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(1, $st)->getValue());
                $firstname = ($objWorksheet->getCellByColumnAndRow(2, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(2, $st)->getValue());
                $middlename = ($objWorksheet->getCellByColumnAndRow(3, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(3, $st)->getValue());
                $rfid = '';
                $grade_id = ($objWorksheet->getCellByColumnAndRow(32, $st)->getValue() == null ? 0 : $objWorksheet->getCellByColumnAndRow(32, $st)->getValue());
                $section = ($objWorksheet->getCellByColumnAndRow(33, $st)->getValue() == null ? 0 : $objWorksheet->getCellByColumnAndRow(33, $st)->getValue());
                $religion = ($objWorksheet->getCellByColumnAndRow(7, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(7, $st)->getValue());
                $gender = $objWorksheet->getCellByColumnAndRow(8, $st)->getValue();
                $birthdate = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP(($objWorksheet->getCellByColumnAndRow(9, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(9, $st)->getValue())));;
                $birthplace = ($objWorksheet->getCellByColumnAndRow(10, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(10, $st)->getValue());
                // $street = $objWorksheet->getCellByColumnAndRow(10,$st)->getValue();
                //$street = "";
                $street = ($objWorksheet->getCellByColumnAndRow(11, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(11, $st)->getValue());
                $barangay = ($objWorksheet->getCellByColumnAndRow(12, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(12, $st)->getValue());
                $mun_city = ($objWorksheet->getCellByColumnAndRow(13, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(13, $st)->getValue());
                $phone = '';
                $f_lastname = ($objWorksheet->getCellByColumnAndRow(14, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(14, $st)->getValue());
                $f_firstname = ($objWorksheet->getCellByColumnAndRow(15, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(15, $st)->getValue());
                $f_middlename = ($objWorksheet->getCellByColumnAndRow(16, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(16, $st)->getValue());
                $f_occupation = ($objWorksheet->getCellByColumnAndRow(17, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(17, $st)->getValue());
                $f_office_name = '';
                $f_office_address = '';
                $f_mobile = ($objWorksheet->getCellByColumnAndRow(18, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(18, $st)->getValue());
                $m_lastname = ($objWorksheet->getCellByColumnAndRow(19, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(19, $st)->getValue());
                $m_firstname = ($objWorksheet->getCellByColumnAndRow(20, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(20, $st)->getValue());
                $m_middlename = ($objWorksheet->getCellByColumnAndRow(21, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(21, $st)->getValue());
                $m_occupation = ($objWorksheet->getCellByColumnAndRow(22, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(22, $st)->getValue());
                $m_office_name = '';
                $m_office_address = '';
                $m_mobile = ($objWorksheet->getCellByColumnAndRow(23, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(23, $st)->getValue());
                $m_email = '';
                $g_lastname = ($objWorksheet->getCellByColumnAndRow(24, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(24, $st)->getValue());
                $g_firstname = ($objWorksheet->getCellByColumnAndRow(25, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(25, $st)->getValue());
                $g_middlename = ($objWorksheet->getCellByColumnAndRow(26, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(26, $st)->getValue());
                $g_relation = 'Relative';
                $g_mobile = ($objWorksheet->getCellByColumnAndRow(28, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(28, $st)->getValue());
                $person_ice = $objWorksheet->getCellByColumnAndRow(39, $st)->getValue();

                $school_last = ($objWorksheet->getCellByColumnAndRow(30, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(30, $st)->getValue());
                $address_school_last = ($objWorksheet->getCellByColumnAndRow(31, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(31, $st)->getValue());

                //$person_contact_ice = $objWorksheet->getCellByColumnAndRow(40,$st)->getValue();
                //                        if($objWorksheet->getCellByColumnAndRow(5,$st)->getValue()!=NULL):
                //                            $lrn = $objWorksheet->getCellByColumnAndRow(5,$st)->getValue();
                //                        else:
                //                            $lrn = '';
                //                        endif;
                $lrn = '';
                $religion_id = $processAdmission->setReligion($religion);
                if ($person_ice == null):
                    $person_contact_ice = '';
                    $person_ice = '';
                endif;
                switch ($gender):
                    case 'F':
                        $gender = 'Female';
                        break;
                    case 'M':
                        $gender = 'Male';
                        break;
                endswitch;
                $basicInfo = array(
                    'rfid'             => $rfid,
                    'lastname'         => $lastname,
                    'firstname'        => $firstname,
                    'middlename'       => $middlename,
                    'add_id'           => 0,
                    'sex'              => $gender,
                    'rel_id'           => $religion_id,
                    'bdate_id'         => 0,
                    'contact_id'       => 0,
                    'status'           => 0,
                    'nationality'      => 'Filipino',
                    'account_type'     => 5,
                    'ethnic_group_id'  => 0,
                    'occupation_id'    => 1,
                    'avatar'           => $st_id . '.jpg'

                );

                //saves the basic info
                $profile_id = $processAdmission->saveProfile($basicInfo);

                $processAdmission->setStudInfo($st_id, $profile_id, $section, $grade_id, '', '', $sy, $school_last, $address_school_last, $lrn);

                //saves the address
                if ($barangay != null):
                    $barangay_id = $processAdmission->setBarangay($barangay);
                else:
                    $barangay_id = 0;
                endif;
                if ($street == null):
                    $street = '';
                endif;
                $city = Modules::run('main/getCities', $mun_city);

                $add = array(
                    'street'                => $street,
                    'barangay_id'           => $barangay_id,
                    'city_id'               => $city->cid,
                    'province_id'           => $city->province_id,
                    'country'               => 'Philippines',
                    'zip_code'              => 0,
                );

                $address_id = $processAdmission->setAddress($add, $profile_id);


                //saves the basic contact
                $contact_id = $processAdmission->setContacts($phone, '', $profile_id);

                //saves the birthday
                $date = $birthdate;
                $processAdmission->setBdate($date, $profile_id, 'bdate_id');

                if ($f_lastname == null && $m_lastname == null):
                    $guardian = array(
                        'lastname'         => $g_lastname,
                        'firstname'        => $g_firstname,
                        'middlename'       => $g_middlename,
                        'add_id'           => $address_id,
                        'sex'              => '',
                        'nationality'      => 'Filipino',
                        'account_type'     => 4,
                    );

                    $guardian_id = $processAdmission->saveProfile($guardian);

                    //$processAdmission->setParentsPro($profile_id, $guardian_id,0, 1, $this->input->post('relationship'));

                    $processAdmission->setContacts($g_mobile, '', $guardian_id);
                else:
                    $guardian_id = 0;
                endif;

                $father = array(
                    'lastname'         => $f_lastname,
                    'firstname'        => $f_firstname,
                    'middlename'       => $f_middlename,
                    'add_id'           => $address_id,
                    'sex'              => 'Male',
                    'nationality'      => 'Filipino',
                    'account_type'     => 4,
                );

                $father_id = $processAdmission->saveProfile($father);

                $processAdmission->setContacts($f_mobile, '', $father_id);
                if ($f_occupation != null):
                    $processAdmission->chooseOcc($f_occupation, $father_id);
                endif;

                $mother = array(
                    'lastname'         => $m_lastname,
                    'firstname'        => $m_firstname,
                    'middlename'       => $m_middlename,
                    'add_id'           => $address_id,
                    'sex'              => 'Female',
                    'nationality'      => 'Filipino',
                    'account_type'     => 4,
                );

                $mother_id = $processAdmission->saveProfile($mother);
                if ($f_office_name == null):
                    $f_office_name = '';
                endif;
                if ($m_office_name == null):
                    $m_office_name = '';
                endif;


                $processAdmission->setContacts($m_mobile, $m_email, $mother_id);

                $processAdmission->chooseOcc($m_occupation, $mother_id);

                $processAdmission->setParentsPro($profile_id, $father_id, $mother_id, $f_office_name, 0, $m_office_name, 0, $guardian_id, $g_relation, $person_ice, $person_contact_ice);

                //$processAdmission->saveMed($blood_type,'',$med_history,'','','', $profile_id );



            }
        ?>
            <script type="text/javascript">
                alert('Student Record successfully imported');
                document.location = '<?php echo base_url() . 'registrar/getAllStudents' ?>'
            </script>
        <?php


        }
    }
    public function importStudents()
    {

        //load library phpExcel
        $this->load->library("excel");
        //here i used microsoft excel 2007
        $processExport = Modules::load('reports/export_import_handler/');
        $sheet_number = $this->input->post('sheet_number');
        $data['error'] = ''; //initialize image upload error array to empty

        $config['upload_path'] = 'uploads';
        $config['overwrite'] = true;
        $config['allowed_types'] = '*';
        $config['max_size'] = '5000';

        $this->load->library('upload', $config);

        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
            print_r($data);
            //$this->load->view('csvindex', $data);
        } else {

            $file_data = $this->upload->data();
            $file_path = 'uploads/' . $file_data['file_name'];

            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            //set to read only
            $objReader->setReadDataOnly(true);
            //load excel file
            $objPHPExcel = $objReader->load($file_path);
            if ($sheet_number != ""):
                $sheet_number = $sheet_number;
            else:
                $sheet_number = 0;
            endif;
            $objWorksheet = $objPHPExcel->setActiveSheetIndex($sheet_number);

            $processAdmission = Modules::load('registrar/registrardbprocess/');

            $sy = $this->session->userdata('school_year');

            $num_rows = $objWorksheet->getHighestRow();
            //echo $num_rows;
            for ($st = 4; $st <= ($num_rows); $st++) {


                $lrn = $objWorksheet->getCellByColumnAndRow(0, $st)->getValue();
                $lastID = Modules::run('registrar/getLatestIdNum', $objWorksheet->getCellByColumnAndRow(40, $st)->getValue());

                $lastID = json_decode($lastID);
                $id = $lastID->id + 1;
                switch (true):
                    case $id >= 1000:
                        $prefix = "";
                        break;
                    case $id >= 100 && $id < 1000:
                        $prefix = "0";
                        break;
                    case $id >= 10 && $id < 100:
                        $prefix = "00";
                        break;
                    case $id >= 1 && $id < 10:
                        $prefix = "000";
                        break;
                endswitch;
                $st_id = $sy . $lastID->deptCode . $prefix . $id;

                $name = $objWorksheet->getCellByColumnAndRow(2, $st)->getValue();
                $nameItems = explode(",", $name);
                $lastname = $nameItems[0];
                //                        $remName = $nameItems[1];
                //                        $last_word_start = strrpos ( $remName , " ") + 1;
                //                        $last_word_end = strlen($remName) - 1;
                //                        $middlename = substr($remName, $last_word_start, $last_word_end);
                //                        $firstnames = explode( " ", $remName );
                //                        array_splice( $firstnames, -1 );
                $firstname = $nameItems[1];
                $middlename = $nameItems[2];
                $rfid = '';
                $grade_id = $objWorksheet->getCellByColumnAndRow(40, $st)->getValue();
                $section = $objWorksheet->getCellByColumnAndRow(42, $st)->getValue();
                $religion = ($objWorksheet->getCellByColumnAndRow(14, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(14, $st)->getValue());
                $gender = $objWorksheet->getCellByColumnAndRow(6, $st)->getValue();
                //$birthdate = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(7,$st)->getValue()));
                //$birthdate = date("Y-m-d", strtotime($objWorksheet->getCellByColumnAndRow(7,$st)->getValue()));
                $bdate = explode('-', $objWorksheet->getCellByColumnAndRow(7, $st)->getValue());
                $year = $bdate[2];
                $day = $bdate[1];
                $month = $bdate[0];
                $birthdate = $year . '-' . $month . '-' . $day;
                $birthplace = '';
                $street = ($objWorksheet->getCellByColumnAndRow(15, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(15, $st)->getValue());
                $barangay = ($objWorksheet->getCellByColumnAndRow(16, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(16, $st)->getValue());
                $mun_city = ($objWorksheet->getCellByColumnAndRow(20, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(20, $st)->getValue());
                $phone = $objWorksheet->getCellByColumnAndRow(37, $st)->getValue();


                $religion_id = $processAdmission->setReligion($religion);

                $basicInfo = array(
                    'rfid'             => $rfid,
                    'lastname'         => $lastname,
                    'firstname'        => $firstname,
                    'middlename'       => $middlename,
                    'add_id'           => 0,
                    'sex'              => ($gender == 'M' ? 'Male' : 'Female'),
                    'rel_id'           => $religion_id,
                    'temp_bdate'       => '',
                    'bdate_id'         => $birthdate,
                    'contact_id'       => 0,
                    'status'           => 0,
                    'nationality'      => 'Filipino',
                    'account_type'     => 5,
                    'ethnic_group_id'  => 0,
                    'occupation_id'    => 1,
                    'avatar'           => $st_id . '.jpg'

                );


                //saves the basic info
                $profile_id = $processAdmission->saveProfile($basicInfo);

                $processAdmission->setStudInfo($st_id, $profile_id, '', $grade_id, '', '', $sy, '', '', $lrn);

                //saves the address
                if ($barangay != null):
                    $barangay_id = $processAdmission->setBarangay($barangay);
                else:
                    $barangay_id = 0;
                endif;
                if ($street == null):
                    $street = '';
                endif;
                $city = Modules::run('main/getCities', $mun_city);

                $add = array(
                    'address_id'            => $profile_id,
                    'street'                => $street,
                    'barangay_id'           => $barangay_id,
                    'city_id'               => $city->cid,
                    'province_id'           => $city->province_id,
                    'country'               => 'Philippines',
                    'zip_code'              => 0,
                );

                $address_id = $processAdmission->setAddress($add, $profile_id);


                //saves the basic contact
                $contact_id = $processAdmission->setContacts($phone, '', $profile_id);

                //saves the birthday
                $date = $birthdate;
                $processAdmission->setBdate($date, $profile_id, 'bdate_id');

                if ($objWorksheet->getCellByColumnAndRow(27, $st)->getValue() != null):
                    $fnameItems = explode(",", $objWorksheet->getCellByColumnAndRow(27, $st)->getValue());
                    $f_lastname = $fnameItems[0];
                    $fremName = $fnameItems[1];
                    $flast_word_start = strrpos($fremName, " ") + 1;
                    $flast_word_end = strlen($fremName) - 1;
                    $f_middlename = substr($fremName, $flast_word_start, $flast_word_end);
                    $ffirstnames = explode(" ", $fremName);
                    array_splice($ffirstnames, -1);
                    $f_firstname = implode(" ", $ffirstnames);
                else:
                    $f_firstname = "";
                    $f_middlename = "";
                    $f_lastname = "";
                endif;

                $f_occupation = '';
                $f_office_name = '';
                $f_office_address = '';
                $f_mobile = $objWorksheet->getCellByColumnAndRow(37, $st)->getValue();
                if ($objWorksheet->getCellByColumnAndRow(31, $st)->getValue() != null):
                    $mnameItems = explode(",", $objWorksheet->getCellByColumnAndRow(31, $st)->getValue());
                    $m_lastname = $mnameItems[0];
                    $m_firstname = $mnameItems[1];
                    $m_middlename = $mnameItems[2];
                else:
                /**if($objWorksheet->getCellByColumnAndRow(27,$st)->getValue()==NULL || $objWorksheet->getCellByColumnAndRow(27,$st)->getValue()==", "):
                                if($objWorksheet->getCellByColumnAndRow(33,$st)->getValue()!=NULL || $objWorksheet->getCellByColumnAndRow(33,$st)->getValue()!=", "):
                                    $gnameItems = explode( ",", $objWorksheet->getCellByColumnAndRow(33,$st)->getValue());
                                    $g_lastname = $gnameItems[0];
                                    $g_firstname = $gnameItems[1];
                                    $g_middlename = $gnameItems[2];
                                    if($objWorksheet->getCellByColumnAndRow(37,$st)->getValue()!=NULL):
                                        $g_relation = $objWorksheet->getCellByColumnAndRow(37,$st)->getValue();
                                    else:
                                        $g_relation = "Relative";
                                    endif;
                                endif;
                            endif;**/
                endif;
                $m_occupation = '';
                $m_office_name = '';
                $m_office_address = '';
                $m_mobile = '';
                $m_email = '';
                $g_mobile = '';
                $med_history = '';
                $blood_type = '';
                $person_ice = null;
                $person_contact_ice = '';
                $lrn = '';

                if ($person_ice == null):
                    $person_contact_ice = '';
                    $person_ice = '';
                endif;
                switch ($gender):
                    case 'F':
                        $gender = 'Female';
                        break;
                    case 'M':
                        $gender = 'Male';
                        break;
                endswitch;
                if ($rfid == null):
                    $rfid = "";
                endif;
                if ($rfid == null):
                    $rfid = "";
                endif;


                if ($f_lastname == null || $f_lastname == ""):
                    if ($m_lastname == null):
                        $guardian = array(
                            'lastname'         => $g_lastname,
                            'firstname'        => $g_firstname,
                            'middlename'       => $g_middlename,
                            'add_id'           => $address_id,
                            'sex'              => '',
                            'nationality'      => 'Filipino',
                            'account_type'     => 4,
                        );

                        $guardian_id = $processAdmission->saveProfile($guardian);
                    endif;

                    //$processAdmission->setParentsPro($profile_id, $guardian_id,0, 1, $this->input->post('relationship'));

                    $processAdmission->setContacts($g_mobile, '', $guardian_id);
                else:
                    $guardian_id = 0;
                endif;

                $father = array(
                    'lastname'         => $f_lastname,
                    'firstname'        => $f_firstname,
                    'middlename'       => $f_middlename,
                    'add_id'           => $address_id,
                    'sex'              => 'Male',
                    'nationality'      => 'Filipino',
                    'account_type'     => 4,
                );

                $father_id = $processAdmission->saveProfile($father);

                $processAdmission->setContacts($f_mobile, '', $father_id);
                if ($f_occupation != null):
                    $processAdmission->chooseOcc($f_occupation, $father_id);
                endif;
                //
                $mother = array(
                    'lastname'         => $m_lastname,
                    'firstname'        => $m_firstname,
                    'middlename'       => $m_middlename,
                    'add_id'           => $address_id,
                    'sex'              => 'Female',
                    'nationality'      => 'Filipino',
                    'account_type'     => 4,
                );

                $mother_id = $processAdmission->saveProfile($mother);
                if ($f_office_name == null):
                    $f_office_name = '';
                endif;
                if ($m_office_name == null):
                    $m_office_name = '';
                endif;


                $processAdmission->setContacts($m_mobile, $m_email, $mother_id);

                $processAdmission->chooseOcc($m_occupation, $mother_id);

                $processAdmission->importParentsPro($profile_id, $father_id, $mother_id, $guardian_id);
                //                     //$processAdmission->setParentsPro($profile_id, $father_id, $mother_id, $f_office_name, 0, $m_office_name, 0,  $guardian_id, $g_relation, $person_ice, $person_contact_ice);
                //
                //
            }
        ?>
            <script type="text/javascript">
                alert('Student Record successfully imported');
                document.location = '<?php echo base_url() . 'registrar/getAllStudents' ?>'
            </script>
        <?php

        }
    }

    //process to import students
    public function importCollegeStudents()
    {

        //load library phpExcel
        $this->load->library("excel");
        //here i used microsoft excel 2007
        $processExport = Modules::load('reports/export_import_handler/');
        $sheet_number = $this->input->post('sheet_number');
        $data['error'] = ''; //initialize image upload error array to empty

        $config['upload_path'] = 'uploads';
        $config['overwrite'] = true;
        $config['allowed_types'] = '*';
        $config['max_size'] = '5000';

        $this->load->library('upload', $config);

        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
            print_r($data);
            //$this->load->view('csvindex', $data);
        } else {

            $file_data = $this->upload->data();
            $file_path = 'uploads/' . $file_data['file_name'];

            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            //set to read only
            $objReader->setReadDataOnly(true);
            //load excel file
            $objPHPExcel = $objReader->load($file_path);
            if ($sheet_number != ""):
                $sheet_number = $sheet_number;
            else:
                $sheet_number = 0;
            endif;
            $objWorksheet = $objPHPExcel->setActiveSheetIndex($sheet_number);

            $processAdmission = Modules::load('registrar/registrardbprocess/');

            $sy = $this->session->userdata('school_year');

            $num_rows = $objWorksheet->getHighestRow();
            //echo $num_rows;
            for ($st = 3; $st <= ($num_rows); $st++) {
                //for($st=3; $st<=10; $st++){

                if ($objWorksheet->getCellByColumnAndRow(0, $st)->getValue() != null):
                    $st_id = $objWorksheet->getCellByColumnAndRow(0, $st)->getValue();
                else:
                    $lastID = Modules::run('registrar/getLatestIdNum', $objWorksheet->getCellByColumnAndRow(42, $st)->getValue());
                    $lastID = json_decode($lastID);
                    $id = $lastID->id + 1;
                    if ($id < 10) {
                        $prefix = '0000';
                    } else {
                        if ($id < 100) {
                            $prefix = '000';
                        } else {
                            $prefix = '00';
                        }
                    }
                    $st_id = $sy . $lastID->deptCode . $lastID->order . $prefix . $id;

                endif;

                $firstname = $objWorksheet->getCellByColumnAndRow(2, $st)->getValue();
                $middlename = $objWorksheet->getCellByColumnAndRow(3, $st)->getValue();
                $lastname = $objWorksheet->getCellByColumnAndRow(1, $st)->getValue();
                $course = $objWorksheet->getCellByColumnAndRow(4, $st)->getValue();
                $year_level = $objWorksheet->getCellByColumnAndRow(5, $st)->getValue();
                $religion = '';
                //$religion = $objWorksheet->getCellByColumnAndRow(6,$st)->getValue();
                $gender = $objWorksheet->getCellByColumnAndRow(7, $st)->getValue();
                //$birthDate = date('Y-d-m', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(8,$st)->getValue()));
                $semester = $objWorksheet->getCellByColumnAndRow(9, $st)->getValue();
                $street = $objWorksheet->getCellByColumnAndRow(10, $st)->getValue();
                $barangay = $objWorksheet->getCellByColumnAndRow(11, $st)->getValue();
                $mun_city = $objWorksheet->getCellByColumnAndRow(12, $st)->getValue();
                $postal_code = $objWorksheet->getCellByColumnAndRow(13, $st)->getValue();
                $phone = $objWorksheet->getCellByColumnAndRow(14, $st)->getValue();
                $f_firstname = ($objWorksheet->getCellByColumnAndRow(16, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(16, $st)->getValue());
                $f_middlename = ($objWorksheet->getCellByColumnAndRow(17, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(17, $st)->getValue());
                $f_lastname = ($objWorksheet->getCellByColumnAndRow(15, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(15, $st)->getValue());
                $f_occupation = $objWorksheet->getCellByColumnAndRow(18, $st)->getValue();
                $f_office_name = $objWorksheet->getCellByColumnAndRow(19, $st)->getValue();
                $f_office_address = $objWorksheet->getCellByColumnAndRow(20, $st)->getValue();
                $f_mobile = $objWorksheet->getCellByColumnAndRow(21, $st)->getValue();
                $m_firstname = ($objWorksheet->getCellByColumnAndRow(22, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(22, $st)->getValue());
                $m_middlename = ($objWorksheet->getCellByColumnAndRow(23, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(23, $st)->getValue());
                $m_lastname = ($objWorksheet->getCellByColumnAndRow(24, $st)->getValue() == null ? "" : $objWorksheet->getCellByColumnAndRow(24, $st)->getValue());
                $m_occupation = $objWorksheet->getCellByColumnAndRow(25, $st)->getValue();
                $m_office_name = $objWorksheet->getCellByColumnAndRow(26, $st)->getValue();
                $m_office_address = $objWorksheet->getCellByColumnAndRow(27, $st)->getValue();
                $m_mobile = $objWorksheet->getCellByColumnAndRow(28, $st)->getValue();
                $m_email = $objWorksheet->getCellByColumnAndRow(29, $st)->getValue();
                $g_firstname = $objWorksheet->getCellByColumnAndRow(30, $st)->getValue();
                $g_middlename = $objWorksheet->getCellByColumnAndRow(31, $st)->getValue();
                $g_lastname = $objWorksheet->getCellByColumnAndRow(32, $st)->getValue();
                $g_relation = $objWorksheet->getCellByColumnAndRow(33, $st)->getValue();
                $g_mobile = $objWorksheet->getCellByColumnAndRow(34, $st)->getValue();
                $last_school = $objWorksheet->getCellByColumnAndRow(35, $st)->getValue();
                $last_school_address = $objWorksheet->getCellByColumnAndRow(36, $st)->getValue();
                $course_id = $objWorksheet->getCellByColumnAndRow(37, $st)->getValue();
                $med_history = $objWorksheet->getCellByColumnAndRow(38, $st)->getValue();
                $blood_type = $objWorksheet->getCellByColumnAndRow(39, $st)->getValue();
                $person_ice = $objWorksheet->getCellByColumnAndRow(40, $st)->getValue();
                $person_contact_ice = $objWorksheet->getCellByColumnAndRow(41, $st)->getValue();

                $bdate = explode('-', $objWorksheet->getCellByColumnAndRow(8, $st)->getValue());
                $year = $bdate[2];
                $day = $bdate[1];
                $month = $bdate[0];
                $birthDate = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(8, $st)->getValue()));




                if ($last_school == null):
                    $last_school = "";
                    $last_school_address = "";
                endif;

                $religion_id = $processAdmission->setReligion($religion);
                if ($person_ice == null):
                    $person_contact_ice = '';
                    $person_ice = '';
                endif;
                switch ($gender):
                    case 'F':
                        $gender = 'Female';
                        break;
                    case 'M':
                        $gender = 'Male';
                        break;
                endswitch;

                $basicInfo = array(
                    'lastname'         => trim(preg_replace('/\s+/', ' ', $lastname)),
                    'firstname'        => trim(preg_replace('/\s+/', ' ', $firstname)),
                    'middlename'       => trim(preg_replace('/\s+/', ' ', $middlename)),
                    'add_id'           => 0,
                    'sex'              => $gender,
                    'rel_id'           => $religion_id,
                    'bdate_id'         => 0,
                    'contact_id'       => 0,
                    'status'           => 0,
                    'nationality'      => 'Filipino',
                    'account_type'     => 5,
                    'ethnic_group_id'  => 0,
                    'occupation_id'    => 1,
                    'avatar'           => $st_id . '.jpg'

                );

                //saves the basic info
                $profile_id = $processAdmission->saveProfile($basicInfo);

                $processAdmission->setCollegeInfo($st_id, $profile_id, $course_id, $year_level, ($date_enrolled == null ? '0000-00-00' : $date_enrolled), $sy, $semester, $last_school, $last_school_address);

                //saves the address
                $barangay = ($barangay == null ? "Poblacion" : $barangay);
                if ($barangay != null):
                    $barangay_id = $processAdmission->setBarangay(trim(preg_replace('/\s+/', ' ', $barangay)));
                else:
                    $barangay_id = 0;
                endif;
                if ($street == null):
                    $street = '';
                endif;
                $city = Modules::run('main/getCities', trim(preg_replace('/\s+/', ' ', $mun_city)));
                if ($postal_code == null):
                    $postal_code = 0;
                endif;
                $add = array(
                    'street'                => $street,
                    'barangay_id'           => $barangay_id,
                    'city_id'               => $city->cid,
                    'province_id'           => $city->province_id,
                    'country'               => 'Philippines',
                    'zip_code'              => $postal_code,
                );

                $address_id = $processAdmission->setAddress($add, $profile_id);


                //saves the basic contact
                $processAdmission->setContacts($phone, '', $profile_id);

                //saves the birthday
                $date = $birthDate;
                $processAdmission->setBdate($date, $profile_id, 'bdate_id');

                if ($g_lastname != ""):
                    $guardian = array(
                        'lastname'         => $g_lastname,
                        'firstname'        => $g_firstname,
                        'middlename'       => $g_middlename,
                        'add_id'           => $address_id,
                        'sex'              => '',
                        'nationality'      => 'Filipino',
                        'account_type'     => 4,
                    );

                    $guardian_id = $processAdmission->saveProfile($guardian);

                    //$processAdmission->setParentsPro($profile_id, $guardian_id,0, 1, $this->input->post('relationship'));

                    $processAdmission->setContacts($g_mobile, '', $guardian_id);
                else:
                    $guardian_id = 0;
                endif;

                $father = array(
                    'lastname'         => $f_lastname,
                    'firstname'        => $f_firstname,
                    'middlename'       => $f_middlename,
                    'add_id'           => $address_id,
                    'sex'              => 'Male',
                    'nationality'      => 'Filipino',
                    'account_type'     => 4,
                );

                $father_id = $processAdmission->saveProfile($father);

                $processAdmission->setContacts($f_mobile, '', $father_id);

                $processAdmission->chooseOcc($f_occupation, $father_id);

                $mother = array(
                    'lastname'         => $m_lastname,
                    'firstname'        => $m_firstname,
                    'middlename'       => $m_middlename,
                    'add_id'           => $address_id,
                    'sex'              => 'Female',
                    'nationality'      => 'Filipino',
                    'account_type'     => 4,
                );

                $mother_id = $processAdmission->saveProfile($mother);
                if ($f_office_name == null):
                    $f_office_name = '';
                endif;
                if ($m_office_name == null):
                    $m_office_name = '';
                endif;


                $processAdmission->setContacts($m_mobile, $m_email, $mother_id);

                $processAdmission->chooseOcc($m_occupation, $mother_id);

                // $processAdmission->setParentsPro($profile_id, $father_id, $mother_id, $f_office_name, 0, $m_office_name, 0,  $guardian_id, $g_relation, $person_ice, $person_contact_ice);
                $processAdmission->importParentsPro($profile_id, $father_id, $mother_id);
                //$processAdmission->saveMed($blood_type,'',$med_history,'','','', $profile_id );



            }
        ?>
            <script type="text/javascript">
                alert('College Student Record successfully imported');
                document.location = '<?php echo base_url() . 'college/getStudents' ?>'
            </script>
            <?php


        }
    }

    public function importSample()
    {

        //load library phpExcel
        $this->load->library("excel");
        //here i used microsoft excel 2007
        $processExport = Modules::load('reports/export_import_handler/');
        $sheet_number = $this->input->post('sheet_number');
        $data['error'] = ''; //initialize image upload error array to empty

        $config['upload_path'] = 'uploads';
        $config['overwrite'] = true;
        $config['allowed_types'] = '*';
        $config['max_size'] = '5000';

        $this->load->library('upload', $config);

        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
            print_r($data);
            //$this->load->view('csvindex', $data);
        } else {

            $file_data = $this->upload->data();
            $file_path = 'uploads/' . $file_data['file_name'];

            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            //set to read only
            $objReader->setReadDataOnly(true);
            //load excel file
            $objPHPExcel = $objReader->load($file_path);
            if ($sheet_number != ""):
                $sheet_number = $sheet_number;
            else:
                $sheet_number = 0;
            endif;
            $objWorksheet = $objPHPExcel->setActiveSheetIndex($sheet_number);

            $processAdmission = Modules::load('registrar/registrardbprocess/');

            $sy = $this->session->userdata('school_year');

            $num_rows = $objWorksheet->getHighestRow();
            //echo $num_rows;
            echo '<table>';
            for ($st = 3; $st <= ($num_rows); $st++) {
                //for($st=3; $st<=10; $st++){

                $name =  $objWorksheet->getCellByColumnAndRow(10, $st)->getValue();
                $name1 = str_replace('Mr. & Mrs.', '', $name);
                $name1 = str_replace('Mr & Mrs.', '', $name1);
                $name1 = str_replace('Mr. & Ms.', '', $name1);
                $name2 = str_replace('Mrs.', '', $name1);
                $name2 = str_replace('Pstr.', '', $name2);
                $name2 = str_replace('Mr.', '', $name2);
                $name3 = str_replace('Mr', '', $name2);
                $name3 = str_replace('&', '', $name3);
                $items = explode(',', $name);
            ?>
                <tr>
                    <td><?php echo $items[0] ?></td>
                    <td><?php echo $items[1] ?></td>
                    <td><?php echo $items[2] ?></td>
                    <td><?php echo $items[3] ?></td>
                </tr>
            <?php
            }
            echo '</table>';
            echo $objWorksheet->getCellByColumnAndRow(42, $st)->getValue();
        }
    }

    public function getEDate($date)
    {
        $unixdate = ($date - 25569) * 86400;
        $en_date = gmdate('Y-m-d', ($unixdate));

        return $en_date;
    }

    public function getaconduct($stid)
    {
        $conduct = $this->reports_model->getaconduct($stid);
        return $conduct;
    }

    public function saveconduct($st_id, $rating, $term, $school_year)
    {
        switch ($term) {
            case 1:
                $cd = 'cd_first';
                break;
            case 2:
                $cd = 'cd_second';
                break;
            case 3:
                $cd = 'cd_third';
                break;
            case 4:
                $cd = 'cd_fourth';
                break;
        }
        $data = array(
            'cd_st_id' => $st_id,
            $cd => $rating,
            'cd_sy' => $school_year,
        );

        $ifcdexist = $this->reports_model->ifcdexist($st_id, $school_year);
        if ($ifcdexist):
            $this->reports_model->updateconduct($data, $st_id, $school_year);
        else:
            $this->reports_model->insertconduct($data);
        endif;
    }

    public function sbeMsg($name)
    {
        switch ($name):
            case 'csfl':
            ?>
                <p style="text-align: justify; word-spacing: 10em">Dear Parents,<br>
                <div style="text-indent: 20px;">
                    This report card shows the ability and the progress your child has made in the different learning areas as well as his/her progress in character development.
                </div>
                <div style="text-indent: 20px;">
                    The school welcomes you if you desire to know more about any school - related progress of your child.
                </div>
                </p>
            <?php
                break;
            case 'maclc':
            ?>
                <p style="text-align: justify; word-spacing: 10em">Dear Parents/Guardians,<br>
                <div style="text-indent: 20px;">
                    This report card shows the ability and progress your child has made in school attendance and in the different learning areas as well as his/her progress in character development.
                </div>
                <div style="text-indent: 20px;">
                    The school welcomes you if you desire to know more about any school – related progress of your child.
                </div>
                </p>
<?php
                break;
        endswitch;
    }

    public function getBhGroup($id, $bhid = null, $dept_id = null)
    {
        return $this->reports_model->getBhGroup($id, $bhid, $dept_id);
    }


    public function getStudentStat($id)
    {
        return $this->reports_model->getStudentStat($id);
    }

    public function getCoreValues()
    {
        return $this->reports_model->getCoreValues();
    }
}
