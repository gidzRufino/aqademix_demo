<div class="modal fade" id="ovrSubj" role="dialog" align="left">
    <div class="modal-dialog modal-lg-12" style="width: 60%">
        <div class="modal-content col-md-12">
            <div class="modal-header panel-danger">
                <h3>Add Subject</h3>
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
                <dl class="dl-horizontal" id="sectionSelect" hidden="">
                    <dt>
                        Select Section:
                    </dt>
                    <dd>
                        <select style="height:35px; width: 225px;"  name="selectSection" id="selectSection" required>
                            <option value="0">Select Section</option>  
                        </select>
                    </dd>
                </dl>
                <dl class="dl-horizontal" id="strandSelect" hidden="">
                    <dt>
                        Select Strand:
                    </dt>
                    <dd>
                        <select style="height:35px; width: 225px;"  name="semesterSelect" id="semesterSelect" required >
                            <option disabled="" selected="">Select Semester</option>
                            <option value="1" onclick="$('#selectStrand').prop('disabled', false)">1st Semester</option>
                            <option value="2" onclick="$('#selectStrand').prop('disabled', false)">2nd Semester</option>
                        </select>
                        <?php $listStrand = Modules::run('registrar/getSeniorHighStrand'); ?>
                        <select style="height:35px; width: 225px;"  name="selectStrand" id="selectStrand" required disabled="">
                            <option value="0">Select Strand</option>
                            <?php foreach ($listStrand as $ls): ?>
                                <option value="<?php echo $ls->st_id ?>" onclick="$('#idStrand').val(this.value), getSubject($('#semesterSelect').val())"><?php echo $ls->strand ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" id="idStrand" name="idStrand">
                    </dd>
                </dl>
                <dl class="dl-horizontal" id="subjectSelect" hidden="">
                    <dt>
                        Select Subject:
                    </dt>
                    <dd>
                        <select style="height:35px; width: 225px;"  name="selectSubject" id="selectSubject" required>
                            <option value="0">Select Subject</option>  
                        </select>
                    </dd>
                </dl>
                <dl class="dl-horizontal" id="selectSem" hidden="">
                    <dt>
                        Select Term:
                    </dt>
                    <dd>
                        <select style="height:35px; width: 225px;"  name="semSelect" id="semSelect" required>
                            <option value="0" disabled="" selected="">Select Term</option>
                            <option value="1">First Sem</option>
                            <option value="2">Second Sem</option>
                        </select>&nbsp;[ Select Semester Enrolled ]
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
        if (grade == 12 || grade == 13) {
            $('#termSelect').show();
            $('#strandSelect').show();
            $('#subjectSelect').show();
            $('#sectionSelect').show();
            $('#selectSem').show();
        } else {
            $('#termSelect').hide();
            $('#sectionSelect').show();
            $('#subjectSelect').show();
            $('#strandSelect').hide();
            $('#selectSem').hide();
        }
        var url = '<?php echo base_url() . 'registrar/getSectionByGL/' ?>' + grade + '/' + 1;
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

    function getSubject(term) {
        var grade = $('#grade_level').val();
        var strand = $('#idStrand').val();
        var url = '<?php echo base_url() . 'academic/getSpecificSubjectPerlevel/' ?>' + grade + '/' + <?php echo $this->session->userdata('school_year') ?> + '/' + 1 + '/' + term + '/' + strand;

        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $('#subjectSelect').show();
                $('#selectSubject').html(data);
            }
        })
    }



</script>