<!-- top navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-xs fixed-top">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-sidebar">
      <span class="navbar-toggler-icon" data-bs-target="#offcanvas-sidebar"></span>
    </button>
    
        <!-- Brand -->
        <?php
        $homeUrl = ($this->session->userdata('dept_id') == 10)
            ? base_url('college')
            : base_url();
        ?>

        <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="<?php echo $homeUrl; ?>">
            <?php if (strpos(base_url(), 'localhost') === false): ?>
                <i id="client_status" class="fa fa-circle text-danger small"></i>
            <?php else: ?>
                <i id="portal_status" class="fa fa-spinner fa-spin text-primary"></i>
            <?php endif; ?>
            <?php echo $settings->set_school_name; ?>
        </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Right Menu -->
    <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav align-items-center gap-2">

                <!-- User Menu -->
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa fa-user-circle fs-5"></i>
                        <span class="fw-medium">
                            Hi <?php echo $this->session->userdata('name'); ?>!
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <a
                                class="dropdown-item"
                                href="<?php echo base_url(
                                    'hr/viewTeacherInfo/' .
                                    base64_encode($this->session->userdata('employee_id'))
                                ); ?>">
                                <i class="fa fa-user me-2"></i> User Profile
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a
                                class="dropdown-item text-danger"
                                href="<?php echo base_url('login/logout'); ?>">
                                <i class="fa fa-sign-out me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>

    </div>
</nav>
<!-- top navigation -->