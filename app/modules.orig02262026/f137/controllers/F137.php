<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class f137 extends MX_Controller {

    //put your code here

    protected $generate;

    public function __construct() {
        parent::__construct();
        $this->load->library('Pdf');
        $this->load->library('csvimport');
        $this->load->library('csvreader');
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->dbforge();
        $this->load->model('f137_model');
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

        $db_name = 'csscore_eskwela_' . strtolower($settings->short_name) . '_' . $year;

        if ($this->dbforge->create_database($db_name)) {
            $this->f137_model->createSPRTables($db_name, 'spr.sql');
            $this->f137_model->createSPRTables($db_name, 'address.sql');
            $this->f137_model->createSPRTables($db_name, 'subject.sql');
            sleep(5);

            $subjectArray = $this->f137_model->exportSubjects($this->session->school_year);

            foreach ($subjectArray as $subArr):
                $this->f137_model->insertAllSubjects($year, $subArr);
            endforeach;

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function generateForm137() {
        $data['subjects'] = Modules::run('academic/getSubjects');
        $data['students'] = $this->getAllStudentsByLevel(NULL, NULL, $this->session->school_year);
        $data['modules'] = "f137";
        $data['main_content'] = 'generateForm137';
        echo Modules::run('templates/main_content', $data);
    }

    function searchStudent($value, $year = NULL) {
        $student = json_decode($this->f137_model->searchStudent($value, $year));
        echo '<ul>';
        if ($student->result):
            foreach ($student->result as $s):
                ?>
                <li style="font-size:18px;" onclick="$('#searchName').hide(), $('#searchBox').val('<?php echo $s->firstname . ' ' . $s->lastname ?>'), loadStudentDetails('<?php echo base64_encode($s->st_id) ?>', <?php echo $student->status ?>, '<?php echo $year ?>', '<?php echo $s->grade_id ?>')" ><?php echo strtoupper($s->lastname . ', ' . $s->firstname) ?></li>
                <?php
            endforeach;
            echo '</ul>';
        else:
            echo '<li style="color: red">Entry Not Found!!!</li>';
            echo '</ul>';
        endif;
    }

    function getPersonalInfo($st_id, $status, $school_year = NULL, $level = NULL) {
        $sy = ($school_year != NULL ? $school_year : $this->session->school_year);

        $data['grade'] = Modules::run('registrar/getGradeLevel');
        $data['subjects'] = Modules::run('academic/getSubjects');
        $data['student'] = $this->getSingleStudent(base64_decode($st_id), $sy, $level);
        $data['status'] = $status;
        $data['dataSY'] = $sy;
        $data['modules'] = "f137";
        $data['main_content'] = 'personalInfo';
        echo Modules::run('templates/main_content', $data);
    }

    function getSingleStudent($stid, $school_year = NULL, $level = NULL) {
        $sy = ($school_year != NULL ? $school_year : $this->session->school_year);
        $r = $this->f137_model->checkIfDataExist('gs_spr', 'st_id', $stid, $sy);

        if ($r->num_rows() > 0):
            return $this->f137_model->getSprRec($stid, $sy, $sy, $level);
        else:
            return $this->f137_model->addSprRec($stid, $sy, $sy, $level);
        endif;
    }

    function generateF137($st_id, $year = NULL, $lastSYen = NULL, $level = NULL) {
        $sy = ($year == NULL ? $this->session->school_year : $year);
        $data['student'] = $this->f137_model->getSprRec(base64_decode($st_id), $sy, $lastSYen, $level);
        $data['sy'] = $sy;
        $this->load->view('recordsForm', $data);
    }

    function getAddress($stid, $opt, $sy = NULL) {
        return $this->f137_model->getAddress($stid, $opt, $sy);
    }

    function showAcadRecords($user_id, $grade_id = NULL, $school_year = NULL, $spr_id = NULL) {
        $chckDB = $this->f137_model->checkIFdbExist($school_year);
//        $sprid = $this->getSPRrec($user_id, $school_year);

        $data['school_year'] = $school_year;
        $data['grade_id'] = $grade_id;
        $data['user_id'] = $user_id;
        $data['spr_id'] = $spr_id;
        $data['dbExist'] = ($chckDB ? 1 : 0);
        if ($chckDB):
            if ($grade_id != 12 && $grade_id != 13):
                $this->load->view('academicRecords', $data);
            else:
                $this->load->view('academicRecords_sh', $data);
            endif;
        else:
            $this->load->view('recordsCheck', $data);
        endif;
    }

    function getSPRFinalGrade($sprid, $sy, $semester = NULL) {
        return $this->f137_model->getSPRFinalGrade($sprid, $sy, $semester);
    }

    function getSPRrec($stID, $year, $lastSYen = NULL, $level = NULL) {
        return $this->f137_model->getSPRrec($stID, $year, $lastSYen, $level);
    }

    function fetchAcadRecord() {
//        $id = $this->input->post('spr_id');
        $stid = $this->input->post('st_id');
        $levelCode = $this->input->post('grade_level');
        $strand_id = $this->input->post('strand_id');
        $sy = $this->input->post('sy');

        $chckDB = $this->f137_model->checkIFdbExist($sy);

        if ($chckDB):
            $tblExist = $this->f137_model->checkTableExist('esk_gs_final_card', $sy);

            if ($tblExist):
                $id = $this->f137_model->getSprRec(base64_decode($stid), $sy, NULL, $levelCode);
                if (count($id) > 0):
                    $this->f137_model->updateSchoolRec(base64_decode($stid), $id->spr_id, $sy);
                    $this->f137_model->fetchAcadRecord($id->spr_id, base64_decode($stid), $levelCode, $strand_id, $sy);
                    echo json_encode(array('msg' => '', 'status' => TRUE));
                else:
                    echo json_encode(array('msg' => 'No records to fetch. CLick the button below to add record', 'status' => FALSE));
                endif;
            else:
                echo json_encode(array('msg' => 'No records to fetch. Click Import File Button', 'status' => FALSE));
            endif;
        else:
            echo json_encode(array('msg' => 'No records to fetch. CLick the button below to add record', 'status' => FALSE));
        endif;
    }

    function newRecord() {
        $settings = $this->eskwela->getSet();
        $school_year = $this->input->post('school_year');
        $current = $this->input->post('current_year');
        $lastSYen = $this->input->post('lastSYen');
        $st_id = $this->input->post('st_id');
        $sprid = $this->input->post('spr_id');
        $grade_level_id = $this->input->post('grade_level_id');

        $db_name = 'eskwela_' . strtolower($settings->short_name) . '_' . $school_year;

        $dbExist = $this->ifDatabaseExist($db_name);
        if ($dbExist):
            $tableExist = $this->f137_model->checkTableExist('esk_gs_spr', $school_year);
            if (!$tableExist):
                $this->f137_model->createSPRTables($db_name, 'spr.sql');
            endif;
        else:
            if ($this->create_database($school_year)):
            endif;
        endif;

        sleep(10);
        $this->f137_model->getSprRec(base64_decode($st_id), $school_year, $lastSYen, $grade_level_id);
    }

    function addSubjects() {
        $addSubjects = $this->input->post('addSubjects');
        $sy = $this->input->post('sy');
        $stid = $this->input->post('stid');

        $spr_id = $this->getSingleStudentSPR(base64_decode($stid), $sy);

        $subs = explode(',', $addSubjects);
        foreach ($subs as $s):
            $sub_id = $this->f137_model->getSubID($s, $sy);

            $this->f137_model->saveSPRSubject($sub_id, $spr_id->spr_id, $sy);
        endforeach;
    }

    function getSingleStudentSPR($st_id, $sy) {
        return $this->f137_model->getSingleStudentSPR($st_id, $sy);
    }

    function getSchoolAddress($add_id, $school_year) {
        return $this->f137_model->getSchoolAddress($add_id, $school_year);
    }

    function editInfo() {
        $newVal = $this->input->post('newVal');
        $owner = $this->input->post('owner');
        $sy = $this->input->post('sy');
        $field = $this->input->post('field');
        $tbl_name = $this->input->post('tbl_name');
        $stid = $this->input->post('stid');
        $this->f137_model->editInfo($newVal, base64_decode($owner), $sy, $tbl_name, $field, $stid);
    }

    function editSchoolInfo() {
        $newVal = $this->input->post('newVal');
        $owner = $this->input->post('owner');
        $sy = $this->input->post('sy');
        $field = $this->input->post('field');
        $tbl_name = $this->input->post('tbl_name');
        $id = $this->input->post('id');
        $primary_key = $this->input->post('primary_key');
        $st_id = $this->input->post('st_id');
        $sch_id = $this->input->post('sch_id');
        $this->f137_model->editSchoolInfo($newVal, $owner, $sy, $tbl_name, $field, $id, $primary_key, base64_decode($st_id), $sch_id);
    }

    function editAddressInfo() {
        $address_id = $this->input->post('add_id');
        $street = $this->input->post('street');
        $barangay = $this->input->post('brgy');
        $city = $this->input->post('city');
        $province = $this->input->post('province');
        $zip_code = $this->input->post('zip_code');
        $user_id = $this->input->post('user_id');
        $sy = $this->input->post('sy');
        $is_home = $this->input->post('is_home');
        $schID = $this->input->post('schID');

        $this->f137_model->updateAddress($address_id, $street, $barangay, $city, $province, $zip_code, base64_decode($user_id), $sy, $is_home, $schID);
    }

    public function importAssessment() {
        //load library phpExcel
        $this->load->library("excel");
        //here i used microsoft excel 2007
        $processExport = Modules::load('f137/export_import_handler/');

        $data['error'] = ''; //initialize image upload error array to empty

        $config['upload_path'] = 'uploads';
        $config['overwrite'] = TRUE;
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
            $term = $this->input->post('importTerm');
            $school_year = $this->input->post('selectSY');
            $sprid = $this->input->post('st_sprid');
            $student_id = base64_decode($this->input->post('student_id'));
            $sLevel = $this->input->post('sLevel');
            $lastSYen = $this->input->post('lastSYen');

            if ($sprid == ''):
                $r = $this->f137_model->getSprRec($student_id, $school_year, $lastSYen, $sLevel);
                $spr = $r->spr_id;
            else:
                $spr = $sprid;
            endif;
//            echo $school_year . ' ' . $spr . ' ' . $student_id;

            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            //set to read only
            $objReader->setReadDataOnly(true);
            //load excel file
            $objPHPExcel = $objReader->load($file_path);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

            $num_rows = $objWorksheet->getHighestRow();
            $rows = 2;

//                $section = $objWorksheet->getCellByColumnAndRow(1, 1)->getValue();
//                $school_id = $objWorksheet->getCellByColumnAndRow(2, 1)->getValue();
//                $school_name = $objWorksheet->getCellByColumnAndRow(3, 1)->getValue();
//                $district = $objWorksheet->getCellByColumnAndRow(4, 1)->getValue();
//                $division = $objWorksheet->getCellByColumnAndRow(5, 1)->getValue();
//                $region = $objWorksheet->getCellByColumnAndRow(6, 1)->getValue();
//                $adviser = $objWorksheet->getCellByColumnAndRow(7, 1)->getValue();
//                
//                $this->f137_model->editSchoolInfo($section, $spr, $school_year, 'gs_spr', 'section', 'spr_id', NULL, $student_id, $sch_id = NULL);
//                $this->f137_model->editSchoolInfo($school_id, 'esk_gs_spr_school_code', $school_year, 'gs_spr_school', 'school_id', 'spr_id', NULL, $student_id, $sch_id = NULL);
//                $this->f137_model->editSchoolInfo($school_name, $spr, $school_year, 'gs_spr', 'section', 'spr_id', NULL, $student_id, $sch_id = NULL);
//                $this->f137_model->editSchoolInfo($district, $spr, $school_year, 'gs_spr', 'section', 'spr_id', NULL, $student_id, $sch_id = NULL);
//                $this->f137_model->editSchoolInfo($division, $spr, $school_year, 'gs_spr', 'section', 'spr_id', NULL, $student_id, $sch_id = NULL);
//                $this->f137_model->editSchoolInfo($region, $spr, $school_year, 'gs_spr', 'section', 'spr_id', NULL, $student_id, $sch_id = NULL);
//                $this->f137_model->editSchoolInfo($adviser, $spr, $school_year, 'gs_spr', 'section', 'spr_id', NULL, $student_id, $sch_id = NULL);

            while ($rows != ($num_rows + 1)):
                $subject = $objWorksheet->getCellByColumnAndRow(0, $rows)->getValue();
                $firstQ = $objWorksheet->getCellByColumnAndRow(1, $rows)->getValue();
                $secondQ = $objWorksheet->getCellByColumnAndRow(2, $rows)->getValue();
                $thirdQ = $objWorksheet->getCellByColumnAndRow(3, $rows)->getValue();
                $fourthQ = $objWorksheet->getCellByColumnAndRow(4, $rows)->getValue();
                $final = $objWorksheet->getCellByColumnAndRow(5, $rows)->getValue();
                $remarks = $objWorksheet->getCellByColumnAndRow(6, $rows)->getValue();
                $sem = $objWorksheet->getCellByColumnAndRow(7, $rows)->getValue();

                $semester = ($sem != '' ? $sem : 0);

                $subj_id = $this->f137_model->insertSubject($subject, $school_year);

                $this->f137_model->updateSPRgrading($spr, $subj_id, $firstQ, $school_year, 'first');
                $this->f137_model->updateSPRgrading($spr, $subj_id, $secondQ, $school_year, 'second');
                $this->f137_model->updateSPRgrading($spr, $subj_id, $thirdQ, $school_year, 'third');
                $this->f137_model->updateSPRgrading($spr, $subj_id, $fourthQ, $school_year, 'fourth');
                $this->f137_model->updateSPRgrading($spr, $subj_id, $semester, $school_year, 'sem');

                $rows++;
            endwhile;
        }
//            
        ?>
        <script type="text/javascript">
            alert('Academic record successfully imported');
            document.location = '<?php echo base_url() . 'f137/getPersonalInfo/' . $this->input->post('student_id') . '/0/' . $this->session->school_year ?>'
        </script>
        <?php
    }

    function checkTableExist($tbl, $school_year) {
        return $this->f137_model->checkTableExist($tbl, $school_year);
    }

    function printF137($st_id, $sy, $val, $strand = Null) {
        $gs_settings = Modules::run('gradingsystem/getSet');
        $settings = Modules::run('main/getSet');
        $data['gs_settings'] = Modules::run('gradingsystem/getSet');
        $data['settings'] = Modules::run('main/getSet');
        $data['year'] = $sy;
        $data['usd'] = base64_decode($st_id);
        $data['pYear'] = $sy;
        $data['student'] = $this->f137_model->getStudentInfo(base64_decode($st_id), ($sy == NULL ? $this->session->school_year : $sy));
        $data['avatar'] = $this->f137_model->getAvatar(base64_decode($st_id));
        switch (strtolower($settings->short_name)):
            case 'csfl':
                echo Modules::run('customize/printF137', $data);
                break;
            default :
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
                break;
        endswitch;
    }

    function checkIFdbExist($sy) {
        return $this->f137_model->checkIFdbExist($sy);
        //echo $q;
    }

    function checkAdmission($stid, $school_year) {
        return $this->f137_model->checkAdmission($stid, $school_year);
    }

    function getSettings($sy) {
        $siteSettings = $this->f137_model->getSettings($sy);
        return $siteSettings;
    }

    function getGradeLevelById($grade_id, $sy) {
        $grade_id = $this->f137_model->getGradeLevelById($grade_id, $sy);
        return $grade_id;
    }

    function getEdHistory($st_id, $history_type, $sy) {
        $edHistory = $this->f137_model->getEdHistory(base64_decode($st_id), $sy, $history_type);
        return $edHistory;
    }

    function getStrand($id = NULL, $opt) {
        return $this->f137_model->getStrand($id, $opt);
    }

    function deleteRec() {
        $sy = $this->input->post('sy');
        $spr_id = $this->input->post('id');
        $subj_id = $this->input->post('subj_id');
        $q = $this->f137_model->deleteRec($spr_id, $subj_id, $sy);
        if ($q):
            echo json_encode(array('msg' => 'Academic Records Successfuly Deleted', 'status' => TRUE));
        else:
            echo json_encode(array('msg' => 'An error occured during the delete process', 'status' => FALSE));
        endif;
    }

    function updateAdmission() {
        $this->db = $this->eskwela->db(2019);

        $pf = $this->db->get('profile_students')->result();

        foreach ($pf as $pa):
            $this->db->where('user_id', $pa->user_id);
            $this->db->update('profile_students_admission', array('st_id' => $pa->st_id));
        endforeach;
    }

    function getGenRecByID($id, $sy = NULL) {
        return $this->f137_model->getGenRecByID($id, $sy);
    }

    function updateCheckBox() {
        $stid = $this->input->post('stid');
        $field = $this->input->post('field');
        $opt = $this->input->post('opt');
        $sy = $this->input->post('sy');
        $certp = $this->input->post('certp');

        $this->f137_model->updateCheckBox(base64_decode($stid), $field, $opt, $sy, $certp);
    }

    function displayCredentialPresented($stid, $sy) {
        for ($a = 1; $a <= 3; $a++):
            $isCheck = $this->getCredentialPresented($a, $stid, $sy);
            switch ($a):
                case 1:
                    $label = 'Kinder Progress Repport';
                    $id = 'kpr';
                    break;
                case 2:
                    $label = 'ECCD Checklist';
                    $id = 'eccd';
                    break;
                case 3:
                    $label = 'Kindergarten Certificate of Completion';
                    $id = 'kcoc';
                    break;
            endswitch;
            ?>
            <input class="form-check-input" type="checkbox" id="box_<?php echo $id ?>" <?php echo ($isCheck ? 'checked' : '') ?> onclick="checkBox('<?php echo $id ?>', $('#elemSY').val(), 'credential_presented', $('#st_id').val())"/>
            <label class="form-check-label" for="<?php echo $id ?>"><?php echo $label ?></label><br>
            <?php
        endfor;
    }

    function getCredentialPresented($val, $stid, $sy) {
        $r = $this->f137_model->getEligibility(base64_decode($stid), $sy);
        $loop = explode(',', $r->credential_presented);
        foreach ($loop as $l):
            if ($l == $val):
                return TRUE;
            endif;
        endforeach;
    }

    function getSchoolList($sy) {
        return $this->f137_model->getSchoolList($sy);
    }

    function displaySchoolList($sy) {
        $r = $this->getSchoolList($sy);
        foreach ($r as $s):
            ?>
            <option id="<?php echo $s->school_id ?>" value="<?php echo $s->school_id ?>"><?php echo $s->school_name ?></option>
            <?php
        endforeach;
    }

    function updateEligibility() {
        $stid = $this->input->post('stid');
        $field = $this->input->post('field');
        $value = $this->input->post('value');
        $sy = $this->input->post('sy');
        $tbl = $this->input->post('tbl');
        $tbl_id = $this->input->post('tbl_id');

        $this->f137_model->updateEligibility(base64_decode($stid), $field, $value, $tbl, $tbl_id, $sy);
    }

    function getEligibilityInfo($stid, $sy) {
        $r = $this->f137_model->getEligibility(base64_decode($stid), $sy);
        echo json_encode($r);
    }

    function getSchoolInfo($id, $sy = NULL) {
        return $this->f137_model->getSchoolInfo($id, $sy);
    }

    function addSchool() {
        $school_name = $this->input->post('school_name');
        $idSchool = $this->input->post('idSchool');
        $street = $this->input->post('street');
        $brgy = $this->input->post('brgy');
        $city = $this->input->post('city');
        $province = $this->input->post('province');
        $sy = $this->input->post('sy');

        $id = $this->f137_model->addSchoolAddress($street, $brgy, $city, $province, $sy);

//        if ($id != ''):
        $this->f137_model->addSchool($school_name, $idSchool, $id, $sy);
//        endif;
    }
    
    function getObserveValues($stid, $sy){
        return $this->f137_model->getObserveValues($stid, $sy);
    }
    
    function observeValues($val) {
        switch ($val):
            case 1:
                return 'Always Observed';
            case 2:
                return 'Rarely Observed';
            case 3:
                return 'Sometimes Observed';
            case 4:
                return 'Not Observed';
        endswitch;
    }

}
