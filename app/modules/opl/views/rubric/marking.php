<button type="button" onclick="$('#rubricDetails_<?php echo $student->st_id ?>').modal('show')" id="rubricToggle_<?php echo $student->st_id ?>" class="btn btn-xs btn-primary float-right">Show Rubric Details</button>
<i class="fa fa-redo fa-xs float-right mt-1 mr-2 pt-1 text-muted" title="Let student retake the exam" onmouseover="$(this).addClass('fa-spin')" onmouseout="$(this).removeClass('fa-spin')" task-code="<?php echo $task->task_code; ?>" st-id="<?php echo $student->st_id; ?>" student-name="<?php echo $student->firstname . " " . $student->lastname; ?>" onclick="readyReset(this)"></i>
<?php $criteria = Modules::run('opl/getRubricCriteria', $rubricId, $school_year); ?>
<div class="modal col-12" id='rubricDetails_<?php echo $student->st_id ?>' tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg col-12" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="col-lg-12">Rubric Details
                    <span class="float-right">Total Possible Score : <span id="tps_<?php echo $student->st_id ?>" class="text-danger"><?php echo $totalScore ?></span> </span>
                </h4>
                <div class="form-group col-lg-12 float-left" id="rubricCriteriaWrapper">
                    <table class="table table-stripped table-hover table-responsive-sm">
                        <tr>
                            <th class="col-lg-1">Criteria</th>
                            <th class="text-center">Percentage</th>
                            <th class="text-center" id="thScale" colspan="<?php echo $criteria->row()->ri_scale ?>">SCALE</th>
                            <th class="text-center">Criterion Points</th>
                        </tr>
                        <tbody id="criteriaBody">
                            <?php
                            //print_r($criteria->result());
                            $totalScore = 0;
                            $rScore = 0;
                            foreach ($criteria->result()  as $c):
                                // echo $student->st_id . ' ' . $task->task_code . ' ' . $c->rcid . '<br>';
                                $scale = Modules::run('opl/getRubricScaleDescription', $c->rcid, $school_year);
                                $scoring = Modules::run('opl/getRubricMarkings', $student->st_id, $task->task_code, $c->rcid, $school_year);
                                $rScore = ($scoring->num_rows() > 0 ? $scoring->row()->sr_point : 0);
                                $totalScore += $rScore;
                            ?>
                                <tr>
                                    <td><?php echo $c->rc_criteria ?></td>
                                    <td class="text-center"><?php echo $c->rc_percentage ?></td>
                                    <?php
                                    foreach ($scale->result() as $s):
                                        $rubricMarking = Modules::run('opl/getRubricMarkings', $student->st_id, $task->task_code, $c->rcid, $school_year, $s->rdid);
                                    ?>
                                        <td onmouseover="$(this).addClass('bg-info')"
                                            onmouseout="$(this).removeClass('bg-info')"
                                            onclick="calculateCriterion($(this))"
                                            st_id="<?php echo $student->st_id ?>"
                                            marking="<?php echo ($rubricMarking->num_rows() > 0 ? $rScore : 0) ?>"
                                            criteria="<?php echo $c->rcid ?>"
                                            critPercent="<?php echo $c->rc_percentage ?>"
                                            scale_id="<?php echo $s->rdid ?>"
                                            val="<?php echo $s->rd_scale ?>"
                                            class="text-center hasScale_<?php echo $student->st_id ?>_<?php echo $c->rcid ?> <?php echo ($rubricMarking->num_rows() > 0 ? ($rubricMarking->row()->sr_rdid == $s->rdid ? 'bg-danger' : '') : '') ?>"><?php echo $s->rd_scale ?></td>
                                    <?php endforeach; ?>
                                    <td id="tcp_<?php echo $student->st_id . '_' . $c->rcid ?>" class="totalCriterionPoints text-center"><?php echo $rScore ?></td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total Score</th>
                                <td colspan="<?php echo $criteria->row()->ri_scale + 1 ?>"></td>
                                <th class="text-center" id="totalScore_<?php echo $student->st_id ?>"><?php echo $totalScore ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">

                <input type="hidden" class="form-control" id="numScale_<?php echo $student->st_id ?>" value="<?php echo $criteria->row()->ri_scale ?>">
                <input type="hidden" class="form-control" id="score_<?php echo $student->st_id ?>" value="" style="height: 25px;" placeholder="score" aria-label="score" aria-describedby="button-addon2">
                <button ans_id="<?php echo $ans_id ?>" onclick="saveRawScore($(this),'<?php echo $task->task_code ?>','<?php echo $student->st_id ?>')" type="button" class="btn btn-danger" id="saveBtn">Save My Marking</button>
                <button type="button" onclick="$('#rubricDetails_<?php echo $student->st_id ?>').modal('hide')" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // var tps = $('#tps_<?php echo $student->st_id ?>').html();

    calculateCriterion = function(that) {
        var tcp = 0;
        var score = 0;
        var st_id = that.attr('st_id');
        var critId = that.attr('criteria');
        var critPercent = parseFloat(that.attr('critPercent')) || 0;
        var scaleId = that.attr('scale_id');
        var value = parseFloat(that.attr('val')) || 0;
        var numScale = parseFloat($('#numScale_' + st_id).val()) || 1;
        var tps = parseFloat($('#tps_' + st_id).html()) || 0;

        $('.hasScale_' + st_id + '_' + critId).removeClass('bg-danger');
        var tcp_partial = (value / numScale) * (critPercent / 100);
        tcp = (tcp_partial * tps).toFixed(1);

        $('#tcp_' + st_id + '_' + critId).html(tcp);
        that.addClass('bg-danger');

        // limit the scope to this student's rubric table
        $('#rubricDetails_' + st_id + ' .totalCriterionPoints').each(function() {
            const val = parseFloat($(this).text());
            if (!isNaN(val)) score += val;
        });

        $('#totalScore_' + st_id).html(score);
        saveMarkings(st_id, '<?php echo $task->task_code ?>', tcp, scaleId, score, critId);
    };

    function saveMarkings(st_id, ref_id, point, rdid, totalScore, rcid) {
        var school_year = '<?php echo $school_year ?>';
        var base = $('#base').val();
        var url = base + 'opl/saveRubricMarkings';
        $.ajax({
            type: "POST",
            url: url,
            data: {
                sr_stid: st_id,
                sr_ref_id: ref_id,
                sr_rdid: rdid,
                rcid: rcid,
                sr_point: point,
                sr_comment: '',
                is_question: '<?php echo $isQuestion ?>',
                school_year: school_year,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data) {
                //                $('.totalCriterionPoints').each(function(){
                //                    score += parseFloat($(this).html());
                //                });
                $('#score_' + st_id).val(totalScore)
            }
        });
    }

    saveRawScore = function(that, task_code, st_id) {
        var base = $('#base').val();
        var url = base + 'opl/qm/saveRawScore';

        $.ajax({
            type: 'POST',
            url: url,
            data: {
                st_id: st_id,
                score: $('#totalScore_' + st_id).text(),
                task_code: task_code,
                ans_id: that.attr('ans_id'),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            dataType: 'json',
            success: function(data) {
                alert(data.message);
                location.reload();
            }
        });
    };
</script>