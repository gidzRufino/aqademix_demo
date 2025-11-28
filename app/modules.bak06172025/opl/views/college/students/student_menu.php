
<?php if($subjectDetails!=NULL): ?>
<li class="nav-item">
    <a href="<?php echo base_url('opl/student/classBulletin/'.$subjectDetails->subject_id.'/'.$school_year) ?>" class="nav-link">
        <i class="nav-icon fas fa-university"></i>
        <p>
            Class Bulletin
            <!--<span class="badge badge-info right">2</span>-->
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/student/myLessons/'.$school_year.'/'.$subjectDetails->subject_id.'/'.$gradeDetails->grade_id) ?>" class="nav-link">
        <i class="nav-icon fas fa-book"></i>
        My Lessons
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/student/classBulletin/'.$subjectDetails->subject_id.'/'.$school_year.'/List') ?>" class="nav-link">
        <i class="nav-icon fas fa-tasks"></i>
        My Tasks
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        Assignment Bin
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-book"></i>
        Quiz Book
    </a>
</li>
<?php endif;

