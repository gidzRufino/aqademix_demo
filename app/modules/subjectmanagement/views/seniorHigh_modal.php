<div class="modal fade" id="seniorHighModal" tabindex="-1" aria-labelledby="seniorHighModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-md">

        <div class="modal-content shadow-sm border-0">

            <!-- Header -->
            <div class="modal-header">

                <h5 class="modal-title" id="seniorHighModalLabel">
                    <i class="fa fa-graduation-cap text-primary me-2"></i>
                    Add Senior High School Strands
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <!-- Body -->
            <div class="modal-body">

                <div class="container-fluid">

                    <!-- Strand Name -->
                    <div class="mb-3">
                        <label for="strand_name" class="form-label fw-semibold">
                            <i class="fa fa-graduation-cap me-1 text-primary"></i>
                            Strand Description
                        </label>
                        <input
                            type="text"
                            id="strand_name"
                            name="strand"
                            class="form-control"
                            placeholder="Enter Strand">
                    </div>

                    <!-- Short Code -->
                    <div class="mb-3">
                        <label for="strand_code" class="form-label fw-semibold">
                            <i class="fa fa-code me-1 text-success"></i>
                            Short Code
                        </label>
                        <input
                            type="text"
                            id="strand_code"
                            name="short_code"
                            class="form-control"
                            placeholder="Enter short code">
                        <div class="form-text">
                            Short identifier used for reports and quick reference.
                        </div>
                    </div>

                    <!-- Multiple Strands (Optional bulk entry) -->
                    <!-- <div class="mb-2">
                        <label class="form-label fw-semibold">
                            <i class="fa fa-list me-1 text-secondary"></i>
                            Add Multiple Strands
                        </label>

                        <input
                            type="text"
                            id="addedStrands"
                            name="addedStrands"
                            class="form-control"
                            placeholder="Type strand and press Enter">
                        <small class="text-muted">
                            You can add multiple strands separated by comma or Enter.
                        </small>
                    </div> -->

                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light border"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-success"
                    onclick="addStrand()">

                    <i class="fa fa-save me-1"></i>
                    Save

                </button>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#addedStrands").select2({
            tags: [<?php
                    foreach ($strands as $s) {
                        echo '"' . $s->short_code . '",';
                    }
                    ?>]
        });


    });

    function addStrand() {
        var formData = {};

        $('#seniorHighModal .modal-body input').each(function() {
            var name = $(this).attr('name');

            if (name) {
                formData[name] = $(this).val();
            }
        });

        // CSRF
        var csrfName = $('#csrf_name').val();
        var csrfHash = $('#csrf_hash').val();

        formData[csrfName] = csrfHash;

        console.log(formData);

        $.ajax({
            type: 'POST',
            url: '<?= base_url() . 'subjectmanagement/addStrand' ?>',
            data: formData,
            dataType: 'json',
            success: function(data) {
                showTopAlert(data.msg, data.status ? 'success' : 'danger', 'reload');
            }
        })
    }


    function saveSHStrand() {
        var strands = $('#addedStrands').val()

        var url = "<?php echo base_url() . 'subjectmanagement/saveSHStrand/' ?>" // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "strands=" + strands + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                //location.reload();    
            }
        });
    }
</script>