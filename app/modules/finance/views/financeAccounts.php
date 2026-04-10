<style>
    /* subtle modern feel */
    .glass-card {
        backdrop-filter: blur(6px);
        background: rgba(255, 255, 255, 0.9);
    }

    .card {
        transition: all .2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    /* nicer search dropdown */
    #searchName {
        max-height: 300px;
        overflow-y: auto;
        border-radius: 12px;
    }

    .glass-card {
        backdrop-filter: blur(6px);
        position: relative;
        z-index: 1;
        /* important */
    }

    .card {
        transition: all .2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    #searchName {
        max-height: 300px;
        overflow-y: auto;
        border-radius: 12px;
    }
</style>

<div class="container-fluid py-3">

    <!-- 🔷 MERGED HEADER -->
    <div class="card glass-card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body">

            <!-- 🔝 TOP ROW -->
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-3">

                <!-- TITLE -->
                <div>
                    <h5 class="fw-bold mb-0">Finance Accounts</h5>
                    <small class="text-muted">Manage student accounts & transactions</small>
                </div>

                <!-- ACTIONS -->
                <div class="d-flex gap-2 flex-wrap">

                    <button class="btn btn-light btn-sm"
                        onclick="location.href='<?= base_url('main/dashboard') ?>'">
                        Dashboard
                    </button>

                    <button class="btn btn-light btn-sm"
                        onclick="location.href='<?= base_url('finance') ?>'">
                        Settings
                    </button>

                    <button class="btn btn-outline-secondary btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#searchOR">
                        Search OR
                    </button>

                    <!-- REPORTS -->
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle"
                            data-bs-toggle="dropdown">
                            Reports
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="<?= base_url('finance/collectionReport') ?>">Collection</a></li>
                            <li><a class="dropdown-item" href="#" onclick="$('#chequeEncashments').modal('show')">Cheque Encashments</a></li>
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#cashBreakdown">Cash Breakdown</a></li>

                            <?php if ($this->session->is_admin): ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?= base_url('college/finance/financeLog') ?>">Finance Log</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>

                </div>
            </div>


            <!-- 🔍 SEARCH + FILTER ROW -->
            <div class="row g-3 align-items-center">

                <!-- SEARCH -->
                <div class="col-lg-6 position-relative" style="z-index: 2000;">

                    <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                        <span class="input-group-text bg-white border-0">🔍</span>

                        <input onkeyup="search(this.value)"
                            id="searchBox"
                            type="text"
                            class="form-control border-0"
                            placeholder="Search student name...">
                    </div>

                    <!-- ✅ FIXED DROPDOWN -->
                    <div id="searchName"
                        class="position-absolute w-100 mt-2 bg-white shadow rounded-4"
                        style="
                            z-index: 9999;
                            display:none;
                            max-height:300px;
                            overflow-y:auto;
                        ">
                    </div>

                </div>

                <!-- SCHOOL YEAR -->
                <div class="col-lg-3">
                    <div class="dropdown w-100">
                        <button class="btn btn-light border w-100 text-start dropdown-toggle"
                            id="btnControl"
                            data-bs-toggle="dropdown">
                            <?= $school_year . ' - ' . ($school_year + 1) ?>
                        </button>

                        <ul class="dropdown-menu w-100 shadow-sm">
                            <?php foreach (Modules::run('registrar/getROYear') as $ro): ?>
                                <?php $roYears = $ro->ro_years + 1; ?>
                                <li>
                                    <a class="dropdown-item"
                                        href="#"
                                        onclick="$('#btnControl').text('<?= $ro->ro_years . ' - ' . $roYears ?>'); $('#inputSchoolYear').val('<?= $ro->ro_years ?>')">
                                        <?= $ro->ro_years . ' - ' . $roYears ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <input type="hidden" id="inputSchoolYear" value="<?= $school_year ?>">
                    </div>
                </div>

                <!-- SEM -->
                <div class="col-lg-3">
                    <select id="inputSem" class="form-select">
                        <option value="0" <?= ($this->uri->segment(5) == 0 ? 'selected' : '') ?>>Regular</option>
                        <option value="3" <?= ($this->uri->segment(5) == 3 ? 'selected' : '') ?>>Summer</option>
                    </select>
                </div>

            </div>


            <!-- EXTRA -->
            <?php if ($id == NULL): ?>
                <div class="mt-3">
                    <?php $this->load->view('otherAccounts'); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>


    <!-- 🔷 MAIN CONTENT -->
    <div class="card border-0 shadow-sm rounded-4" style="position:relative; z-index:0;">

        <div class="card-body p-0">

            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0 fw-semibold">Account Details</h6>
                    <small class="text-muted">Selected student financial information</small>
                </div>

                <?php if ($id != NULL): ?>
                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                        Active Record
                    </span>
                <?php endif; ?>
            </div>

            <div id="AccountBody" class="p-3">

                <?php if ($id != NULL): ?>
                    <?= Modules::run('finance/loadAccountDetails', $id, $school_year, ($semester != 3 ? 0 : 3)); ?>
                <?php else: ?>

                    <div class="text-center py-5 text-muted">
                        <div class="mb-3" style="font-size: 50px;">📄</div>
                        <h6 class="fw-semibold">No student selected</h6>
                        <small>Use the search above to view account details</small>
                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>
<div class="modal fade" id="searchOR" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Search Receipts</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="input-group mb-3">
                    <input onkeyup="searchOR(this.value)"
                        id="searchReceiptBox"
                        type="text"
                        class="form-control form-control-lg"
                        placeholder="Search receipts...">

                    <button class="btn btn-outline-secondary dropdown-toggle"
                        id="btnReceiptControl"
                        data-bs-toggle="dropdown">
                        <?= $school_year . ' - ' . ($school_year + 1) ?>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php foreach (Modules::run('registrar/getROYear') as $ro): ?>
                            <?php $roYears = $ro->ro_years + 1; ?>
                            <li>
                                <a class="dropdown-item"
                                    href="#"
                                    onclick="$('#btnReceiptControl').text('<?= $ro->ro_years . ' - ' . $roYears ?>'); $('#inputSchoolYearReceipts').val('<?= $ro->ro_years ?>')">
                                    <?= $ro->ro_years . ' - ' . $roYears ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <input type="hidden" id="inputSchoolYearReceipts" value="<?= $school_year ?>">
                </div>

                <div id="searchReceipt"
                    class="list-group mb-3"
                    style="display:none;"></div>

                <hr>

                <div id="orDetails"></div>

            </div>

        </div>
    </div>
</div>
<?php
?>

<script type="text/javascript">
    $(document).ready(function() {

        shortcut.add("alt+p", function() {
            alert('hey')
            //$('#cashRegister').modal('show');
        });
        shortcut.add("shift+0", function() {
            window.setTimeout(function() {
                document.getElementById("searchBox").focus();
            }, 500);
        });
        shortcut.add("shift+i", function() {
            window.setTimeout(function() {
                document.getElementById("ptAmountTendered").focus();
            }, 500);
        });
        shortcut.add("F1", function() {
            document.location = 'http://localhost/e-sKwela/college/finance/accounts';
        });

    });

    function loadDetails(st_id, sy, semester) {

        var url = '<?php echo base_url() . 'finance/loadAccountDetails/' ?>' + st_id + '/' + sy + '/' + semester;
        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + st_id, // serializes the form's elements.
            success: function(data) {
                // $('#AccountBody').html(data);
                document.location = '<?php echo base_url() . 'finance/accounts/' ?>' + st_id + '/' + sy + '/' + semester;
            }
        });

        return false;
    }

    function loadORDetails(ref_number, sy) {
        var url = '<?php echo base_url() . 'finance/loadORDetails/' ?>' + ref_number + '/' + sy;
        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + ref_number, // serializes the form's elements.
            success: function(data) {
                $('#orDetails').html(data);
            }
        });

        return false;
    }

    function search(value) {
        var school_year = $('#inputSchoolYear').val()
        var sem = $('#inputSem').val()
        var url = '<?php echo base_url() . 'search/searchStudentAccountsK12/' ?>' + value + '/' + school_year + '/' + sem + '/searchName';
        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + value, // serializes the form's elements.
            success: function(data) {
                $('#searchName').show();
                $('#searchName').html(data);

            }
        });

        return false;
    }

    function searchOR(value) {
        var school_year = $('#inputSchoolYearReceipts').val()
        var url = '<?php echo base_url() . 'finance/searchReceipt/' ?>' + value + '/' + school_year;
        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + value, // serializes the form's elements.
            success: function(data) {
                $('#searchReceipt').show();
                $('#searchReceipt').html(data);
            }
        });

        return false;
    }


    function numberWithCommas(x) {
        if (x == null) {
            x = 0;
        }
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function showDropdown(html) {
        let dropdown = document.getElementById('searchName');

        dropdown.innerHTML = html;
        dropdown.style.display = 'block';

        let rect = document.getElementById('searchBox').getBoundingClientRect();

        dropdown.style.position = 'fixed';
        dropdown.style.top = (rect.bottom + 5) + 'px';
        dropdown.style.left = rect.left + 'px';
        dropdown.style.width = rect.width + 'px';
        dropdown.style.zIndex = 99999;
    }

    function selectStudent(id, year, semester, name) {
        document.getElementById('searchName').style.display = 'none';
        document.getElementById('searchBox').value = name;

        loadDetails(id, year, semester);
    }
</script>

<script src="<?php echo base_url(); ?>assets/js/plugins/shortcut.js"></script>