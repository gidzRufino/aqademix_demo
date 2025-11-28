<?php
$level = $this->session->oplSessions['grade_level'];
$school_year = $this->session->oplSessions['school_year'];
$section = $this->session->oplSessions['section'];
$subject = $this->session->oplSessions['subject_id'];
if ($this->uri->segment(2) != 'college'): ?>
    <li class="nav-item">
        <a href="<?php echo base_url('opl/classBulletin/' . $school_year . '/NULL/' . $level . '/' . $section . '/' . $subject) ?>" class="nav-link <?= ($this->uri->segment(4) == 'NULL' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-book"></i>
            <p>
                Class Bulletin
                <!--<span class="badge badge-info right">2</span>-->
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('opl/classBulletin/' . $school_year . '/Students/' . $level . '/' . $section . '/' . $subject) ?>" class="nav-link <?= ($this->uri->segment(4) == 'Students' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
                Class Members
                <!--<span class="badge badge-info right">2</span>-->
            </p>
        </a>
    </li>
    <li class="nav-header">MESSAGES</li>
    <li class="nav-item">
        <a onclick="compose()" class="nav-link pointer <?= ($this->uri->segment(2) == 'create_message' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-file"></i>
            <p>
                Compose
                <!--<span class="badge badge-info right">2</span>-->
            </p>
        </a>
    </li>
    <li class="nav-item pointer">
        <a class="nav-link <?= ($this->uri->segment(3) == 'employee_inbox' ? 'active' : '') ?>" onclick="inbox()">
            <i class="nav-icon fas fa-envelope"></i>
            <p>
                Inbox
                <span class="badge badge-info right"><?php // echo $unread 
                                                        ?></span>
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php // echo base_url('opl/classBulletin/'.$school_year.'/Students/'.$gradeDetails->grade_id.'/'.$gradeDetails->section_id.'/'.$subjectDetails->subject_id)   
                    ?>" class="nav-link <?= $active ?>">
            <i class="nav-icon fas fa-envelope"></i>
            <p>
                Sent
                <!--<span class="badge badge-info right">2</span>-->
            </p>
        </a>
    </li>
    <li class="nav-header">TASK</li>
    <li class="nav-item">
        <a href="<?php echo base_url('opl/createTask/' . $school_year) ?>" class="nav-link <?= ($this->uri->segment(2) == 'createTask' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-plus-square"></i>
            <p>
                Add Task
                <!--<span class="badge badge-info right">2</span>-->
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('opl/classBulletin/' . $school_year . '/List/' . $level . '/' . $section . '/' . $subject . '/') ?>" class="nav-link <?= ($this->uri->segment(2) == 'classBulletin' && $this->uri->segment(4) == 'List' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-tasks"></i>
            Task List
        </a>
    </li>
    <li class="nav-header">Lesson Library</li>
    <li class="nav-item">
        <a href="<?php echo base_url('opl/unitView/' . $school_year . '/Add/' . $level . '/' . $section . '/' . $subject) ?>" class="nav-link <?= ($this->uri->segment(2) == 'unitView' && $this->uri->segment(4) == 'Add' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-folder"></i>
            Add a Unit
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('opl/unitView/' . $school_year . '/List/' . $level . '/' . $section . '/' . $subject) ?>" class="nav-link <?= ($this->uri->segment(2) == 'unitView' && $this->uri->segment(4) == 'List' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-bars"></i>
            List of Units
        </a>
    </li>

    <li class="nav-item">
        <a href="<?php echo base_url('opl/newDiscussion/' . $school_year) ?>" class="nav-link <?= ($this->uri->segment(2) == 'newDiscussion' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-file"></i>
            Add a Discussion
        </a>
    </li>

    <li class="nav-item">
        <a href="<?php echo base_url('opl/discussionBoard/' . $school_year . '/' . $this->session->username . '/' . $level . '/' . $section . '/' . $subject) ?>" class="nav-link <?= ($this->uri->segment(2) == 'discussionBoard' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-users"></i>
            Discussion Board
        </a>
    </li>

    <li class="nav-header">Questions Bank</li>

    <li class="nav-item">
        <a href="<?php echo base_url('opl/qm/create/' . $school_year . '/' . $level . '/' . $section . '/' . $subject) ?>" class="nav-link <?= ($this->uri->segment(2) == 'qm' && $this->uri->segment(3) == 'create' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-file"></i>
            Quiz Management
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('opl/qm/questionsList/' . base64_encode($this->session->employee_id) . '/' . $school_year  . '/' . $level . '/' . $section . '/' . $subject) ?>" class="nav-link <?= ($this->uri->segment(2) == 'qm' && $this->uri->segment(3) == 'questionsList' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-file"></i>
            Questions Lists
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('opl/createRubric' . '/' . $school_year) ?>" class="nav-link <?= ($this->uri->segment(2) == 'createRubric' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-calculator"></i>
            Create Rubric
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('opl/rubricList' . '/' . $school_year) ?>" class="nav-link <?= ($this->uri->segment(2) == 'rubricList' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-calculator"></i>
            Rubric List
        </a>
    </li>
<?php
else:

    $this->load->view('college_class_menu');

endif;
// print_r($gradeDetails);
?>

<script type="text/javascript">
    function compose() {
        var subj_id = '<?php echo $subject ?>';
        var gLevel = '<?php echo $level ?>';
        var section_id = '<?php echo $section ?>';
        var url = '<?php echo base_url() . 'opl/create_message/' ?>' + gLevel + '/' + section_id + '/' + subj_id;
        document.location = url;
    }
    // $this->session->oplSessions['grade_level'] . '/' . $this->session->oplSessions['section'] . '/' . $this->session->oplSessions['subject_id']
    function inbox() {
        var subj_id = '<?php echo $subject ?>';
        var gLevel = '<?php echo $level ?>';
        var section_id = '<?php echo $section ?>';
        var eid = '<?php echo base64_encode($this->session->employee_id) ?>';
        var url = '<?php echo base_url() . 'opl/messages/employee_inbox/' ?>' + eid + '/' + subj_id + '/' + gLevel + '/' + section_id;
        document.location = url;
    }

    function readMsge(id, isReply, msg_id, uid) {
        // alert(id + ' ' + uid + ' ' + isReply)
        var subj_id = '<?php echo $subjectDetails->subject_id ?>';
        var gLevel = '<?php echo $level ?>';
        var section_id = '<?php echo $section ?>';
        var url = '<?php echo base_url() . 'opl/messages/readMsge/' ?>' + id + '/' + subj_id + '/' + gLevel + '/' + section_id + '/' + isReply + '/' + msg_id + '/' + uid;
        document.location = url;
    }
</script>