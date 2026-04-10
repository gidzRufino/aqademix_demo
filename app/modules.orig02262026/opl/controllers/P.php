<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Opl
 *
 * @author genesisrufino
 */
class P extends MX_Controller
{
    //put your code here


    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('p_model');
        $this->load->model('opl_model');
    }

    private function post($name)
    {
        return $this->input->post($name);
    }

    public function discussionBoard($school_year = NULL, $grade_level = NULL, $section = NULL, $subject = NULL)
    {
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $grade_level, $section, $subject, $school_year));
        $data = array(
            'isClass' => FALSE,
            'school_year' => $school_year,
            'gradeDetails' => $classDetails->basicInfo,
            'subjectDetails' => $classDetails->subjectDetails,
            'headerTitle' => 'Discussion Board',
            'main_header' => '',
            'title' => 'Aqademix Online Platform for Learning',
            'modules' => 'opl',
            'main_content' => 'parent/discussionBoard',
            'login_page' => 'parentsEntrance',
            'grade_level' => $grade_level,
            'section_id' => $section,
            'subject_id' => $subject
        );
        $data['discussionDetails'] = $this->p_model->getDiscussionBoard($school_year, $grade_level, $section, $subject);

        echo Modules::run('templates/opl_content', $data);
    }

    public function uploadPaymentReceipt()
    {

        $school_year = $this->post('school_year');
        $paymentRemarks = $this->post('payment_remarks');
        $paymentCenter = $this->post('paymentCenter');
        $isEnrollment = $this->post('is_enrollment');
        $semester = $this->post('semester');
        $st_id = $this->post('st_id');
        $is_or = $this->post('is_or');
        $file = $this->post('userfile');
        $data['error'] = ''; //initialize image upload error array to empty

        $config['upload_path'] = 'uploads/' . $school_year . DIRECTORY_SEPARATOR . 'students' . DIRECTORY_SEPARATOR . base64_decode($st_id) . DIRECTORY_SEPARATOR . ($is_or ? 'original_receipts' : 'online_payments');
        if (!is_dir($config['upload_path'] . '/')):
            mkdir($config['upload_path'], 0777, TRUE);
        endif;
        $rn = substr(str_shuffle("0123456789"), 0, 2);
        $fname = strtotime(date('Y-m-d')) . '-' . $rn . '-OR';

        $config['overwrite'] = FALSE;
        $config['allowed_types'] = '*';
        $config['max_size'] = '3072';
        $config['maintain_ratio'] = TRUE;
        $config['quality'] = '50%';
        $config['width'] = 200;
        $config['file_name'] = $fname;
        $this->load->library('upload', $config);

        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
            //print_r($data);
            echo $config['upload_path'] . '/';
            //$this->load->view('csvindex', $data);
        } else {
            $file_data = $this->upload->data();

            //print_r($file_data);
            // $ext = $file_data['file_ext'];
            // $link = $config['upload_path'].'/'.$file;
            $link = $config['upload_path'] . '/' . $fname . '.' . $file_data['image_type'];
            if ($this->p_model->savePaymentReceipt(base64_decode($st_id), $link, $file_data['file_name'], $paymentCenter, $paymentRemarks, $school_year, $semester, $is_or, $isEnrollment)):
                if (!$is_or):
                    echo 'Thank you for uploading. We will just notify you once your payment is confirm.';
                else:
                    echo 'Original Receipt Successfuly Uploaded';
                endif;
                if ($this->session->department == 4):
                    $student = $this->p_model->getStudentDetails(base64_decode($st_id), $semester, $school_year);
                else:
                    $student = $this->p_model->getStudentDetailsBasicEd(base64_decode($st_id), $semester, $school_year);
                endif;

                $remarks = $student->firstname . ' ' . $student->lastname . ' has uploaded a payment receipt to the system';
                Modules::run('notification_system/systemNotification', 5, $remarks);
            endif;
        }
    }


    // public function uploadPaymentReceipt()
    // {       

    //         $school_year = $this->post('school_year');
    //         $paymentRemarks = $this->post('payment_remarks');
    //         $paymentCenter = $this->post('paymentCenter');
    //         $semester = $this->post('semester');
    //         $st_id = $this->post('st_id');
    //         $file = $this->post('userfile');
    //         $data['error'] = ''; //initialize image upload error array to empty

    //         $config['upload_path'] = 'uploads/'.$school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR. base64_decode($st_id).DIRECTORY_SEPARATOR.'online_payments';
    //         if(!is_dir($config['upload_path'].'/')):
    //             mkdir($config['upload_path'],0777,TRUE);
    //         endif;
    //         $config['overwrite'] = FALSE;
    //         $config['allowed_types'] = '*';
    //         $config['max_size'] = '3072';
    //         $config['maintain_ratio'] = TRUE;  
    //         $config['quality'] = '50%';  
    //         $config['width'] = 200;  
    //         $this->load->library('upload', $config);

    //          // If upload failed, display error
    //         if (!$this->upload->do_upload()) {
    //             $data['error'] = $this->upload->display_errors();
    //             //print_r($data);
    //           echo $config['upload_path'].'/';
    //             //$this->load->view('csvindex', $data);
    //         } else {
    //             $file_data = $this->upload->data();

    //             //print_r($file_data);
    //             $ext = $file_data['file_ext'];
    //             $link = $config['upload_path'].'/'.$file;
    //             if($this->p_model->savePaymentReceipt(base64_decode($st_id),$link, $file_data['file_name'], $paymentCenter, $paymentRemarks, $school_year, $semester)):
    //                 echo 'Thank you for uploading. We will just notify you once your payment is confirm.';
    //                 if($this->session->department==4):
    //                     $student = $this->p_model->getStudentDetails(base64_decode($st_id), $semester, $school_year);
    //                 else:
    //                     $student = $this->p_model->getStudentDetailsBasicEd(base64_decode($st_id), $semester, $school_year);
    //                 endif;

    //                 $remarks = $student->firstname.' '.$student->lastname.' has uploaded a payment receipt to the system';
    //                 Modules::run('notification_system/systemNotification', 5, $remarks);
    //             endif;
    //         }

    // }

    public function getPadalaCenters($school_year)
    {
        return $this->p_model->getPadalaCenters($school_year);
    }

    function getFinanceAccounts()
    {
        $children = explode(',', $this->session->child_links);
        $child = [];
        $fin_sum = [];
        foreach ($children as $ch):
            if ($ch != ''):
                $isEnrolled = Modules::run('registrar/isEnrolled', $ch, $this->session->school_year);
                $school_year = $isEnrolled ? $this->session->userdata('school_year') : $this->session->userdata('school_year') - 1;
                $student = Modules::run('registrar/getSingleStudent', $ch, $school_year);

                $gt = $this->financeAmountDue($student);

                $plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0, $student->st_type, $student->school_year);

                $child[] = [
                    'collapseId' => 'details-' . $student->st_id,
                    'gender' => $student->sex,
                    'avatar' => $student->avatar,
                    'name' => strtoupper($student->firstname . " " . $student->lastname),
                    'level' => $student->level . ' - ' . $student->section,
                    'stid' => $student->st_id,
                    'finance_summary' => $fin_sum,
                    'finance_transaction' => $gt['history'],
                    'plan_title' => $plan->plan_title,
                    'total' => $gt['total_charges'],
                    'balance' => $gt['balance'],
                    'total_paid' => number_format($gt['total_paid'], 2),
                    'amount_due' => $gt['due']
                ];
            endif;
        endforeach;

        $data['child'] = $child;
        $data['login_page'] = 'parentsEntrance';
        $data['headerTitle'] = 'Finance Account';
        $data['child_links'] = $this->session->child_links;
        $data['main_content'] = 'parent/financeRecords';
        $data['modules'] = 'opl';
        echo Modules::run('templates/opl_content', $data);
    }

    function requestEntry()
    {
        $uname = $this->post('u');
        $pass = $this->post('p');

        $request = $this->p_model->requestEntry($uname);

        $isVerified = $this->checkCredentials($uname, $pass);

        if ($isVerified):
            $parentDetails = $this->p_model->parentDetails($request->parent_id);
            $this->setParentData($parentDetails);
            echo json_encode(array('url' => 'opl/p/dashboard', 'status' => true, 'msg' => 'Access Granted'));
        else:
            echo json_encode(array('url' => 'entrance', 'status' => false, 'msg' => 'Access Denied'));
        endif;
    }

    function verify()
    {
        $this->form_validation->set_rules('u', 'Username',  'trim|required');
        $this->form_validation->set_rules('p', 'Password',  'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $user = $this->input->post('u');
            $pass = md5($this->input->post('p'));
            $request = $this->p_model->requestEntry($user);

            $query = $this->p_model->getInside($user, $pass);
            //echo $user;
            //print_r($query);
            $isValidated = $this->checkCredentials($user, $pass);

            if ($query->isActive):
                if ($isValidated):
                    $parentDetails = $this->p_model->parentDetails($request->parent_id);
                    $this->setParentData($parentDetails);
                    echo json_encode(array('url' => 'opl/p/dashboard', 'status' => true, 'msg' => 'Access Granted'));
                else:
                    echo json_encode(array('url' => 'entrance', 'status' => false, 'msg' => 'Access Denied'));
                endif;
            else:
?>
                <script type="text/javascript">
                    alert('Sorry Your account needs to be Activated');
                    document.location = '<?php echo base_url('login/logout') ?>';
                </script>
<?php

            endif;
        }
    }

    function setUserData($user)
    {
        //get first the usertype which handle by hr module
        $term = Modules::run('main/getCurrentQuarter');
        $settings = Modules::run('main/getSet');
        $position_id = "";
        $position = "";
        $is_admin = FALSE;
        $is_superAdmin = FALSE;
        $is_adviser = FALSE;
        $employee_id = '';
        $rfid = '';
        $advisory = 0;
        $section_id = "";
        $grade_id = "";
        $siblings = "";
        $is_parent = FALSE;
        $parent_id = "";
        $uType = Modules::run('users/getUserType', $user);
        $uType_id = $uType->utype;
        $parent = $uType->if_p;

        if ($parent) {
            $is_parent = TRUE;
        }

        if ($is_parent) {
            $position = 'Parent';
            $position_id = 4;
            $parent = Modules::run('users/getParentData', $user);
            if ($parent->firstname != ""):
                $name = $parent->firstname;
            else:
                $name = $parent->m_name;
            endif;
            $siblings = $parent->child_links;
            $parent_id = $parent->pid;
            $user_id = $uType->u_id;
        } else {

            if ($uType_id != 4) { //if user type != to student
                $getPosition = Modules::run('users/getPositionInfo', $user);
                $position_id = $getPosition->p_id;
                $m_access = Modules::run('nav/getMenuByPosition', $position_id);
                $position = $getPosition->post;
                $basicInfo = Modules::run('users/getBasicInfo', $user);
                $name = $basicInfo->firstname . ' ' . substr($basicInfo->middlename, 0, 1) . '. ' . $basicInfo->lastname;
                $user_id = $basicInfo->user_id;
                $employee_id = $basicInfo->employee_id;
                $rfid = $basicInfo->rfid;
                $getAdvisory = Modules::run('academic/getAdvisory', $user, $settings->school_year);
                if ($getAdvisory->num_rows() > 0):
                    $is_adviser = TRUE;
                    $advisory = $getAdvisory->row()->section_id;
                endif;
            } else {
            }
            $admin = Modules::run('hr/ifDepartmentHead', $user, $uType_id);
            if ($admin) {
                $is_admin = true;
            }

            if ($position_id >= 38 || $position_id <= 44):
                $is_admin = TRUE;
            endif;

            if ($uType_id == 1) {
                $is_superAdmin = true;
                $is_admin = true;
            }
            if ($position == 'Faculty' || $position == 'Part-Time Faculty'):
                $is_admin = FALSE;
            endif;
        }



        if ($settings->att_check == 1) {
            $attend_auto = TRUE;
        } else {
            $attend_auto = FALSE;
        }


        $data = array(
            'is_logged_in'  => TRUE,
            'username'      => $user,
            'rfid'          => $rfid,
            'user_id'       => $user_id,
            'employee_id'   => $employee_id,
            'basicInfo'     => $basicInfo,
            'usertype'      => $uType_id,
            'position'      => $position,
            'position_id'   => $position_id,
            'is_superAdmin' => $is_superAdmin,
            'is_admin'      => $is_admin,
            'dept_id'       => $uType_id,
            'is_adviser'    => $is_adviser,
            'advisory'      => $advisory,
            'name'          => $name,
            'siblings'      => $siblings,
            'parent_id'     => $parent_id,
            'term'          => $term,
            'attend_auto'   => $attend_auto,
            'school_year'   => $settings->school_year,
            'menu_access'   => $m_access->menu_access

        );
        $this->session->set_userdata($data);
    }

    function checkCredentials($user, $pass)
    {
        $query = $this->p_model->getInside($user, $pass);
        if ($query) {
            $this->setUserData($user);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function classBulletin($gradeLevel, $section_id, $school_year)
    {
        $data['school_year'] = $school_year;
        $data['sectionDetails'] = Modules::run('opl/opl_variables/getSectionDetails', $gradeLevel, $section_id, $school_year);
        $data['headerTitle'] = $data['sectionDetails']->level . ' - ' . $data['sectionDetails']->section;
        $data['main_content'] = 'parent/subjectDashboard';
        $data['login_page'] = 'parentsEntrance';
        $data['modules'] = 'opl';
        echo Modules::run('templates/opl_content', $data);
    }

    function getSingleStudent($st_id, $school_year = NULL, $sem = NULL)
    {
        $student = $this->p_model->getBasicStudent($st_id, $school_year, $semester);
        return $student;
    }

    function myChildren()
    {
        $this->load->view('parent/widgets/student');
    }

    public function getPost()
    {
        $postDetails = $this->opl_model->getPost(null, null, null, null, null);
        return $postDetails;
    }

    function dashboard()
    {
        $settings = Modules::run('main/getSet');
        $start = new DateTime($settings->bosy);
        $end = new DateTime();
        $end->setTime(0, 0, 0);
        $interval = new DateInterval('P1D');

        $period = new DatePeriod($start, $interval, $end->modify('+1 day'));

        $kids = explode(',', $this->session->basicInfo->child_links);
        $students = [];
        $month2date = date("n");
        if ($month2date > date('n', strtotime($settings->bosy))) {
            $sch_month = $month2date - date('n', strtotime($settings->bosy));
        } elseif ($month2date < date('n', strtotime($settings->bosy))) {
            $sch_month = $month2date + (12 - date('n', strtotime($settings->bosy)));
        } else {
            $sch_month = 0;
        }

        foreach ($kids as $k):
            if ($k != ''):
                $weekdays = 0;
                $pdays = 0;
                $pending = 0;
                $completed = 0;
                $isMonthly = [];
                $otherList = [];
                $total = 0;
                foreach ($period as $date):
                    if ($date->format('N') < 6):
                        $tday = 1;
                        $m = $date->format('m');
                        $y = $date->format('Y');
                        $d = $date->format('d');
                        $isHoliday = Modules::run('calendar/dateExist', $date->format('Y-m-d'));
                        $t = Modules::run('attendance/ifPresent', $k, $d, $m, $y, $this->session->details->school_year);
                        if ($t):
                            $pdays++;
                        endif;
                        $weekdays += ($tday - ($isHoliday ? 1 : 0));
                    endif;
                endforeach;

                $att_percent = round(($pdays / $weekdays) * 100);

                $tlist = [];
                $activities = [];

                $s = Modules::run('opl/p/getSingleStudent', $k, $this->session->school_year);

                $gt = $this->financeAmountDue($s);

                $subList = [];
                $subjects = $this->p_model->getSubjectList($s->grade_id, $this->session->details->school_year);
                foreach ($subjects as $j):
                    $st = $this->p_model->getSubjectTeacher($s->grade_id, $j->subject_id);
                    $first = (Modules::run('gradingsystem/getFinalGrade', $k, $j->subject_id, 1, $this->session->details->school_year))->row()->final_rating;
                    $second = (Modules::run('gradingsystem/getFinalGrade', $k, $j->subject_id, 2, $this->session->details->school_year))->row()->final_rating;
                    $third = (Modules::run('gradingsystem/getFinalGrade', $k, $j->subject_id, 3, $this->session->details->school_year))->row()->final_rating;
                    $fourth = (Modules::run('gradingsystem/getFinalGrade', $k, $j->subject_id, 4, $this->session->details->school_year))->row()->final_rating;
                    $task_list = $this->opl_model->getTask($s->grade_id, $s->section_id, $j->subject_id, $this->session->details->school_year, 1);

                    foreach ($task_list as $tl):
                        $isSubmitted = Modules::run('opl/opl_variables/getSubmittedTask', $tl->task_code, $this->session->details->school_year, $k);
                        if ($isSubmitted->row()):
                            $completed++;
                        else:
                            $pending++;
                        endif;
                        $tlist[] = [
                            'task_code' => $tl->task_code,
                            'task_title' => $tl->task_title,
                            'due_date'  => $tl->task_end_time,
                            'link'      => base_url() . 'opl/viewTaskDetails/' . $tl->task_code . '/' . $s->grade_id . '/' . $s->section_id . '/' . $j->subject_id . '/' . $this->session->details->school_year,
                            'status' => ($isSubmitted->row() ? 'Completed' : 'Pending'),
                            'dateTime' => ($isSubmitted->row() ? $isSubmitted->row()->ts_date_submitted : ''),
                            'description' => ($isSubmitted->row() ? 'Submitted ' . $isSubmitted->row()->task_title . ' ' . $isSubmitted->row()->tt_type . ' on ' . $j->subject : '')
                        ];
                    endforeach;
                    $subList[] = "'" . $j->subject . "'";

                    $q1[] = ($first != '' || $first != 0 ? $first : 0);
                    $q2[] = ($second != '' || $second != 0 ? $second : 0);
                    $q3[] = ($third != '' || $third != 0 ? $third : 0);
                    $q4[] = ($fourth != '' || $fourth != 0 ? $fourth : 0);
                endforeach;
                $students[] = [
                    'avatar' =>  $s->avatar,
                    'gender' => $s->sex,
                    'name' => ucwords(strtolower($s->firstname . ' ' . $s->lastname)),
                    'level_section' => $s->level . ' - ' . $s->section,
                    'sid' => $s->st_id,
                    'subjectList'   => implode(',', $subList),
                    'first'         => implode(',', $q1),
                    'second'        => implode(',', $q2),
                    'third'         => implode(',', $q3),
                    'fourth'        => implode(',', $q4),
                    'att_percent' => $att_percent,
                    'totalDays'     => $weekdays,
                    'totalPresent'  => $pdays,
                    'tasks' => $tlist,
                    'pending' => $pending,
                    'completed' => $completed,
                    'amt_due' => $gt['due']
                ];
            endif;
        endforeach;

        $data = array(
            'grade_level' => '',
            'section_id' => '',
            'subject_id' => '',
            'total_kids' => count($kids),
            'subjectDetails' => [],
            'students' => $students,
            'post' => $this->getPost(),
            'isClass' => FALSE,
            'title' => 'Parent Dashboard',
            'headerTitle' => 'Parent Dashboard - School Bulletin',
            'login_page' => 'parentsEntrance',
            'main_header' => '',
            'main_content' => 'parent/default',
            'modules' => 'opl',
        );

        echo Modules::run('templates/opl_content', $data);
    }

    function financeAmountDue($s)
    {
        $settings = Modules::run('main/getSet');
        $month2date = date("n");
        $start = date('n', strtotime($settings->bosy));
        if ($month2date > date('n', strtotime($settings->bosy))) {
            $sch_month = $month2date - date('n', strtotime($settings->bosy));
        } elseif ($month2date < date('n', strtotime($settings->bosy))) {
            $sch_month = $month2date + (12 - date('n', strtotime($settings->bosy)));
        } else {
            $sch_month = 0;
        }

        if ($month2date < $start):
            $month2date += 12;
        endif;

        $remMonth = 9 - (($month2date - 1) - $start);
        $remMonth = ($remMonth < 0 ? 0 : $remMonth);
        //---------------------- Finance Charges -------------------------------------//
        // Get finance plan for this student
        $plan = Modules::run('finance/getPlanByCourse', $s->grade_id, 0, $s->st_type, $s->school_year);

        // If a plan exists, load charges; otherwise no charges
        $charges = $plan->fin_plan_id != ''
            ? Modules::run('finance/financeChargesByPlan', 0, $this->session->school_year, 0, $plan->fin_plan_id)
            : [];

        // Arrays to separate monthly vs one-time charges
        $isMonthly = [];   // recurring/monthly charges
        $otherList = [];   // one-time charges
        $total     = 0;    // total charges

        // Split charges into monthly and one-time
        foreach ($charges as $c) {
            if ($c->payment_term != 0) {
                $isMonthly[] = [$c->item_id, $c->item_description, $c->amount, $c->total_month];
            } else {
                $otherList[] = [$c->item_id, $c->item_description, $c->amount];
            }
            $total += $c->amount; // accumulate total charges
        }

        // Load transactions (payments, discounts, etc.)
        $transaction   = Modules::run('college/finance/getTransaction', $s->uid, 0, $s->school_year);

        // Load extra finance charges (misc fees not in plan)
        $extraCharges  = Modules::run('finance/getExtraFinanceCharges', $s->user_id, 0, $s->school_year);

        //-------------------------------- LOOKUPS -----------------------------------//
        // Build lookup for transactions by item_id (used for one-time charges)
        $transactionsByItem = [];
        foreach ($transaction->result() as $tr) {
            $transactionsByItem[$tr->item_id][] = $tr;
        }

        //-------------------- Monthly Payments vs Discounts -------------------------//
        // For each monthly charge, check payments/discounts applied
        $totalIsMonthly = [];
        foreach ($isMonthly as $ol) {
            $monthlyPaid = 0;
            $discounted  = 0;

            // Compare each monthly item against all transactions (old logic kept)
            foreach ($transaction->result() as $tr) {
                if ($ol[0] == $tr->t_charge_id) {
                    if ($tr->t_type == 2) {
                        $discounted += $tr->t_amount;   // type=2 means discount
                    } else {
                        $monthlyPaid += $tr->t_amount; // otherwise regular payment
                    }
                }
            }

            // Store totals for this monthly item
            $totalIsMonthly[] = [$ol[0], $ol[1], $monthlyPaid, $discounted];
        }

        //--------------------------- Extra Charges ----------------------------------//
        // Track extra charges and add them to total
        $listXtra   = [];
        $totalExtra = 0;
        foreach ($extraCharges->result() as $ec) {
            if ($ec->amount != 0) {
                $listXtra[] = [$ec->item_id, $ec->item_description, $ec->amount];
                $totalExtra += $ec->amount;
            }
        }
        $total += $totalExtra; // add to total charges
        $grandTotal = $total;

        //-------------------- Deduct Transactions from Total ------------------------//
        $totalXtraPaid = 0;
        $history = [];
        $totalPaid = 0;
        foreach ($transaction->result() as $tr) {
            $total -= $tr->t_amount; // deduct every transaction (payment/discount)
            $totalPaid += $tr->t_amount;
            $history[] = [
                'date' => $tr->t_date,
                'ref_num' => $tr->ref_number,
                'amount' => $tr->t_amount
            ];

            // If transaction is for an extra charge, track it
            foreach ($listXtra as $lx) {
                if ($lx[0] == $tr->item_id) {
                    $totalXtraPaid += $tr->t_amount;
                }
            }
        }
        $paymentTotal = $total; // net balance after transactions

        //---------------- Monthly Arrears & Balance Calculation ---------------------//
        $listTmonthBal     = []; // remaining monthly balance
        $listTmonthArrears = []; // arrears per monthly item
        $gt = 0;                 // grand total outstanding

        foreach ($isMonthly as $ol) {
            foreach ($totalIsMonthly as $tm) {
                if ($ol[0] == $tm[0]) {
                    $md          = $ol[2] - $tm[3];              // net amount after discount
                    $tMonth      = $md / $ol[3];                 // per-month installment
                    $tMonthToPay = $tMonth * $sch_month;         // amount due by current month

                    if ($tm[2] < $md) {
                        // If paid is less than expected, compute arrears
                        $monthArrears = ($tMonth * ($sch_month - 1)) - $tm[2];
                        $tMonthBal    = $tMonth + $monthArrears;
                    } else {
                        $monthArrears = 0;
                        $tMonthBal    = 0;
                    }

                    $listTmonthArrears[] = [$ol[0], $ol[1] . ' Arrears', $monthArrears];
                    $listTmonthBal[]     = [$ol[0], $ol[1], ($tMonthBal - $monthArrears)];
                }
            }
        }

        //-------------------- Other One-Time Balances -------------------------------//
        $otherBal = [];
        foreach ($otherList as $ol) {
            $paid = 0;
            if (!empty($transactionsByItem[$ol[0]])) {
                foreach ($transactionsByItem[$ol[0]] as $tr) {
                    $paid += $tr->t_amount;
                }
            }
            $rem = $ol[2] - $paid; // remaining balance
            $otherBal[] = [$ol[0], $rem, $ol[1]];
        }

        //------------------------- Grand Total Balance ------------------------------//
        // Sum arrears
        foreach ($listTmonthArrears as $ol) {
            if ($ol[2] > 0) $gt += $ol[2];
        }
        // Sum other one-time balances
        foreach ($otherBal as $op) {
            if ($op[1] != 0) $gt += $op[1];
        }
        // Add unpaid extra charges
        $xtraBal = $totalExtra - $totalXtraPaid;
        $gt += $xtraBal;
        // Sum monthly balances
        foreach ($listTmonthBal as $ol) {
            if ($ol[2] > 0) $gt += $ol[2];
        }

        $dueAmt = round($paymentTotal / $remMonth);

        $finance = [
            // 'due' => $gt,
            'due' => $dueAmt,
            'total_charges' => $grandTotal,
            'total_paid' => $totalPaid,
            'balance' => $paymentTotal,
            'history' => $history
        ];

        return $finance;
        //---------------------- End of Finance Calculation --------------------------//
    }

    function setParentData($details)
    {
        $data = array(
            'is_logged_in' => TRUE,
            'isParent' => TRUE,
            'username' => $details->uname,
            'user_id' => $details->u_id,
            'basicInfo' => $details,
            'usertype' => 4,
            'father' => $details->f_firstname . ' ' . $details->f_lastname,
            'mother' => $details->m_firstname . ' ' . $details->m_lastname,
            'child_links' => $details->child_links,
            'parent_id' => $details->parent_id,
            'school_year' => $this->eskwela->getSet()->school_year,
            'login_page' => 'parentsEntrance'

        );
        $this->session->set_userdata($data);
        return;
    }

    function verifyOTP()
    {
        $parent_id = $this->post('parent_id');
        $otp = $this->post('otp');
        $parentDetails = $this->p_model->parentDetails($parent_id);
        $db_code = $parentDetails->verify_code;
        //print_r($parentDetails);
        $codeIsVerified = password_verify($otp, $db_code);
        if (!$codeIsVerified):
            echo json_encode(array('url' => 'entrance', 'status' => false, 'msg' => 'Sorry, You have entered a wrong OTP'));
        else:
            $this->setParentData($parentDetails);
            echo json_encode(array('url' => 'opl/p/dashboard', 'status' => true));
        endif;
    }

    function registerParent()
    {
        $details = $this->post('details');
        $u = $this->post('u');
        $p = $this->post('p');

        $pword = password_hash($p, PASSWORD_DEFAULT, ['cost' => 8]);

        $verify_code = $this->eskwela->code();

        $childLinks = '';
        $number = '';
        foreach ($details as $d):
            $childLinks .= $d['st_id'] . ',';
            $number = $d['ice_contact'];
            $parent_id = $d['p_id'];
        endforeach;

        $childIDs = rtrim($childLinks, ',');

        $uaDetails = array(
            'u_id' => $parent_id,
            'uname' => $u,
            'pword' => $pword,
            'utype' => 4,
            'secret_key' => $p,
            'if_p' => 1,
            'child_links' => $childIDs,
            'parent_id' => $parent_id,
            'verify_code' => password_hash($verify_code, PASSWORD_DEFAULT, ['cost' => 8]),
            'contact_num' => $number
        );

        $msg = 'Please enter this verification code to the system : ' . $verify_code;

        // if($this->sendSMS($number, $msg)):
        $result = json_decode($this->p_model->registerParent($uaDetails, $u, $parent_id, $this->eskwela->getSet()->school_year));
        if ($result->status):
            if (count($details) > 1):
                $this->p_model->updateParentId($number, $parent_id, $this->eskwela->getSet()->school_year);
            endif;
            echo json_encode(array('status' => true, 'msg' => $result->msg, 'parent_id' => $parent_id, 'vcode' => $verify_code));

        else:
            echo json_encode(array('status' => false, 'msg' => $result->msg));
        endif;
        // else:
        //     echo json_encode(array('status' => false, 'msg' => 'Something went wrong, Please try again later'));
        // endif;


    }

    function verifyParent($data, $sy = NULL)
    {
        $ifVerified = $this->p_model->getVerified($data, ($sy == NULL ? $this->eskwela->getSet()->school_year : $sy));
        if ($ifVerified->num_rows() > 0):
            $r = 0;
            $acc = [];
            foreach ($ifVerified->result() as $d):
                $q = $this->p_model->checkUserAcc($d->p_id);
                if ($q):
                    $acc = $this->p_model->parentDetails($d->p_id);
                    $r = 1;
                    break;
                endif;
            endforeach;
            if ($r == 1):
                echo json_encode(array('status' => TRUE, 'isReg' => TRUE, 'uAccounts' => $acc, 'details' => $ifVerified->result()));
            else:
                echo json_encode(array('status' => TRUE, 'isReg' => FALSE, 'uAccounts' => null, 'details' => $ifVerified->result()));
            endif;
        else:
            echo json_encode(array('status' => FALSE, 'isReg' => FALSE, 'uAccounts' => null, 'details' => null));
        endif;
    }


    function sendSMS($number, $msg = NULL)
    {
        if ($msg == NULL):
            $msg = $this->post('msg');
        endif;
        $result = json_decode($this->sendConfirmation($number, $msg));
        $try = 0;
        $resultStatus = $result->status;

        while ($resultStatus != 1):
            $try++;
            $result = json_decode($this->sendConfirmation($number, $msg));
            if ($try == 10):
                echo 'Sorry Something went wrong, Please try again later';
                break;

            endif;
            $resultStatus = $result->status;
        endwhile;

        if ($resultStatus):
            return true;
        else:
            return false;
        endif;
    }

    public function sendConfirmation($number = NULL, $msg = NULL)
    {
        $api = Modules::run('main/getSet');

        $message = strtoupper($api->short_name) . ' SMS: ' . urldecode($msg);
        $apicode = $api->apicode;
        $apipass = $api->api_pass;

        $result = $this->eskwela->itexmo($number, $message, $apicode, $apipass);
        if ($result == "") {
            $msg = "No server response";
            $stat = 0;
            $result = $msg;
        } else if ($result == 0) {
            $msg = "Message sent";
            $stat = 1;
            $result = $msg;
        } else {
            $msg = "error encountered";
            $stat = 2;
            $result = $msg;
        }
        return json_encode(array('number' => $number, 'msg' => $msg, 'status' => $stat));
    }

    public function getAcademicRecords()
    {
        $data['settings'] = Modules::run('main/getSet');
        $data['headerTitle'] = 'Academic Records';
        $data['login_page'] = 'parentsEntrance';
        $data['title'] = 'Academic Records';
        $data['main_header'] = '';

        $data['child_links'] = $this->session->child_links;
        $data['modules'] = 'opl';
        switch ($data['settings']->short_name):
            case 'wiserkidz':
                $data['main_content'] = 'parent/' . $data['settings']->short_name . '_academicRecord';
                break;
            default:
                $data['main_content'] = 'parent/academicRecord';
                break;
        endswitch;

        echo Modules::run('templates/opl_content', $data);
    }

    function viewParentDetails()
    {
        $data = array(
            'grade_level' => '',
            'section_id' => '',
            'subject_id' => '',
            'subjectDetails' => [],
            'post' => $this->getPost(),
            'isClass' => FALSE,
            'title' => 'Parent Details',
            'headerTitle' => 'Parent Details - School Bulletin',
            'main_header' => '',
            'main_content' => 'parent/parentsDetails',
            'modules' => 'opl',
        );
        echo Modules::run('templates/opl_content', $data);
    }

    function changePass()
    {
        $pid = $this->input->post('pid');
        $newpass = $this->input->post('newpass');

        return $this->p_model->changePass(base64_decode($pid), $newpass);
    }
}
