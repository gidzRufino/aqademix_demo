<?php if ($subjectDetails != NULL): ?>
    <!-- <a class="<?= ($this->uri->segment(6) == '' ? 'active' : '') ?>" href="<?php echo base_url('opl/student/classBulletin/' . $subjectDetails->subject_id . '/' . $school_year) ?>" class="nav-link">
        <i class="nav-icon fas fa-university"></i> Class Bulletin
    </a>
    <a class="<?= ($this->uri->segment(3) == 'myLessons' ? 'active' : '') ?>" href="<?php echo base_url('opl/student/myLessons/' . $school_year . '/' . $subjectDetails->subject_id . '/' . $gradeDetails->grade_id) ?>" class="nav-link">
        <i class="nav-icon fas fa-book"></i> My Lessons
    </a>
    <a class="<?= ($this->uri->segment(6) == 'List' || $this->uri->segment(2) == 'viewTaskDetails' || $this->uri->segment(3) == 'viewTaskDetails' ? 'active' : '') ?>" href="<?php echo base_url('opl/student/classBulletin/' . $subjectDetails->subject_id . '/' . $school_year . '/List') ?>" class="nav-link">
        <i class="nav-icon fas fa-tasks"></i> My Tasks
    </a> -->
    <li class="nav-item">
        <a href="<?php echo base_url('opl/student/classBulletin/' . $subjectDetails->subject_id . '/' . $school_year)
                    ?>" class="nav-link <?= ($this->uri->segment(6) == '' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-university"></i>
            <p>
                Class Bulletin
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('opl/student/myLessons/' . $school_year . '/' . $subjectDetails->subject_id . '/' . $gradeDetails->grade_id . '/' . $gradeDetails->section_id)
                    ?>" class="nav-link <?= ($this->uri->segment(3) == 'myLessons' || $this->uri->segment(3) == 'discussionDetails' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-book"></i>
            <p>My Lessons</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo base_url('opl/student/classBulletin/' . $subjectDetails->subject_id . '/' . $school_year . '/List')
                    ?>" class="nav-link <?= ($this->uri->segment(6) == 'List' || $this->uri->segment(2) == 'viewTaskDetails' || $this->uri->segment(3) == 'viewTaskDetails' ? 'active' : '') ?>">
            <i class="nav-icon fas fa-tasks"></i>
            <p>My Tasks</p>
        </a>
    </li>
    <!-- <li class="nav-item">
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
    </li> -->
<?php endif;
