<?php
$current_url  = uri_string(); // e.g. registrar/admission
$segment1     = $this->uri->segment(1);
$segment2     = $this->uri->segment(2);

/**
 * Checks if current URL matches menu link
 */
function is_active($link, $current_url)
{
    return trim($link, '/') === trim($current_url, '/');
}
?>

<!-- Page wrapper -->
<div class="d-flex">

    <!-- Sidebar -->
        <nav class="nav flex-column sidebar-nav">

            <?php
            $position_id = $this->session->userdata('position_id');
            $menu = $menus->menu_access;

            if ($menu != "") {
                $item = explode(",", $menu);
                foreach ($item as $m) {
                    $menuItem = Modules::run('nav/getMenuAccess', $m);
                    if ($menuItem->menu_parent == 0) {
            ?>

            <!-- Main Menu Item -->
            <div class="nav-item">

                <?php if ($menuItem->menu_li_class == 'dropdown'):
                $hasActiveSub = false;
                // Detect active submenu
                foreach ($item as $sm) {
                    $submenu = Modules::run('nav/getSubMenu', $menuItem->menu_id, $sm);
                    if ($submenu != '0' && is_active($submenu->menu_link, $current_url)) {
                        $hasActiveSub = true;
                        break;
                    }
                }
                     ?>
                    <a class="nav-link d-flex align-items-center justify-content-between <?= $hasActiveSub ? 'active-parent' : '' ?>"
                       data-bs-toggle="collapse"
                       href="#menu-<?php echo $menuItem->menu_id ?>"
                       role="button">
                        <span class="d-flex align-items-center">
                            <i class="fa <?php echo $menuItem->menu_a_class ?> me-3"></i>
                            <?php echo $menuItem->menu_name ?>
                        </span>
                        <i class="fa fa-chevron-down small"></i>
                    </a>

                    <!-- Submenu -->
                    <div class="collapse submenu" id="menu-<?php echo $menuItem->menu_id ?>">
                        <?php
                        foreach ($item as $m) {
                            $submenu = Modules::run('nav/getSubMenu', $menuItem->menu_id, $m);
                            if ($submenu != '0' && $submenu->menu_type == 'submenu') {
                        ?>
                            <?php if ($submenu->menu_name == 'Admission'): ?>
                                <a class="nav-link submenu-link"
                                   href="#"
                                   data-bs-toggle="modal"
                                   data-bs-target="#selectNewOption">
                                    <i class="fa <?php echo $submenu->menu_a_class ?> me-2"></i>
                                    <?php echo $submenu->menu_name ?>
                                </a>
                            <?php else: 
                            $subActive = is_active($submenu->menu_link, $current_url) ? 'active' : '';
                                ?>
                                <a class="nav-link submenu-link <?= $subActive ?>"
                                   href="<?php echo base_url($submenu->menu_link); ?>">
                                    <i class="fa <?php echo $submenu->menu_a_class ?> me-2"></i>
                                    <?php echo $submenu->menu_name ?>
                                </a>
                            <?php endif; ?>
                        <?php }} ?>
                    </div>

                <?php else: 
                $active = is_active($menuItem->menu_link, $current_url) ? 'active' : '';
                    ?>
                    <a class="nav-link d-flex align-items-center <?= $active ?>"
                       href="<?php echo base_url($menuItem->menu_link); ?>">
                        <i class="fa <?php echo $menuItem->menu_a_class ?> me-3"></i>
                        <?php echo $menuItem->menu_name ?>
                    </a>
                <?php endif; ?>

            </div>

            <?php }}} ?>

            <!-- College Grading System -->
            <?php
            $collegeLoad = Modules::run(
                'college/subjectmanagement/getAssignedSubjectRaw',
                $this->session->employee_id
            );
            if ($collegeLoad): ?>
                <div class="nav-item mt-3 border-top pt-2">
                    <a href="<?php echo base_url('college/gradingsystem') ?>"
                       class="nav-link d-flex align-items-center fw-semibold text-success">
                        <i class="fa fa-calculator me-3"></i>
                        College Grading System
                    </a>
                </div>
            <?php endif; ?>
        </nav>
</div>

<!-- SELECT NEW OPTION MODAL -->
<div id="selectNewOption" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-sm border-0 rounded-lg text-center p-4">
            <h5 class="mb-4">Please select an option to enroll</h5>
            <?php switch ($settings->level_catered):
                case 0: ?>
                    <button class="btn btn-primary btn-block mb-2" onclick="location='<?php echo base_url('admission/basicEd/2'); ?>'">PRE-SCHOOL & GRADE SCHOOL</button>
                    <button class="btn btn-warning btn-block mb-2" onclick="location='<?php echo base_url('admission/basicEd/3'); ?>'">JUNIOR HIGH SCHOOL</button>
                    <button class="btn btn-success btn-block mb-2" onclick="location='<?php echo base_url('admission/basicEd/4'); ?>'">SENIOR HIGH SCHOOL</button>
                    <button class="btn btn-danger btn-block" onclick="location='<?php echo base_url('admission/college'); ?>'">COLLEGE LEVEL</button>
                <?php break;
                case 1:
                case 2: ?>
                    <button class="btn btn-primary btn-block" onclick="location='<?php echo base_url('admission/basicEd/2'); ?>'">PRE-SCHOOL & GRADE SCHOOL</button>
                <?php break;
                case 3: ?>
                    <button class="btn btn-primary btn-block mb-2" onclick="location='<?php echo base_url('admission/basicEd/2'); ?>'">PRE-SCHOOL & GRADE SCHOOL</button>
                    <button class="btn btn-warning btn-block" onclick="location='<?php echo base_url('admission/basicEd/3'); ?>'">JUNIOR HIGH SCHOOL</button>
                <?php break;
                case 4: ?>
                    <button class="btn btn-primary btn-block mb-2" onclick="location='<?php echo base_url('admission/basicEd/2'); ?>'">PRE-SCHOOL & GRADE SCHOOL</button>
                    <button class="btn btn-warning btn-block mb-2" onclick="location='<?php echo base_url('admission/basicEd/3'); ?>'">JUNIOR HIGH SCHOOL</button>
                    <button class="btn btn-success btn-block" onclick="location='<?php echo base_url('admission/basicEd/4'); ?>'">SENIOR HIGH SCHOOL</button>
            <?php endswitch; ?>
        </div>
    </div>
</div>

<style>
    /* Sidebar wrapper */
.sidebar-wrapper {
    /* padding-top: 45px; navbar height */
}

/* Sidebar */
.sidebar {
    width: 260px;
    min-height: calc(100vh - 56px);
    transition: all 0.3s ease;
    /* border-right: 1px solid #e9ecef; */
}

/* Nav links */
.sidebar-nav .nav-link {
    padding: 0.65rem 1rem;
    color: #495057;
    font-weight: 500;
    border-radius: 0.375rem;
    margin: 2px 0;
    transition: all 0.2s ease-in-out;
}

/* Hover state */
.sidebar-nav .nav-link:hover {
    background-color: #f1f5ff;
    color: #0d6efd;
}

/* Active (optional JS can add .active) */
.sidebar-nav .nav-link.active {
    background-color: #0d6efd;
    color: #fff;
}

/* Icons */
.sidebar-nav i {
    width: 20px;
    text-align: center;
}

/* Submenu */
.submenu {
    padding-left: 1.25rem;
}

.submenu-link {
    font-size: 0.9rem;
    padding-left: 1.75rem;
    color: #6c757d;
}

.submenu-link:hover {
    color: #0d6efd;
}

/* Sidebar header */
.sidebar-header {
    padding: 1rem 1.25rem;
    margin-bottom: 0;
    border-bottom: 1px solid #e5e7eb;
}


/* Mobile */
@media (max-width: 991px) {
    .sidebar {
        position: fixed;
        left: -260px;
        top: 45px;
        z-index: 1050;
        background: #fff;
    }

    .sidebar.show {
        left: 0;
    }
}

/* ==============================
   ACTIVE CHILD
   ============================== */
   .submenu-link.active {
    background: rgba(13,110,253,0.12);
    color: #0d6efd;
    font-weight: 600;
}


/* ==============================
   ACTIVE PARENT (HAS ACTIVE CHILD)
   ============================== */
   .nav-link.active-parent {
    background: #eef2ff;
    color: #0d6efd;
    font-weight: 600;
    border-left: 4px solid #0d6efd;
}

/* Parent icon highlight */
.nav-link.active-parent i {
    color: #0d6efd;
}

/* Chevron rotation */
.nav-link.active-parent .fa-chevron-down {
    transform: rotate(180deg);
    transition: transform 0.2s ease;
}
</style>