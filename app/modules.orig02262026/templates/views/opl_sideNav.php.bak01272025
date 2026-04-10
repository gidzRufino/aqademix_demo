<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo (!$this->session->isStudent?base_url(): ($this->session->isCollege?base_url('opl/college'): base_url('opl/student'))) ?>" class="brand-link">
      <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>" width="40" alt="<?php echo $settings->short_name ?>"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><?php echo $settings->short_name ?></span>
    </a>

    <!-- Sidebar -->
    <?php if(!$this->session->isParent): 
        
            $avatar = site_url('images'.DIRECTORY_SEPARATOR.'forms'.DIRECTORY_SEPARATOR.$this->eskwela->getSet()->set_logo);
            if($this->session->avatar != NULL || $this->session->avatar != ""):
                if(file_exists(FCPATH."uploads".DIRECTORY_SEPARATOR.$this->session->avatar)):
                    $avatar = site_url('uploads'.DIRECTORY_SEPARATOR.$this->session->avatar);
                endif;
                if(file_exists(FCPATH."uploads".$this->session->school_year.DIRECTORY_SEPARATOR.$this->session->avatar)):
                    $avatar = site_url('uploads'.$this->session->school_year.DIRECTORY_SEPARATOR.$this->session->avatar);
                endif;
            endif;
        ?>
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <?php if($this->session->isStudent): ?>
                <img src="<?php echo $avatar ?>" class="img-circle elevation-2" alt="User Image">
              <?php else: ?>  
                <img src="<?php echo $avatar ?>" class="img-circle elevation-2" alt="User Image">
              <?php endif; ?>
            </div>
            <div class="info">
                <?php if ($this->session->isStudent): ?>
                    <a href="<?php echo base_url() . 'opl/student/viewDetails/' . base64_encode($this->session->st_id) ?>" class="d-block"><?php echo strtoupper($this->session->name) ?></a>
                <?php else: ?>
                    <a href="<?php echo base_url() . 'hr/viewTeacherInfo/' . base64_encode( $this->session->employee_id) ?>" class="d-block"><?php echo strtoupper($this->session->name) ?></a>
                <?php endif; ?>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
              <?php if(!$this->session->isStudent): ?>
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>" class="nav-link">
                    <i class="nav-icon fas fa-home"></i>
                    <p>
                      Home
                    </p>
                  </a>
                </li>
              <?php endif; ?>  
              <li class="nav-item">
                  <a href="<?php echo ($this->session->isStudent?($this->session->isCollege?base_url('opl/college'): base_url('opl/student')):base_url('opl')) ?>" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <?php 
                if($this->session->isCollege):
                    ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('opl/college/financeAccounts') ?>" class="nav-link">
                        <i class="nav-icon fas fa-money-bill-alt "></i>
                        <p>
                          My Account
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('opl/college/subjectsAndSchedules') ?>" class="nav-link">
                        <i class="nav-icon fas fa-calendar "></i>
                        <p>
                          Subjects and Schedules
                        </p>
                      </a>
                    </li>

                    <?php
                endif;
                if($this->session->isStudent): 
                    if($this->session->isCollege):
                        echo Modules::run('opl/college/student_menu', $subject_id);
                    else:
                        echo Modules::run('opl/student/student_menu', $subjectDetails);
                    endif;
                else:    
                    if($this->uri->segment(2)!=NULL && $this->session->position="High School Faculty"):
                       if(!$this->session->isOplAdmin):
                        echo Modules::run('opl/task_menu');
                       endif;
                    endif; 
                endif;   
                ?>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
    <?php else: ?>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="info">
                  <a href="<?php echo base_url() . 'opl/p/dashboard' ?>" class="d-block">Hi&nbsp;<?php echo ucfirst($this->session->username) ?>&nbsp;!</a>
              </div>
            </div>
            
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo base_url() . 'opl/p/dashboard' ?>" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Dashboard
                    </p>
                  </a>
                </li>
            </ul>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo base_url() . 'opl/p/getFinanceAccounts' ?>" class="nav-link">
                    <i class="nav-icon fas fa-money-bill-alt"></i>
                    <p>
                      Finance Accounts
                    </p>
                  </a>
                </li>
            </ul>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo base_url() . 'opl/p/getAcademicRecords' ?>" class="nav-link">
                    <i class="nav-icon fas fa-book-open"></i>
                    <p>
                      Academic Records
                    </p>
                  </a>
                </li>
            </ul>
        </nav>

    <?php endif; ?>
    <!-- /.sidebar -->
  </aside>