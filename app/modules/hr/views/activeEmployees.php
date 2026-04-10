<div class="col-lg-12">
    <!-- ===== Pagination + Search Row ===== -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div id="links">
            <?= $links; ?>
        </div>

        <div class="search-wrapper">
            <input type="text"
                class="form-control"
                placeholder="Search Employee"
                id="searchEmployee"
                onkeyup="searchTeacher(this.value)">
            <button type="button"
                class="search-btn"
                onclick="searchTeacher(document.getElementById('searchEmployee').value)">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>

    <!-- ===== Employee Table Card ===== -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0 position-relative" style="overflow: visible;">
            <div class="table-responsive" id="employeeTable" style="overflow: visible;">
                <table class="table table-hover align-middle mb-0" style="font-size:14px;">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Employee</th>
                            <th>Employee ID</th>
                            <th>Position</th>
                            <th>Status</th>
                            <?php if ($this->session->userdata('is_admin') && $this->session->position != "Cashier"): ?>
                                <th>PW</th>
                                <th style="min-width:180px;">Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody id="tableDetails">
                        <?php foreach ($employee as $s):
                            $name = strtoupper($s->firstname . ' ' . $s->middlename . ' ' . $s->lastname);
                            $avatar = ($s->avatar && file_exists('uploads/' . $s->avatar))
                                ? 'uploads/' . $s->avatar
                                : 'images/avatar/' . ($s->sex == 'Female' ? 'female.png' : 'male.png');

                            $statusColors = [1 => 'success', 2 => 'warning', 3 => 'danger', 0 => 'secondary'];
                            $statusIcons = [1 => 'fa-check-circle', 2 => 'fa-exclamation-circle', 3 => 'fa-times-circle', 0 => 'fa-minus-circle'];
                            $statusText = [1 => 'Active', 2 => 'Suspended', 3 => 'Resigned', 0 => 'Deactivated'];
                            $color = $statusColors[$s->isActive];
                            $icon = $statusIcons[$s->isActive];
                            $text = $statusText[$s->isActive];
                        ?>
                            <tr class="table-row-hover shadow-sm rounded mb-2">
                                <!-- Employee Column (Avatar + Name) -->
                                <td class="text-start">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="<?= base_url($avatar) ?>" class="rounded-circle border" style="width:48px;height:48px;object-fit:cover;">
                                        <div>
                                            <div class="fw-semibold" style="cursor:pointer"
                                                onclick="document.location='<?= base_url('hr/viewTeacherInfo/' . base64_encode($s->uid) . '/' . base64_encode($s->user_id)) ?>'">
                                                <?= strtoupper($s->lastname) ?>,
                                            </div>
                                            <small class="text-muted"><?= strtoupper($s->firstname . ' ' . $s->middlename) ?></small>
                                        </div>
                                    </div>
                                </td>

                                <!-- User ID -->
                                <td class="text-center">
                                    <a class="fw-semibold text-decoration-none" href="<?= base_url('hr/viewTeacherInfo/' . base64_encode($s->uid)) ?>">
                                        <?= $s->uid ?>
                                    </a>
                                </td>

                                <!-- Position -->
                                <td class="text-center align-middle col-position">
                                    <span class="badge bg-primary-subtle text-primary">
                                        <?= $s->position ?>
                                    </span>
                                </td>

                                <!-- Status -->
                                <td class="text-center align-middle col-status">
                                    <div class="dropend">
                                        <span class="badge bg-<?= $color ?> dropdown-toggle"
                                            id="statusDropdown<?= $s->employee_id ?>"
                                            data-bs-toggle="dropdown"
                                            data-bs-display="static"
                                            aria-expanded="false"
                                            style="cursor:pointer;">
                                            <i class="fa <?= $icon ?>"></i> <?= $text ?>
                                        </span>

                                        <ul class="dropdown-menu shadow"
                                            aria-labelledby="statusDropdown<?= $s->employee_id ?>">
                                            <li><a class="dropdown-item" href="#" onclick="updateEmployeeStatus('<?= $s->employee_id ?>',1)">Active</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="updateEmployeeStatus('<?= $s->employee_id ?>',2)">Suspended</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="updateEmployeeStatus('<?= $s->employee_id ?>',3)">Resigned</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="updateEmployeeStatus('<?= $s->employee_id ?>',0)">Deactivated</a></li>
                                        </ul>
                                    </div>
                                </td>

                                <?php if ($this->session->userdata('is_admin') && $this->session->position != "Cashier"): ?>
                                    <!-- ===== PASSWORD COLUMN ===== -->
                                    <td class="text-center align-middle col-password">
                                        <span id="pw_mask_<?= $s->employee_id ?>"
                                            class="badge bg-secondary"
                                            style="cursor:pointer;"
                                            onclick="togglePassword('<?= $s->employee_id ?>')">
                                            ••••••••
                                        </span>

                                        <span id="pw_real_<?= $s->employee_id ?>"
                                            class="badge bg-dark d-none"
                                            style="cursor:pointer;"
                                            onclick="togglePassword('<?= $s->employee_id ?>')">
                                            <?= $s->secret_key ?>
                                        </span>
                                    </td>

                                    <!-- ===== ACTIONS COLUMN ===== -->
                                    <td class="text-center align-middle" style="min-width:200px;">
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <?php if ($s->rfid == "" || $s->rfid == "NULL"): ?>
                                                <button class="btn btn-sm btn-light border text-primary rounded-pill px-3"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#addId"
                                                    onclick="showAddRFIDForm('<?= $s->user_id ?>','RFID','<?= $name ?>')">
                                                    <i class="fa fa-id-card me-1"></i> RFID
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-light border text-secondary rounded-pill px-3"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#addId"
                                                    onclick="showAddRFIDForm('<?= $s->user_id ?>','<?= $s->rfid ?>','<?= $name ?>')">
                                                    <i class="fa fa-edit me-1"></i> RFID
                                                </button>
                                            <?php endif; ?>

                                            <button class="btn btn-sm btn-light border text-danger rounded-pill px-3"
                                                onclick="deleteEmployee('<?= $s->user_id ?>','<?= $s->employee_id ?>')">
                                                <i class="fa fa-trash me-1"></i> Delete
                                            </button>

                                        </div>
                                    </td>

                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bottom Pagination -->
    <div class="d-flex justify-content-center mt-3">
        <?= $links ?>
    </div>
</div>

<!-- ===== Custom CSS ===== -->
<style>
    .table-row-hover:hover {
        background-color: #f8f9fa !important;
        transition: all 0.2s ease-in-out;
        transform: translateY(-2px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .table thead th {
        vertical-align: middle;
    }

    /* Ensure dropdown appears above table rows */
    .table-responsive,
    .card-body {
        overflow: visible !important;
    }

    .dropdown-menu {
        z-index: 1055;
        /* higher than table rows */
        position: absolute !important;
    }

    .col-position {
        font-size: 1rem;
    }

    .col-status {
        font-size: 1rem;
    }

    .col-password {
        font-size: 1rem;
    }

    .search-group .form-control,
    .search-group .btn {
        height: 38px;
    }

    .search-group .btn {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input-group>.form-control,
    .input-group>.btn {
        height: 38px;
    }

    .input-group>.btn {
        line-height: 1;
    }

    .search-wrapper {
        position: relative;
        width: 260px;
        flex: 0 0 260px;
        /* prevents it from affecting table width */
    }

    .search-wrapper .form-control {
        height: 38px;
        padding-right: 40px;
        border-radius: 50px;
    }

    .search-wrapper .search-btn {
        position: absolute;
        top: 50%;
        right: 6px;
        transform: translateY(-50%);
        height: 30px;
        width: 30px;
        border: none;
        background: transparent;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .table-responsive {
        width: 100%;
    }

    .search-wrapper .search-btn:hover {
        background: #f1f1f1;
        color: #000;
    }

    .action-group {
        display: inline-flex;
        gap: 6px;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .2s ease;
    }

    .action-btn:hover {
        background: #f8f9fa;
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, .08);
    }
</style>