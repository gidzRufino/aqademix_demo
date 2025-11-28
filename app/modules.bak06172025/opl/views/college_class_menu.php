
<li class="nav-item">
    <a href="<?php echo base_url('opl/college/classBulletin/'.$subject_id."/".$section_id.'/'.$semester.'/'.$school_year) ?>" class="nav-link">
        <i class="nav-icon fas fa-book"></i>
        <p>
            Class Bulletin
            <!--<span class="badge badge-info right">2</span>-->
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/college/getStudentsPerSubject/'.$school_year.'/'.$section_id.'/'.$semester) ?>" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Class Members
            <!--<span class="badge badge-info right">2</span>-->
        </p>
    </a>
</li>
<li class="nav-header">TASK</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/college/createTask/'.$school_year).'/'.$semester ?>" class="nav-link">
        <i class="nav-icon fas fa-plus-square"></i>
        <p>
            Add Task
            <!--<span class="badge badge-info right">2</span>-->
        </p>
    </a>
</li>
<li class="nav-item">
    <!-- <a href="<?php echo base_url('opl/college/classBulletin/'.$school_year.'/List/'.$subject_id."/".$semester."/".$section_id) ?>" class="nav-link">
        <i class="nav-icon fas fa-tasks"></i>
        Task List<?php echo $semester; ?>
    </a> -->
    <a href="<?php echo base_url('opl/college/taskList/'.$subject_id."/".$section_id."/".$semester."/".$school_year) ?>" class="nav-link">
        <i class="nav-icon fas fa-tasks"></i>
        Task List
    </a>
</li>
<li class="nav-header">Lesson Library</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/college/unitView/'.$school_year.'/Add/'.$semester.'/'.$section_id.'/'.$subject_id) ?>" class="nav-link">
       <i class="nav-icon fas fa-folder"></i>
        Add a Unit
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/college/unitView/'.$school_year.'/List/'.$semester.'/'.$section_id.'/'.$subject_id) ?>" class="nav-link">
        <i class="nav-icon fas fa-bars"></i>
        List of Units
    </a>
</li>

<li class="nav-item">
    <a href="<?php echo base_url('opl/college/newDiscussion/'.$school_year."/".$semester) ?>" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        Add a Discussion
    </a>
</li>

<li class="nav-item">
    <a href="<?php echo base_url('opl/college/discussionBoard/'.$school_year.'/'.$this->session->username.'/'.$section_id.'/'.$subject_id.'/'.$semester) ?>" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
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
<li class="nav-item">
    <a href="<?php echo base_url('opl/createRubric'.'/'.$school_year) ?>" class="nav-link">
        <i class="nav-icon fas fa-calculator"></i>
        Create Rubric
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/rubricList'.'/'.$school_year) ?>" class="nav-link">
        <i class="nav-icon fas fa-calculator"></i>
        Rubric List
    </a>
</li>
