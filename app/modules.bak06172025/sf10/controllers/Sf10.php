<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class sf10 extends MX_Controller {

    //put your code here

    protected $generate;

    public function __construct() {
        parent::__construct();
        $this->load->library('Pdf');
        $this->load->library('csvimport');
        $this->load->library('csvreader');
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->model('sf10_model');
    }

    private function post($name) {
        return $this->input->post($name);
    }

    private function ifDatabaseExist($db_name) {
        if ($this->dbutil->database_exists($db_name)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    private function create_database($year) {
        $settings = $this->eskwela->getSet();

        $db_name = 'eskwela_' . strtolower($settings->short_name) . '_' . $year;

        if ($this->dbforge->create_database($db_name)) {
            $this->sf10_model->createSPRTables($db_name, 'spr.sql');
            $this->sf10_model->createSPRTables($db_name, 'address.sql');
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAttendanceDetailsSH($spr_id, $school_year, $semester) {
        $data['school_year'] = $school_year;
        $data['semester'] = $semester;
        $data['attendaceTardy'] = $this->getTardy($spr_id);
        $data['attendanceDetails'] = $this->getAttendanceOveride($spr_id, $school_year);
        $this->load->view('attendanceDetails_sh', $data);
    }

    public function getAttendanceDetails($spr_id, $school_year, $semester, $st_id) {
        $data['school_year'] = $school_year;
        $data['semester'] = $semester;
        $data['attendaceTardy'] = $this->getTardy($spr_id);
        $data['attendanceDetails'] = $this->getAttendanceOveride($spr_id, $school_year, $st_id);
        $this->load->view('attendanceDetails', $data);
    }

    public function checkSpecialClass($st_id, $school_year, $sem = NULL, $subject_id = NULL) {
        $specialClass = $this->sf10_model->checkSpecialClass($st_id, $school_year, $subject_id, $sem);
        return $specialClass;

        //print_r($specialClass->result());
    }

    public function autoFetchPresent() {
        $st_id = base64_decode($this->post('st_id'));
        $school_year = $this->post('school_year');
        $semester = $this->post('semester');
        $for_school = $this->post('for_school');

        $spr_records = $this->getSPRrec($st_id, $school_year, $semester, null);


        for ($i = 1; $i <= 12; $i++):
            if ($i != 5 && $i != 6):
                if ($i < 10):
                    $i = '0' . $i;
                endif;
                switch ($i):
                    case 1:
                    case 2:
                    case 3:
                        $year = $spr_records->school_year + 1;
                        break;
                    default :
                        $year = $spr_records->school_year;
                        break;
                endswitch;
                $present = Modules::run('attendance/getIndividualMonthlyAttendance', $spr_records->st_id, $i, $year, $school_year);
                if ($present > 0):
                    $present = $present;
                else:
                    $present = 0;
                endif;
//                echo $spr_records->st_id.' - '.$present.'<br />';
                $monthName = $this->getMonthName($i);
//                $monthName = Modules::run('main/getMonthName', $i);

                $attendance_details = array(
                    'spr_id' => $spr_records->spr_id,
                    $monthName => $present,
                    'is_school' => $for_school
                );

                $this->sf10_model->saveAttendanceOveride($attendance_details, $spr_records->spr_id, $for_school, $school_year, $monthName, $present);
            endif;
        endfor;

        echo 'Successfully Fetched';
    }

    function getAttendanceOveride($spr_id, $school_year, $st_id = NULL) {
        $this->updateAttendanceDetails($st_id, $spr_id);
        $attendance = $this->sf10_model->getDaysPresent($spr_id, $school_year);
        return $attendance;
    }

    function updateAttendanceDetails($st_id, $spr_id) {
        $settings = Modules::run('main/getSet');
        $school_year = $settings->school_year;
        $gs_start = date('m', strtotime($settings->bosy));
        $gs_end = date('m', strtotime($settings->eosy));

        $y_start = date('Y', strtotime($settings->bosy));
        $y_end = date('Y', strtotime($settings->eosy));
        
        for ($i = $gs_start; $i <= (12 + $gs_end); $i++):
            $m = $i;
            $month = ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : ($m == 9 ? '0' . $m : $m));
            $year = ($m <= 12 ? $y_start : $y_end);

            $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $month, 10)), $year, 'first');
            $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $month, 10)), $year, 'last');

            for ($x = $firstDay; $x <= $lastDay; $x++) {
                $day = date('D', strtotime($year . '-' . $month . '-' . $x));

                if ($x < 10):
                    $day = "0" . $x;
                else:
                    $day = $x;
                endif;

                //echo $day.' ';
                $ifPresent = Modules::run('attendance/ifPresent', $st_id, $day, $month, $year, $this->session->userdata('attend_auto'), $school_year);

                if ($ifPresent):
                    $present += 1;
                endif;
            }

            Modules::run('sf10/autoSaveAttendance', $month, $present, $spr_id, $this->session->school_year);
            $present = 0;
        endfor;
    }

    function getPreviousSchoolDays($school_name, $school_year) {
        $schoolDays = $this->sf10_model->getPreviousSchoolDays($school_name, $school_year);
        return $schoolDays;
    }

    function saveAttendanceOveride() {
        $st_id = base64_decode($this->post('st_id'));
        $grade_id = $this->post('level_id');
        $school_year = $this->post('school_year');
        $semester = $this->post('semester');
        $for_school = $this->post('for_school');
        $column = $this->post('month');
        $numberOfDays = $this->post('value');
        $is_school = $this->post('is_school');
        $school_name = $this->post('school_name');

        $spr_records = $this->getSPRrec($st_id, $school_year, $semester, $grade_id);

        if ($is_school == 1):
            $schoolDetails = array(
                'school_name' => trim($school_name)
            );

            $school_id = $this->sf10_model->saveSchoolDetails($schoolDetails, trim($school_name), $school_year);

            $attendance_details = array(
                $column => $numberOfDays,
                'spr_school_id' => $school_id
            );

            if ($this->sf10_model->saveSchoolDays($attendance_details, $school_id, $school_year)):
                echo 'Successfully Saved ';
            else:
                echo 'Sorry Someting went wrong';
            endif;


        else:

            $attendance_details = array(
                'spr_id' => $spr_records->spr_id,
                $column => $numberOfDays,
                'is_school' => $for_school
            );

            if ($this->sf10_model->saveAttendanceOveride($attendance_details, $spr_records->spr_id, $for_school, $school_year, $column, $numberOfDays)):
                echo 'Successfully Saved ';
            else:
                echo 'Sorry Someting went wrong';
            endif;
        endif;
    }

    function attendanceManualOveride($st_id, $school_year, $sem = 0, $for_school = FALSE, $isForm138 = FALSE, $grade_id = NULL) {
        $data['grade_id'] = $grade_id;
        $data['st_id'] = $st_id;
        $data['school_year'] = $school_year;
        $data['sem'] = $sem;
        $data['for_school'] = $for_school;
        $data['isForm138'] = $isForm138;
        $this->load->view('attendanceOveride', $data);
    }

    function getAcadAverage($spr_id, $semester) {
        $average = $this->sf10_model->getAcadAverage($spr_id, $semester);
        return $average;
    }

    function deleteRecord($ar_id, $school_year) {
        if ($this->sf10_model->deleteRecord($ar_id, $school_year)):
            echo 'Successfully Deleted';
            $remarks = $this->session->userdata('name') . ' has deleted a permanent record.';
            Modules::run('main/logActivity', 'REGISTRAR', $remarks, $this->session->userdata('user_id'));
        else:
            echo 'Something Went Wrong';
        endif;
    }

    function getEdHistory($st_id, $history_type, $sy) {
        $edHistory = $this->sf10_model->getEdHistory(base64_decode($st_id), $sy, $history_type);
        return $edHistory;
    }

    function editAcademicRecordsSH() {
        $first = $this->post('first');
        $second = $this->post('second');
        $average = $this->post('average');
        $semester = $this->post('semester');
        $school_year = $this->post('school_year');
        $ar_id = $this->post('ar_id');

        if ($semester == 1):
            $arDetails = array(
                'first' => $first,
                'second' => $second,
                'avg' => $average
            );
        else:
            $arDetails = array(
                'third' => $first,
                'fourth' => $second,
                'avg' => $average
            );
        endif;

        $this->sf10_model->editAR($ar_id, $arDetails, $school_year);
    }

    function newRecord() {
        $settings = $this->eskwela->getSet();
        $school_year = $this->post('school_year');
        $current = $this->post('current_year');
        $st_id = $this->post('st_id');
        $grade_level_id = $this->post('grade_level_id');

        $db_name = 'eskwela_' . strtolower($settings->short_name) . '_' . $school_year;

        $dbExist = $this->ifDatabaseExist($db_name);
        if ($dbExist):
            $tableExist = $this->sf10_model->checkTableExist('esk_gs_spr', $school_year);
            if (!$tableExist):
                $this->sf10_model->createSPRTables($db_name, 'spr.sql');

            endif;
        else:
            if ($this->create_database($school_year)):
            endif;
        endif;

        sleep(2);
        $profile = $this->sf10_model->getStudentInfo(base64_decode($st_id), $current);
        $tableExist = $this->sf10_model->checkTableExist('esk_gs_spr_profile', $school_year);

        //print_r($profile);
        if ($profile):
            if ($tableExist):
                $newDetails = array(
                    'sprp_st_id' => $profile->st_id,
                    'sprp_lrn' => $profile->sprp_lrn,
                    'sprp_lastname' => $profile->lastname,
                    'sprp_firstname' => $profile->firstname,
                    'sprp_middlename' => $profile->middlename,
                    'sprp_father' => $profile->sprp_father,
                    'sprp_father_occ' => $profile->sprp_father,
                    'sprp_mother' => $profile->sprp_father_occ,
                    'sprp_mother_occ' => $profile->sprp_mother_occ,
                    'sprp_bdate' => $profile->bdate,
                    'sprp_bplace' => $profile->bplace,
                    'sprp_nationality' => $profile->sprp_nationality
                );

                $this->sf10_model->saveNewInfo($newDetails, $profile->lastname, $profile->firstname, $profile->middlename, $school_year, $profile->st_id);
                switch ($grade_level_id):
                    case 12:
                    case 13:
                        $spr1 = array(
                            'st_id' => $profile->st_id,
                            'grade_level_id' => $grade_level_id,
                            'school_year' => $school_year,
                            'semester' => 1
                        );
                        $this->sf10_model->saveSPR($spr1, $school_year, $profile->st_id);
                        $spr2 = array(
                            'st_id' => $profile->st_id,
                            'grade_level_id' => $grade_level_id,
                            'school_year' => $school_year,
                            'semester' => 2
                        );
                        $this->sf10_model->saveSPR($spr2, $school_year, $profile->st_id);

                        break;
                    default:
                        $spr = array(
                            'st_id' => $profile->st_id,
                            'grade_level_id' => $grade_level_id,
                            'school_year' => $school_year
                        );
                        $this->sf10_model->saveSPR($spr, $school_year, $profile->st_id);

                        break;
                endswitch;
                echo 'New Record Successfully Created';
            else:
                $this->sf10_model->createSPRTables($db_name, 'spr.sql');
                sleep(2);
                $newDetails = array(
                    'sprp_st_id' => $profile->st_id,
                    'sprp_lrn' => $profile->sprp_lrn,
                    'sprp_lastname' => $profile->lastname,
                    'sprp_firstname' => $profile->firstname,
                    'sprp_middlename' => $profile->middlename,
                    'sprp_father' => $profile->sprp_father,
                    'sprp_father_occ' => $profile->sprp_father,
                    'sprp_mother' => $profile->sprp_father_occ,
                    'sprp_mother_occ' => $profile->sprp_mother_occ,
                    'sprp_bdate' => $profile->bdate,
                    'sprp_bplace' => $profile->bplace,
                    'sprp_nationality' => $profile->sprp_nationality
                );

                $this->sf10_model->saveNewInfo($newDetails, $profile->lastname, $profile->firstname, $profile->middlename, $school_year, $profile->st_id);


                switch ($grade_level_id):
                    case 12:
                    case 13:
                        $spr1 = array(
                            'st_id' => $profile->st_id,
                            'grade_level_id' => $grade_level_id,
                            'school_year' => $school_year,
                            'semester' => 1
                        );
                        $this->sf10_model->saveSPR($spr1, $school_year, $profile->st_id);
                        $spr2 = array(
                            'st_id' => $profile->st_id,
                            'grade_level_id' => $grade_level_id,
                            'school_year' => $school_year,
                            'semester' => 2
                        );
                        $this->sf10_model->saveSPR($spr2, $school_year, $profile->st_id);

                        break;
                    default:
                        $spr = array(
                            'st_id' => $profile->st_id,
                            'grade_level_id' => $grade_level_id,
                            'school_year' => $school_year
                        );
                        $this->sf10_model->saveSPR($spr, $school_year, $profile->st_id);

                        break;
                endswitch;

                echo 'New Record Successfully Created';
            endif;
        endif;
    }

    function gsUpdateBySection($section_id) {
        $getStudents = $this->sf10_model->getStudents($section_id);
        $i = 0;
        foreach ($getStudents->result() as $student):
            $details = array('grading' => 1);
            $this->db->where('st_id', $student->st_id);
            $this->db->where('subject_id', 9);
            $this->db->where('school_year', 2018);
            $this->db->where('grading', 0);

            if ($this->db->update('gs_final_card', $details)):
                $i++;
            endif;

        endforeach;
        echo 'Successfully updated ' . $i . ' records';
    }

    function deleteDups() {
        $query = "DELETE t1 from esk_gs_raw_score as t1, esk_gs_raw_score as t2 WHERE t1.raw_id < t2.raw_id AND t1.assess_id = t2.assess_id AND t1.st_id = t2.st_id";
        if ($this->db->query($query)):
            echo 'Successfully Deleted Duplicates';
        endif;
    }

    function getSHSubjects($gradeLevel, $sem, $strand_id, $core = NULL) {
        $result = $this->subjectmanagement_model->getSHSubjects($gradeLevel, $sem, $strand_id, $core);
        return $result;
    }

    function getSubjectById($sub_id) {
        $subjects = $this->sf10_model->getSubjectById($sub_id);
        return $subjects;
    }

    function getSubjectId($subject) {
        $subject_id = $this->sf10_model->getSubjectId($subject);
        return $subject_id;
    }

    function getGradeLevelId($level) {
        $grade_id = $this->sf10_model->getGradeLevelId($level);
        return $grade_id;
    }

    function getLatestIDNum($year) {
        $idNum = $this->sf10_model->getLatestIDNum($year);
        return $idNum + 1;
    }

    function uploadF137() {
        $this->load->library("excel");
        //here i used microsoft excel 2007
        $data['error'] = ''; //initialize image upload error array to empty

        $config['upload_path'] = 'uploads';
        $config['overwrite'] = TRUE;
        $config['allowed_types'] = '*';
        $config['max_size'] = '10000';

        $this->load->library('upload', $config);

        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
            ?>
            <script type="text/javascript">
                alert('Error: <?php echo $data['error'] ?>');
                document.location = '<?php echo base_url('sf10/generateForm137') ?>'
            </script>
            <?php
        } else {

            $file_data = $this->upload->data();
            $file_path = 'uploads/' . $file_data['file_name'];
            switch ($file_data['file_ext']):
                case '.xls':
                case '.XLS':
                    $objReader = PHPExcel_IOFactory::createReader('Excel5');
                    break;
                case '.xlsx':
                    $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                    break;
            endswitch;
            //set to read only
            $objReader->setReadDataOnly(true);
            //load excel file
            $objPHPExcel = $objReader->load($file_path);

            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);


            $num_rows = $objWorksheet->getHighestRow();

//            $num_rows  = 8;


            $gradeLevel = $objWorksheet->getCellByColumnAndRow(0, 1)->getValue();
            $grade_id = $this->getGradeLevelId($gradeLevel);
            $school_year = $objWorksheet->getCellByColumnAndRow(2, 1)->getValue();
//           $school = $objWorksheet->getCellByColumnAndRow(3,1)->getValue();
//           $adviser = $objWorksheet->getCellByColumnAndRow(0,2)->getValue();
            $numberOfColumns = PHPExcel_Cell::columnIndexFromString($objPHPExcel->setActiveSheetIndex(0)->getHighestColumn());

            $uploadOption = $this->post('uploadOption');

            $n = 0;
            for ($st = 4; $st <= ($num_rows); $st++):

                if ($st >= 5):
                    $st_id = $objWorksheet->getCellByColumnAndRow(0, $st)->getValue();
                    if ($st_id != NULL):
                        $name = $objWorksheet->getCellByColumnAndRow(1, $st)->getValue();
                        $section = $objWorksheet->getCellByColumnAndRow(2, $st)->getValue();
                        $adviser = $objWorksheet->getCellByColumnAndRow(3, $st)->getValue();
                        $school = $objWorksheet->getCellByColumnAndRow(4, $st)->getValue();

                        $nameItems = explode(",", $name);
                        $lastname = $nameItems[0];
                        $remName = $nameItems[1];
                        $last_word_start = strrpos($remName, " ") + 1;
                        $last_word_end = strlen($remName) - 1;
                        $middlename = substr($remName, $last_word_start, $last_word_end);
                        $firstnames = explode(" ", $remName);
                        array_splice($firstnames, -2);
                        $firstname = implode(" ", $firstnames);
                        $exist = $this->sf10_model->checkAcadExist($st_id, $school_year);
                        if ($st_id == 0):
                            if ($uploadOption == '0'):
                                $latestId = $this->getLatestIDNum($school_year);
                                switch (TRUE):
                                    case $latestId < 10:
                                        $brd = '000';
                                        break;
                                    case $latestId < 100:
                                        $brd = '00';

                                        break;
                                    case $latestId < 1000:
                                        $brd = '0';
                                        break;
                                    default :
                                        $brd = '';
                                        break;

                                endswitch;

                                $array = array(
                                    'sprp_st_id' => $school_year . $grade_id . $brd . $latestId,
                                    'sprp_lrn' => '',
                                    'sprp_lastname' => trim($lastname),
                                    'sprp_firstname' => trim($firstname),
                                    'sprp_middlename' => trim($middlename)
                                );
                                $profileSave = $this->savePersonalInfo($array, trim($lastname), trim($firstname), trim($middlename), $school_year);
                                $st_id = $school_year . $grade_id . $brd . $latestId;
                            endif;
                        else:
                            $array = array(
                                'sprp_st_id' => $st_id,
                                'sprp_lrn' => '',
                                'sprp_lastname' => trim($lastname),
                                'sprp_firstname' => trim($firstname),
                                'sprp_middlename' => trim($middlename)
                            );
                            $profileSave = $this->savePersonalInfo($array, trim($lastname), trim($firstname), trim($middlename), $school_year, $st_id);
                        endif;
                        if (!$exist):
                            if ($uploadOption == '0'):
                                $spr = array(
                                    'st_id' => $st_id,
                                    'grade_level_id' => $grade_id,
                                    'section' => $section,
                                    'school_name' => $school,
                                    'spr_adviser' => $adviser,
                                    'school_year' => $school_year
                                );

                                $spr_id = $this->sf10_model->saveSPR($spr, $school_year);
                            //print_r($spr);
                            endif;
                        else:
                            $spr_id = $exist;
                        endif;
                    endif;

                    //                        echo '<br />';
                    //                        echo $st_id.' - '.$firstname.' '.$middlename.' '.$lastname.'<br />';
                    //                          echo $numberOfColumns;
                    if ($uploadOption == '0'):
                        // Academic Grades
                        for ($col = 5; $col <= ($numberOfColumns - 2); $col++):
                            if ($objWorksheet->getCellByColumnAndRow($col, 3)->getValue() != NULL):
                                $subject_id = $this->getSubjectId($objWorksheet->getCellByColumnAndRow($col, 3)->getValue());
                                $firstQG = $objWorksheet->getCellByColumnAndRow($col, $st)->getValue();
                                $secondQG = $objWorksheet->getCellByColumnAndRow($col + 1, $st)->getValue();
                                $thirdQG = $objWorksheet->getCellByColumnAndRow($col + 2, $st)->getValue();
                                $fourthQG = $objWorksheet->getCellByColumnAndRow($col + 3, $st)->getValue();
                                $aveGrade = $objWorksheet->getCellByColumnAndRow($col + 4, $st)->getValue();

                                $ar = array(
                                    'spr_id' => $spr_id,
                                    'subject_id' => $subject_id,
                                    'first' => ($firstQG == NULL ? 0 : $firstQG),
                                    'second' => ($secondQG == NULL ? 0 : $secondQG),
                                    'third' => ($thirdQG == NULL ? 0 : $thirdQG),
                                    'fourth' => ($fourthQG == NULL ? 0 : $fourthQG),
                                    'avg' => ($aveGrade == NULL ? 0 : $aveGrade)
                                );

                                $this->sf10_model->saveAR($ar, $spr_id, $subject_id, $school_year);
                                $n++;
                            //                                echo $col.' | ';
                            //                                echo $subject_id.' | '.$firstQG.' | '.$secondQG.' | '.$thirdQG.' | '.$fourthQG.' | '.$aveGrade.'<br />';
                            endif;
                        endfor;
                        $spr = array(
                            'gen_ave' => $objWorksheet->getCellByColumnAndRow($numberOfColumns - 1, $st)->getValue()
                        );

                        $this->sf10_model->updateBasicSPR($spr_id, $spr, $school_year);
                    else:
                        if ($st_id == 0):
                            $spr_id = $this->sf10_model->getPersonalInfoByName(trim($lastname), trim($firstname));
                        // echo $spr_id;
                        endif;

                        for ($col = 2; $col <= ($numberOfColumns - 2); $col++):
                            if ($objWorksheet->getCellByColumnAndRow($col, 3)->getValue() != NULL):
                                $monthName = $objWorksheet->getCellByColumnAndRow($col, 3)->getValue();
                                $presentDays = $objWorksheet->getCellByColumnAndRow($col, $st)->getValue();
                                $tardy = $objWorksheet->getCellByColumnAndRow($col + 1, $st)->getValue();

                                if ($presentDays != NULL):
                                    $attDetails = array(
                                        'spr_id' => $spr_id,
                                        $monthName => $presentDays
                                    );

                                    $this->sf10_model->saveAttendanceDetails($attDetails, $spr_id);
                                endif;

                                if ($tardy != NULL):
                                    $tardyDetails = array(
                                        'spr_id' => $spr_id,
                                        $monthName => $tardy
                                    );

                                    $this->sf10_model->saveTardyDetails($tardyDetails, $spr_id);
                                endif;

                            //                                echo $monthName.' | '.$presentDays.' | '.$tardy.' | ';
                            endif;
                        endfor;
                        echo '<br /><br />';
                    endif;
                endif;
            endfor;
            ?>
            <script type="text/javascript">
                alert('Successfully Uploaded <?php echo $n ?> records');
                document.location = '<?php echo base_url('sf10/generateForm137') ?>'
            </script>
            <?php
        }
    }

    function getSingleStudentSPR($st_id, $sy) {
        return $this->sf10_model->getSingleStudentSPR($st_id, $sy);
    }

    function xportExcel($value, $sy = NULL) {
        $this->load->library('eskwela');
        $this->load->library('excel');
        $this->load->helper('download');

        $this->excel->getActiveSheet()->getPageMargins()->setRight(0.5);
//        $this->excel->getActiveSheet()->getPageMargins()->setLeft(1);

        $gs_settings = Modules::run('gradingsystem/getSet');
        $settings = Modules::run('main/getSet');
        $data['gs_settings'] = Modules::run('gradingsystem/getSet');
        $data['settings'] = Modules::run('main/getSet');
        $data['edHistory'] = $this->sf10_model->getEdHistory(base64_decode($value));
        $data['year'] = $sy;
        $data['usd'] = base64_decode($value);
        $data['pYear'] = $settings->school_year;
        $student = $this->getSingleStudentSPR(base64_decode($value));

        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(15);
        $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(15);
        $this->excel->getActiveSheet()->getRowDimension('6')->setRowHeight(15);
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);

        $centerE1E2 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'font' => array('size' => 12, 'name' => 'Verdana'));
        $centerE3 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'font' => array('size' => 9, 'bold' => TRUE));
        $stValue = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT), 'font' => array('size' => 8));

        $this->excel->getActiveSheet()->getStyle('C1:C2')->applyFromArray($centerE1E2);
        $this->excel->getActiveSheet()->getStyle('C3')->applyFromArray($centerE3);
        $this->excel->getActiveSheet()->mergeCells('C1:G1');
        $this->excel->getActiveSheet()->setCellValue('C1', "Republic of the Philippines");
        $this->excel->getActiveSheet()->mergeCells('C2:G2');
        $this->excel->getActiveSheet()->setCellValue('C2', "Department of Education");
        $this->excel->getActiveSheet()->mergeCells('C3:G3');
        $this->excel->getActiveSheet()->setCellValue('C3', "Learners Permanent Record for Elementary School (SF10-ES)");

        $this->excel->getActiveSheet()->mergeCells('C4:G4');
        $this->excel->getActiveSheet()->getStyle('C4')->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'font' => array('size' => 7, 'name' => 'Verdana')));
        $this->excel->getActiveSheet()->setCellValue('C4', "(Formerly Form 137)");

        $centerA6 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'font' => array('size' => 9, 'bold' => TRUE));
        $this->excel->getActiveSheet()->mergeCells('A6:I6');
        $this->excel->getActiveSheet()->getStyle('A6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('A9A9A9');
        $this->excel->getActiveSheet()->getStyle('A6')->applyFromArray($centerA6);
        $this->excel->getActiveSheet()->setCellValue('A6', "LEARNER`S PERSONAL INFORMATION");

        $this->excel->getActiveSheet()->getStyle('A7:J7')->applyFromArray($stValue);
        $this->excel->getActiveSheet()->setCellValue('A7', 'Last Name:');
        $this->excel->getActiveSheet()->setCellValue('B7', $student->sprp_lastname);

        $this->excel->getActiveSheet()->setCellValue('D7', 'First Name:');
        $this->excel->getActiveSheet()->setCellValue('E7', $student->sprp_firstname);

        $this->excel->getActiveSheet()->setCellValue('F7', 'NAME EXTN.(Jr,I,II)');
        $this->excel->getActiveSheet()->setCellValue('G7', $student->sprp_extname);

        $this->excel->getActiveSheet()->setCellValue('H7', 'Middle Name:');
        $this->excel->getActiveSheet()->setCellValue('I7', $student->sprp_middlename);

        $this->excel->getActiveSheet()->getStyle('A8:I8')->applyFromArray($stValue);
        $this->excel->getActiveSheet()->mergeCells('A8:B8');
        $this->excel->getActiveSheet()->setCellValue('A8', 'Learner Reference Number (LRN):');
        $this->excel->getActiveSheet()->setCellValue('C8', $student->sprp_lrn);

        $this->excel->getActiveSheet()->setCellValue('E8', 'Birthdate:');
        $this->excel->getActiveSheet()->setCellValue('F8', date('m/d/Y', strtotime($student->sprp_bdate)));

        $this->excel->getActiveSheet()->setCellValue('G8', 'Sex:');
        $this->excel->getActiveSheet()->setCellValue('H8', strtoupper($student->sprp_gender));

        $centerA9 = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'font' => array('size' => 9, 'bold' => TRUE));
        $this->excel->getActiveSheet()->mergeCells('A9:I9');
        $this->excel->getActiveSheet()->getStyle('A9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('A9A9A9');
        $this->excel->getActiveSheet()->getStyle('A9')->applyFromArray($centerA6);
        $this->excel->getActiveSheet()->setCellValue('A9', "ELIGIBILITY FOR ELEMENTARY SCHOOL ENROLMENT");

        $this->excel->getActiveSheet()->getStyle('A10:I10')->applyFromArray($stValue);
        $this->excel->getActiveSheet()->mergeCells('A10:B10');
        $this->excel->getActiveSheet()->setCellValue('A10', 'Credential Presented for Grade 1:');

        header('Content-Type: application/vnd.ms-excel'); //mime type
        //header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        ob_end_clean();
        $objWriter->save('php://output');
    }

    function exportStudentListToExcell($value, $year = NULL) {
        $this->load->library('eskwela');
        $this->load->library('excel');
        $this->load->helper('download');
        $settings = $this->eskwela->getSet();

        $year = ($year == NULL ? $this->session->school_year : $year);

        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $section = $this->getSectionById($value);
//        $section = Modules::run('registrar/getSectionById', $value);

        $this->excel->getActiveSheet()->setTitle($section->level . '-' . $section->section);

        $this->excel->getActiveSheet()->setCellValue('A1', "[REPLACE GRADE LEVEL HERE] ex. GRADE 5");
        $this->excel->getActiveSheet()->setCellValue('C1', "[REPLACE SCHOOL YEAR] ex. for 2017-2018 just put 2017");
        $this->excel->getActiveSheet()->setCellValue('D1', "[REPLACE SCHOOL NAME] ex. PRECIOUS INTERNATIONAL SCHOOL OF DAVAO");

        $this->excel->getActiveSheet()->setCellValue('A2', "[Teacher's Name] ");

        $this->excel->getActiveSheet()->setCellValue('A4', 'ID Number');
        $this->excel->getActiveSheet()->setCellValue('B4', 'STUDENT NAME');
        $this->excel->getActiveSheet()->setCellValue('C4', 'SECTION');


        $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

        $students = $this->sf10_model->getPreviousStudent($value, $year);
        //$students = $this->get_registrar_model->getAllCollegeStudents(600, 0, $level_id, NULL, $sy);
        $column = 4;
        foreach ($students as $s):
            $studentStat = $this->getStudentStat($s->stid);
//            $studentStat = Modules::run('reports/getStudentStat', $s->stid);
            if ($studentStat->remark_to == ''):
                $column++;
                $this->excel->getActiveSheet()->setCellValue('A' . $column, $s->stid);
                $this->excel->getActiveSheet()->getStyle('A' . $column)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $this->excel->getActiveSheet()->setCellValue('B' . $column, strtoupper($s->lastname . ', ' . $s->firstname . ' ' . substr($s->middlename, 0, 1) . '. '));
            endif;
        endforeach;

        $filename = $settings->short_name . '_' . $year . '_' . $s->level . '_' . $s->section . '.xls'; //save our workbook as this file name
        // $filename=$settings->short_name.'_'.$sy.'_'.$s->course_id.'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    function generateF137($st_id, $status, $year = NULL) {
        if ($status == 0):
            $student = $this->sf10_model->getSingleStudent(base64_decode($st_id), ($year == NULL ? $this->session->school_year : $year));
            $data['m'] = $this->sf10_model->getMother($student->user_id);
            $data['f'] = $this->sf10_model->getFather($student->user_id);
        else:
            $student = $this->sf10_model->getStudentInfo(base64_decode($st_id), ($year == NULL ? $this->session->school_year : $year));
        endif;
        $data['edHistory'] = $this->sf10_model->getEdHistory(base64_decode($st_id), $year);
        $data['student'] = $student;
        $data['sy'] = ($year == NULL ? $this->session->school_year : $year);
        $this->load->view('recordsForm', $data);
    }

    public function checkAcad($grade_id, $st_id) {
        $acad = $this->sf10_model->checkAcad($grade_id, base64_decode($st_id));

        $details = array(
            'school_year' => $acad->school_year,
            'school_name' => $acad->school_name,
            'spr_id' => $acad->spr_id
        );

        echo json_encode($details);
    }

    public function saveAcademicRecords($user_id = NULL) {
        $school_year = $this->post('school_year');
        $semester = $this->post('semester');
        $school = $this->post('school');
        $first = $this->post('first');
        $second = $this->post('second');
        $third = $this->post('third');
        $fourth = $this->post('fourth');
        $average = $this->post('average');
        $subject_id = $this->post('subject_id');
        $grade_id = $this->post('grade_id');


        $exist = $this->sf10_model->checkAcad(base64_decode($user_id), $school_year, $semester);

        $subjectArray = $this->sf10_model->getSubjectArray($subject_id, $this->session->school_year);

        $this->sf10_model->checkInSubject($subject_id, $school_year, $subjectArray);

        if (!$exist):

            $spr = array(
                'st_id' => base64_decode($user_id),
                'grade_level_id' => $grade_id,
                'school_name' => $school,
                'school_year' => $school_year
            );
            $spr_id = $this->sf10_model->saveSPR($spr, $school_year, base64_decode($user_id));

            $ar = array(
                'spr_id' => $spr_id,
                'subject_id' => $subject_id,
                'first' => $first,
                'second' => $second,
                'third' => $third,
                'fourth' => $fourth,
                'avg' => $average,
                'sem' => $semester
            );

            if ($subject_id != 0):
                $this->sf10_model->saveAR($ar, $spr_id, $subject_id, $school_year, $semester);
            endif;
        else:
            $spr_id = $exist;
            $ar = array(
                'spr_id' => $exist,
                'subject_id' => $subject_id,
                'first' => $first,
                'second' => $second,
                'third' => $third,
                'fourth' => $fourth,
                'avg' => $average,
                'sem' => $semester
            );

            if ($subject_id != 0):
                $this->sf10_model->saveAR($ar, $exist, $subject_id, $school_year, $semester);
            endif;

        endif;

        if ($subject_id == 0):
            $spr = array(
                'spr_id' => $spr_id,
                'subject_id' => 0,
                'first' => $first,
                'second' => $second,
                'third' => $third,
                'fourth' => $fourth,
                'avg' => $average,
                'sem' => $semester
            );

            $this->sf10_model->saveAR($spr, $spr_id, $subject_id, $school_year, $semester);
        endif;

        // this portion is for especialized Class

        if ($school_year == $this->session->school_year):
            if ($first != NULL):
                $firstArray = array(
                    'st_id' => base64_decode($user_id),
                    'subject_id' => $subject_id,
                    'grading' => 1,
                    'school_year' => $school_year,
                    'final_rating' => $first,
                    'is_final' => 1,
                    'is_manual' => 1,
                    'is_special' => 1
                );
                $this->sf10_model->saveFinalCard($firstArray, base64_decode($user_id), 1, $school_year, $subject_id);
            endif;
            if ($second != NULL):
                $secondArray = array(
                    'st_id' => base64_decode($user_id),
                    'subject_id' => $subject_id,
                    'grading' => 2,
                    'school_year' => $school_year,
                    'final_rating' => $second,
                    'is_final' => 1,
                    'is_manual' => 1,
                    'is_special' => 1
                );
                $this->sf10_model->saveFinalCard($secondArray, base64_decode($user_id), 2, $school_year, $subject_id);
            endif;
            if ($third != NULL):
                $thirdArray = array(
                    'st_id' => base64_decode($user_id),
                    'subject_id' => $subject_id,
                    'grading' => 3,
                    'school_year' => $school_year,
                    'final_rating' => $third,
                    'is_final' => 1,
                    'is_manual' => 1,
                    'is_special' => 1
                );
                $this->sf10_model->saveFinalCard($thirdArray, base64_decode($user_id), 3, $school_year, $subject_id);
            endif;
            if ($fourth != NULL):
                $fourthArray = array(
                    'st_id' => base64_decode($user_id),
                    'subject_id' => $subject_id,
                    'grading' => 4,
                    'school_year' => $school_year,
                    'final_rating' => $fourth,
                    'is_final' => 1,
                    'is_manual' => 1,
                    'is_special' => 1
                );
                $this->sf10_model->saveFinalCard($fourthArray, base64_decode($user_id), 4, $school_year, $subject_id);
            endif;
            if ($average != NULL):
                $averageArray = array(
                    'st_id' => base64_decode($user_id),
                    'subject_id' => $subject_id,
                    'grading' => 0,
                    'school_year' => $school_year,
                    'final_rating' => $average,
                    'is_final' => 1,
                    'is_manual' => 1,
                    'is_special' => 1
                );
                $this->sf10_model->saveFinalCard($averageArray, base64_decode($user_id), 0, $school_year, $subject_id);
            endif;

        endif;

        $ar['acadRecords'] = $this->sf10_model->getAcadRecords($spr_id, $school_year, $grade_id, $semester);
        $ar['spr_id'] = $spr_id;
        $this->load->view('academicRecordsModal', $ar);
    }

    function showAcadRecordsModal($spr_id, $grade_id = NULL, $school_year = NULL, $semester = NULL) {
        $ar['acadRecords'] = $this->sf10_model->getAcadRecords($spr_id, $school_year, $grade_id, $semester);
        $ar['spr_id'] = $spr_id;
        $this->load->view('academicRecordsModal', $ar);
    }

    function getAcadRecordsRaw($st_id, $school_year, $grade_id, $semester) {
        $records = $this->sf10_model->getAcadRecords(base64_decode($st_id), $school_year, $grade_id, $semester);
        return $records;
    }

    function showAcadRecords($user_id, $grade_id = NULL, $school_year = NULL) {
        $chckDB = $this->sf10_model->checkIFdbExist($school_year);

        $data['school_year'] = $school_year;
        $data['grade_id'] = $grade_id;
        $data['user_id'] = $user_id;
        if ($chckDB == 1):
            $t = $this->getSPRrec(base64_decode($user_id), $school_year);
            if (!empty($t)):
                $ar['gsYR'] = $school_year;
                $ar['grdID'] = $grade_id;

                if ($grade_id != 12 && $grade_id != 13):
                    $this->load->view('academicRecords', $ar);
                else:
                    $this->load->view('academicRecords_sh', $ar);
                endif;
            else:
                $this->load->view('recordsCheck', $data);
            endif;
        else:
            $this->load->view('recordsCheck', $data);
        endif;
    }

    function getAcadRecords($user_id, $school_year, $grade_level = NULL) {
        $acadRecords = $this->sf10_model->getAcadRecords($user_id, $school_year, $grade_level);
        return $acadRecords;
    }

    function getAcademicRecords($user_id, $school_year, $grade_level = NULL, $sem = NULL) {
        $acadRecords = $this->sf10_model->getAcadRecords($user_id, $school_year, $grade_level, $sem);
        return $acadRecords;
    }

    function getPersonalInfo($st_id, $status, $year = NULL) {
        //if $status == 0 then get present student info. else get previous student info
        if ($status == 0):
            $student = $this->sf10_model->getSingleStudent(base64_decode($st_id), ($year == NULL ? $this->session->school_year : $year), 1);
            $data['m'] = $this->sf10_model->getMother($student->user_id);
            $data['f'] = $this->sf10_model->getFather($student->user_id);
        else:
            $student = $this->sf10_model->getStudentInfo(base64_decode($st_id), ($year == NULL ? $this->session->school_year : $year));
        endif;

        $data['grade'] = Modules::run('registrar/getGradeLevel');
        $data['subjects'] = Modules::run('academic/getSubjects');
        $data['student'] = $student;
        $data['status'] = $status;
        $data['dataSY'] = $year;
        $data['modules'] = "sf10";
        $data['main_content'] = 'personalInfo';
        echo Modules::run('templates/main_content', $data);
    }

    function savePersonalInfo($array, $lastname, $firstname, $middlename = NULL, $school_year = NULL, $stid = NULL) {
        $profile_id = $this->sf10_model->saveNewInfo($array, $firstname, $lastname, $middlename, $school_year, $stid);

        if (!$profile_id):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    function saveNewInfo() {
        $lastname = $this->post('inputLastName');
        $firstname = $this->post('inputFirstName');
        $middlename = $this->post('inputMiddleName');

        $newDetails = array(
            'sprp_st_id' => $this->post('inputIdNum'),
            'sprp_lrn' => $this->post('inputLRN'),
            'sprp_lastname' => $lastname,
            'sprp_firstname' => $firstname,
            'sprp_middlename' => $middlename,
            'sprp_father' => $this->post('nameOfFather'),
            'sprp_father_occ' => $this->post('fatherOcc'),
            'sprp_mother' => $this->post('nameOfMother'),
            'sprp_mother_occ' => $this->post('motherOcc'),
            'sprp_bdate' => $this->post('sprBdate'),
            'sprp_bplace' => $this->post('inputPlaceOfBirth'),
            'sprp_nationality' => $this->post('inputNationality')
        );

        $profile_id = $this->sf10_model->saveNewInfo($newDetails, $firstname, $lastname, $middlename = NULL);

        if (!$profile_id):
            echo 'This student is already registered in the system';
        else:
            $barangay_id = $this->sf10_model->setBarangay($this->post('inputBarangay'));

            $add = array(
                'address_id' => $profile_id,
                'street' => $this->post('inputStreet'),
                'barangay_id' => $barangay_id,
                'city_id' => $this->post('inputMunCity'),
                'province_id' => $this->post('inputPID'),
                'country' => $this->post('country'),
                'zip_code' => $this->post('inputPostal'),
            );

            $this->sf10_model->setAddress($add, $profile_id);

            echo 'Successfully Saved';
        endif;
    }

    public function getNewInfo() {

        $data['cities'] = Modules::run('main/getCities');
        $data['provinces'] = Modules::run('main/getProvinces');
        $data['religion'] = Modules::run('main/getReligion');
        $data['grade'] = Modules::run('registrar/getGradeLevel');
        $data['modules'] = "sf10";
        $data['main_content'] = 'newInfo';
        echo Modules::run('templates/main_content', $data);
    }

    function searchStudent($value, $year = NULL) {
        $student = json_decode($this->sf10_model->searchStudent($value, $year));
        echo '<ul>';
        if ($student->result):
            foreach ($student->result as $s):
                ?>
                <li style="font-size:18px;" onclick="$('#searchName').hide(), $('#searchBox').val('<?php echo $s->firstname . ' ' . $s->lastname ?>'), loadStudentDetails('<?php echo base64_encode($s->st_id) ?>', <?php echo $student->status ?>, '<?php echo $year ?>')" ><?php echo strtoupper($s->lastname . ', ' . $s->firstname) ?></li>
                <?php
            endforeach;
            echo '</ul>';
        endif;
    }

    public function editBasicInfo() {
        $sy = $this->input->post('sy');
        $user_id = $this->input->post('user_id');
        $rowid = $this->input->post('rowid');
        $pos = $this->input->post('pos');
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $middlename = $this->input->post('middlename');
        $nameExt = $this->input->post('nameExt');

        $details = array(
            'sprp_firstname' => $firstname,
            'sprp_middlename' => $middlename,
            'sprp_lastname' => $lastname,
            'sprp_extname' => $nameExt
        );

        $this->sf10_model->updateBasicInfo($details, $user_id, $sy);
    }

    function editInfo() {
        $newVal = $this->input->post('newVal');
        $owner = $this->input->post('owner');
        $sy = $this->input->post('sy');
        $field = $this->input->post('field');
        $tbl_name = $this->input->post('tbl_name');
        $stid = $this->input->post('stid');
        $sem = $this->post('sem');
        //print_r($bDate . ' ' . $owner . ' ' . $sy);
        $this->sf10_model->editInfo($newVal, base64_decode($owner), $sy, $tbl_name, $field, $stid, $sem);
    }

    function getSPRrec($stID, $year, $semester = NULL, $level = NULL) {
        return $this->sf10_model->getSPRrec($stID, $year, $semester, $level);
    }

    function displayDept($st_id, $value, $grade_id, $sy) {
        $data['sy'] = $sy;
        $data['grade_id'] = $grade_id;
        $data['st_id'] = base64_decode($st_id);
        $data['edHistory'] = $this->sf10_model->getEdHistory(base64_decode($st_id), $sy);
        switch ($value):
            case 1:
                echo $this->load->view('formElementary', $data);
                break;
            case 2:
                echo $this->load->view('formJuniorHigh', $data);
                break;
            case 3:
                echo $this->load->view('formSeniorHigh', $data);
                break;
        endswitch;
    }

    function searchRecords() {
        $settings = Modules::run('main/getSet');
        $school_year = $this->post('school_year');
        $semester = $this->post('semester');
        $user_id = $this->post('user_id');
        $st_id = base64_decode($this->post('st_id'));
        $sySelect = $this->post('sySelect');
        $levelCode = $this->post('grade_level');
        $ifSave = $this->post('ifSave');
        $spr_id = $this->post('spr_id');

        $chckDB = $this->sf10_model->checkIFdbExist($sySelect);

        if ($chckDB == 1):
            $stid = base64_decode($user_id);
            if ($this->post('strand_id') == 0):
                $strand_id = $this->sf10_model->getStrand_id($stid, $sySelect);
            else:
                $strand_id = $this->post('strand_id');
            endif;
            $records = $this->sf10_model->getSPRrecord($spr_id, $sySelect, $levelCode, $stid, $strand_id, $semester);

            if ($records):
                $sprData['records'] = $records;
                $this->load->view('autoFetchRecord', $sprData);
            else:
                echo '<p style="color: red">Error: No Records Fetched</p>';
            endif;
        else:
            echo '<p style="color: red">Error: Unable to fetch Records. Records for S.Y. ' . $sySelect . ' - ' . ($sySelect + 1) . ' was not found on the system</p>';
        endif;
    }

    function getFinalCardByLevel($level, $sy = null) {
        return $this->sf10_model->getFinalCardByLevel($level, $sy);
    }

    function getFinalGrade($stid, $subID, $term) {
        return $this->sf10_model->getFinalGrade($stid, $subID, $term);
    }

    function updateSPRgrading($spr_id, $sub_id, $value, $sy, $field) {
        //print_r($spr_id . ' ' . $sub_id . ' ' . $value . ' ' . $sy . ' ' . $field);
        $this->sf10_model->updateSPRgrading($spr_id, $sub_id, $value, $sy, $field);
    }

    function getSubjectDesc($subj_id) {
        return $this->sf10_model->getSubjectDesc($subj_id);
    }

    function updateSPRrecord($spr_id, $subj_id, $ar_id, $first, $second, $third, $fourth, $sy) {
        $details = array(
            'first' => $first,
            'second' => $second,
            'third' => $third,
            'fourth' => $fourth
        );

        $this->sf10_model->updateSPRrecord($spr_id, $subj_id, $ar_id, $details, $sy);
    }

    function getSettings($sy) {
        $siteSettings = $this->sf10_model->getSettings($sy);
        return $siteSettings;
    }

    function getStrand($id = NULL, $opt) {
        return $this->sf10_model->getStrand($id, $opt);
    }

    function printF137($st_id, $sy, $val, $strand = Null) {
        $gs_settings = Modules::run('gradingsystem/getSet');
        $settings = Modules::run('main/getSet');
        $data['gs_settings'] = Modules::run('gradingsystem/getSet');
        $data['settings'] = Modules::run('main/getSet');
        $data['year'] = $sy;
        $data['usd'] = base64_decode($st_id);
        $data['pYear'] = $sy;
        $data['student'] = $this->sf10_model->getStudentInfo(base64_decode($st_id), ($sy == NULL ? $this->session->school_year : $sy));
//        $data['student'] = Modules::run('registrar/getSingleStudentSPR', base64_decode($st_id), $sy);
//        if ($gs_settings->customized_f137):
//            $this->load->view('form137/' . strtolower($settings->short_name) . '_main', $data);
//        else:
        $data['avatar'] = $this->sf10_model->getAvatar(base64_decode($st_id));
        if ($val == 1):
            $this->load->view('gs_frontpage', $data);
        elseif ($val == 2):
            $this->load->view('jhs_frontpage', $data);
        elseif ($val == 3):
            $data['strand_id'] = $strand;
            $this->load->view('shs_frontpage', $data);
        else:
            $this->load->view('kinder_main', $data);
        endif;
//        endif;
    }

    function checkIFdbExist($sy) {
        return $this->sf10_model->checkIFdbExist($sy);
        //echo $q;
    }

    function checkStudentsInfo($id, $sy) {
        $q = $this->sf10_model->getStudentInfo(base64_decode($id), $sy);
        echo json_encode($q);
    }

    function checkUpdateAcad($user_id, $sy) {
        $q = $this->sf10_model->checkUpdateAcad(base64_decode($user_id), $sy);
        echo json_encode($q);
    }

    function checkRecords($stid, $sy, $level) {
        $data['gsYR'] = $sy;
        $data['st_id'] = base64_decode($stid);

        if ($level != 12 && $level != 13):
            $data['stDetails'] = $this->getSPRrec(base64_decode($stid), $sy, 0, $level);
            $data['acadRecords'] = $this->sf10_model->getAcadRecords($data['stDetails']->spr_id, $sy, $level, 0);
            $data['acadAverage'] = $this->getAcadAverage($data['stDetails']->spr_id, 0);
            echo $this->load->view('acadRecords', $data);

        else:

            $stDetailsFirst = $this->getSPRrec(base64_decode($stid), $sy, 1, $level);
            $stDetailsSecond = $this->getSPRrec(base64_decode($stid), $sy, 2, $level);

            $acadRecordsFirst = $this->sf10_model->getAcadRecords($stDetailsFirst->spr_id, $sy, $level, 1);
            $acadRecordsSecond = $this->sf10_model->getAcadRecords($stDetailsSecond->spr_id, $sy, $level, 2);

            $acadAverageFirst = $this->getAcadAverage($stDetailsFirst->spr_id, 1);
            $acadAverageSecond = $this->getAcadAverage($stDetailsSecond->spr_id, 2);

            $data['acadAverageFirst'] = $acadAverageFirst;
            $data['acadAverageSecond'] = $acadAverageSecond;
            $data['stDetailsFirst'] = $stDetailsFirst;
            $data['stDetailsSecond'] = $stDetailsSecond;
            $data['acadRecordsFirst'] = $acadRecordsFirst;
            $data['acadRecordsSecond'] = $acadRecordsSecond;

            echo $this->load->view('acadRecords_sh', $data);
        endif;
    }

    function lock_unlock_SPR() {
        $spr = $this->reports_model->lock_unlock_SPR($this->post('spr_id'), $this->post('option'));
        return $spr;
    }

    function checkSubject($subject_id, $spr_id) {
        $exist = $this->sf10_model->checkSubject($subject_id, $spr_id);
        if ($exist):
            echo json_encode(array('status' => TRUE, 'msg' => 'Sorry, Subject already Exist'));
        endif;
    }

    function checkIfAcadExist($user_id, $levelCode) {
        $exist = $this->sf10_model->checkIfAcadExist(base64_decode($user_id), $levelCode);
        if ($exist->num_rows() > 0):
            echo json_encode(array('status' => TRUE, 'school' => $exist->row()->school_name, 'year' => $exist->row()->school_year, 'spr_id' => $exist->row()->spr_id));
        else:
            echo json_encode(array('status' => FALSE));
        endif;
    }

    public function saveEdHistory() {
        $edHistory = array(
            'st_id' => base64_decode($this->input->post('st_id')),
            'name_of_school' => $this->input->post('elemSchool'),
            'gen_ave' => $this->input->post('genAve'),
            'school_year' => $this->input->post('school_year'),
            'total_years' => $this->input->post('yearsCompleted'),
            'curriculum' => $this->input->post('curriculum'),
            'history_type' => $this->input->post('recordType'),
        );


        if ($this->sf10_model->saveEdHistory($edHistory, $this->input->post('recordType'), base64_decode($this->input->post('st_id')))):
            echo json_encode(array('status' => TRUE, 'msg' => "Information Succesfully added"));
        else:
            echo json_encode(array('status' => FALSE, 'msg' => "Internal Error Occured"));
        endif;
    }

    public function generateForm137() {
        $data['subjects'] = Modules::run('academic/getSubjects');
        //print_r(Modules::run('registrar/getAllStudentsByLevel',NULL, $section_id, $school_year));
        $data['students'] = $this->getAllStudentsByLevel(NULL, NULL, $this->session->school_year);
//        $data['students'] = Modules::run('registrar/getAllStudentsByLevel',NULL, NULL, $this->session->school_year);
        $data['modules'] = "sf10";
        $data['main_content'] = 'generateForm137';
        echo Modules::run('templates/main_content', $data);
    }

    function getSectionById($id, $sy = NULL) {
        $section = $this->sf10_model->getSectionById($id, $sy);
        return $section;
    }

    function getStudentStat($id, $sy = NULL) {
        return $this->sf10_model->getStudentStat($id, $sy);
    }

    function getAllStudentsByLevel($grade_level = NULL, $section_id = null, $year = NULL) {
        $result = $this->sf10_model->getAllStudentsByLevel($grade_level, $section_id, $year);
        return $result;
        //echo $result->num_rows();
    }

    function getStrandCode($id, $sy = Null) {
        $strand = $this->sf10_model->getStrandByID($id, $sy);
        return $strand;
    }

    function getSHOfferedStrand() {
        $strands = $this->sf10_model->getSHOfferedStrand();
        return $strands;
    }

    function getSingleStudent($user_id, $year = NULL) {
        $student = $this->sf10_model->getSingleStudent($user_id, $year);
        return $student;
    }

    function getGradeLevelByLevelCode($grade_id) {
        $grade_id = $this->sf10_model->getGradeLevelByLevelCode($grade_id);
        return $grade_id;
    }

    function deleteSPRecords($spr_id) {
        $spr = $this->sf10_model->deleteSPRecords($spr_id);
        if ($spr):
            echo json_encode(array('status' => TRUE));
        else:
            echo json_encode(array('status' => FALSE));
        endif;
    }

    function deleteSingleRecord($spr_id) {
        $spr = $this->sf10_model->deleteSingleRecord($spr_id);
        if ($spr):
            echo json_encode(array('status' => TRUE));
        else:
            echo json_encode(array('status' => FALSE));
        endif;
    }

    function getGradeLevelById($grade_id, $sy) {
        $grade_id = $this->sf10_model->getGradeLevelById($grade_id, $sy);
        return $grade_id;
    }

    public function autoFetchDaysPresent() {
        $spr_id = $this->input->post('spr_id');
        $spr_details = $this->sf10_model->getSPRById($spr_id);

        for ($i = 1; $i <= 12; $i++):
            if ($i != 5 && $i != 6):
                if ($i < 10):
                    $i = '0' . $i;
                endif;
                switch ($i):
                    case 1:
                    case 2:
                    case 3:
                        $school_year = $spr_details->school_year + 1;
                        break;
                    default :
                        $school_year = $spr_details->school_year;
                        break;
                endswitch;
                $present = Modules::run('attendance/getIndividualMonthlyAttendance', $spr_details->st_id, $i, $school_year);
                if ($present > 0):
                    $present = $present;
                else:
                    $present = 0;
                endif;
                //echo $spr_details->st_id.' - '.$present.'<br />';
                $monthName = $this->getMonthName($i);
//                $monthName = Modules::run('main/getMonthName', $i);
                $exist = $this->sf10_model->getDaysPresent($spr_details->spr_id);

                $values = array(
                    'spr_id' => $spr_details->spr_id,
                    $monthName => $present
                );

                if (!$exist):
                    if ($this->sf10_model->insertDaysPresent($values)):
                    // $this->getSchoolDays($school_year);
                    endif;
                else:
                    if ($this->sf10_model->updateDaysPresent($spr_details->spr_id, $values)):

                    endif;
                endif;
            endif;
        endfor;
        $this->getDaysPresentModal($spr_details->spr_id, $st_id);
    }

    public function getDaysPresentModal($spr_id = NULL, $st_id = NULL) {
        if ($spr_id == NULL):
            $spr_id = $this->post('spr_id');
        endif;
        $data['rfid'] = $st_id;
        $data['exist'] = $this->sf10_model->getDaysPresent($spr_id);
        $data['schoolDays'] = $this->getRawSchoolDays($data['exist']->row()->school_year);

        $this->load->view('daysPresentModal', $data);
    }

    public function getRawSchoolDays($year) {
        $schoolDays = $this->sf10_model->getSchoolDays($year);
        return $schoolDays;
    }

    public function autoFetchDays() {
        $school_year = $this->input->post('year');
//        for($i=1;$i<=12; $i++):
//            if($i!=5 && $i!=6):
//                if($i<6):
//                    $year = $school_year + 1;
//                else:
//                    $year = $school_year;
//                endif;
//                $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $i, 10)), $year, 'first');
//                $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $i, 10)), $year, 'last');
//                $holiday = Modules::run('calendar/holidayExist', $i, $year);
//                $school_days = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $i , $year);
//                $sdays = ($school_days - $holiday->num_rows());
//
//
//                $monthName = Modules::run('main/getMonthName', $i);
//                $exist = $this->reports_model->getSchoolDays($school_year);
//
//                $values = array(
//                    'school_year' => $school_year,
//                     $monthName => $sdays
//                );
//
//                if(!$exist):
//                    if($this->reports_model->insertSchoolDays($values)):
//                   // $this->getSchoolDays($school_year);
//                    endif;
//                else:
//                    if($this->reports_model->updateSchoolDays($school_year, $values)):
//
//                    endif;
//                endif;
//            endif;
//        endfor;
        $this->getSchoolDays($school_year);
    }

    public function getSchoolDays($year = NULL) {
        if ($year == NULL):
            $year = $this->input->post('year');
        endif;
        $data['exist'] = $this->sf10_model->getSchoolDays($year);
        $this->load->view('schoolDays', $data);
    }

    function autoSaveAttendance($month, $days, $spr_id, $school_year) {
        $monthName = $this->getMonthName($month);

        $exist = $this->sf10_model->getDaysPresent($spr_id, $school_year);

        $values = array(
            'spr_id' => $spr_id,
            $monthName => $days
        );

        if (!$exist):
            if ($this->sf10_model->insertDaysPresent($values, $school_year)):
                echo json_encode(array('month' => $monthName, 'days' => $days));
            endif;
        else:
            if ($this->sf10_model->updateDaysPresent($spr_id, $values, $school_year)):
                echo json_encode(array('month' => $monthName, 'days' => $days));
            endif;
        endif;
    }

    public function savePresentDays() {
        $month = $this->post('month');
        $days = $this->post('days');
        $spr_id = $this->post('spr_id');
        $school_year = $this->post('school_year');
        $monthName = $this->getMonthName($month);
//        $monthName = Modules::run('main/getMonthName', $month);

        $exist = $this->sf10_model->getDaysPresent($spr_id, $school_year);

        $values = array(
            'spr_id' => $spr_id,
            $monthName => $days
        );

        if (!$exist):
            if ($this->sf10_model->insertDaysPresent($values, $school_year)):
                echo json_encode(array('month' => $monthName, 'days' => $days));
            endif;
        else:
            if ($this->sf10_model->updateDaysPresent($spr_id, $values, $school_year)):
                echo json_encode(array('month' => $monthName, 'days' => $days));
            endif;
        endif;
    }

    function getMonthName($m_id = NULL) {
        return date("F", strtotime(date("d-$m_id-y")));
    }

    function updateBasicSPR() {
        $spr_id = $this->post('spr_id');
        $school = $this->post('school');
        $school_year = $this->post('school_year');

        $details = array(
            'school_name' => $school,
            'school_year' => $school_year
        );

        $spr = $this->sf10_model->updateBasicSPR($spr_id, $details);
    }

    public function saveSchoolDays() {
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $days = $this->input->post('numOfSchoolDays');
        $monthName = $this->getMonthName($month);
//        $monthName = Modules::run('main/getMonthName', $month);

        $exist = $this->sf10_model->getSchoolDays($year);

        $values = array(
            'school_year' => $year,
            $monthName => $days
        );

        if (!$exist):
            if ($this->sf10_model->insertSchoolDays($values)):
                echo json_encode(array('month' => $monthName, 'days' => $days));
            endif;
        else:
            if ($this->sf10_model->updateSchoolDays($year, $values)):
                echo json_encode(array('month' => $monthName, 'days' => $days));
            endif;
        endif;
    }

    function editAddressInfo() {
        $address_id = $this->input->post('address_id');
        $street = $this->input->post('street');
        $barangay = $this->input->post('barangay');
        $city = $this->input->post('city');
        $province = $this->input->post('province');
        $zip_code = $this->input->post('zip_code');
        $user_id = $this->input->post('user_id');
        $sy = $this->input->post('sy');
        $is_home = $this->input->post('isHome');

        $details = array(
            'sprp_profile_id' => $user_id,
            'street' => $street,
            'barangay_id' => $barangay,
            'city_id' => $city,
            'province_id' => $province,
            'zip_code' => $zip_code,
            'is_home' => $is_home
        );

        $this->sf10_model->updateAddress($address_id, $sy, $details, $is_home);
    }

    function getAddress($stid, $opt, $sy = NULL) {
        return $this->sf10_model->getAddress($stid, $opt, $sy);
    }

    function sf10UPdates($year) {
        $this->db = $this->eskwela->db(($year == NULL ? $this->session->school_year : $year));

        $this->db->where('sem', 2);
        $this->db->group_by('spr_id');
        $q = $this->db->get('gs_spr_ar');
        $cnt = 0;
        foreach ($q->result() as $row):
            $this->db->where('spr_id', $row->spr_id);
            $this->db->where('semester', $row->sem);
            $q2 = $this->db->get('gs_spr');

            if ($q2->num_rows() > 0):
                $spr_id = $q2->row()->spr_id;
            else:
                $this->db->where('spr_id', $row->spr_id);
                $this->db->where('semester', 1);
                $q3 = $this->db->get('gs_spr')->row();

                $info1 = array(
                    'st_id' => $q3->st_id,
                    'grade_level_id' => $q3->grade_level_id,
                    'school_year' => $q3->school_year,
                    'semester' => 2,
                    'time_added' => date('Y-m-d H:i:s'),
                );
                $this->db = $this->eskwela->db(($year == NULL ? $this->session->school_year : $year));

                if ($this->db->insert('gs_spr', $info1)):
                    $spr_id = $this->db->insert_id();
                endif;
            endif;

            $data = array(
                'spr_id' => $spr_id,
            );

            $this->db->where('spr_id', $row->spr_id);
            $this->db->where('sem', $row->sem);
            if ($this->db->update('gs_spr_ar', $data)):
                $cnt++;
            endif;


        endforeach;
        echo $cnt;
    }

    function getTardy($stid) {
        return $this->sf10_model->getTardy($stid);
    }

    function saveTardy() {
        $spr_id = $this->post('spr_id');
        $month = $this->post('month');
        $value = $this->post('value');
        $school_year = $this->post('school_year');

        if ($this->sf10_model->saveTardy($spr_id, $month, $value, $school_year)):
            echo 'Tardy Successfuly Save!';
        else:
            echo 'An Error Occured!';
        endif;
    }

}
