<div class="row">
    <div class="col-12">
        <h3 class="page-header">
            Generate DepEd Form 138 - A
            <small class="d-block mt-2">
                <div class="d-flex justify-content-end flex-wrap gap-2">

                    <!-- Student Select -->
                    <div class="mb-3">
                        <select class="form-select" id="inputStudent" name="inputSection" onclick="generateCard()" required>
                            <option selected>Select Student</option>
                            <?php foreach ($students->result() as $s) { ?>
                                <option value="<?php echo $s->st_id; ?>">
                                    <?php echo strtoupper($s->lastname.', '.$s->firstname) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </small>
        </h3>

        <input type="hidden" id="strand" value="<?php echo $strand ?>" />
    </div>

    <div id="generatedResult" class="col-12 mt-3">
        <!-- Generated report will appear here -->
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#sy").select2();
        $("#inputStudent").select2();
        $("#inputTerm").select2();
    });

    function generateCard() {
        var st_id = $('#inputStudent').val();
        var term = $('#inputTerm').val();
        var school_year = $('#inputSY').val();
        var strand_id = $('#strand').val();
        var url = "<?php echo base_url().'reports/generateReportCard/'?>" + st_id + '/' + term + '/' + school_year + '/' + strand_id;

        $.ajax({
            type: "GET",
            url: url,
            data: { qcode: term },
            success: function(data) {
                $('#generatedResult').html(data);
            }
        });
    }
</script>
