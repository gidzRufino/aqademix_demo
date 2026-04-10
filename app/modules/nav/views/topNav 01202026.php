<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm sticky-top w-100">
    <div class="container-fluid px-3">

        <!-- Sidebar Toggle (Mobile) -->
        <button
            class="btn btn-outline-secondary d-lg-none me-2"
            data-bs-toggle="offcanvas"
            data-bs-target="#sidebarOffcanvas"
            aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
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
