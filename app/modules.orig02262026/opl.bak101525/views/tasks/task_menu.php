<li class="nav-header">TASK</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/gradeView/'.$gradeDetails->grade_id.'/'.$gradeDetails->section_id.'/'.$subjectDetails->subject_id.'/'.$school_year.'/Add') ?>" class="nav-link">
        <i class="nav-icon fas fa-plus-square"></i>
        <p>
            Add Task
            <!--<span class="badge badge-info right">2</span>-->
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/gradeView/'.$gradeDetails->grade_id.'/'.$gradeDetails->section_id.'/'.$subjectDetails->subject_id.'/'.$school_year.'/List') ?>" class="nav-link">
        <i class="nav-icon fas fa-tasks"></i>
        Task List
    </a>
</li>
<li class="nav-header">Lesson Library</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/unitView/'.$gradeDetails->grade_id.'/'.$gradeDetails->section_id.'/'.$subjectDetails->subject_id.'/'.$school_year.'/Add') ?>" class="nav-link">
       <i class="nav-icon fas fa-folder"></i>
        Add a Unit
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/unitView/'.$gradeDetails->grade_id.'/'.$gradeDetails->section_id.'/'.$subjectDetails->subject_id.'/'.$school_year.'/List') ?>" class="nav-link">
        <i class="nav-icon fas fa-bars"></i>
        List of Units
    </a>
</li>

<li class="nav-item">
    <a href="" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        Add a Chapter
    </a>
</li>

<div id="addTaskWrapper" style="display: none;">
    
</div>
