<?php foreach ($employee as $s):
    if ($s->lastname != ''):
        $name = strtoupper($s->firstname . ' ' . $s->middlename . ' ' . $s->lastname);
        $avatar = ($s->avatar && file_exists('uploads/' . $s->avatar))
            ? 'uploads/' . $s->avatar
            : 'images/avatar/' . ($s->sex == 'Female' ? 'female.png' : 'male.png');

        $statusColors = [1 => 'success', 2 => 'warning', 3 => 'danger', 0 => 'secondary'];
        $statusIcons  = [1 => 'fa-check-circle', 2 => 'fa-exclamation-circle', 3 => 'fa-times-circle', 0 => 'fa-minus-circle'];
        $statusText   = [1 => 'Active', 2 => 'Suspended', 3 => 'Resigned', 0 => 'Deactivated'];

        $color = $statusColors[$s->isActive];
        $icon  = $statusIcons[$s->isActive];
        $text  = $statusText[$s->isActive];
?>
        <tr class="table-row-hover shadow-sm rounded mb-2">
            <!-- Employee (Avatar + Name) -->
            <td class="text-start">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= base_url($avatar) ?>" class="rounded-circle border"
                        style="width:48px;height:48px;object-fit:cover;">
                    <div>
                        <div class="fw-semibold" style="cursor:pointer"
                            onclick="document.location='<?= base_url('hr/viewTeacherInfo/' . base64_encode($s->uid)) ?>'">
                            <?= strtoupper($s->lastname) ?>,
                        </div>
                        <small class="text-muted">
                            <?= strtoupper($s->firstname . ' ' . $s->middlename) ?>
                        </small>
                    </div>
                </div>
            </td>

            <!-- Employee ID -->
            <td class="text-center">
                <a class="fw-semibold text-decoration-none"
                    href="<?= base_url('hr/viewTeacherInfo/' . base64_encode($s->uid)) ?>">
                    <?= $s->uid ?>
                </a>
            </td>

            <!-- Position -->
            <td class="text-center align-middle">
                <span class="badge bg-primary-subtle text-primary">
                    <?= $s->position ?>
                </span>
            </td>

            <?php if ($this->session->userdata('is_admin')): ?>
                <!-- Status Dropdown -->
                <td class="text-center align-middle">
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
                            <li><a class="dropdown-item" href="#"
                                    onclick="updateEmployeeStatus('<?= $s->employee_id ?>',1)">Active</a></li>
                            <li><a class="dropdown-item" href="#"
                                    onclick="updateEmployeeStatus('<?= $s->employee_id ?>',2)">Suspended</a></li>
                            <li><a class="dropdown-item" href="#"
                                    onclick="updateEmployeeStatus('<?= $s->employee_id ?>',3)">Resigned</a></li>
                            <li><a class="dropdown-item" href="#"
                                    onclick="updateEmployeeStatus('<?= $s->employee_id ?>',0)">Deactivated</a></li>
                        </ul>
                    </div>
                </td>

                <!-- Password (click to reveal) -->
                <td class="text-center align-middle">
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

                <!-- Actions -->
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
<?php
    endif;
endforeach; ?>

<script type="text/javascript">
    $(function() {
        $('.clickover').clickover({
            placement: 'bottom',
            html: true
        });
    });

    function togglePassword(id) {
        const mask = document.getElementById('pw_mask_' + id);
        const real = document.getElementById('pw_real_' + id);
        mask.classList.toggle('d-none');
        real.classList.toggle('d-none');
    }
</script>