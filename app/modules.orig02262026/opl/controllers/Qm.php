<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Qm
 *
 * @author genesisrufino
 */
class Qm extends MX_Controller
{
    //put your code here

    public function __construct()
    {
        parent::__construct();
        $this->load->model('qm_model');
        if (!$this->session->is_logged_in) :
            redirect('login');
        endif;
    }

    private function post($name)
    {
        return $this->input->post($name);
    }

    function updateQuizDetails()
    {
        $details = array(
            'qi_title'              =>  $this->post('quizTitle'),
            'qi_grade_level_id'     =>  $this->post('quizGrade'),
            'qi_section_id'         =>  $this->post('quizSection'),
            'qi_subject_id'         =>  $this->post('quizSubject')
        );
        if ($this->qm_model->updateQuizDetails($this->post('quizID'), $details)):
            echo json_encode(array("success" => 1, "message" => "Successfully updated Quiz Details"));
        else:
            echo json_encode(array("success" => 0, "message" => "Something went wrong while trying to update the Quiz Details"));
        endif;
    }

    function index() {}

    function getAnswerKey($q_code, $school_year)
    {
        $ans = $this->qm_model->checkAnswer($q_code, $school_year);
        return $ans->qq_answer;
    }

    function removeQuizItem()
    {
        $quiz_id = $this->post('quiz_id');
        $quiz_items = $this->post('quiz_items');
        $school_year = $this->post('school_year');

        $qDetails = array(
            'qi_qq_ids' => $quiz_items
        );

        if ($this->qm_model->removeQuizItems($qDetails, $quiz_id, $school_year)) :
            echo 'Successfully Removed';
        else :
            echo 'Something went wrong, Please try again later.';
        endif;
    }

    function saveRawScore()
    {
        $assess_id = $this->post('task_code');
        $st_id = $this->post('st_id');
        $score = $this->post('score');
        $ans_id = $this->post('ans_id');

        $rawScoreDetails = array(
            'raw_id'    => $ans_id,
            'st_id'     => $st_id,
            'raw_score' => $score,
            'assess_id' => $assess_id,
        );
        $result = $this->qm_model->saveRawScore($rawScoreDetails, $assess_id, $st_id, $this->session->school_year);
        if ($result == 0) :
            echo json_encode(array('status' => 'failed', 'message' => 'Sorry Something went wrong'));
        elseif ($result == 1) :
            echo json_encode(array('status' => 'success', 'message' => 'Score was saved successfully'));
        else :
            echo json_encode(array('status' => 'success', 'message' => 'Score was updated successfully'));
        endif;
    }

    function getRawScore($assess_id, $st_id, $school_year)
    {
        return $this->qm_model->getRawScore($assess_id, $st_id, $school_year);
    }

    function checkAnswer($answer, $q_code, $school_year)
    {
        $qm = $this->qm_model->checkAnswer($q_code, $school_year);
        switch ($qm->qq_qt_id):
            case 1:
                $ans = explode("|", $qm->qq_answer);
                foreach ($ans as $an) :
                    if (!strcasecmp(trim(strtolower($answer)), trim(strtolower($an)))) :
                        return TRUE;
                    endif;
                endforeach;
            case 3:
                $ans = trim(strtolower(substr($qm->qq_answer, 0, 1)));
                return !strcasecmp(trim(strtolower($answer)), $ans);
            default:
                $ans = trim(strtolower($qm->qq_answer));
                return !strcasecmp(trim(strtolower($answer)), $ans);
        endswitch;
    }

    function searchAQuiz($value, $school_year)
    {
        $quiz = $this->qm_model->searchAQuiz($value, $school_year);
        echo '<ul>';
        foreach ($quiz as $q) :
?>
            <li style="font-size:18px;" data-dismiss="modal" onclick="$('#searchQuestions').hide(), $('#searchBox').val(&quot;<?php echo $q->qi_title ?>&quot;), $('#quiz_id').val('<?php echo $q->qi_sys_code ?>')"><?php echo $q->qi_title ?></li>
        <?php
        endforeach;
        echo '</ul>';
    }

    function getSingleQuestion($sys_code, $school_year, $quiz_id = NULL)
    {
        $question = $this->qm_model->getSingleQuestion(base64_decode($sys_code), $school_year);
        if ($quiz_id != NULL) :
            $qq_id = $this->qm_model->getQQids($quiz_id);
            if ($qq_id->qi_qq_ids == "") :
                $quizItems = array('qi_qq_ids' => base64_decode($sys_code));
            else :
                $quizItems = array('qi_qq_ids' => $qq_id->qi_qq_ids . ',' . base64_decode($sys_code));
            endif;
            $this->qm_model->updateQuiz($quizItems, $quiz_id);
        endif;

        echo $question->question;
    }

    function searchQuestions($value, $school_year)
    {
        $questions = $this->qm_model->searchQuestions(urldecode($value), $school_year);
        echo '<ul>';
        foreach ($questions as $q) :
        ?>
            <li style="font-size:18px;" data-dismiss="modal" onclick="$('#searchQuestions').hide(), $('#searchBox').val('<?php echo preg_replace('/[^a-zA-Z0-9-_\.]/', $q->plain_question) ?>'), getSingleQuestion('<?php echo base64_encode($q->sys_code) ?>')"><?php echo $q->plain_question ?></li>
            <?php
        endforeach;
        echo '</ul>';
    }

    function getQuestionItems($itemCode, $school_year)
    {
        $questionItems = $this->qm_model->getQuestionItems($itemCode, $school_year);
        return $questionItems;
    }

    function getQuizDetails($quizCode, $school_year)
    {
        return $this->qm_model->getQuizDetails($quizCode, $school_year);
    }

    function quizDetails($quizCode, $school_year)
    {
        $questionsDetails = array(
            'isClass'           => FALSE,
            'quizDetails'       => $this->qm_model->getQuizDetails($quizCode, $school_year),
            'school_year'       => $school_year,
            'grade_level'       => [],
            'subject_id'        => [],
            'gradeDetails'      => [],
            'subjectDetails'    => [],
            'getSubjects'       => Modules::run('opl/opl_widgets/mySubject', $this->session->username, $school_year),
            'quiz_type'         => $this->qm_model->getQuizType(),
            'headerTitle'       => 'Assessment Details',
            'main_header'       => '',
            'title'             => 'e-sKwela Online Platform for Learning',
            'modules'           => 'opl',
            'main_content'      => 'qm/quizDetails',
            'login_page' => 'login/logout'
        );

        echo Modules::run('templates/opl_content', $questionsDetails);
    }

    function deleteQuiz()
    {
        $quizCode = $this->post('quizCode');
        $school_year = $this->post('school_year');

        if ($this->qm_model->deleteQuiz($quizCode, $school_year)) :
            echo 'Successfully Deleted';
        else :
            echo 'Something went wrong, please try again later or contact support@thecsscore.com';
        endif;
    }

    function searchQuestion($search, $teacher_id, $school_year, $page = 0)
    {
        $search = base64_decode($search);
        $teacher_id = base64_decode($teacher_id);
        $limit = 10;
        $data['page'] = $page;

        if ($page != 0) :
            $page = $page - 1;
            $data['page'] = $page;
            $page = $page * $limit;
        endif;

        $questions = $this->qm_model->searchQuestion($search, $teacher_id, $school_year);

        $totalRows = $questions->num_rows();

        $this->load->library('pagination');

        $config['base_url'] = base_url('opl/qm/searchQuestion/' . base64_encode($search) . '/' . base64_encode($teacher_id) . '/' . $school_year . '/' . $page);
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = ($totalRows <= 100) ? $totalRows : 50;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;

        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link bg-dark border-0">';
        $config['cur_tag_close']    = '<span class="sr-only bg-gray border-0" style="cursor: pointer;">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['last_tag_close']  = '</span></li>';

        $this->pagination->initialize($config);

        $paginate = $this->pagination->create_links();

        $data['pagination'] = $paginate;
        $fin['paginate'] = $paginate;

        $data['questions'] = $this->qm_model->searchQuestion($search, $teacher_id, $school_year, $limit, $page)->result();
        $data['limit'] = $limit;
        $data['school_year'] = $school_year;
        $fin['questions'] = $this->load->view('qm/questionRows', $data, TRUE);

        echo json_encode($fin);
    }

    function searchQuizzes($search, $teacher_id, $school_year, $page = 0)
    {
        $search = base64_decode($search);
        $teacher_id = base64_decode($teacher_id);
        $limit = 10;
        $data['page'] = $page;

        if ($page != 0) :
            $page = $page - 1;
            $data['page'] = $page;
            $page = $page * $limit;
        endif;

        $quizes = $this->qm_model->searchQuizzes($search, $teacher_id, $school_year);

        $totalRows = $quizes->num_rows();

        $this->load->library('pagination');

        $config['base_url'] = base_url('opl/qm/searchQuizzes/' . base64_encode($search) . '/' . base64_encode($teacher_id) . '/' . $school_year . '/' . $page);
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = ($totalRows <= 100) ? $totalRows : 50;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;

        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link bg-dark border-0">';
        $config['cur_tag_close']    = '<span class="sr-only bg-gray border-0" style="cursor: pointer;">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['last_tag_close']  = '</span></li>';

        $this->pagination->initialize($config);

        $paginate = $this->pagination->create_links();

        $data['pagination'] = $paginate;
        $fin['paginate'] = $paginate;

        $data['quizes'] = $this->qm_model->searchQuizzes($search, $teacher_id, $school_year, $limit, $page)->result();
        $data['limit'] = $limit;
        $data['school_year'] = $school_year;
        $fin['quiz'] = $this->load->view('qm/quizRows', $data, TRUE);

        echo json_encode($fin);
    }

    function getAllQuizzes($teacher_id, $school_year, $page = 0)
    {
        $teacher_id = base64_decode($teacher_id);
        $limit = 10;
        $data['page'] = $page;

        if ($page != 0) :
            $page = $page - 1;
            $data['page'] = $page;
            $page = $page * $limit;
        endif;

        $quizes = $this->qm_model->getAllQuizzes($teacher_id, $school_year);

        $totalRows = $quizes->num_rows();

        $this->load->library('pagination');

        $config['base_url'] = base_url('opl/qm/getAllQuizzes/' . base64_encode($teacher_id) . '/' . $school_year . '/' . $page);
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = ($totalRows <= 100) ? $totalRows : 50;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;

        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link bg-dark border-0">';
        $config['cur_tag_close']    = '<span class="sr-only bg-gray border-0" style="cursor: pointer;">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['last_tag_close']  = '</span></li>';

        $this->pagination->initialize($config);

        $paginate = $this->pagination->create_links();

        $data['pagination'] = $paginate;
        $fin['paginate'] = $paginate;

        $data['quizes'] = $this->qm_model->getAllQuizzes($teacher_id, $school_year, $limit, $page)->result();
        $data['limit'] = $limit;
        $data['school_year'] = $school_year;
        $fin['quiz'] = $this->load->view('qm/quizRows', $data, TRUE);

        echo json_encode($fin);
    }

    function getAllQuestions($teacher_id, $school_year, $page = 0)
    {
        $teacher_id = base64_decode($teacher_id);
        $limit = 10;
        $data['page'] = $page;

        if ($page != 0) :
            $page = $page - 1;
            $data['page'] = $page;
            $page = $page * $limit;
        endif;

        $questions = $this->qm_model->questionsList($teacher_id, $school_year);

        $totalRows = $questions->num_rows();

        $this->load->library('pagination');

        $config['base_url'] = base_url('opl/qm/getAllQuestions/' . base64_encode($teacher_id) . '/' . $school_year . '/' . $page);
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = ($totalRows <= 100) ? $totalRows : 50;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;

        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link bg-dark border-0">';
        $config['cur_tag_close']    = '<span class="sr-only bg-gray border-0" style="cursor: pointer;">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link bg-gray border-0" style="cursor: pointer;">';
        $config['last_tag_close']  = '</span></li>';

        $this->pagination->initialize($config);

        $paginate = $this->pagination->create_links();

        $data['pagination'] = $paginate;
        $fin['paginate'] = $paginate;

        $data['questions'] = $this->qm_model->questionsList($teacher_id, $school_year, $limit, $page)->result();
        $data['limit'] = $limit;
        $data['school_year'] = $school_year;
        $fin['questions'] = $this->load->view('qm/questionRows', $data, TRUE);

        echo json_encode($fin);
    }


    function deleteQuestion()
    {
        $school_year = $this->post('school_year');
        if ($this->qm_model->deleteQuestion($this->post('sys_code'), $school_year)) :
            echo 'Successfully Deleted';
        else :
            echo 'Something went wrong, please try again later or contact support@thecsscore.com';
        endif;
    }

    function questionsList($teachers_id, $school_year = NULL, $grade_id, $section_id, $subject)
    {
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $grade_id, $section_id, $subject, $this->session->school_year));
        $questionsDetails = array(
            'teacher_id'        => $teachers_id,
            'isClass'           => FALSE,
            'school_year'       => $school_year,
            'grade_level'       => $grade_id,
            'subject_id'        => $subject,
            'section_id'        => $section_id,
            'gradeDetails'      => [],
            'subjectDetails'    => [],
            'headerTitle'       => 'Questions List | <small style="font-size: medium">' . $classDetails->subjectDetails->subject . ' - ' . $classDetails->basicInfo->level . ' [ ' . $classDetails->basicInfo->section . ' ]</small>',
            'main_header'       => '',
            'title'             => 'e-sKwela Online Platform for Learning',
            'login_page' => 'login/logout',
            'modules'           => 'opl',
            'main_content'      => 'qm/questionsList'
        );

        echo Modules::run('templates/opl_content', $questionsDetails);
    }

    function getAllQuestionsLevelSubj($grade_id, $subject_id)
    {
        return $this->qm_model->getAllQuestionsLevelSubj($grade_id, $subject_id);
    }

    function listQuestions($grade_id, $subject_id)
    {
        $qlist = $this->getAllQuestionsLevelSubj($grade_id, $subject_id);
        if ($qlist->num_rows() > 0):
            $q = 1;
            foreach ($qlist->result() as $s):
            ?>
                <tr>
                    <td><?= $q++ ?></td>
                    <td><?= $s->question_text ?></td>
                    <td><?= $s->question_type ?></td>
                    <td class="text-center">
                        <button
                            class="btn btn-sm btn-outline-warning"
                            onclick='viewQuestionDetails(<?= json_encode($s) ?>)'>
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-primary"
                            onclick='editQuestion(<?= json_encode($s) ?>)'>
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger"
                            onclick='deleteQuestion("<?= base64_encode($s->id) ?>")'>
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="4">No questions yet</td>
            </tr>
<?php
        endif;
    }

    function create($school_year, $grade_id, $section_id, $subject_id)
    {
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $grade_id, $section_id, $subject_id, $school_year));
        $data = array(
            'isClass'           => FALSE,
            'school_year'       => $school_year,
            'grade_level'       => $grade_id,
            'subject_id'        => $subject_id,
            'section_id'        => $section_id,
            'gradeDetails'      => [],
            'subjectDetails'    => $classDetails->subjectDetails,
            'headerTitle'       => 'Quiz Management | <small style="font-size: medium">' . $classDetails->subjectDetails->subject . ' - ' . $classDetails->basicInfo->level . ' [ ' . $classDetails->basicInfo->section . ' ]</small>',
            'quiz_type'         => $this->qm_model->getQuizType(),
            'getSubjects'       => Modules::run('opl/opl_widgets/mySubject', $this->session->username, $school_year),
            'main_header'       => '',
            'title'             => 'Aqademix Online Platform for Learning',
            'login_page' => 'login/logout',
            'modules'           => 'opl',
            'main_content'      => 'qm/create'
        );

        echo Modules::run('templates/opl_content', $data);
    }

    function createQuiz()
    {
        $quizSystemCode = $this->eskwela->codeCheck('opl_qm_quiz_items', 'qi_sys_code', $this->eskwela->code());

        $subGradSec = explode('-', $this->post('subGradeSec'));
        $quizItems = array(
            'qi_grade_level_id'  => $subGradSec[1],
            'qi_section_id'      => $subGradSec[2],
            'qi_qq_ids'          => '',
            'qi_date_created'    => date('Y-m-d g:i:s'),
            'qi_created_by'      => $this->session->username,
            //            'qi_date_activation' => $this->post('startDate'),
            //            'qi_date_expired'    => $this->post('endDate'),
            'qi_title'           => $this->post('quizTitle'),
            'qi_sys_code'        => $quizSystemCode
        );
        if ($this->qm_model->addQuiz($quizItems)) :
            echo json_encode(array('quiz_code' => $quizSystemCode));
        endif;
    }

    function addQuestions()
    {
        $sysCode = $this->post('q_code');
        $subGradSec = explode('-', $this->post('subGradeSec'));
        $details = array(
            'question'          => $this->post('question'),
            'plain_question'    => $this->post('plain_q'),
            'qq_answer'         => $this->post('answer'),
            'qq_qt_id'          => $this->post('qtype'),
            'created_by'        => $this->session->username,
            'sys_code'          => $sysCode,
            'qq_grade_level_id' => $subGradSec[1]
        );

        if ($this->qm_model->addQuestions($details)) :
            if ($this->post('quizTitle') != "") :
                if ($this->post('quiz_id') == 0) :
                    $quizSystemCode = $this->eskwela->codeCheck('opl_qm_quiz_items', 'qi_sys_code', $this->eskwela->code());

                    $quizItems = array(
                        'sys_code'           => $quizSystemCode,
                        'qi_grade_level_id'  => $subGradSec[1],
                        'qi_section_id'      => $subGradSec[2],
                        'qi_qq_ids'          => $sysCode,
                        'qi_date_created'    => date('Y-m-d g:i:s'),
                        'qi_created_by'      => $this->session->username,
                        'qi_date_activation' => $this->post('startDate'),
                        'qi_date_expired'    => $this->post('endDate'),
                        'qi_title'           => $this->post('quizTitle'),
                        'qi_sys_code'        => $quizSystemCode
                    );
                    $this->qm_model->addQuiz($quizItems);
                else :
                    $quizSystemCode = $this->post('quiz_id');
                    $qq_id = $this->qm_model->getQQids($quizSystemCode);
                    if ($qq_id->qi_qq_ids == "") :
                        $quizItems = array('qi_qq_ids' => $sysCode);
                    else :
                        $quizItems = array('qi_qq_ids' => $qq_id->qi_qq_ids . ',' . $sysCode);
                    endif;
                    $this->qm_model->updateQuiz($quizItems, $quizSystemCode);
                endif;
            endif;
            echo json_encode(array('sysCode' => $sysCode, 'quizCode' => $quizSystemCode));
        else :
            echo 'Sorry Something went wrong';
        endif;
    }

    function loadCode()
    {
        // echo $this->eskwela->code();
        echo $this->eskwela->codeCheck('opl_qm_qq', 'sys_code', $this->eskwela->code());
    }

    //------------------------------ Save, Update and Delete Question -------------------------------------------------//
    public function save()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('No direct script access allowed', 403);
        }

        $type = $this->input->post('question_type');
        $text = $this->input->post('question_text');
        $grade_id = $this->input->post('grade_id');
        $subject_id = $this->input->post('subject_id');
        $section_id = $this->input->post('section_id');

        $choices = null;
        $correct_answer = '';

        if ($type === 'multiple_choice') {
            $choice_data = [];
            $correct_choices = $this->input->post('correct_choices'); // Array of indexes like [1, 3]

            // Loop over 4 possible choices (choice_1, choice_2, etc.)
            for ($i = 1; $i <= 4; $i++) {
                $choice_text = trim($this->input->post("choice_$i"));
                if ($choice_text !== '') {
                    $is_correct = (!empty($correct_choices) && in_array($i, $correct_choices));
                    $choice_data[] = [
                        'ans' => $choice_text,
                        'is_correct' => $is_correct
                    ];
                }
            }

            // Extract correct answers for clarity (optional)
            $correct_answer_arr = array_column(
                array_filter($choice_data, fn($c) => $c['is_correct']),
                'ans'
            );

            $choices = json_encode($choice_data);
            $correct_answer = json_encode($correct_answer_arr);
        } else {
            $correct_answer = $this->input->post('correct_answer');
        }

        $data = [
            'question_type' => $type,
            'question_text' => $text,
            'choices' => $choices,
            'correct_answer' => $correct_answer,
            'grade_id' => $grade_id,
            'subject_id' => $subject_id,
            'section_id' => $section_id
        ];

        $q = $this->qm_model->saveQuestion($data);

        $response = [
            'status' => ($q ? 'success' : 'error'),
            'message' => ($q ? 'Question saved successfully!' : 'An error occurred'),
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        ];

        echo json_encode($response);
    }

    public function update()
    {
        $id = $this->input->post('question_id');
        $data = [
            'question_type' => $this->input->post('question_type'),
            'question_text' => $this->input->post('question_text'),
        ];

        if ($data['question_type'] == 'multiple_choice') {
            $choices = [];
            for ($i = 0; $i < 4; $i++) {
                $choices[] = [
                    'ans' => $this->input->post("choice_$i"),
                    'is_correct' => in_array($i, $this->input->post('correct_choices') ?? [])
                ];
            }
            $data['choices'] = json_encode($choices);
        } else {
            $data['correct_answer'] = $this->input->post('correct_answer');
        }

        $update = $this->qm_model->updateQuestion($data, $id);

        echo json_encode([
            'success' => $update,
            'message' => $update ? 'Updated successfully' : 'Failed to update question'
        ]);
    }

    public function delete($id)
    {
        // $id = base64_decode($id);
        $this->output->set_content_type('application/json');

        // Security: verify CSRF if using CodeIgniter 3
        if ($this->input->method() !== 'post') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $deleted = $this->qm_model->removeQuestion($id);

        $response = [
            'success' => $deleted,
            'message' => $deleted ? 'Question deleted successfully.' : 'Failed to delete question.',
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        ];

        echo json_encode($response);
    }

    function removeQuiz($id, $link, $name, $qtitle, $user_id)
    {
        $q = $this->qm_model->removeQuiz($id, $link);
        if ($q):
            Modules::run('main/logActivity', 'LMS', urldecode($name) . ' deleted a quiz entitled "' . $qtitle . '"', $user_id);
            echo json_encode(array('status' => true, 'msg' => 'Quiz deleted Successfuly'));
        else:
            echo json_encode(array('status' => false, 'msg' => 'An error occured'));
        endif;
    }

    public function listQuestionsAjax()
    {
        $this->output->set_content_type('application/json');

        $limit = (int) $this->input->get('limit') ?: 5;
        $page = (int) $this->input->get('page') ?: 1;
        $offset = ($page - 1) * $limit;

        $type = $this->input->get('type');
        $grade_id = $this->input->get('grade_id');
        $subject_id = $this->input->get('subject_id');
        $keyword = $this->input->get('search');

        // 🔹 Call the model to get data and total count
        $result = $this->qm_model->get_questions($limit, $offset, $type, $grade_id, $subject_id, $keyword);

        $response = [
            'questions' => $result['questions'],
            'total'     => $result['total'],
            'page'      => $page,
            'limit'     => $limit
        ];

        $this->output->set_output(json_encode($response));
    }

    public function save_quiz_json()
    {
        // if (!$this->input->is_ajax_request()) {
        //     show_error('No direct script access allowed', 403);
        // }

        $quizData   = $this->input->post('quizData');
        $user_id    = $this->input->post('user_id');
        $grade_id   = $this->input->post('grade_id');
        $subject_id = $this->input->post('subject_id');
        $section_id = $this->input->post('section_id');

        if (empty($quizData)) {
            echo json_encode(['status' => 'error', 'message' => 'No quiz data received.']);
            return;
        }

        $quizArray = json_decode($quizData, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['status' => 'error', 'message' => 'Malformed JSON: ' . json_last_error_msg()]);
            return;
        }

        if (empty($quizArray['title'])) {
            echo json_encode(['status' => 'error', 'message' => 'Missing quiz title.']);
            return;
        }

        if (empty($quizArray['totalItem'])) {
            echo json_encode(['status' => 'error', 'message' => 'Missing number of Items.']);
            return;
        }

        $uploadDir = 'uploads/faculty/' . $user_id . '/quizzes/' . $grade_id . '/' . $subject_id . '/';
        log_message('debug', 'Upload directory: ' . $uploadDir);

        if (!is_dir($uploadDir)) {
            $created = @mkdir($uploadDir, 0777, true);
            log_message('debug', 'mkdir() result: ' . var_export($created, true));
            if (!$created) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to create uploads directory: ' . $uploadDir
                ]);
                return;
            }
        }

        if (!is_writable($uploadDir)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Upload directory not writable: ' . $uploadDir
            ]);
            return;
        }

        $quizTitle = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $quizArray['title']);
        $filename = ($quizTitle ?: 'quiz') . '_' . date('Ymd_His') . '.json';
        $filePath = $uploadDir . $filename;

        $jsonData = json_encode($quizArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $saved = @file_put_contents($filePath, $jsonData);
        log_message('debug', 'file_put_contents result: ' . var_export($saved, true));

        if ($saved === false) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Unable to save file. Check write permissions for: ' . $uploadDir
            ]);
            return;
        }

        $details = array(
            'grade_id' => $grade_id,
            'subject_id' => $subject_id,
            'section_id' => $section_id,
            'faculty_id' => $this->session->employee_id,
            'quiz_title' => $quizArray['title'],
            'quiz_link' => $filePath,
            'total_items' => $quizArray['totalItem']
        );

        $this->qm_model->saveQuiz($details);

        echo json_encode([
            'status' => 'success',
            'message' => 'Quiz saved successfully!',
            'file' => base_url('uploads/faculty/' . $user_id . '/quizzes/' . $grade_id . '/' . $subject_id . '/' . $filename)
        ]);
    }

    function quizList($grade_id, $subject_id, $faculty)
    {
        $data['quizList'] = $this->qm_model->getQuizList($grade_id, $subject_id, $faculty);
        $this->load->view('qm/quizList', $data);
    }
}
