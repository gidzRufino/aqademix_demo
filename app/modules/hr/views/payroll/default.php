<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<div class="container-fluid py-3">

    <!-- Header / Navigation -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3 pb-2 border-bottom">
        <h3 class="mb-3 mb-md-0 fw-semibold">
            <i class="fa-solid fa-money-check-dollar me-2 text-primary"></i>
            Payroll System
        </h3>

        <div class="btn-group flex-wrap" role="group">
            <button type="button"
                class="btn btn-outline-primary"
                onclick="loadPayrollPage('<?= base_url('hr/payroll/create') ?>')">
                <i class="fa-solid fa-plus me-1"></i> Create Payroll
            </button>

            <button type="button"
                class="btn btn-outline-info"
                onclick="location.href = '<?= base_url('/hr/getAllEmployee') ?>'">
                <i class="fa-solid fa-users me-1"></i> Employees
            </button>

            <button type="button"
                class="btn btn-outline-dark"
                onclick="loadPayrollPage('<?= base_url('hr/payroll/settings') ?>')">
                <i class="fa-solid fa-gear me-1"></i> Settings
            </button>
        </div>
    </div>

    <!-- Content Body -->
    <div class="card shadow-sm border-0">
        <div class="card-body bg-light" id="payrollContent">
            <div class="text-center py-5 text-muted">
                <i class="fa-solid fa-folder-open fa-3x mb-3"></i>
                <h5 class="fw-semibold">Select an option above</h5>
                <p class="mb-0">Content will be loaded here without leaving the page.</p>
            </div>
        </div>
    </div>

</div>

<script>
    function loadPayrollPage(url) {
        const container = document.getElementById('payrollContent');
        container.innerHTML = `
    <div class="text-center py-5">
      <div class="spinner-border text-primary" role="status"></div>
      <p class="mt-3 text-muted">Loading content...</p>
    </div>
  `;

        fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
            })
            .catch(() => {
                container.innerHTML = `
        <div class="alert alert-danger">
          <i class="fa-solid fa-triangle-exclamation me-2"></i>
          Failed to load content. Please try again.
        </div>
      `;
            });
    }
</script>