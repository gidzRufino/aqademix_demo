<li class="nav-item">
    <a href="<?php echo base_url('opl/classBulletin/'.$school_year.'/NULL/'.$gradeDetails->grade_id.'/'.$gradeDetails->section_id.'/'.$subjectDetails->subject_id) ?>" class="nav-link">
        <i class="nav-icon fas fa-book"></i>
        <p>
            Class Bulletin
            <!--<span class="badge badge-info right">2</span>-->
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/classBulletin/'.$school_year.'/Students/'.$gradeDetails->grade_id.'/'.$gradeDetails->section_id.'/'.$subjectDetails->subject_id) ?>" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Class Members
            <!--<span class="badge badge-info right">2</span>-->
        </p>
    </a>
</li>
<li class="nav-header">TASK</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/createTask/'.$school_year) ?>" class="nav-link">
        <i class="nav-icon fas fa-plus-square"></i>
        <p>
            Add Task
            <!--<span class="badge badge-info right">2</span>-->
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/classBulletin/'.$school_year.'/List/'.$gradeDetails->grade_id.'/'.$gradeDetails->section_id.'/'.$subjectDetails->subject_id.'/') ?>" class="nav-link">
        <i class="nav-icon fas fa-tasks"></i>
        Task List
    </a>
</li>
<li class="nav-header">Lesson Library</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/unitView/'.$school_year.'/Add/'.$gradeDetails->grade_id.'/'.$gradeDetails->section_id.'/'.$subjectDetails->subject_id) ?>" class="nav-link">
       <i class="nav-icon fas fa-folder"></i>
        Add a Unit
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/unitView/'.$school_year.'/List/'.$gradeDetails->grade_id.'/'.$gradeDetails->section_id.'/'.$subjectDetails->subject_id) ?>" class="nav-link">
        <i class="nav-icon fas fa-bars"></i>
        List of Units
    </a>
</li>

<li class="nav-item">
    <a href="<?php echo base_url('opl/newDiscussion/'.$school_year) ?>" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        Add a Discussion
    </a>
</li>

<li class="nav-item">
    <a href="<?php echo base_url('opl/discussionBoard/'.$school_year.'/'.$this->session->username.'/'.$gradeDetails->grade_id.'/'.$gradeDetails->section_id.'/'.$subjectDetails->subject_id) ?>" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        Discussion Board
    </a>
</li>

<li class="nav-header">Questions Bank</li>

<li class="nav-item">
    <a href="<?php echo base_url('opl/qm/create/'.$school_year) ?>" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        Create a Quiz
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/qm/questionsList/'.base64_encode($this->session->employee_id).'/'.$school_year) ?>" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        Questions Lists
    </a>
</li>

