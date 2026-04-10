<section>
    <div class="card card-outline card-blue">
        <div class="card-header">
            <h4 class="page-header">Unit List for <?php echo $subjectDetails->subject ?></h4>
        </div>
            <?php if(count($getUnits) != 0): ?>
        <div class="card-body col-md-12 col-sm-12 row">
            <?php
                foreach ($getUnits as $lessons): ?>
            <div class="col-md-4 col-sm-4">
                <div class="card">
                    <div class="card-body col-12 row">
                        <div class="col-9 d-inline-block text-truncate text-primary">
                            <a href="#" title="<?php echo $lessons->ou_unit_title ?>" onclick="getUnitDetails('<?php echo $lessons->ou_opl_code; ?>')" ><?php echo $lessons->ou_unit_title ?></a>
                        </div>
                        <?php if(!$this->session->isOplAdmin): ?>
                        <div class="col-3 float-right">
                            <div class="col-6 float-right">
                                <button class="btn btn-outline-danger btn-xs" lesson-id="<?php echo $lessons->ou_opl_code; ?>" lesson-title="<?php echo $lessons->ou_unit_title; ?>" onclick="readyDelete(this)"><i class="fas fa-trash fa-xs"></i></button>
                            </div>
                            <div class="col-6 float-right">
                                <button class="btn btn-outline-success btn-xs" lesson-id="<?php echo $lessons->ou_opl_code; ?>" lesson-title="<?php echo $lessons->ou_unit_title; ?>" lesson-objective="<?php echo htmlspecialchars($lessons->ou_unit_objectives); ?>" lesson-overview="<?php echo htmlspecialchars($lessons->ou_unit_overview); ?>" onclick="showUnitEdit(this)"><i class="fas fa-edit fa-xs"></i></button>
                            </div>
                        </div>    
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; 
            ?>
        </div>
        <?php
                else:
                    ?>
                    <div class="card-body text-center">
                        <div>
                            <h3>No Units Listed</h3>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
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

<?php 
    if(!$this->session->isOplAdmin):
        echo $this->load->view('units/editUnit'); 
    endif;

?>

<script type="text/javascript">

    $(function () {
        // Summernote
        $('.textarea').summernote();
    });

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