<section id="gvDetails" class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fas fa-clipboard-list mr-2"></i>Rubric Details
        </h5>
        <small class="text-light d-block mt-2">
            A rubric is an evaluation tool or set of guidelines used to promote the consistent application of learning expectations or to measure their attainment against consistent criteria.
        </small>
    </div>

    <div class="card-body">
        <?php
        $attributes = array('class' => '', 'role' => 'form', 'id' => 'addRubricForm', 'onsubmit' => 'event.preventDefault();');
        echo form_open(base_url() . 'opl/addTask', $attributes);
        $hasDescription = FALSE;
        ?>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="rubricTitle" class="font-weight-bold">Rubric Title</label>
                <input type="text" class="form-control" id="rubricTitle"
                    value="<?php echo $rubricDetails->ru_alias ?>"
                    placeholder="Enter rubric title">
            </div>

            <div class="form-group col-md-3">
                <label for="scale" class="font-weight-bold">Number of Scale</label>
                <input type="text" class="form-control" id="scale"
                    value="<?php echo $rubricDetails->ri_scale ?>"
                    placeholder="e.g. 5 or 10">
            </div>

            <div class="form-group col-md-3">
                <label for="inputType" class="font-weight-bold">Rubric Type</label>
                <select id="inputType" class="form-control">
                    <option value="">Select Rubric Type</option>
                    <option <?php echo ($rubricDetails->ru_type == 0 ? 'selected' : '') ?> value="0">In Test</option>
                    <option <?php echo ($rubricDetails->ru_type == 1 ? 'selected' : '') ?> value="1">Project Type</option>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-secondary mb-0"><i class="fas fa-list mr-1"></i>Criteria List</h6>
            <button type="button" onclick="addCriteriaModal()" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i>Add Criteria
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Criteria</th>
                        <th>Percentage</th>
                        <th id="thScale" colspan="<?php echo $rubricDetails->ri_scale ?>">Scale</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="criteriaBody">
                    <?php
                    $criteria = Modules::run('opl/getRubricCriteria', $ruid, $school_year);
                    foreach ($criteria->result() as $c):
                        $scale = Modules::run('opl/getRubricScaleDescription', $c->rcid, $school_year);
                    ?>
                        <tr>
                            <td><?php echo $c->rc_criteria ?></td>
                            <td><?php echo $c->rc_percentage ?>%</td>
                            <?php foreach ($scale->result() as $s):
                                if ($s->rd_description != "") $hasDescription = TRUE;
                            ?>
                                <td><?php echo $s->rd_scale ?></td>
                            <?php endforeach; ?>
                            <td>
                                <button onclick="editCriteriaModal($(this))"
                                    rcid="<?php echo $c->rcid ?>"
                                    criteria="<?php echo $c->rc_criteria ?>"
                                    percentage="<?php echo $c->rc_percentage ?>"
                                    class="btn btn-sm btn-outline-warning mr-1">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteCriteria($(this))"
                                    rcid="<?php echo $c->rcid ?>"
                                    class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php if ($hasDescription): ?>
                            <tr class="bg-light">
                                <td colspan="2"></td>
                                <?php
                                $i = 1;
                                foreach ($scale->result() as $d):  ?>
                                    <td class="small text-muted"><?php echo $d->rd_description ?></td>
                                <?php endforeach; ?>
                                <td></td>
                            </tr>
                    <?php endif;
                    endforeach; ?>
                </tbody>
            </table>
        </div>
        <input type="hidden" id="criteriaCounter" value="0" />
    </div>

    <!-- Add/Edit Criteria Modal -->
    <div class="modal fade" id="addCriteria" tabindex="-1" role="dialog" aria-labelledby="criteriaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="criteriaModalLabel"><i class="fas fa-balance-scale mr-1"></i> Criteria Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Name of Criteria</label>
                        <input onclick="if($('#inputType').val()==''){alert('Please Select Rubric Type!'); $('#inputTerm').focus();}"
                            type="text" class="form-control" id="rubricCriteria" placeholder="e.g. Content / Idea">
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Percentage of Criteria</label>
                        <input type="text" class="form-control" id="criteriaPercentage" placeholder="Enter percentage">
                    </div>
                    <input type="hidden" id="rcid" value="0" />

                    <div id="scaleDetails" class="pt-2 border-top"></div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="isEdit" value="0" />
                    <button type="button" class="btn btn-success" id="editBtn" onclick="addCriteriaToRubric()">
                        <i class="fas fa-check mr-1"></i>Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ADD / EDIT CRITERIA MODAL -->
<!-- <div class="modal fade" id="addCriteria" tabindex="-1" role="dialog" aria-labelledby="addCriteriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-clipboard-check mr-1"></i> Criteria Detailsss</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>Criteria Name</strong></label>
                    <input type="text" class="form-control" id="rubricCriteria" placeholder="e.g. Content / Idea">
                </div>

                <div class="form-group">
                    <label><strong>Percentage</strong></label>
                    <input type="number" class="form-control" id="criteriaPercentage" placeholder="Percentage of Criteria">
                </div>

                <div id="scaleDetails" class="border-top pt-3"></div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="isEdit" value="0" />
                <button type="button" class="btn btn-success" id="editBtn" onclick="addCriteriaToRubric()">
                    <i class="fas fa-check mr-1"></i>Save
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Cancel
                </button>
            </div>
        </div>
    </div>
</div> -->

<!-- Hidden Fields -->

<input type="hidden" id="rubricCode" value="<?php echo $ruid ?>" />
<input type="hidden" id="grade_level_id" value="<?php echo $gradeDetails->grade_level_id ?>" />
<input type="hidden" id="section_id" value="<?php echo $gradeDetails->section_id ?>" />
<input type="hidden" id="subject_id" value="<?php echo $subjectDetails->subject_id ?>" />
<input type="hidden" id="school_year" value="<?php echo $school_year ?>" />

<!-- Toast Container -->
<div aria-live="polite" aria-atomic="true" style="position: fixed; top: 1rem; right: 1rem; z-index: 1080;">
    <div class="toast" id="actionToast" data-delay="2500">
        <div class="toast-header bg-success text-white">
            <strong class="mr-auto"><i class="fas fa-check-circle mr-1"></i>Success</strong>
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
        </div>
        <div class="toast-body"></div>
    </div>
</div>

<script>
    $(function() {

        function showToast(message, isError = false) {
            $('#actionToast .toast-header')
                .toggleClass('bg-success', !isError)
                .toggleClass('bg-danger', isError);
            $('#actionToast .toast-body').text(message);
            $('#actionToast').toast('show');
        }

        window.addCriteriaModal = function() {
            $('#editBtn').text('Add');
            $('#addCriteria').modal('show');
            let scale = parseInt($('#scale').val()) || 0;
            let html = '';
            for (let i = 1; i <= scale; i++) {
                html += `
                <div class="form-group">
                    <label>Scale ${i}</label>
                    <input type="text" id="scale_desc_${i}" scale="${i}" class="form-control scaleCriteria" placeholder="Description for scale ${i}">
                </div>`;
            }
            $('#scaleDetails').html(html);
        };

        window.editCriteriaModal = function(that) {
            $('#rcid').val(that.attr('rcid'));
            $('#addCriteria').modal('show');
            $('#editBtn').text('Update');
            $('#rubricCriteria').val(that.attr('criteria'));
            $('#criteriaPercentage').val(that.attr('percentage'));
            $('#isEdit').val(1);
        };

        window.addCriteriaToRubric = function() {
            let criteriaName = $('#rubricCriteria').val();
            let criteriaPercentage = $('#criteriaPercentage').val();
            let scale = parseInt($('#scale').val());
            let rubricCode = $('#rubricCode').val();
            let rcid = $('#rcid').val();
            let descriptions = [];

            $('.scaleCriteria').each(function() {
                descriptions.push({
                    rd_scale: $(this).attr('scale'),
                    rd_description: $(this).val()
                });
            });

            $.ajax({
                type: "POST",
                url: "<?= base_url('opl/saveCriteria/') ?>",
                data: {
                    scales: JSON.stringify(descriptions),
                    criteriaName,
                    criteriaPercentage,
                    ruid: rubricCode,
                    rcid: rcid,
                    school_year: $('#school_year').val(),
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function(data) {
                    showToast('Criteria saved successfully!');
                    setTimeout(() => location.reload(), 800);
                },
                error: function() {
                    showToast('Error saving criteria.', true);
                }
            });
        };

        window.deleteCriteria = function(that) {
            if (!confirm('Are you sure you want to delete this criteria? This action cannot be undone.')) return;
            $.ajax({
                type: "POST",
                url: "<?= base_url('opl/deleteCriteria/') ?>",
                data: {
                    rcid: that.attr('rcid'),
                    school_year: $('#school_year').val(),
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function() {
                    showToast('Criteria deleted.');
                    setTimeout(() => location.reload(), 800);
                },
                error: function() {
                    showToast('Error deleting criteria.', true);
                }
            });
        };
    });
</script>