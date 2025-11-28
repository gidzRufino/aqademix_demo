<?php 
if($this->uri->segment(2)!='college'): ?>
<li class="nav-item">
    <a href="<?php echo base_url('opl/classBulletin/'.$this->session->oplSessions['school_year'].'/NULL/'.$this->session->oplSessions['grade_level'].'/'.$this->session->oplSessions['section'].'/'.$this->session->oplSessions['subject_id']) ?>" class="nav-link">
        <i class="nav-icon fas fa-book"></i>
        <p>
            Class Bulletin
            <!--<span class="badge badge-info right">2</span>-->
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/classBulletin/'.$this->session->oplSessions['school_year'].'/Students/'.$this->session->oplSessions['grade_level'].'/'.$this->session->oplSessions['section'].'/'.$this->session->oplSessions['subject_id']) ?>" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Class Members
            <!--<span class="badge badge-info right">2</span>-->
        </p>
    </a>
</li>
<li class="nav-header">MESSAGES</li>
    <li class="nav-item">
        <a onclick="compose()" class="nav-link pointer">
            <i class="nav-icon fas fa-file"></i>
            <p>
                Compose
                <!--<span class="badge badge-info right">2</span>-->
            </p>
        </a>
    </li>
    <li class="nav-item pointer">
        <a class="nav-link" onclick="inbox()">
            <i class="nav-icon fas fa-envelope"></i>
            <p>
                Inbox
                <span class="badge badge-info right"><?php echo $unread ?></span>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php // echo base_url('opl/classBulletin/'.$school_year.'/Students/'.$gradeDetails->grade_id.'/'.$gradeDetails->section_id.'/'.$subjectDetails->subject_id)   ?>" class="nav-link">
            <i class="nav-icon fas fa-envelope"></i>
            <p>
                Sent
                <!--<span class="badge badge-info right">2</span>-->
            </p>
        </a>
    </li>
<li class="nav-header">TASK</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/createTask/'.$this->session->oplSessions['school_year']) ?>" class="nav-link">
        <i class="nav-icon fas fa-plus-square"></i>
        <p>
            Add Task
            <!--<span class="badge badge-info right">2</span>-->
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/classBulletin/'.$this->session->oplSessions['school_year'].'/List/'.$this->session->oplSessions['grade_level'].'/'.$this->session->oplSessions['section'].'/'.$this->session->oplSessions['subject_id'].'/') ?>" class="nav-link">
        <i class="nav-icon fas fa-tasks"></i>
        Task List
    </a>
</li>
<li class="nav-header">Lesson Library</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/unitView/'.$this->session->oplSessions['school_year'].'/Add/'.$this->session->oplSessions['grade_level'].'/'.$this->session->oplSessions['section'].'/'.$this->session->oplSessions['subject_id']) ?>" class="nav-link">
       <i class="nav-icon fas fa-folder"></i>
        Add a Unit
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/unitView/'.$this->session->oplSessions['school_year'].'/List/'.$this->session->oplSessions['grade_level'].'/'.$this->session->oplSessions['section'].'/'.$this->session->oplSessions['subject_id']) ?>" class="nav-link">
        <i class="nav-icon fas fa-bars"></i>
        List of Units
    </a>
</li>

<li class="nav-item">
    <a href="<?php echo base_url('opl/newDiscussion/'.$this->session->oplSessions['school_year']) ?>" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        Add a Discussion
    </a>
</li>

<li class="nav-item">
    <a href="<?php echo base_url('opl/discussionBoard/'.$this->session->oplSessions['school_year'].'/'.$this->session->username.'/'.$this->session->oplSessions['grade_level'].'/'.$this->session->oplSessions['section'].'/'.$this->session->oplSessions['subject_id']) ?>" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        Discussion Board
    </a>
</li>

<li class="nav-header">Questions Bank</li>

<li class="nav-item">
    <a href="<?php echo base_url('opl/qm/create/'.$this->session->oplSessions['school_year']) ?>" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        Create a Quiz
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/qm/questionsList/'.base64_encode($this->session->employee_id).'/'.$this->session->oplSessions['school_year']) ?>" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        Questions Lists
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/createRubric'.'/'.$this->session->oplSessions['school_year']) ?>" class="nav-link">
        <i class="nav-icon fas fa-calculator"></i>
        Create Rubric
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/rubricList'.'/'.$this->session->oplSessions['school_year']) ?>" class="nav-link">
        <i class="nav-icon fas fa-calculator"></i>
        Rubric List
    </a>
</li>
<?php 
else: 
    
    $this->load->view('college_class_menu');

endif;

?>

<script type="text/javascript">

    function compose() {
        var subj_id = '<?php echo $subjectDetails->subject_id ?>';
        var gLevel = '<?php echo $gradeDetails->grade_id ?>';
        var section_id = '<?php echo $gradeDetails->section_id ?>';
        var url = '<?php echo base_url() . 'opl/create_message/' ?>' + gLevel + '/' + section_id + '/' + subj_id;
        document.location = url;
    }

    function inbox() {
        var subj_id = '<?php echo $subjectDetails->subject_id ?>';
        var gLevel = '<?php echo $gradeDetails->grade_id ?>';
        var section_id = '<?php echo $gradeDetails->section_id ?>';
        var eid = '<?php echo base64_encode($this->session->employee_id) ?>';
        var url = '<?php echo base_url() . 'opl/messages/employee_inbox/' ?>' + eid + '/' + subj_id + '/' + gLevel + '/' + section_id;
        document.location = url;
    }
        
    function readMsge(id, isReply, msg_id) {
        var subj_id = '<?php echo $subjectDetails->subject_id ?>';
        var gLevel = '<?php echo $gradeDetails->grade_id ?>';
        var section_id = '<?php echo $gradeDetails->section_id ?>';
        var url = '<?php echo base_url() . 'opl/messages/readMsge/' ?>' + id + '/' + subj_id + '/' + gLevel + '/' + section_id + '/' + isReply + '/' + msg_id;
        document.location = url;
    }
</script>