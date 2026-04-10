<div class="container-fluid py-3">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

        <div>
            <h3 class="mb-0">
                <i class="fa fa-users text-primary me-2"></i>
                Human Resource Management
            </h3>
            <small class="text-muted">
                Manage departments, positions and HR settings
            </small>
        </div>

    </div>


    <div class="card shadow-sm border-0">

        <!-- TABS -->
        <div class="card-header bg-white border-bottom">

            <ul class="nav nav-tabs card-header-tabs" role="tablist">

                <li class="nav-item">
                    <button class="nav-link active"
                        data-bs-toggle="tab"
                        data-bs-target="#dp">

                        <i class="fa fa-building me-1"></i>
                        Departments & Positions
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link"
                        data-bs-toggle="tab"
                        data-bs-target="#pds">

                        <i class="fa fa-cog me-1"></i>
                        HR Settings
                    </button>
                </li>

            </ul>

        </div>


        <!-- TAB CONTENT -->
        <div class="card-body">

            <div class="tab-content">

                <!-- DEPARTMENTS -->
                <div class="tab-pane fade show active" id="dp">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-light">
                            <?php
                            $hrdb = Modules::load('hr/hrdbprocess/');
                            $hrdb->getListOfDepartmentsPositions();
                            ?>
                        </div>
                    </div>
                </div>

                <!-- HR SETTINGS -->
                <div class="tab-pane fade" id="pds">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-light">

                            <i class="fa fa-calendar text-secondary me-2"></i>
                            <strong>Payroll / Payment Schedule</strong>

                        </div>

                        <div class="card-body">

                            <?php
                            $hrdb->getPaymentSchedule();
                            ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>