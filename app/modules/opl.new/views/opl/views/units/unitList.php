<section>
    <div class="card card-outline card-blue">
        <div class="card-header">
            <h4 class="page-header">Unit List for <?php echo $subjectDetails->subject ?></h4>
        </div>
        <div class="card-body">
            <?php foreach ($getUnits as $lessons): ?>
                <div onclick="getUnitDetails('<?php echo $lessons->ou_opl_code; ?>')" class="col-md-4 col-sm-4 pull-left"><i class="fa fa-arrow-circle-right fa-fw"></i> <a href="#"><?php echo $lessons->ou_unit_title ?></a></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<div class="modal fade in " id="unitDetailModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="unitTitle" class="modal-title pull-left">Default Modal</h4>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-8 float-left">
                    <h5>Overview :</h5>
                    <p id="overviewId"></p>
                    <h5>Objectives :</h5>
                    <p id="objectives"></p>
                </div>
                <div class="col-lg-4 float-right border-left">
                    <h6>Tasks:</h6>
                    <ol id="task">
                        
                    </ol>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<input type="hidden" id="grade_level_id" value="<?php echo $gradeDetails->grade_level_id ?>" />
<input type="hidden" id="section_id" value="<?php echo $gradeDetails->section_id ?>" />
<input type="hidden" id="subject_id" value="<?php echo $subjectDetails->subject_id ?>" />
<input type="hidden" id="school_year" value="<?php echo $school_year ?>" />

<script type="text/javascript">

    function getUnitDetails(unitCode)
    {
        var base = $('#base').val();
        var url = base + 'opl/getUnitDetails/' + unitCode + '/' + $('#school_year').val();
        $.ajax({
            type: "GET",
            url: url,
            data: {

                csrf_test_name: $.cookie('csrf_cookie_name')
            }, // serializes the form's elements.
            dataType: 'json',
            success: function (data)
            {
                $('#unitDetailModal').modal('show');
                $('#overviewId').html(data.unitDetails.ou_unit_overview);
                $('#objectives').html(data.unitDetails.ou_unit_objectives);
                $('#unitTitle').html(data.unitDetails.ou_unit_title);
                $('#task').html(data.tasks)
            }
        });
    }
</script>    