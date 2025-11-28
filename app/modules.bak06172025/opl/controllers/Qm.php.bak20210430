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

    function updateQuizDetails(){
        $details = array(
            'qi_title'              =>  $this->post('quizTitle'),
            'qi_grade_level_id'     =>  $this->post('quizGrade'),
            'qi_section_id'         =>  $this->post('quizSection'),
            'qi_subject_id'         =>  $this->post('quizSubject')
        );
        if($this->qm_model->updateQuizDetails($this->post('quizID'), $details)):
            echo json_encode(array("success" => 1, "message"=>"Successfully updated Quiz Details"));
        else:
            echo json_encode(array("success" => 0, "message"=>"Something went wrong while trying to update the Quiz Details"));
        endif;
    }

    function index()
    {
    }

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
            echo 'Sorry Something went wrong';
        elseif ($result == 1) :
            echo 'Score was saved successfully';
        else :
            echo 'Score was updated successfully';
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
            'main_content'      => 'qm/quizDetails'
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

    function searchQuestion($search, $teacher_id, $school_year, $page = 0){
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
        $config['total_rows'] = ($totalRows <= 100) ? $totalRows : 50 ;
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

    function searchQuizzes($search, $teacher_id, $school_year, $page = 0){
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
        $config['total_rows'] = ($totalRows <= 100) ? $totalRows : 50 ;
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
        $config['total_rows'] = ($totalRows <= 100) ? $totalRows : 50 ;
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
        $config['total_rows'] = ($totalRows <= 100) ? $totalRows : 50 ;
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

    function questionsList($teachers_id, $school_year = NULL)
    {
        $questionsDetails = array(
            'teacher_id'        => $teachers_id,
            'isClass'           => FALSE,
            'school_year'       => $school_year,
            'grade_level'       => [],
            'subject_id'        => [],
            'gradeDetails'      => [],
            'subjectDetails'    => [],
            'headerTitle'       => 'Questions Bank',
            'main_header'       => '',
            'title'             => 'e-sKwela Online Platform for Learning',
            'modules'           => 'opl',
            'main_content'      => 'qm/questionsList'
        );

        echo Modules::run('templates/opl_content', $questionsDetails);
    }

    function create($school_year)
    {
        $data = array(
            'isClass'           => FALSE,
            'school_year'       => $school_year,
            'grade_level'       => [],
            'subject_id'        => [],
            'gradeDetails'      => [],
            'subjectDetails'    => [],
            'headerTitle'       => 'Create a Quiz ',
            'quiz_type'         => $this->qm_model->getQuizType(),
            'getSubjects'       => Modules::run('opl/opl_widgets/mySubject', $this->session->username, $school_year),
            'main_header'       => '',
            'title'             => 'e-sKwela Online Platform for Learning',
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
        echo $this->eskwela->code();
    }
}
