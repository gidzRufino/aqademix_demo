<?php if($subject_id!=NULL): ?>
<li class="nav-item">
    <a href="<?php echo base_url('opl/college/classBulletin/'.$subject_id.'/'.$section_id.'/'.$semester.'/'.$school_year) ?>" class="nav-link">
        <i class="nav-icon fas fa-university"></i>
        <p>
            Class Bulletin
            <!--<span class="badge badge-info right">2</span>-->
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?php echo base_url('opl/college/myLessons/'.$school_year.'/'.$subject_id.'/'.$section_id) ?>" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        My Lessons
    </a>
</li>
<!--<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        Grade Book
    </a>
</li>-->
<li class="nav-item">
    <a href="<?php echo base_url('opl/college/myTask/'.$school_year.'/'.$subject_id.'/'.$section_id) ?>" class="nav-link">
        <i class="nav-icon fas fa-book"></i>
        My Task
    </a>
</li>
<!--<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-book"></i>
        Assignment Bin
    </a>
</li>-->
<?php endif;

