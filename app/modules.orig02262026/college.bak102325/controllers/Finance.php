<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Registrar
 *
 * @author genesis
 */
class Finance extends MX_Controller
{

    //put your code here


    function __construct()
    {
        parent::__construct();
        $this->load->model('finance_model');
        $this->load->library('pagination');
        $this->load->library('Pdf');
        if (!$this->session->is_logged_in):
            redirect('login');
        endif;
    }

    private function post($name)
    {
        return $this->input->post($name);
    }

    public function getItemByID($item_id)
    {
        return $this->finance_model->getItemByID($item_id);
    }

    public function getPayments($school_year, $sem, $st_id = NULL)
    {
        $student = Modules::run('college/getSingleStudent', base64_decode($st_id), $school_year, $sem);

        $payments = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $school_year);
        $paymentTotal = 0;
        if ($payments->num_rows() > 0):
            foreach ($payments->result() as $tr):
                $paymentTotal += $tr->subTotal;
            endforeach;
        endif;

        $online = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $school_year, 4);
        $onlineTotal = 0;
        if ($online->num_rows() > 0):
            foreach ($online->result() as $tr):
                $onlineTotal += $tr->subTotal;
            endforeach;
        endif;

        $excess = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $school_year, 5);
        $excessTotal = 0;
        if ($excess->num_rows() > 0):
            foreach ($excess->result() as $tr):
                $excessTotal += $tr->subTotal;
            endforeach;
        endif;

        $payrollDeduction = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $school_year, 6);
        $payrollDeductionTotal = 0;
        if ($payrollDeduction->num_rows() > 0):
            foreach ($payrollDeduction->result() as $tr):
                $payrollDeductionTotal += $tr->subTotal;
            endforeach;
        endif;

        $forwardedBalance = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $school_year, 7);
        $forwardedBalanceTotal = 0;
        if ($forwardedBalance->num_rows() > 0):
            foreach ($forwardedBalance->result() as $tr):
                $forwardedBalanceTotal += $tr->subTotal;
            endforeach;
        endif;
        $totalPayment = $paymentTotal + $onlineTotal + $excessTotal + $payrollDeductionTotal + $forwardedBalanceTotal;

        return $totalPayment;
    }

    function addDiscCat()
    {
        $item = $this->post('disc_cat');
        $result = $this->finance_model->addDiscountCat($item);
        $result = json_decode($result);
        if ($result->status):
            echo "<option value='$result->id'>$result->value</option>";
        endif;
    }

    function generateScholarshipAmount($school_year, $semester = NULL)
    {
        set_time_limit(300);
        $this->load->library('eskwela');
        $this->load->library('excel');
        $this->load->helper('download');
        $settings = $this->eskwela->getSet();

        $data['settings'] = $settings;
        $data['school_year'] = $school_year;
        $data['scholarship'] = $this->finance_model->getScholarshipReport($school_year, $semester, TRUE);

        $this->load->view('finance/reports/scholarshipReport', $data);

        $filename = $school_year . '-' . ($school_year + 1) . ' Scholarship Report.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    public function collectionSummaryPerSem($sem, $school_year)
    {
        $data['collegeStudents'] = $this->finance_model->getStudentListPerSem($sem, $school_year, TRUE);
        $this->load->view('finance/reports/printCollectionSummaryPerSem', $data);
    }

    function getBasicStudent($st_id, $school_year = NULL, $semester = NULL)
    {
        $student = $this->finance_model->getBasicStudent($st_id, $school_year, $semester);
        return $student;
    }

    function printReceivables($dept_id, $semester, $school_year, $course_id)
    {
        $data['students'] = $this->finance_model->getStudentList($dept_id, $semester, $school_year, $course_id);
        $data['semester'] = $semester;
        $data['dept_id'] = $dept_id;
        $data['school_year'] = $school_year;
        $data['course_id'] = $course_id;
        $this->load->view('finance/reports/printReceivables', $data);
    }

    function getBasicFinanceBalance($st_id, $school_year, $semester)
    {
        $student = $this->finance_model->getBasicStudent(base64_decode($st_id), $school_year, $semester);

        $plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0, $student->st_type, $student->school_year);
        $charges = Modules::run('finance/financeChargesByPlan', 0, $student->school_year, 0, $plan->fin_plan_id, $student->semester);

        $i = 1;
        $total = 0;

        foreach ($charges as $c):
            $total += $c->amount;
        endforeach;
        $totalExtra = 0;
        $extraCharges = Modules::run('finance/getExtraFinanceCharges', $student->user_id, $student->semester, $student->school_year);
        if ($extraCharges->num_rows() > 0):
            foreach ($extraCharges->result() as $ec):
                $totalExtra += $ec->extra_amount;
            endforeach;
            $total = $total + $totalExtra;
        endif;

        //transaction
        $transaction = Modules::run('college/finance/getTransaction', base64_decode($st_id), $student->semester, $student->school_year);
        $paymentTotal = 0;
        if ($transaction->num_rows() > 0):
            foreach ($transaction->result() as $tr):
                if ($tr->t_type != 3):
                    $paymentTotal += $tr->t_amount;
                endif;
            endforeach;
        endif;

        $details = array(
            'charges' => $total,
            'payments' => $paymentTotal,
            'rawBalance' => $total - $paymentTotal,
            'status' => ($total - $paymentTotal > 0 ? TRUE : FALSE)
        );

        return json_encode($details);
    }

    //    function addItem($item_id = NULL, $semester=NULL, $school_year = NULL)
    //    {
    //        $this->db = $this->eskwela->db($school_year);
    //        $this->db->where('school_year', $school_year);
    //        $this->db->where('semester', $semester);
    //        $this->db->group_by('plan_id');
    //        $q = $this->db->get('c_finance_charges');
    //        $c = 0;
    //        foreach ($q->result() as $row):
    //            $array = array('item_id' => $item_id, 'amount' => 2108, 'semester' => $semester, 'school_year'=> $school_year, 'plan_id' => $row->plan_id);
    //            if($this->db->insert('c_finance_charges', $array)):
    //                $c++;
    //            endif;
    //        endforeach;
    //        
    //        echo 'Successfully added '.$c.' records';
    //    }


    function forwardFees($semester = NULL, $school_year = NULL, $item_id = NULL)
    {
        if ($semester == NULL):
            $semester = $this->post('semester');
            $school_year = $this->post('school_year');

            $charges = $this->finance_model->getAllFinanceCharges($semester, $school_year, $item_id = NULL);
            foreach ($charges as $c):
                if ($c->item_id == 1 || $c->item_id == 45 || $c->item_id == 46):
                    $charge = array(
                        'item_id' => $c->item_id,
                        'amount' => $c->amount,
                        'semester' => ($semester == 3 ? 1 : $semester + 1),
                        'school_year' => ($semester == 3 ? $school_year + 1 : $school_year),
                        'plan_id' => $c->plan_id
                    );

                    $this->finance_model->addFinanceCharges($charge, $c->plan_id, $c->item_id, ($semester == 3 ? 1 : $semester + 1), ($semester == 3 ? $school_year + 1 : $school_year));
                endif;
            endforeach;
        endif;

        echo 'Fees Are successfully Forwarded';
    }

    function printClearance($st_id, $sem, $term = 1)
    {
        $data['st_id'] = base64_decode($st_id);
        $data['sem'] = $sem;
        $data['term'] = $term;

        $this->load->view('finance/schoolClearance', $data);
    }

    function loadPreviousBalance()
    {
        $st_id = $this->post('st_id');
        $user_id = $this->post('user_id');
        $school_year = $this->post('school_year');
        $semester = $this->post('semester');
        $balance = $this->post('balance');

        if ($semester == 1) {
            $previousYear = $school_year - 1;
        } else {
            $previousYear = $school_year;
        }

        $previousSemester = $semester - 1;


        switch ($semester):
            case 1:
                $sem = 'First Semester';
                break;
            case 2:
                $sem = 'Second Semester';
                break;
            case 3:
                $sem = 'Summer';
                break;
        endswitch;

        //charge to current Year

        $deductPreviousYear = array(
            'ref_number' => date('Ymdgis'),
            't_st_id' => base64_decode($st_id),
            't_em_id' => $this->session->username,
            't_amount' => $balance,
            't_charge_id' => 4,
            't_type' => 7,
            't_date' => date('Y-m-d'),
            't_sem' => $previousSemester,
            't_school_year' => $previousYear,
            't_receipt_type' => 2,
            't_remarks' => 'Balance Forward to ' . $school_year . ' - ' . ($school_year + 1) . ' (' . $sem . ') '
        );

        $this->finance_model->saveTransaction($deductPreviousYear, $previousYear);

        $charge = array(
            'extra_st_id' => $user_id,
            'extra_item_id' => 4,
            'extra_amount' => $balance,
            'extra_sem' => $semester,
            'extra_school_year' => $school_year
        );

        if ($this->finance_model->addExtraFinanceCharges($charge)):
            $this->saveFinanceLog($this->session->userdata('employee_id'), $this->session->userdata('name') . ' has forwarded a balance of student # ' . base64_decode($st_id) . ' with an amount of ' . number_format($balance, 2, '.', ',') . ' .');
            echo 'Successfully Loaded';
        endif;
    }

    function getDiscountType()
    {
        $discountType = $this->finance_model->getDiscountType();
        return $discountType;
    }

    function getAssessmentPerStudentBasicEd($student, $school_year = NULL)
    {
        $plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0, $student->st_type);
        $charges = Modules::run('finance/financeChargesByPlan', 0, $school_year, 0, $plan->fin_plan_id);

        $tuition = 0;
        $fusedCharges = 0;
        foreach ($charges as $c):

            if ($c->is_fused):
                $chargeAmount = $c->amount;
                $fusedCharges += $chargeAmount;
            else:
                if ($c->item_id == 3):
                    $tuition = $c->amount;
                else:
                    $fusedCharges += $c->amount;
                endif;
            endif;
        endforeach;


        $totalExtra = 0;
        $extraCharges = Modules::run('finance/getExtraFinanceCharges', $student->user_id, 0, $student->school_year);

        if ($extraCharges->num_rows() > 0):
            foreach ($extraCharges->result() as $ec):

                if ($ec->extra_item_id == 78):
                    $books += $ec->extra_amount;
                else:
                    $totalExtra += $ec->extra_amount;
                endif;
            endforeach;
        endif;

        $specialClass = 0;
        $extraCharges = Modules::run('college/finance/getExtraFinanceCharges', $student->user_id, 0, $student->school_year);
        if ($extraCharges->num_rows() > 0):
            foreach ($extraCharges->result() as $ec):
                $totalExtra += $ec->extra_amount;
                if ($ec->category_id == 5):
                    $specialClass += $ec->extra_amount;
                endif;
            endforeach;
        endif;

        $totalAssessment = $tuition + $fusedCharges + $specialClass;

        $assessmentArray = array(
            'totalTuition' => $tuition,
            'otherFees' => $fusedCharges,
            'specialClass' => $specialClass,
            'assessmentBalance' => $totalAssessment
        );

        return json_encode($assessmentArray);
    }

    function generateAssessementForElementary($school_year, $status = 1)
    {
        set_time_limit(300);
        $this->load->library('eskwela');
        $this->load->library('excel');
        $this->load->helper('download');
        $settings = $this->eskwela->getSet();

        $data['settings'] = $settings;
        $data['school_year'] = $school_year;
        $data['department'] = 'Elementary';

        $this->load->view('finance/reports/printAssessmentHeader_basicEd', $data);

        $students = $this->finance_model->generateAssessementForElementary(NULL, $school_year, NULL, $status);
        $y = 6;
        $seq = 1;
        foreach ($students as $s):

            $data['seq'] = $seq++;
            $data['y'] = $y++;
            $data['s'] = $s;
            // if($seq <= 6):
            $data['assessment'] = json_decode(Modules::run('college/finance/getAssessmentPerStudentBasicEd', $s, $school_year));
            $this->load->view('finance/reports/printAssessment_basicEd', $data);
        //  endif;    

        endforeach;

        $filename = $school_year . '-' . ($school_year + 1) . ' Elementary.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    function generateAssessementForJuniorHigh($school_year, $status = 1)
    {
        set_time_limit(300);
        $this->load->library('eskwela');
        $this->load->library('excel');
        $this->load->helper('download');
        $settings = $this->eskwela->getSet();

        $data['settings'] = $settings;
        $data['school_year'] = $school_year;
        $data['department'] = 'Junior High School';

        $this->load->view('finance/reports/printAssessmentHeader_basicEd', $data);

        $students = $this->finance_model->generateAssessementForJuniorHigh(NULL, $school_year, NULL, $status);
        $y = 6;
        $seq = 1;
        foreach ($students as $s):

            $data['seq'] = $seq++;
            $data['y'] = $y++;
            $data['s'] = $s;
            // if($seq <= 6):
            $data['assessment'] = json_decode(Modules::run('college/finance/getAssessmentPerStudentBasicEd', $s, $school_year));
            $this->load->view('finance/reports/printAssessment_basicEd', $data);
        //  endif;    

        endforeach;

        $filename = $school_year . '-' . ($school_year + 1) . ' Junior High School.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    function generateAssessementForSeniorHigh($school_year, $status = 1)
    {
        set_time_limit(300);
        $this->load->library('eskwela');
        $this->load->library('excel');
        $this->load->helper('download');
        $settings = $this->eskwela->getSet();

        $data['settings'] = $settings;
        $data['school_year'] = $school_year;
        $data['department'] = 'Senior High School';

        $this->load->view('finance/reports/printAssessmentHeader_basicEd', $data);

        $students = $this->finance_model->generateAssessementForSeniorHigh(NULL, $school_year, NULL, $status);
        $y = 6;
        $seq = 1;
        foreach ($students as $s):

            $data['seq'] = $seq++;
            $data['y'] = $y++;
            $data['s'] = $s;
            // if($seq <= 6):
            $data['assessment'] = json_decode(Modules::run('college/finance/getAssessmentPerStudentBasicEd', $s, $school_year));
            $this->load->view('finance/reports/printAssessment_basicEd', $data);
        //  endif;    

        endforeach;

        $filename = $school_year . '-' . ($school_year + 1) . ' Senior High School.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    function generateAssessementPerSem($semester, $school_year, $department = NULL)
    {
        set_time_limit(300);
        $this->load->library('eskwela');
        $this->load->library('excel');
        $this->load->helper('download');
        $settings = $this->eskwela->getSet();

        $data['settings'] = $settings;
        $data['semester'] = $semester;
        $data['sem'] = ($semester == 1 ? 'First Semester' : ($semester == 2 ? 'Second Semester' : 'Summer'));
        $data['school_year'] = $school_year;

        $this->load->view('finance/reports/printAssessmentHeader', $data);

        $students = $this->finance_model->getStudentsForAssessment(NULL, $school_year, $semester, NULL, NULL, 1, $department);
        $y = 6;
        $seq = 1;
        foreach ($students as $s):
            $data['seq'] = $seq++;
            $data['y'] = $y++;
            $data['s'] = $s;
            $data['assessment'] = json_decode(Modules::run('college/finance/getAssessmentPerStudent', $s));
            $this->load->view('finance/reports/printAssessment', $data);
        endforeach;

        $filename = $school_year . '-' . ($school_year + 1) . ' ' . $data['sem'] . ' Assessment.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    function getAssessmentPerStudent($student, $semester = NULL, $school_year = NULL, $showPayment = FALSE)
    {

        //CHARGES / FEES

        $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $student->admission_id, $student->semester, $student->school_year);

        $totalUnits = 0;
        $totalSubs = 0;
        $totalLab = 0;
        $perUnit = 0;
        $otherFees = 0;
        foreach ($loadedSubject as $sl):
            $totalSubs++;
            $totalUnits += ($sl->s_lect_unit + $sl->s_lab_unit);
            if ($sl->sub_lab_fee_id != 0):
                $itemCharge = Modules::run('college/finance/getFinanceItemById', $sl->sub_lab_fee_id, $student->school_year);
                $totalLab += $itemCharge->default_value;
            endif;
        endforeach;

        $plan = Modules::run('college/finance/getPlanByCourse', $student->course_id, $student->year_level);
        $tuition = Modules::run('college/finance/getChargesByCategory', 1, $student->semester, $student->school_year, $plan->fin_plan_id);
        $charges = Modules::run('college/finance/financeChargesByPlan', $student->year_level, $student->school_year, $student->semester, $plan->fin_plan_id);

        foreach ($charges as $c):
            if ($c->item_id <= 1):
                $perUnit = $c->amount;
            endif;
            if ($c->item_id != 46):
                $totalCharges += ($c->item_id <= 1 || $c->item_id <= 2 ? 0 : $c->amount);
            endif;
            $totalExamFee += ($c->item_id <= 1 || $c->item_id <= 2 ? 0 : ($c->item_id == 46 ? ($c->amount) : 0));
            if ($c->category_id == 2):
                $otherFees += $c->amount;
            endif;
        endforeach;
        $totalExtra = 0;
        $specialClass = 0;
        $extraCharges = Modules::run('college/finance/getExtraFinanceCharges', $student->u_id, $student->semester, $student->school_year);
        if ($extraCharges->num_rows() > 0):
            foreach ($extraCharges->result() as $ec):
                $totalExtra += $ec->extra_amount;
                if ($ec->category_id == 5):
                    $specialClass += $ec->extra_amount;
                endif;
            endforeach;
        endif;


        $totalFees = (($tuition->row()->amount * $totalUnits) + $totalCharges + $totalLab + $totalExtra);

        $overAllExamFees = $totalExamFee * $totalSubs;
        $totalAssessment = $totalFees + $overAllExamFees;

        $assessmentArray = array(
            'totalAssessment' => number_format($totalAssessment, 2, '.', ','),
            'assessmentBalance' => $totalAssessment - $totalExtra,
            'totalUnits' => $totalUnits,
            'examFee' => $totalExamFee,
            'examFees' => $overAllExamFees,
            'totalTuition' => ($tuition->row()->amount * $totalUnits),
            'totalSubjects' => $totalSubs,
            'totalLabFee' => $totalLab,
            'perUnit' => $perUnit,
            'otherFees' => $otherFees,
            'specialClass' => $specialClass
        );

        return json_encode($assessmentArray);
    }

    function processFundTransfer()
    {
        $transfer_trans_id = $this->post('transfer_trans_id');
        $transferAmountFrom = $this->post('transferAmountFrom');
        $transferedAmount = $this->post('transferedAmount');
        $transferItemFrom = $this->post('transferItemFrom');
        $transferItemTo = $this->post('transferItemTo');
        $transferReceiptType = $this->post('transferReceiptType');
        $transferRefNumber = $this->post('transferRefNumber');
        $transferSchoolYear = $this->post('transferSchoolYear');
        $transferSchoolYearTo = $this->post('transferSchoolYearTo');
        $transferSTID = $this->post('transferSTID');
        $transferSTIDFrom = $this->post('transferSTIDFrom');
        $transferItemNameFrom = $this->post('transferItemNameFrom');
        $transferItemNameTo = $this->post('transferItemNameTo');
        $transferPaymentType = $this->post('transferPaymentType');
        $transferNameFrom = $this->post('transferNameFrom');
        $transferNameTo = $this->post('transferNameTo');
        $date = $this->post('transferDateFrom');
        $semester = $this->post('transferSemesterTo');


        if ($transferSTID == $transferSTIDFrom):
            $remarksFrom = 'FT to: [ Amount: ' . $transferedAmount . 'Php; Item : ' . $transferItemNameTo . ' ]';
            $remarksTo = 'FT from: [ Amount: ' . $transferedAmount . 'Php; Item : ' . $transferItemNameFrom;
        else:
            $remarksFrom = 'FT to: [ Amount: ' . $transferedAmount . 'Php; Item : ' . $transferItemNameTo . '; Account Name: ' . $transferNameTo;
            $remarksTo = 'FT from: [ Amount: ' . $transferedAmount . 'Php; Item : ' . $transferItemNameFrom . '; Account Name: ' . $transferNameFrom;

        endif;

        $fundRemaining = $transferAmountFrom - $transferedAmount;

        $remainingFundUpdate = array(
            't_amount' => $fundRemaining,
            't_remarks' => $remarksFrom
        );

        $transferTransactionDetails = array(
            'ref_number' => $transferRefNumber,
            't_st_id' => $transferSTID,
            't_em_id' => $this->session->employee_id,
            't_amount' => $transferedAmount,
            't_charge_id' => $transferItemTo,
            't_type' => $transferPaymentType,
            't_date' => $date,
            't_sem' => $semester,
            't_school_year' => $transferSchoolYearTo,
            't_receipt_type' => $transferReceiptType,
            't_remarks' => $remarksTo,
            'acnt_type' => 0,
        );

        if ($this->finance_model->updateFundTransfer($remainingFundUpdate, $transfer_trans_id, $transferSchoolYear, $fundRemaining)):

            $result = $this->finance_model->saveTransaction($transferTransactionDetails, $transferSchoolYearTo);
            if (!$result):
                echo 'Funds Transferred Error Occured To';
            else:

                $transferDetails = array(
                    'fft_st_id_from' => $transferSTIDFrom,
                    'fft_st_id_to' => $transferSTID,
                    'fft_item_id_from' => $transferItemFrom,
                    'fft_item_id_to' => $transferItemTo,
                    'fft_amount' => $transferedAmount,
                    'fft_transferred_by' => $this->session->employee_id,
                    'fft_trans_id' => $result,
                    'fft_datetime' => date('Y-m-d G:i:s')
                );

                if ($this->finance_model->saveTransferFunds($transferDetails, $transferSchoolYear)):
                    echo 'Funds Transferred Successfully';
                else:
                    echo 'Funds Transferred Error Occured in Transferred Log';
                endif;

            endif;
        else:
            echo 'Funds Transferred Error Occured From';
        endif;
    }

    function searchFundTransferAccount($value, $year = NULL)
    {
        $student = $this->finance_model->searchFundTransferAccount($value, $year);
        echo '<ul>';
        foreach ($student as $s):
            $checkStudent = $this->finance_model->checkStudentAdmission($s->st_id);
?>
            <li style="font-size:18px;" onclick="$('#transferSemesterTo').val('<?php echo ($checkStudent ? $checkStudent->semester : 0) ?>'), $('#searchTransferName').hide(), $('#searchTransferBox').val('<?php echo $s->firstname . ' ' . $s->lastname ?>'), $('#transferSTID').val('<?php echo $s->st_id ?>'), $('#transferNameTo').val('<?php echo strtoupper($s->lastname . ', ' . $s->firstname) ?>')"><?php echo strtoupper($s->lastname . ', ' . $s->firstname) ?></li>
            <?php
        endforeach;
        echo '</ul>';
    }

    function prepareFundTransfer()
    {
        $school_year = $this->post('school_year');
        $trans_id = $this->post('trans_id');

        $data['school_year'] = $school_year;
        $data['semester'] = $this->post('semester');
        $data['name'] = $this->post('name');
        $data['st_id'] = $this->post('st_id');
        $data['fin_items'] = $this->finance_model->getFinItems($school_year);
        $data['transaction'] = $this->finance_model->loadFinanceTransaction($trans_id, $school_year);
        $this->load->view('finance/fundTransfer', $data);
    }

    function removeCashDenomination($id)
    {
        if ($this->finance_model->removeCashDenomination($id)):
            echo 'Successfully Removed';
        endif;
    }

    public function getCashBreakdownDetails()
    {
        $date = $this->post('dateCollected');
        $denomination = $this->finance_model->getCashBreakdownDetails($date);
        if ($denomination):
            $total = 0;
            foreach ($denomination as $d):
                $total += $d->denomination * $d->fdcb_total_count;
            ?>
                <tr id="li_<?php echo $d->fdcb_id ?>">
                    <td><strong><?php echo $d->denomination ?></strong></td>
                    <td><?php echo $d->fdcb_total_count ?></td>
                    <td class="text-right"><?php echo $d->denomination * $d->fdcb_total_count ?></td>
                    <td><i onclick="$('#li_<?php echo $d->fdcb_denom_id ?>').hide(), removeFromList('<?php echo $d->fdcb_id ?>')" class="fa fa-close pointer text-danger"></i>
                </tr>
            <?php
            endforeach;
            ?>
            <tr>
                <td></td>
                <td></td>
                <td class="text-right"><strong> ₱ <?php echo number_format($total, 2, '.', ',') ?></strong></td>
            </tr>
        <?php
        endif;
    }

    public function printCashBreakDown($from)
    {
        $data['cashbreakdown'] = $this->finance_model->getCashbreakdown($from);
        $this->load->view('finance/reports/printCashBreakDown', $data);
    }

    public function collectionSummary($from, $to, $sy = NULL, $sem = NULL)
    {
        $data['school_year'] = $sy;
        $data['semester'] = $sem;
        $data['collection'] = $this->finance_model->getCollectionSummary($from, $to, $sy, $sem);

        if (file_exists(APPPATH . 'modules/college/views/finance/reports/' . strtolower($this->eskwela->getSet()->short_name) . '/printCollectionSummary.php')):
            $this->load->view('finance/reports/' . strtolower($this->eskwela->getSet()->short_name) . '/printCollectionSummary', $data);
        else:
            $this->load->view('finance/reports/printCollectionSummary', $data);
        endif;
    }

    public function getTotalCollectionPerItem($teller_id = NULL, $item_id, $date, $t_type, $sy = NULL)
    {
        $collection1 = $this->finance_model->getTotalCollectionPerItem($teller_id, $item_id, $date, $t_type, $sy);
        //$collection = $this->finance_model->getTotalCollectionPerItemAdvanced($teller_id, $item_id, $date, $t_type, $sy);
        //$collection = array_merge($collection1, $collection2);
        foreach ($collection1 as $col):
            $amount += $col->t_amount;
        endforeach;
        return $amount;
    }

    function getFinCategory($id = NULL)
    {
        $category = $this->finance_model->getFinCategory($id);
        return $category;
    }

    function getFinanceItemById($item_id, $school_year = NULL)
    {
        $items = $this->finance_model->getFinanceItemByID($item_id, $school_year);
        return $items;
    }

    function searchFinanceStaff($value, $year = NULL)
    {
        $employee = $this->finance_model->searchFinanceStaff($value, $year);
        echo '<ul>';
        foreach ($employee as $s):
        ?>
            <li style="font-size:18px;" onclick="$('#searchName').hide(), $('#searchBox').val('<?php echo $s->firstname . ' ' . $s->lastname ?>'), $('#assign_employee_id').val('<?php echo $s->employee_id ?>')"><?php echo strtoupper($s->firstname . ' ' . $s->lastname) ?></li>
        <?php
        endforeach;
        echo '</ul>';
    }

    public function addLabCharge($st_id, $item, $amount, $sem, $sy)
    {

        $charge = array(
            'extra_st_id' => $st_id,
            'extra_item_id' => $item,
            'extra_amount' => $amount,
            'extra_sem' => $sem,
            'extra_school_year' => $sy
        );

        if ($this->finance_model->addLabCharge($charge, $st_id, $item)):

        endif;
    }

    public function getLaboratoryFees()
    {
        $fees = $this->finance_model->getLaboratoryFees();
        return $fees;
    }

    public function getFusedPayments($st_id, $sem, $school_year, $cat_id, $type = NULL)
    {
        $transaction = $this->finance_model->getFusedPayments($st_id, $sem, $school_year, $cat_id, $type);
        return $transaction;
    }

    function addCategory()
    {
        $cat_id = $this->post('cat_id');
        $category = $this->post('category');
        $school_year = $this->post('school_year');

        $catDetails = array('fin_category' => $category, 'fin_cat_id' => $this->eskwela->code());

        if ($cat_id == 0):
            if ($this->finance_model->addCategory($catDetails, $category, $school_year)):
                echo 'Successfully Saved';
            else:
                echo 'Sorry Something went wrong, Please contact support';
            endif;
        else:
            if ($this->finance_model->editCategory($catDetails, $cat_id)):
                echo 'Successfully Saved';
            else:
                echo 'Sorry Something went wrong, Please contact support';
            endif;

        endif;
    }

    function fusedFees()
    {
        $cat_id = $this->post('cat_id');
        $fused = $this->post('is_fused');

        $fusedDetails = array('is_fused' => $fused);
        if ($this->finance_model->saveFusedFees($fusedDetails, $cat_id)):
            echo 'Successfully Saved';
        else:
            echo 'Sorry Something went wrong, Please contact support';
        endif;
    }

    function editItem()
    {
        $item_id = $this->post('item_id');
        $itemDescription = $this->post('itemDescription');
        $percentageAmount = $this->post('percentageAmount');
        $itemCategory = $this->post('itemCategory');
        $defaultValue = $this->post('defaultAmount');
        $school_year = $this->post('school_year');
        $mtotal = $this->post('mtotal');
        $pterm = $this->post('pterm');

        $itemDetails = array(
            'item_id' => ($item_id == 0 ? $this->eskwela->code() : $item_id),
            'item_description' => $itemDescription,
            'dept_id' => 4,
            'category_id' => $itemCategory,
            'percentage_amount' => $percentageAmount,
            'default_value' => $defaultValue,
            'payment_term' => $pterm,
            'total_month' => $mtotal
        );

        if ($item_id == 0):
            if ($this->finance_model->addItem($itemDetails, $itemDescription, $school_year)):
                echo json_encode(array('msg' => 'Successfully Added'));
            else:
                echo json_encode(array('msg' => 'Sorry this Item Already exist'));
            endif;
        else:
            if ($this->finance_model->editItem($itemDetails, $item_id, $school_year)):
                echo json_encode(array('msg' => 'Successfully Update'));
            else:
                echo json_encode(array('msg' => 'Sorry Something went wrong, Please contact support'));
            endif;

        endif;
    }

    function deleteItem()
    {
        $school_year = $this->post('school_year');
        $item_id = $this->post('item_id');
        if ($this->finance_model->deleteItem($item_id, $school_year)):
            echo 'Deleted Successfully';
        else:
            echo 'Sorry Something went wrong, Please contact support';
        endif;
    }

    public function printOR($st_id, $ornum, $transType, $amount, $school_year, $semester)
    {
        $transaction = $this->getTransactionByOR($ornum, $school_year);
        foreach ($transaction as $trans):
            $date = date('F d, Y', strtotime($trans->t_date));
        endforeach;
        $data['st_id'] = base64_decode($st_id);
        $data['tDate'] = $date;
        $data['ornum'] = $ornum;
        $data['semester'] = $semester;
        $data['school_year'] = $school_year;
        $data['transType'] = $transType;
        $data['transaction'] = $this->getTransactionByOR($ornum, $school_year);
        $data['student'] = Modules::run('college/getSingleStudent', base64_decode($st_id), $school_year, $semester);
        $data['modules'] = 'college';
        $data['main_content'] = 'finance/reports/printOR';
        echo Modules::run('templates/print_content', $data);
        // $this->load->view('reports/printOR', $data);
    }

    public function printOtherOR($st_id, $ornum, $transType, $amount, $school_year, $semester)
    {
        $transaction = $this->getTransactionByOR($ornum, $school_year);
        foreach ($transaction as $trans):
            $date = date('F d, Y', strtotime($trans->t_date));
        endforeach;
        $data['st_id'] = base64_decode($st_id);
        $data['tDate'] = $date;
        $data['ornum'] = $ornum;
        $data['semester'] = $semester;
        $data['school_year'] = $school_year;
        $data['transType'] = $transType;
        $data['transaction'] = $this->getTransactionByOR($ornum);
        $data['student'] = $this->getOtherAccountDetails(base64_decode($st_id));
        $data['modules'] = 'college';
        $data['main_content'] = 'finance/reports/printOtherOR';
        echo Modules::run('templates/print_content', $data);
        // $this->load->view('reports/printOR', $data);
    }

    function getOtherAccountDetails($st_id, $school_year = NULL)
    {
        $school_year = ($school_year == NULL ? $this->session->school_year : $school_year);
        $details = $this->finance_model->getOtherAccountDetails($st_id, $school_year);
        return $details;
    }

    private function getTransactionByOR($or_num, $school_year = NULL)
    {
        $trans = $this->finance_model->getTransactionByOR($or_num, $school_year);
        return $trans;
    }

    public function getSingleSeries($employee_id)
    {
        $series = $this->finance_model->getSingleSeries($employee_id);
        return $series;
    }

    public function useSeries()
    {
        if ($this->finance_model->useSeries($this->post('id'), $this->post('employee_id'))):
            $this->saveFinanceLog($this->session->userdata('employee_id'), 'Assigned a Receipt Series id #' . $this->post('id') . ' to ' . $this->post('employee_id'));
            echo 'Successfully Assigned';
        endif;
    }

    public function getAllSeries()
    {
        $series = $this->finance_model->getAllSeries();
        return $series;
    }

    public function addSeries()
    {
        $begin = $this->post('beginning');
        $end = $this->post('ending');
        $current = $this->post('current');
        $series_id = $this->post('series_id');

        $details = array(
            'or_begin' => $begin,
            'or_end' => $end,
            'or_current' => $current,
            'or_id' => $series_id
        );

        if ($series_id == 0):
            $msg = $this->finance_model->addSeries($details, $begin, $end, $series_id);
        else:
            $msg = $this->finance_model->updateSeries($details, $series_id);
        endif;

        echo $msg;
    }

    public function OR_series()
    {
        if ($this->session->userdata('is_logged_in')):
            $data['ORSeries'] = $this->getAllSeries();
            $data['FinSettings'] = $this->getSettings();
            $data['main_content'] = "or_series";
            $data['modules'] = 'finance';
            echo Modules::run('templates/college_content', $data);
        else:
            redirect('login');
        endif;
    }

    public function getSettings()
    {
        $settings = $this->finance_model->getSettings();
        return $settings;
    }

    function generalSettings($school_year = NULL)
    {
        $school_year = ($school_year == NULL ? $this->session->school_year : $school_year);
        if ($this->session->is_admin):
            $data['course'] = Modules::run('coursemanagement/getCourses');
            $data['ro_years'] = Modules::run('registrar/getROYear');
            $data['now'] = $school_year;
            $data['nextYear'] = $school_year + 1;
            $data['fin_items'] = $this->finance_model->getFinItems($school_year);
            $data['fin_category'] = $this->finance_model->getFinCategory(null);
            $data['payment_term'] = $this->finance_model->getPaymentTerms();
            $data['ORSeries'] = $this->getAllSeries();
            $data['FinSettings'] = $this->getSettings();
            $data['discount'] = $this->getDiscountType();
            $data['modules'] = 'college';
            $data['main_content'] = 'finance/generalSettings';
            echo Modules::run('templates/college_content', $data);
        else:
            redirect(base_url('college'));
        endif;
    }

    function paymentTerm()
    {
        $tid = $this->input->post('tid');
        $desc = $this->input->post('desc');
        $opt = $this->input->post('opt');

        $r = $this->finance_model->paymentTerm($tid, $desc, $opt);
        switch ($opt):
            case 1:
                if ($r):
                    $status = TRUE;
                    $msg = 'Payment Term Successfuly Added';
                else:
                    $status = FALSE;
                    $msg = 'Something went wrong!!!';
                endif;
                break;
            case 2:
                if ($r):
                    $status = TRUE;
                    $msg = 'Payment Term Successfuly Updated';
                else:
                    $status = FALSE;
                    $msg = 'An Error Occured!';
                endif;
                break;
            case 3:
                if ($r):
                    $status = TRUE;
                    $msg = 'Term Deleted Successfuly!!!';
                else:
                    $status = FALSE;
                    $msg = 'Unable to delete term';
                endif;
                break;
        endswitch;

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    function cancelReceipt()
    {
        $receiptNumber = $this->post('receiptNumber');
        if ($this->finance_model->cancelReceipt($receiptNumber)):
            $this->saveFinanceLog($this->session->userdata('employee_id'), $this->session->userdata('name') . ' has Cancel a Receipt with reference #' . $receiptNumber . '.');
            echo 'Successfully Cancelled';
        else:
            echo 'Sorry Something Went Wrong';
        endif;
    }

    public function getTransactionByCategory($st_id, $sem, $school_year, $category_id = NULL, $type = NULL, $item_id = NULL)
    {
        $transaction = $this->finance_model->getTransactionByCategory($st_id, $sem, $school_year, $category_id, $type, $item_id);
        return $transaction;
    }

    function financeLog()
    {
        if ($this->session->is_admin):
            $data['financeLog'] = $this->finance_model->financeLog();
            $data['modules'] = 'college';
            $data['main_content'] = 'finance/financeLog';
            echo Modules::run('templates/canteen_content', $data);
        else:
            redirect(base_url());
        endif;
    }

    function saveEditTransaction()
    {
        $details = array(
            'ref_number' => $this->post('ref_number'),
            't_amount' => $this->post('amount'),
            't_date' => $this->post('trans_date'),
            't_receipt_type' => $this->post('receipt')
        );

        if ($this->finance_model->saveEditTransaction($details, $this->post('trans_id'))):
            echo 'Transaction Successfully Saved';
        else:
            echo 'Sorry, Something went wrong';
        endif;
    }

    function loadFinanceTransaction()
    {
        $trans_id = $this->post('trans_id');
        $trans_type = $this->post('trans_type');
        $item_id = $this->post('item_id');

        $data['transaction'] = $this->finance_model->loadFinanceTransaction($trans_id);
        $this->load->view('finance/editTransaction', $data);
    }

    function getCollectionReport($from = NULL, $to = NULL, $report_type = NULL, $sy = NULL, $sem = NULL)
    {
        $collection = $this->finance_model->getCollectionItems($from, $to, $report_type, $sy, $sem);
        return $collection;
    }

    function saveCashBreakDown()
    {
        $transaction = $this->post('items');
        $count = count(json_decode($transaction));
        $final = json_decode($transaction);

        $column = array();

        for ($x = 0; $x < $count; $x++) {
            //$items = explode('_', $final[$x]);
            $details = array(
                'fdcb_denom_id' => $final[$x]->den_id,
                'fdcb_total_count' => $final[$x]->count,
                'fdcb_date' => $final[$x]->dateCollected
            );
            $this->finance_model->saveCashBreakDown($details, $final[$x]->den_id, $final[$x]->dateCollected);
        }
    }

    function getOnlinePayments($date, $dateTo = NULL, $item_id = NULL, $fused_cat = NULL)
    {
        $payments = $this->finance_model->getOnlinePayments($date, $dateTo, $item_id, $fused_cat);
        return $payments;
    }

    function getCashPayments($date, $dateTo = NULL, $item_id = NULL, $fused_cat = NULL, $school_year = NULL, $sem = NULL)
    {
        $payments = $this->finance_model->getCashPayments($date, $dateTo, $item_id, $fused_cat, $school_year, $sem);
        return $payments;
    }

    function getChequePayments($date, $dateTo = NULL, $item_id = NULL, $fused_cat = NULL, $school_year = NULL, $sem = NULL)
    {
        $payments = $this->finance_model->getChequePayments($date, $dateTo, $item_id, $fused_cat, $school_year, $sem);
        return $payments;
    }

    function getBank($id = NULL)
    {
        $bank = $this->finance_model->getBank($id);
        return $bank;
    }

    function getEncashments($teller_id, $date)
    {
        $encashments = $this->finance_model->getEncashments($teller_id, $date);
        return $encashments;
    }

    function saveEncashments()
    {
        $bank = $this->post('bank');
        $chequeNum = $this->post('chequeNumber');
        $chequeAmount = $this->post('chequeAmount');
        $chequeDate = $this->post('chequeDate');

        $details = array(
            'encash_bank_id' => $bank,
            'encash_cheque_num' => $chequeNum,
            'encash_amount' => $chequeAmount,
            'encash_date' => $chequeDate,
            'encash_teller_id' => $this->session->employee_id
        );

        if ($this->finance_model->saveEncashments($details)):
            echo 'Cheque Encashments Successfully saved';
        else:
            echo 'Sorry something went wrong';
        endif;
    }

    function addBank()
    {
        $bank = $this->post('bank');
        $bankShortName = $this->post('bankShortName');
        $result = $this->finance_model->addBank(array('bank_name' => $bank, 'bank_short_name' => $bankShortName), $bank);
        $result = json_decode($result);
        if ($result->status):
            echo "<option value='$result->id'>$result->value</option>";
        endif;
    }

    public function getCashDenomination()
    {
        $cash = $this->finance_model->getCashDenomination();
        return $cash;
    }

    public function updateCollectibles($user_id, $st_id, $balance, $sy, $semester = NULL)
    {
        $details = array(
            'fc_user_id' => $user_id,
            'fc_st_id' => $st_id,
            'balance' => $balance,
            'last_update' => date('Y-m-d G:i:s'),
            'fc_school_year' => $sy,
            'fc_semester' => ($semester == NULL ? 0 : $semester)
        );

        $this->finance_model->updateCollectibles($details, $st_id, $sy, ($semester == NULL ? 0 : $semester));
        return TRUE;
    }

    public function generateCollectibles($sy, $sem = NULL)
    {
        $semester = Modules::run('main/getSemester');

        if ($sem == NULL):
            $sem = $semester;
        endif;
        $allStudents = $this->finance_model->getStudents("", "", $sy, $sem);
        $totalBalance = 0;
        foreach ($allStudents->result() as $as):
            $AD = json_decode(Modules::run('college/finance/getRunningBalance', base64_encode($as->st_id), $sy, $sem));
            $balance = $AD->charges - $AD->payments;
            $this->updateCollectibles($as->uid, $as->st_id, $balance, $sy, $sem);
            $totalBalance += $balance;
            unset($balance);
        endforeach;

        echo json_encode(array('totalBalance' => number_format($totalBalance, 2, '.', ',')));
    }

    public function getCollectible($limit = NULL, $offset = NULL, $sy = NULL)
    {
        $this->load->library('pagination');
        if ($sy == NULL):
            $year = $this->session->userdata('school_year');
        else:
            $year = $sy;
        endif;

        if ($this->uri->segment(4)):
            $seg = $this->uri->segment(4);
            $base_url = base_url('college/finance/getCollectible/');
        else:
            $seg = $this->uri->segment(4);
            $base_url = base_url('college/finance/getCollectible/');
        endif;
        $totalBalance = 0;
        $result = $this->finance_model->getCollectibles(NULL, NULL, $year);
        foreach ($result->result() as $r):
            $totalBalance += $r->balance;
        endforeach;
        $config['base_url'] = $base_url;
        $config['total_rows'] = $result->num_rows();
        $config['per_page'] = 30;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';


        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $page = $this->finance_model->getCollectibles($config['per_page'], $seg, $year);
        $data['students'] = $page->result();
        $data['totalBalance'] = number_format($totalBalance, 2, '.', ',');
        $data['school_year'] = $year;
        $data['modules'] = 'college';
        $data['main_content'] = 'finance/collectible';
        echo Modules::run('templates/canteen_content', $data);
    }

    public function getRunningBalance($st_id, $school_year, $sem = NULL)
    {
        $student = Modules::run('college/getSingleStudent', base64_decode($st_id), $school_year, $sem);

        $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $student->admission_id, $sem, $student->school_year);
        $totalUnits = 0;
        foreach ($loadedSubject as $sl):
            $totalUnits += ($sl->s_lect_unit + $sl->s_lab_unit);
        endforeach;

        $plan = Modules::run('college/finance/getPlanByCourse', $student->course_id, $student->year_level);
        $charges = Modules::run('college/finance/financeChargesByPlan', $student->year_level, $student->school_year, $sem, $plan->fin_plan_id);

        $tuition = Modules::run('college/finance/getChargesByCategory', 1, $student->semester, $student->school_year, $plan->fin_plan_id);


        $i = 1;
        $amount = 0;
        $tuitionFee = (($tuition->row()->amount * $totalUnits));
        if ($student->u_id == ""):
            $user_id = $student->us_id;
        else:
            $user_id = $student->u_id;
        endif;

        foreach ($charges as $c):
            $amount = ($c->item_id <= 1 || $c->item_id <= 2 ? 0 : $c->amount);
            $totalCharges += $amount;
        endforeach;

        $totalExtra = 0;
        $extraCharges = Modules::run('college/finance/getExtraFinanceCharges', $student->uid, $sem, $student->school_year);
        if ($extraCharges->num_rows() > 0):
            foreach ($extraCharges->result() as $ec):

                $totalExtra += $ec->extra_amount;
            endforeach;
        endif;
        $total = $totalCharges + $tuitionFee + $totalExtra;

        //transaction
        $transaction = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $student->school_year);
        $paymentTotal = 0;
        if ($transaction->num_rows() > 0):
            foreach ($transaction->result() as $tr):
                $paymentTotal += $tr->subTotal;
            endforeach;
        endif;

        $details = array(
            'charges' => $total,
            'payments' => $paymentTotal,
            'status' => ($total - $paymentTotal > 0 ? TRUE : FALSE)
        );

        return json_encode($details);
    }

    function printPermit($st_id, $sem, $term = 1)
    {
        $data['st_id'] = base64_decode($st_id);
        $data['sem'] = $sem;
        $data['term'] = $term;

        $this->load->view('finance/examPermitWrapper', $data);
    }

    function printSOA($st_id, $sem, $showPayment = NULL, $school_year = NULL)
    {

        $settings = Modules::run('main/getSet');
        $data['st_id'] = base64_decode($st_id);
        $data['sem'] = $sem;
        $data['school_year'] = $school_year;
        $data['showPayment'] = ($showPayment == NULL ? TRUE : ($showPayment == 0 ? TRUE : FALSE));


        if (file_exists(APPPATH . 'modules/college/views/finance/reports/' . strtolower($settings->short_name) . '/printSOA.php')):
            $this->load->view('finance/reports/' . strtolower($settings->short_name) . '/printSOA', $data);
        else:
            $this->load->view('finance/reports/printSOA', $data);
        endif;
    }

    function approvePromisory()
    {
        $prom_id = $this->post('prom_id');
        $amount = $this->post('amount');
        $action = $this->post('action');

        $details = array(
            'fr_approved' => $action,
            'fr_approved_by' => $this->session->userdata('employee_id'),
            'fr_allowable_amount' => $amount,
            'approved_date' => date('Y-m-d g:i:s')
        );
        if ($this->finance_model->approvePromisory($details, $prom_id)):
            echo 'Successfully Submited';
        else:
            echo 'Sorry something went wrong';
        endif;
    }

    function getPromisoryRequest($st_id, $sem)
    {
        $year = $this->session->userdata('school_year');
        $request = $this->finance_model->getPromisoryRequest($year, $st_id, $sem);
        return $request;
    }

    function requestPromisory()
    {
        $st_id = $this->post('st_id');
        $sem = $this->post('semester');
        $sy = $this->session->userdata('school_year');
        $remarks = $this->post('remarks');
        $student = Modules::run('college/getSingleStudent', $st_id, $this->session->userdata('school_year'), $sem);

        $details = array(
            'fr_requesting_id' => $st_id,
            'fr_remarks' => $remarks,
            'fr_year' => $sy,
            'fr_sem' => $sem
        );

        if ($this->finance_model->requestPromisory($details)):
            Modules::run('notification_system/department_notification', "Admin", $student->firstname . ' ' . $student->lastname . ' has submitted a business office promisory note', base_url() . 'college/finance/accounts/' . base64_encode($st_id) . '/' . $sem);
            echo 'Successfully Submitted';
        else:
            echo 'Sorry Something went Wrong';
        endif;
    }

    function getDiscountHistory($details, $balance, $student, $type = NULL, $item_value = NULL)
    {
        $data['type'] = $type;
        $data['student'] = $student;
        $data['details'] = $details;
        $data['total'] = $balance;
        $data['item_value'] = $item_value;
        $this->load->view('discountHistory', $data);
    }

    function getPaymentHistory($details, $balance, $student, $type = NULL)
    {
        $data['type'] = $type;
        $data['student'] = $student;
        $data['details'] = $details;
        $data['total'] = $balance;
        $this->load->view('paymentHistory', $data);
    }

    function saveFinanceLog($id, $remarks)
    {
        $logDetails = array(
            'account_id' => $id,
            'remarks' => $remarks
        );

        $this->finance_model->saveFinanceLog($logDetails);
    }

    function printCollectionReportPerTeller($teller_id, $from = NULL, $to = NULL, $school_year)
    {
        $this->load->library('pdf');
        $this->load->helper('file');
        $settings = Modules::run('main/getSet');
        $now = $this->finance_model->printCollectionReportPerTeller($from, $to, base64_decode($teller_id), ($school_year == NULL ? $this->session->school_year : $school_year));
        //        if(strtotime($from) > strtotime(date('Y-11-01'))):
        //            $advanced = $this->finance_model->printCollectionReportPerTellerAdvanced($from, $to, base64_decode($teller_id), ($this->session->school_year+1));
        //            $data['advanceCollection'] = $advanced;
        //        else:
        //            $data['advanceCollection'] = 0;
        //        endif;    
        $data['school_year'] = $school_year;
        $data['collection'] = $now;
        if (file_exists(APPPATH . 'modules/college/views/finance/reports/' . strtolower($settings->short_name) . '/printCollectionReportPerTeller.php')):
            $this->load->view('finance/reports/' . strtolower($settings->short_name) . '/printCollectionReportPerTeller', $data);
        else:
            $this->load->view('finance/reports/printCollectionReportPerTeller', $data);
        endif;
    }

    function printCollectionReportPerItem($from = NULL, $to = NULL)
    {
        $this->load->library('pdf');
        $data['collection'] = $this->finance_model->printCollectionReportPerItem($from, $to);

        if (file_exists(APPPATH . 'modules/college/views/finance/reports/' . strtolower($this->eskwela->getSet()->short_name) . '/printCollectionReportPerItem.php')):
            $this->load->view('finance/reports/' . strtolower($this->eskwela->getSet()->short_name) . '/printCollectionReportPerItem', $data);
        else:
            $this->load->view('finance/reports/printCollectionReportPerItem', $data);
        endif;
    }

    function printCollectionReport($from = NULL, $to = NULL, $report_type = NULL, $school_year = NULL, $sem = NULL)
    {
        $this->load->library('pdf');
        $sy = ($school_year == NULL ? $this->session->school_year : $school_year);
        $data['collection'] = $this->finance_model->getCollection($from, $to, NULL, $sy, $sem);
        $data['school_year'] = $sy;
        $data['cashbreakdown'] = $this->finance_model->getCashbreakdown($from, $sy);
        switch ($report_type):
            case 0:
                if (file_exists(APPPATH . 'modules/college/views/finance/reports/' . strtolower($this->eskwela->getSet()->short_name) . '/printCollectionReport.php')):
                    $this->load->view('finance/reports/' . strtolower($this->eskwela->getSet()->short_name) . '/printCollectionReport', $data);
                else:
                    $this->load->view('finance/reports/printCollectionReport', $data);
                endif;
                break;
            case 1:
                if (file_exists(APPPATH . 'modules/college/views/finance/reports/' . strtolower($this->eskwela->getSet()->short_name) . '/printCollectionReportPerItem.php')):
                    $this->load->view('finance/reports/' . strtolower($this->eskwela->getSet()->short_name) . '/printCollectionReportPerItem', $data);
                else:
                    $this->load->view('finance/reports/printCollectionReportPerItem', $data);
                endif;
                break;
            case 2:
                $this->load->view('finance/reports/printSummaryOfCollection', $data);
                break;
        endswitch;
    }

    public function collectionReport($semester, $from = NULL, $to = NULL, $report_type = NULL, $school_year = NULL)
    {
        $data['semester'] = ($semester == 1 ? 'First Semester' : ($semester == 2 ? 'Second Semester' : 'Summer'));
        $data['sem'] = $semester;
        $data['school_year'] = $school_year;
        $data['collection'] = $this->finance_model->getCollection($from, $to, $report_type, $school_year);
        $data['from'] = $from;
        $data['to'] = $to;
        $data['ro_year'] = Modules::run('registrar/getROYear');
        $data['modules'] = 'college';
        $data['main_content'] = 'finance/sales';
        echo Modules::run('templates/canteen_content', $data);
    }

    public function calculateItem()
    {
        $item_id = $this->post('item_id');
        $sem = $this->post('sem');
        $school_year = $this->post('school_year');
        $plan_id = $this->post('plan_id');
        $st_id = $this->post('st_id');
        $totalUnits = $this->post('totalUnits');

        $charges = $this->getChargesByItemId($item_id, $sem, $school_year, $plan_id);
        $charge = $charges->row()->amount;
        $item = $charges->row()->item_description;

        $transaction = $this->getTransaction($st_id, $sem, $school_year);
        if ($transaction->num_rows() != 0):
            foreach ($transaction->result() as $chrg):
                $totalPayment += $chrg->t_amount;
            endforeach;
        else:
            $totalPayment = 0;
        endif;

        $totalRetail = ($item_id < 2 ? $charge * $totalUnits : $charge) - $totalPayment;

        echo json_encode(array('totalPayment' => number_format($totalRetail, 2, '.', ','), 'item' => $item));
    }

    public function getDiscountTransaction($st_id, $sem, $school_year, $t_type = NULL, $isGroup = TRUE)
    {
        $transaction = $this->finance_model->getDiscountTransaction($st_id, $sem, $school_year, $t_type, $isGroup);
        return $transaction;
    }

    public function getTransactionByRefNumber($st_id, $sem, $school_year, $t_type = NULL, $isGroup = TRUE)
    {
        $transaction = $this->finance_model->getTransactionByRefNumber($st_id, $sem, $school_year, $t_type, $isGroup);
        return $transaction;
    }

    function getTransByRefNumber($st_id, $sem, $school_year, $t_type = NULL)
    {
        // $transaction = $this->finance_model->getTransByRefNumber(20191502609, 1, 2020, 5);
        $transaction = $this->finance_model->getTransByRefNumber($st_id, $sem, $school_year, $t_type);
        // print_r($transaction->result());
        return $transaction;
    }

    public function getTransactionByItemId($st_id, $sem, $school_year, $item_id = NULL, $type = NULL, $order = NULL, $isGroup = NULL)
    {
        $transaction = $this->finance_model->getTransactionByItemId($st_id, $sem, $school_year, $item_id, $type, $order, $isGroup);
        return $transaction;
    }

    public function getDiscountsByDate($st_id, $sem, $school_year, $date = NULL)
    {
        $disc = $this->finance_model->getDiscountsByDate($st_id, $sem, $school_year, $date);
        return $disc;
    }

    public function getDiscountsById($id)
    {
        $disc = $this->finance_model->getDiscountsById($id);
        return $disc;
    }

    public function getDiscountByStudId($id)
    {
        $disc = $this->finance_model->getDiscountByStudId(20191502960);
        // print_r($disc->result());
        return $disc;
    }

    public function getDiscountsByItemId($st_id, $sem, $school_year, $item_id = NULL)
    {
        $disc = $this->finance_model->getDiscountsByItemId($st_id, $sem, $school_year, $item_id);
        return $disc;
    }

    public function getTransactionByDate($st_id, $sem, $school_year, $date)
    {
        $transaction = $this->finance_model->getTransactionByDate($st_id, $sem, $school_year, $date);
        return $transaction;
    }

    public function getTransaction($st_id, $sem, $school_year)
    {
        $transaction = $this->finance_model->getTransaction($st_id, $sem, $school_year);
        return $transaction;
    }

    public function getBalance($st_id, $sem, $school_year)
    {
        //check if previously enrolled;

        $data = $this->finance_model->checkIfEnrolled(base64_decode($st_id), $sem, $school_year);
        $db_exist = $data->dbExist;


        while ($db_exist):
            $data = $this->finance_model->checkIfEnrolled(base64_decode($st_id), $sem, $school_year);
            if ($data->isEnrolled):
                $sem = $data->details->semester;
                $school_year = $data->details->school_year;
                break;
            else:
                if ($sem != 1):
                    $sem--;
                else:
                    $sem = 3;
                endif;
                $db_exist = $data->dbExist;
            endif;
        endwhile;

        $student = Modules::run('college/getSingleStudent', base64_decode($st_id), $school_year, $sem);

        if ($student->u_id == ""):
            $user_id = $student->us_id;
        else:
            $user_id = $student->u_id;
        endif;


        $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $student->admission_id, $sem, $school_year);

        $totalUnits = 0;
        $totalSubs = 0;
        $totalCharges = 0;
        $discAmount = 0;
        foreach ($loadedSubject as $sl):
            $totalSubs++;
            $totalUnits += ($sl->s_lect_unit + $sl->s_lab_unit);
        endforeach;

        $plan = Modules::run('college/finance/getPlanByCourse', $student->course_id, $student->year_level);
        $charges = Modules::run('college/finance/financeChargesByPlan', $student->year_level, $student->school_year, $sem, $plan->fin_plan_id);

        $tuition = Modules::run('college/finance/getChargesByCategory', 1, $student->semester, $student->school_year, $plan->fin_plan_id);
        $amount = 0;
        $tuitionFee = (($tuition->row()->amount * $totalUnits));


        foreach ($charges as $c):
            $amount = ($c->item_id == 1 || $c->item_id == 2 ? 0 : ($c->item_id == 46 ? ($c->amount * $totalSubs) : $c->amount));
            $totalCharges += $amount;
        endforeach;

        $totalLab = 0;
        foreach ($loadedSubject as $sl):
            if ($sl->sub_lab_fee_id != 0):
                $itemCharge = Modules::run('college/finance/getFinanceItemById', $sl->sub_lab_fee_id, $student->school_year);
                $totalLab += $itemCharge->default_value;
            endif;
        endforeach;

        $totalExtra = 0;
        $extraCharges = Modules::run('college/finance/getExtraFinanceCharges', $user_id, $sem, $student->school_year);

        if ($extraCharges->num_rows() > 0):
            foreach ($extraCharges->result() as $ec):
                $totalExtra += $ec->extra_amount;
            endforeach;
        endif;


        $discount = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $student->school_year, 2);

        if ($discount->row()):
            $dtransaction = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $student->school_year, 2);
            if ($dtransaction->num_rows() > 0):
                foreach ($dtransaction->result() as $tr):
                    $discounts = Modules::run('college/finance/getDiscountsById', $tr->disc_id);
                    if ($discounts->disc_type == 0):
                        if ($discounts->disc_item_id == 1):
                            $discAmount = $tuitionFee * $discounts->disc_amount;
                        else:
                            $discAmount = $tr->subTotal;
                        endif;
                    else:
                        $discAmount = $tr->subTotal;
                    endif;
                endforeach;
            endif;
        endif;

        $payments = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $school_year);
        $paymentTotal = 0;
        if ($payments->num_rows() > 0):
            foreach ($payments->result() as $tr):
                $paymentTotal += $tr->subTotal;
            endforeach;
        endif;

        $online = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $school_year, 4);
        $onlineTotal = 0;
        if ($online->num_rows() > 0):
            foreach ($online->result() as $tr):
                $onlineTotal += $tr->subTotal;
            endforeach;
        endif;

        $excess = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $school_year, 5);
        $excessTotal = 0;
        if ($excess->num_rows() > 0):
            foreach ($excess->result() as $tr):
                $excessTotal += $tr->subTotal;
            endforeach;
        endif;

        $payrollDeduction = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $school_year, 6);
        $payrollDeductionTotal = 0;
        if ($payrollDeduction->num_rows() > 0):
            foreach ($payrollDeduction->result() as $tr):
                $payrollDeductionTotal += $tr->subTotal;
            endforeach;
        endif;

        $forwardedBalance = Modules::run('college/finance/getTransactionByRefNumber', $student->uid, $sem, $school_year, 7);
        $forwardedBalanceTotal = 0;
        if ($forwardedBalance->num_rows() > 0):
            foreach ($forwardedBalance->result() as $tr):
                $forwardedBalanceTotal += $tr->subTotal;
            endforeach;
        endif;
        $totalPayment = $paymentTotal + $onlineTotal + $excessTotal + $payrollDeductionTotal + $forwardedBalanceTotal;

        $overAllTotal = $totalCharges + $tuitionFee + $totalExtra + $totalLab;

        $balance = $overAllTotal - ($totalPayment + $discAmount);
        if ($balance > 0):
            $balanceArray = array(
                'totalPayment' => number_format($totalPayment, 2, '.', ','),
                'totalCharges' => number_format($overAllTotal, 2, '.', ','),
                'balance' => number_format($balance, 2, '.', ','),
                'rawBalance' => $balance,
                'charges' => $overAllTotal,
                'payments' => $totalPayment,
                'status' => TRUE
            );
        else:
            $balanceArray = array('status' => FALSE);
        endif;

        return json_encode($balanceArray);
    }

    public function getChargesByItemId($item_id, $sem, $school_year, $plan_id)
    {
        $charges = $this->finance_model->getChargesByItemId($item_id, $sem, $school_year, $plan_id);
        return $charges;
    }

    public function getExtraChargesByCategory($cat_id, $sem, $school_year, $user_id = NULL)
    {
        $charges = $this->finance_model->getExtraChargesByCategory($cat_id, $sem, $school_year, $user_id);
        return $charges;
    }

    public function getChargesByCategory($cat_id, $sem, $school_year, $plan_id = NULL)
    {
        $charges = $this->finance_model->getChargesByCategory($cat_id, $sem, $school_year, $plan_id);
        return $charges;
    }

    public function saveOtherTransaction()
    {
        $school_year = $this->post('school_year');
        $semester = $this->post('sem');
        $or_num = $this->post('or_num');
        $chequeBank = $this->post('chequeBank');
        $inputCheque = $this->post('inputCheque');
        $lastname = $this->post('lastname');
        $firstname = $this->post('firstname');
        $transaction = $this->post('items');
        $transDate = $this->post('transDate');
        $receipt = $this->post('receipt');
        $t_remarks = $this->post('t_remarks');
        $transType = $this->post('transType');
        $count = count(json_decode($transaction));
        $final = json_decode($transaction);
        $column = array();

        $account = date('ymdHis');
        // print_r('acct:'.$account_number);
        $account = json_decode($this->finance_model->saveAccount($lastname, $firstname, $school_year));
        if ($account->isRegistered):
            $account_number = $account->account_number;
        else:
            $account_number = $account->account_number;
        endif;

        $success = 0;
        for ($x = 0; $x < $count; $x++) {

            $items = explode('_', $final[$x]);

            $details = array(
                'ref_number' => $or_num,
                't_st_id' => $account_number,
                't_em_id' => $this->session->userdata('employee_id'),
                't_amount' => $items[1],
                't_charge_id' => $items[0],
                't_type' => $transType,
                'bank_id' => $chequeBank,
                'tr_cheque_num' => $inputCheque,
                't_date' => $transDate,
                't_sem' => $semester,
                't_school_year' => $school_year,
                't_receipt_type' => $receipt,
                't_remarks' => $t_remarks,
                'acnt_type' => 1,
                't_comment' => ''
            );


            $result = $this->finance_model->saveTransaction($details, $school_year);
            if (!$result):
                echo 'sorry!';
            else:
                $success++;
            //                Modules::run('web_sync/updateSyncController', 'c_finance_transactions', 'trans_id', $result, 'create', 6);
            endif;
        }

        $this->updateOR($or_num);
        if ($success == $count):
            echo json_encode(array('accountNumber' => base64_encode($account_number)));
        endif;
    }

    public function updateOR($or_num)
    {
        $this->finance_model->updateORSeries($or_num);
        return;
    }

    public function saveTransaction()
    {
        $school_year = $this->post('school_year');
        $semester = $this->post('sem');
        $or_num = $this->post('or_num');
        $st_id = $this->post('st_id');
        $transaction = $this->post('items');
        $transDate = $this->post('transDate');
        $receipt = $this->post('receipt');
        $t_remarks = $this->post('t_remarks');
        $transType = $this->post('transType');
        $tcomment = $this->post('tcomment');
        $icomment = $this->post('icomment');
        $chequeNumber = $this->post('chequeNumber');
        $bank = $this->post('bank');
        $count = count(json_decode($transaction));
        $final = json_decode($transaction);
        $column = array();
        $success = 0;
        for ($x = 0; $x < $count; $x++) {

            $items = explode('_', $final[$x]);
            $comment = "";
            if ($items[0] == '1') {
                $comment = $tcomment;
            }
            if ($items[0] == '10') {
                $comment = $icomment;
            }

            $details = array(
                'ref_number' => $or_num,
                't_st_id' => $st_id,
                't_em_id' => $this->session->userdata('employee_id'),
                't_amount' => $items[1],
                't_charge_id' => ($items[2] == 0 ? $items[0] : 0),
                't_type' => $transType,
                'bank_id' => $bank,
                'tr_cheque_num' => $chequeNumber,
                't_date' => $transDate,
                't_sem' => $semester,
                't_school_year' => $school_year,
                't_receipt_type' => $receipt,
                't_remarks' => $t_remarks,
                't_comment' => $comment,
                'fused_category' => $items[2],
            );

            $result = $this->finance_model->saveTransaction($details, $school_year);
            //print_r($result);
            if (!$result):
            else:
                $success++;
            endif;
        }

        if ($this->post('isEnrolled') == 0):
            $this->finance_model->updateStudentStatus($this->post('admission_id'), $school_year);
        endif;
        if ($success == $count):
            echo 'Successfully Saved';
            $this->saveFinanceLog($this->session->employee_id, 'Added a Finance Transacton with reference number ' . $or_num);
        endif;
    }

    public function deleteTransaction()
    {
        $school_year = $this->post('school_year');
        $st_id = $this->post('st_id');
        $trans_id = $this->post('trans_id');
        $item_id = $this->post('item_id');
        $trans_type = $this->post('trans_type');
        $delete_remarks = $this->post('delete_remarks');
        if ($trans_type == 2):
            if ($this->finance_model->deleteDiscount($school_year, $st_id, $item_id)):
                if ($this->finance_model->deleteTransaction($trans_id, $school_year)):

                    $this->saveFinanceLog($this->session->userdata('employee_id'), 'Voided a Transaction with Discount : ' . $delete_remarks);

                    echo 'Successfully Deleted';
                else:
                    echo 'An Error has Occur';
                endif;
            endif;
        else:
            if ($this->finance_model->deleteTransaction($trans_id, $school_year)):
                $this->saveFinanceLog($this->session->userdata('employee_id'), $delete_remarks);
                echo 'Successfully Deleted';
            else:
                echo 'An Error has Occur';
            endif;
        endif;
    }

    public function deleteExtraCharges()
    {
        $school_year = $this->post('school_year');
        $st_id = $this->post('st_id');
        $trans_id = $this->post('trans_id');
        $delete_remarks = $this->post('delete_remarks');
        if ($this->finance_model->deleteExtraCharges($trans_id, $school_year)):

            $this->saveFinanceLog($this->session->userdata('employee_id'), 'Deleted an Extra Charges : ' . $delete_remarks);

            echo 'Successfully Deleted';
        else:
            echo 'An Error has Occur';
        endif;
    }

    public function addFinanceTransaction($ref_num, $st_id, $amount, $charge_id, $t_type, $sem, $school_year, $date = NULL, $discount_id = NULL)
    {
        $details = array(
            'ref_number' => $ref_num,
            't_st_id' => $st_id,
            't_em_id' => $this->session->userdata('employee_id'),
            't_amount' => $amount,
            't_charge_id' => $charge_id,
            't_type' => $t_type,
            'disc_id' => ($discount_id == NULL ? 0 : $discount_id),
            't_date' => ($date == NULL ? date('Y-m-d') : $date),
            't_sem' => $sem,
            't_school_year' => $school_year
        );

        if ($this->finance_model->addFinanceTransaction($details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public function applyDiscounts()
    {
        $item = $this->post('finItem');
        $sem = $this->post('semester');
        $amount = $this->post('finAmount');
        $sy = $this->post('school_year');
        $st_id = $this->post('st_id');
        $discount_type = $this->post('discount_type');
        $remarks = $this->post('remarks');
        $plan_id = $this->post('plan_id');
        $admission_id = $this->post('admission_id');
        $discountCategory = $this->post('discountCategory');

        $otherFees = $this->post('otherFees');

        if ($discount_type == 0):
            $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $admission_id);
            $charge = $this->getChargesByItemId($item, $sem, $sy, $plan_id);
            if ($item == 1 || $item == 2):
                $totalUnits = 0;
                foreach ($loadedSubject as $sl):
                    $totalUnits += ($sl->s_lect_unit + $sl->s_lab_unit);
                endforeach;
                $charges = ($totalUnits * $charge->row()->amount) * $amount;
            else:
                if ($item == 1000):
                    $charges = $otherFees * $amount;
                endif;
            endif;
        else:
            $charges = $amount;
        endif;

        $discountDetails = array(
            'disc_st_id' => $st_id,
            'disc_type' => $discount_type,
            'disc_amount' => $amount,
            'disc_item_id' => $item,
            'disc_remarks' => $remarks,
            'disc_sem' => $sem,
            'disc_school_year' => $sy,
            'disc_category' => $discountCategory
        );

        $discountAdded = $this->finance_model->applyDiscounts($discountDetails);

        if (!$discountAdded):
            echo 'Something is really wrong';
        else:
            if ($this->addFinanceTransaction(date('Ymdgis'), $st_id, $charges, $item, 2, $sem, $sy, NULL, $discountAdded)):
                echo 'Discount Successfully Added';
            else:
                echo 'Discount Not Added to Transaction History';
            endif;
        //return TRUE;
        endif;
    }

    function financeChargesByPlan($year_level = NULL, $school_year, $sem, $plan = NULL)
    {
        $charges = $this->finance_model->financeChargesByPlan($school_year, $sem, $plan, $year_level);
        return $charges;
    }

    function overPayment($st_id, $sem, $school_year)
    {
        $charges = $this->finance_model->overPayment($st_id, $sem, $school_year);
        return $charges;
    }

    function getLaboratoryFee($st_id, $sem, $school_year)
    {
        $charges = $this->finance_model->getLaboratoryFee($st_id, $sem, $school_year);
        //print_r($charges->row());
        return $charges;
    }

    function getExtraFinanceChargesForCR($st_id, $sem, $school_year, $extra_id = NULL)
    {
        $charges = $this->finance_model->getExtraFinanceChargesForCR($st_id, $sem, $school_year, $extra_id);
        return $charges;
    }

    function getExtraFinanceCharges($st_id, $sem, $school_year, $extra_id = NULL)
    {
        $charges = $this->finance_model->getExtraFinanceCharges($st_id, $sem, $school_year, $extra_id);
        return $charges;
    }

    function loadAccountDetails($st_id, $sem, $school_year = NULL)
    {
        $data['sem'] = $sem;
        $data['school_year'] = $school_year;
        $data['ro_years'] = Modules::run('registrar/getROYear');
        $data['fin_items'] = $this->finance_model->getFinItems($school_year);
        $data['discountType'] = $this->getDiscountType();
        $data['st_id'] = $st_id;
        $num_rows = 0;
        switch ($sem):
            case 1:
                $p_sy = $school_year - 1;
                $p_sem = 3;
                break;
            case 2:
                $p_sy = $school_year;
                $p_sem = 1;
                break;
            case 3:
                $p_sy = $school_year;
                $p_sem = 2;
                break;
        endswitch;

        while ($num_rows == 0):
            if ($school_year >= 2021):
                if ($p_sy >= 2020):
                    for ($x = $p_sem; $x >= 1; $x--):
                        $this->db = $this->eskwela->db($p_sy);

                        $this->db->where('st_id', base64_decode($st_id));
                        $this->db->where('semester', $x);
                        $this->db->where('school_year', $p_sy);
                        $this->db->where('status', 1);
                        $q = $this->db->get('profile_students_c_admission');

                        if ($q->num_rows() > 0):
                            $num_rows = json_decode($this->getPrevBal(base64_decode($st_id), $x, $p_sy, $sem, $school_year));
                            //                        $num_rows = json_decode($this->getBalance($st_id, $x, $p_sy));
                            break;
                        endif;
                    endfor;
                    $p_sy--;
                    $p_sem = 3;
                else:
                    break;
                endif;
            else:
                break;
            endif;
        endwhile;

        $data['previous_balance'] = $num_rows;
        $this->load->view('finance/accountDetails', $data);
    }

    // function loadAccountDetails($st_id, $sem, $school_year = NULL)
    // {
    //     $data['sem'] = $sem;
    //     $data['school_year'] = $school_year;
    //     $data['ro_years'] = Modules::run('registrar/getROYear');
    //     $data['fin_items'] = $this->finance_model->getFinItems($school_year);
    //     $data['discountType'] = $this->getDiscountType();
    //     $data['st_id'] = $st_id;
    //     $this->load->view('finance/accountDetails', $data);
    // }

    function setFinanceAccount($st_id, $sem)
    {
        $student = Modules::run('college/getSingleStudent', $st_id, $this->session->userdata('school_year'));
        $course = $student->course_id;
        $plan = $this->getPlanByCourse($course, $student->year_level);

        $finDetails = array(
            'fin_st_id' => $st_id,
            'fin_term_id' => $sem,
            'fin_plan_id' => $plan->fin_plan_id,
            'fin_school_year' => $this->session->userdata('school_year'),
        );

        $this->finance_model->setFinanceAccount($finDetails, $st_id, $plan->fin_plan_id, $this->session->userdata('school_year'), $sem);

        Modules::run('college/updateEnrollmentStatus', $st_id, $this->session->userdata('school_year'), $sem, 1);

        return;
    }

    function getPlanByCourse($course_id, $year_level, $school_year = NULL)
    {
        $plan_id = $this->finance_model->getPlanByCourse($course_id, $year_level);
        return $plan_id;
    }

    function accounts($id = NULL, $sem = NULL, $school_year = NULL)
    {
        if ($this->session->userdata('is_logged_in')):
            $semester = Modules::run('main/getSemester');
            if ($sem == NULL):
                $sem = $semester;
            endif;
            $settings = Modules::run('main/getSet');
            $data['ro_year'] = Modules::run('registrar/getROYear');
            $data['sem'] = $sem;
            $data['id'] = $id;
            $data['modules'] = 'college';
            $data['series'] = $this->getSingleSeries($this->session->employee_id);
            $data['main_content'] = 'finance/financeAccounts';
            $data['fin_items'] = $this->finance_model->getFinItems($school_year);
            $data['getBanks'] = $this->finance_model->getBanks();
            $data['FinSettings'] = $this->getSettings();
            if (file_exists(APPPATH . 'modules/college/finance/views/' . strtolower($settings->short_name) . '_financeAccounts.php')):
                $data['main_content'] = strtolower($settings->short_name) . '_financeAccounts';
            else:
                $data['main_content'] = 'finance/financeAccounts';
            endif;
            echo Modules::run('templates/canteen_content', $data);
        else:
            redirect('login');
        endif;
    }

    function getFinanceChargesWrapper($course_id = 1, $sem = 1, $school_year = NULL)
    {
        $data['course_id'] = $course_id;
        $data['sem'] = $sem;
        $data['school_year'] = ($school_year == NULL ? $this->session->school_year : $school_year);
        $this->load->view('finance/financeChargesWrapper', $data);
    }

    function deleteFinanceCharges()
    {
        $charge_id = $this->post('charge_id');
        $school_year = $this->post('school_year');
        $success = $this->finance_model->deleteFinanceCharges($charge_id, $school_year);
        if ($success):
            echo 'Deleted Successfully';
        else:
            echo 'Something went wrong, Please contact csscore inc.';
        endif;
    }

    function editFinanceCharges()
    {
        $charge_id = $this->post('charge_id');
        $amount = $this->post('fin_amount');
        $semester = $this->post('semester');
        $school_year = $this->post('school_year');

        $success = $this->finance_model->editFinanceCharges($charge_id, $amount, $semester, $school_year);
        if ($success):
            echo json_encode(array('status' => TRUE, 'msg' => 'Successfully Updated', 'amount' => $amount));
        else:
            echo json_encode(array('status' => TRUE, 'msg' => 'Sorry Something went wrong', 'amount' => 0));
        endif;
    }

    function financeCharges($course_id, $year_level, $school_year, $sem)
    {
        $data['year'] = $year_level;
        $data['charges'] = $this->finance_model->financeCharges($course_id, $year_level, $school_year, $sem);
        $this->load->view('finance/financeCharges', $data);
    }

    function addFinanceItem()
    {
        $item = $this->post('finItem');
        $result = $this->finance_model->addFinanceItem($item);
        $result = json_decode($result);
        if ($result->status):
            echo "<option value='$result->id'>$result->value</option>";
        endif;
    }

    function getFinanceCharges($course_id, $year_level, $school_year, $sem)
    {
        $charges = $this->finance_model->financeCharges($course_id, $year_level, $school_year, $sem);
        return $charges;
    }

    public function index()
    {

        if ($this->session->position == 'Cashier'):
            redirect('college/finance/accounts');
        else:
            $data['course_id'] = NULL;
            $data['sems'] = NULL;
            $data['course'] = Modules::run('coursemanagement/getCourses');
            $data['ro_years'] = Modules::run('registrar/getROYear');
            $data['now'] = $this->session->school_year;
            $data['nextYear'] = $this->session->school_year + 1;
            $data['fin_items'] = $this->finance_model->getFinItems($this->session->school_year);
            $data['modules'] = 'college';
            $data['main_content'] = 'finance/finance_settings';
            echo Modules::run('templates/college_content', $data);
        endif;
    }

    public function settings($school_year = NULL, $course_id = NULL, $semester = NULL)
    {
        $this->load->dbutil();
        $settings = $this->eskwela->getSet();

        $db_name = DB_PREFIX . strtolower($settings->short_name) . '_' . $school_year; // local db
        //$db_name = 'eskwelap_'.strtolower($settings->short_name).'_'.$school_year; // live production

        if ($this->dbutil->database_exists($db_name)) {
            $data['course'] = Modules::run('coursemanagement/getCourses');
            $data['ro_years'] = Modules::run('registrar/getROYear');
            $data['now'] = ($school_year == NULL ? $this->session->school_year : $school_year);
            $data['sems'] = $semester;
            $data['course_id'] = $course_id;
            $data['nextYear'] = ($school_year == NULL ? $this->session->school_year : $school_year) + 1;
            $data['fin_items'] = $this->finance_model->getFinItems($school_year);
            $data['modules'] = 'college';
            $data['main_content'] = 'finance/finance_settings';
            echo Modules::run('templates/college_content', $data);
        } else {
        ?>
            <script type="text/javascript">
                alert('Sorry No Record Found');
                window.history.back();
            </script>
            <?php
        }
    }

    public function addExtraFinanceCharges()
    {
        $item = $this->post('finItem');
        $sem = $this->post('semester');
        $amount = $this->post('finAmount');
        $sy = $this->post('school_year');
        $st_id = $this->post('st_id');
        $user_id = $this->post('user_id');
        $year_level = $this->post('year_level');
        $plan_id = $this->post('plan_id');
        $admission_id = $this->post('admission_id');


        $charge = array(
            'extra_id' => $this->eskwela->code(),
            'extra_st_id' => $user_id,
            'extra_item_id' => $item,
            'extra_amount' => $amount,
            'extra_sem' => $sem,
            'extra_school_year' => $sy
        );

        if ($this->finance_model->addExtraFinanceCharges($charge, $sy)):
            $charges = Modules::run('college/finance/financeChargesByPlan', $year_level, $sy, $sem, $plan_id);
            $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $admission_id);
            $totalUnits = 0;
            foreach ($loadedSubject as $sl):
                $totalUnits += ($sl->s_lect_unit + $sl->s_lab_unit);
            endforeach;
            $i = 1;
            $total = 0;
            $amount = 0;

            foreach ($charges as $c):
                $next = $c->school_year + 1;
                $amount = ($c->item_id == 14 ? $c->amount * $totalUnits : $c->amount);
            ?>
                <tr id="tr_<?php echo $c->charge_id ?>">
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $c->item_description ?></td>
                    <td id="td_<?php echo $c->charge_id ?>" class="text-right"><?php echo number_format($amount, 2, '.', ',') ?></td>
                </tr>
                <?php
                $total += $amount;
            endforeach;
            $totalExtra = 0;
            $extraCharges = Modules::run('college/finance/getExtraFinanceCharges', $student->uid, $student->semester, $student->school_year);
            if ($extraCharges->num_rows() > 0):
                foreach ($extraCharges->result() as $ec):
                ?>
                    <tr style="background: #0ff" id="trExtra_<?php echo $ec->extra_id ?>">
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $ec->item_description ?></td>
                        <td id="td_<?php echo $ec->extra_id ?>" class="text-right"><?php echo number_format($ec->extra_amount, 2, '.', ',') ?></td>
                    </tr>
                <?php
                    $totalExtra += $ec->extra_amount;
                endforeach;
                $total = $total + $totalExtra;
            endif;

            if ($total != 0):
                ?>
                <tr style="background:yellow;">
                    <th>TOTAL</th>
                    <th></th>
                    <th class="text-right"><?php echo number_format($total, 2, '.', ',') ?></th>
                    <th></th>
                </tr>
<?php
            endif;
        endif;
    }

    public function addFinanceCharges()
    {
        $item = $this->post('finItem');
        $sem = $this->post('semester');
        $amount = $this->post('finAmount');
        $sy = $this->post('school_year');
        $course_id = $this->post('course_id');
        $year_level = $this->post('year_level');


        $plan = array(
            'fin_course_id' => $course_id,
            'fin_year_level' => $year_level,
            'is_college' => 1,
        );

        $plan_id = $this->finance_model->addPlan($plan, $course_id, $year_level, $sy);

        $charge = array(
            'item_id' => $item,
            'amount' => $amount,
            'semester' => $sem,
            'school_year' => $sy,
            'plan_id' => $plan_id
        );

        $this->finance_model->addFinanceCharges($charge, $plan_id, $item, $sem, $sy);
        echo Modules::run('finance/financeCharges', $course_id, $year_level, $sy, $sem);
    }

    public function convert_number($num)
    {
        $decones = array(
            '01' => "One",
            '02' => "Two",
            '03' => "Three",
            '04' => "Four",
            '05' => "Five",
            '06' => "Six",
            '07' => "Seven",
            '08' => "Eight",
            '09' => "Nine",
            10 => "Ten",
            11 => "Eleven",
            12 => "Twelve",
            13 => "Thirteen",
            14 => "Fourteen",
            15 => "Fifteen",
            16 => "Sixteen",
            17 => "Seventeen",
            18 => "Eighteen",
            19 => "Nineteen"
        );
        $ones = array(
            0 => " ",
            1 => "One",
            2 => "Two",
            3 => "Three",
            4 => "Four",
            5 => "Five",
            6 => "Six",
            7 => "Seven",
            8 => "Eight",
            9 => "Nine",
            10 => "Ten",
            11 => "Eleven",
            12 => "Twelve",
            13 => "Thirteen",
            14 => "Fourteen",
            15 => "Fifteen",
            16 => "Sixteen",
            17 => "Seventeen",
            18 => "Eighteen",
            19 => "Nineteen"
        );
        $tens = array(
            0 => "",
            2 => "Twenty",
            3 => "Thirty",
            4 => "Forty",
            5 => "Fifty",
            6 => "Sixty",
            7 => "Seventy",
            8 => "Eighty",
            9 => "Ninety"
        );
        $hundreds = array(
            "Hundred",
            "Thousand",
            "Million",
            "Billion",
            "Trillion",
            "Quadrillion"
        ); //limit t quadrillion 
        $num = number_format($num, 2, ".", ",");
        $num_arr = explode(".", $num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(",", $wholenum));
        krsort($whole_arr);
        $rettxt = "";
        foreach ($whole_arr as $key => $i) {
            if ($i < 20) {
                $rettxt .= $ones[$i];
            } elseif ($i < 100) {
                $rettxt .= $tens[substr($i, 0, 1)];
                $rettxt .= " " . $ones[substr($i, 1, 1)];
            } else {
                $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
                $rettxt .= " " . $tens[substr($i, 1, 1)];
                $rettxt .= " " . $ones[substr($i, 2, 1)];
            }
            if ($key > 0) {
                $rettxt .= " " . $hundreds[$key] . " ";
            }
        }
        //        $rettxt = $rettxt . " peso/s";

        if ($decnum > 0) {
            $rettxt .= " and ";
            if ($decnum < 20) {
                $rettxt .= $decones[$decnum];
            } elseif ($decnum < 100) {
                $rettxt .= $tens[substr($decnum, 0, 1)];
                $rettxt .= " " . $ones[substr($decnum, 1, 1)];
            }
            $rettxt = $rettxt . " centavo/s";
        }
        return $rettxt;
    }

    function getPrevBal($stid, $sem, $sy, $present_sem, $present_sy)
    {
        $student = Modules::run('college/getSingleStudent', $stid, $sy, $sem);
        $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $student->admission_id, $sem, $student->school_year);

        $totalUnits = 0;
        $totalSubs = 0;
        foreach ($loadedSubject as $sl):
            $totalSubs++;
            $totalUnits += ($sl->s_lect_unit + $sl->s_lab_unit);
        endforeach;
        $plan = Modules::run('college/finance/getPlanByCourse', $student->course_id, $student->year_level);
        $charges = Modules::run('college/finance/financeChargesByPlan', $student->year_level, $student->school_year, $sem, $plan->fin_plan_id);
        $tuition = Modules::run('college/finance/getChargesByCategory', 1, $student->semester, $student->school_year, $plan->fin_plan_id);
        $total = 0;
        $amount = 0;
        $tuitionFee = (($tuition->row()->amount * $totalUnits));
        $totalCharges = 0;

        //print_r($charges);
        foreach ($charges as $c):
            $next = $c->school_year + 1;
            $amount = ($c->item_id == 1 || $c->item_id == 2 ? 0 : ($c->item_id == 46 ? ($c->amount * $totalSubs) : $c->amount)); // this works in exam fee

            if ($c->item_id == 46):
                $examFee = $c->amount * $totalSubs;
            endif;
            $totalCharges += $amount;
        //            $otherFeesLessExamFee = $totalCharges - $examFee;
        endforeach;
        $totalExtra = 0;
        $extraCharges = Modules::run('college/finance/getExtraFinanceCharges', $student->u_id, $sem, $student->school_year);

        $totalLab = 0;
        foreach ($loadedSubject as $sl):
            if ($sl->sub_lab_fee_id != 0):
                $itemCharge = Modules::run('college/finance/getFinanceItemById', $sl->sub_lab_fee_id, $student->school_year);
                $totalLab += $itemCharge->default_value;
            endif;
        endforeach;
        if ($extraCharges->num_rows() > 0):
            foreach ($extraCharges->result() as $ec):
                $totalExtra += $ec->extra_amount;
            endforeach;
        endif;
        $total = $totalCharges + $tuitionFee + $totalExtra + $totalLab;

        $discount = Modules::run('college/finance/getTransactionByRefNumber', $stid, $sem, $sy, 2);
        //print_r($discount->row());
        if ($discount->row()):
            $dtransaction = Modules::run('college/finance/getTransactionByRefNumber', $stid, $sem, $sy, 2);
            //print_r($transaction->result());
            $paymentTotal = 0;
            if ($dtransaction->num_rows() > 0):
                foreach ($dtransaction->result() as $tr):
                    $discounts = Modules::run('college/finance/getDiscountsById', $tr->disc_id);
                    if ($discounts->disc_type == 0):
                        if ($discounts->disc_item_id == 1):
                            $discAmount = $tuitionFee * $discounts->disc_amount;
                        else:
                            $discAmount = $tr->subTotal;
                        endif;
                    else:
                        $discAmount = $tr->subTotal;
                    endif;
                    $total = round($total, 2) - round($discAmount, 2);
                endforeach;
            else:

            endif;
        endif;

        $transaction = Modules::run('college/finance/getTransactionByRefNumber', $stid, $sem, $sy);
        //print_r($transaction->result());
        $paymentTotal = 0;
        if ($transaction->num_rows() > 0):
            foreach ($transaction->result() as $tr):
                $total = $total - $tr->subTotal;
            endforeach;
        else:

        endif;

        $online = Modules::run('college/finance/getTransactionByRefNumber', $stid, $sem, $sy, 4);
        //print_r($transaction->result());
        $paymentTotal = 0;
        if ($online->num_rows() > 0):
            foreach ($online->result() as $tr):
                $total = $total - $tr->subTotal;
            endforeach;
        else:

        endif;

        $excess = Modules::run('college/finance/getTransactionByRefNumber', $stid, $sem, $sy, 5);
        $paymentTotal = 0;
        if ($excess->num_rows() > 0):
            foreach ($excess->result() as $tr):
                $total = $total - $tr->subTotal;
            endforeach;
        else:

        endif;

        $payrollDeduction = Modules::run('college/finance/getTransactionByRefNumber', $stid, $sem, $sy, 6);
        $paymentTotal = 0;
        if ($payrollDeduction->num_rows() > 0):
            foreach ($payrollDeduction->result() as $tr):
                $total = $total - $tr->subTotal;
            endforeach;
        else:

        endif;

        $forwardedBalance = Modules::run('college/finance/getTransactionByRefNumber', $stid, $sem, $sy, 7);
        $paymentTotal = 0;
        if ($forwardedBalance->num_rows() > 0):
            foreach ($forwardedBalance->result() as $tr):
                $total = $total - $tr->subTotal;
            endforeach;
        else:

        endif;

        if ($present_sy >= 2021):
            if ($total > 0 && round($total) != 0):
                $item = 268236;
                $charge = array(
                    'extra_id' => $this->eskwela->code(),
                    'extra_st_id' => $student->u_id,
                    'extra_item_id' => $item,
                    'extra_amount' => $total,
                    'extra_sem' => $present_sem,
                    'extra_school_year' => $present_sy
                );
                $this->finance_model->addExtraFinanceCharges($charge, $present_sy, $item, $student->u_id);
            endif;
        endif;

        switch ($sem):
            case 1:
                $s = '1st Sem';
                break;
            case 2:
                $s = '2nd Sem';
                break;
            case 3:
                $s = '3rd Sem';
                break;
            case 4:
                $s = '4th Sem';
                break;
        endswitch;

        if ($total > 0):
            $balanceArray = array(
                'rawBalance' => $total,
                'sem' => $sem,
                'sy' => $sy,
                'msg' => '[ S.Y.: ' . $sy . ' - ' . ($sy + 1) . ' (' . $s . ') ]',
                'status' => TRUE
            );
        else:
            $balanceArray = array('status' => FALSE, 'msg' => $total);
        endif;

        return json_encode($balanceArray);
    }

    function addEditDiscountCategory($desc, $cat_id, $opt)
    {
        switch ($opt):
            case 1:
                $q = $this->finance_model->addDiscCat(urldecode($desc));

                echo json_encode(($q ? array('status' => TRUE, 'msg' => 'Discount Category Added Successfuly') : array('status' => FALSE, 'msg' => 'Discount Category Already Exist!')));
                break;
            case 0:
                $q = $this->finance_model->editDiscCat(urldecode($desc), $cat_id);
                echo json_encode(($q ? array('status' => TRUE, 'msg' => 'Discount Category Updated Successfuly') : array('status' => FALSE, 'msg' => 'An Error Occured')));
        endswitch;
    }

    function deleteDiscCat($id)
    {
        return $this->finance_model->deleteDiscCat($id);
    }
}
