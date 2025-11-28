<div class="modal fade" id="ovrSubj" role="dialog" align="left">
    <div class="modal-dialog modal-lg-12" style="width: 60%">
        <div class="modal-content col-md-12">
            <div class="modal-header panel-danger">
                <h3>Add Overload Subject</h3>
            </div>
            <div class="modal-body">
                <dl class="dl-horizontal">
                    <dt>
                        <?php $gLevel = Modules::run('registrar/getGradeLevel'); ?>
                        Select Grade Level:
                    </dt>
                    <dd>
                        <select style="height:35px; width: 200px;" id="grade_level" name="grade_level">
                            <option value="0">Select Grade Level</option>
                            <?php foreach ($gLevel as $g): ?>
                                <option value="<?php echo $g->grade_id ?>" onclick="getSectionByLevel('<?php echo $g->grade_id ?>')"><?php echo $g->level ?></option>
                            <?php endforeach; ?>
                        </select>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Select Section:
                    </dt>
                    <dd>
                        <select style="height:35px; width: 225px;"  name="selectSection" id="selectSection" required>
                            <option value="0">Select Section</option>  
                        </select>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Select Subject:
                    </dt>
                    <dd>
                        <select style="height:35px; width: 225px;"  name="selectSubject" id="selectSubject" required>
                            <option value="0">Select Subject</option>  
                        </select>
                    </dd>
                </dl>
                <span id="errorMsg"></span>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-small pull-right" id="saveOvrSubj"><i class="fa fa-save"></i>&nbsp;Save</button>
                <button class="btn btn-danger btn-small pull-right" onclick="$('#ovrSubj').modal('hide')"><i class="fa fa-times"></i>&nbsp;Cancel</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function getSectionByLevel(grade) {
        var url = '<?php echo base_url() . 'registrar/getSectionByGL/' ?>' + grade;
        $.ajax({
            type: 'GET',
            url: url,
            success: function (section) {
                $('#selectSection').html(section);

                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url() . 'academic/getSpecificSubjectPerlevel/' ?>' + grade + '/' + <?php echo $this->session->userdata('school_year') ?> + '/' + 1,
                    success: function (subj) {
                        $('#selectSubject').html(subj);
                    }
                });
            }
        });
    }
</script>