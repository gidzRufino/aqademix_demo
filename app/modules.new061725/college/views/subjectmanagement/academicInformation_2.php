<?php 
    
    $school_year = ($this->uri->segment(5)!=NULL?$this->uri->segment(5):$this->session->school_year);
    $acadSubjects = Modules::run('college/subjectmanagement/getLoadedSubject', $students->admission_id);
?>

<div class="col-lg-12 page-header">
    <table class="table table-hover">
        <tr>
            <th  style="width:10%;" >
                Subject Code
            </th>
            <th style="width:30%;" >Subject Description</th>
            <?php foreach($term->result() as $t): 
                    ?>
                <th style="width:10%;"  class="text-center"><?php echo $t->gst_term; ?></th>
            <?php endforeach; ?>
                <th>Final Grade</th>
                <th style="width:10%;" class="text-center" >Semester</th>
                <th style="width:10%;" class="text-center" >School Year</th>
        </tr>
        <?php
           //    print_r($acadSubjects->result());
            foreach ($acadSubjects as $as):
                $sy = $as->school_year;
                $subject = Modules::run('college/subjectmanagement/getSubjectPerId', $as->s_id);
                switch ($as->sec_sem):
                    case 1:
                        $semester = 'First';
                    break;
                    case 2:
                        $semester = 'Second';
                    break;
                    case 3:
                        $semester = 'Summer';
                    break;
                endswitch;
        ?>        
        <tr>        
            <td style="width:10%;" ><?php echo $subject->sub_code; ?></td>
            <td style="width:30%;" ><?php echo $subject->s_desc_title; ?></td>
         <?php  
         foreach($term->result() as $t):  
                    $grade = Modules::run('college/gradingsystem/getFinalGrade', $students->st_id, $students->course_id, $as->s_id, $as->sec_sem, $as->sec_school_year, $t->gst_id);
                
                if($this->session->is_admin):
            ?>
                    <input type="hidden" id="raw_<?php echo $as->s_id.'_'.$ac->gsc_id.'_'.$t->gst_id ?>" value="<?php echo $grade->gsa_grade; ?>" />
            <?php
                endif;
                
                $finalGrade += $grade->gsa_grade * $t->term_weight;
         ?>
            <td
                id="td_<?php echo $as->s_id.$t->gst_id.$as->sec_sem ?>"
                onclick="getInitialGrade('<?php echo $as->s_id ?>', '<?php echo $details->st_id ?>', '<?php echo $t->gst_id ?>','<?php echo $as->sec_sem ?>','<?php echo $as->sec_school_year ?>','<?php echo $subject->sub_code ?>','<?php echo $t->gst_term ?>','<?php echo $grade->gsa_grade ?>'  )"
                style="width:10%;" class="text-center grade_<?php echo $as->s_id ?>">
                <strong><?php echo $grade->gsa_grade; ?></strong>
            </td>

            <?php 
            
         endforeach;
        ?>
            <td class="text-center"><?php echo number_format($finalGrade,2,'.',',') ?><strong></td>
            <td style="width:10%;"  class="text-center"><?php echo $semester ?></td>    
            <td style="width:10%;"  class="text-center"><?php echo $as->sec_school_year ?></td>    
            
            <?php if($this->session->is_admin || $this->session->position!='Registrar Staff' || $this->session->position=='Registrar'): ?>
            <td class="text-right">
                    <button title="Overwrite Grades" onclick="$('.grade_<?php echo $as->s_id ?>').addClass('editable'),$('.grade_<?php echo $as->s_id ?>').html('[click here to enter grade]') "  style="margin: 10px;" class="btn btn-warning btn-xs pull-right"><i class="fa fa-edit"></i></button>
                    
                </td>
                
            <?php endif; ?>
        </tr>
        <?php
            unset($finalGrade);
        endforeach; ?>
    </table>
    
</div>

<?php if($this->session->is_admin): ?>
<?php if($term->result()) : ?>
    <?php if($this->session->userdata('position_id') == 1 || $this->session->position=='Registrar'): ?>
        <div class="col-lg-12">
            <button title="Print Card" onclick="printClassCard('<?php echo base64_encode($details->st_id) ?>', '<?php echo $sem ?>', '<?php echo $sy ?>')" class="btn btn-success pull-right">PRINT CARD</button><br /> <br />
        </div>
    <?php endif; ?>

    <div id="confirmPrintCard"  style="margin: 50px auto;"  class="modal fade col-lg-3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-red" style='width:100%;'>
            <div class="panel-heading">
                <h6>Select School Year and Semester to Print</h6>
            </div>
            <div class="panel-body">
                
                <div class="form-group pull-left">
                        <select onclick="getStudentByYear(this.value)" tabindex="-1" id="inputCardSY" style="width:200px; font-size: 15px;">
                            <option>School Year</option>
                            <?php 
                                  $ro_year = Modules::run('college/getROYear');
                                  foreach ($ro_year as $ro)
                                   {   
                                      $roYears = $ro->ro_years+1;
                                      if($this->session->userdata('school_year')==$ro->ro_years):
                                          $selected = 'Selected';
                                      else:
                                          $selected = '';
                                      endif;
                                  ?>                        
                                <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$roYears; ?></option>
                                <?php }?>
                        </select>
                 </div>
                
                <div class="form-group pull-left">
                        <select tabindex="-1" id="inputCardSem" onclick="checkIfClaim('<?php echo base64_encode($details->st_id) ?>')" style="width:200px; font-size: 15px;" class=" ">
                            <option>Select Semester</option>
                            <option value="1">First</option>
                            <option value="2">Second</option>
                            <option value="3">Summer</option>
                        </select>
                 </div>
                <div class="pull-left" >
                    <input type="checkbox" checked="" id="claimedCheck" /> Consider this card as claimed
                </div>
                <div style="display: none;" id="claimStatus" class="pull-left alert alert-danger col-lg-12 ">
                    
                </div>
            </div>
            <div class="panel-footer">
                <button id="cancelPrintBtn" data-dismiss="modal" class="btn btn-danger pull-right">NO</button>
                <button id="printCardBtn" class="btn btn-success pull-right">YES</button>
            </div>
        </div>
    </div>
<?php endif;  ?>
<div id="overWriteModal"  style="margin: 50px auto;"  class="modal fade col-lg-3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading">
            <h6>Overwrite Grades in <span id="overWriteSubjects"></span> in <span id="overWriteTerm"></span></h6>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label">Grade:</label>
                <input style="margin-bottom:0;" class="form-control"    name="exam" type="text" id="exam" required>
            </div>
            <input type="hidden" id="overWriteSubId" name="overWriteSubId" />
            <input type="hidden" id="overWriteSt_id" name="overWriteSt_id" />
            <input type="hidden" id="overWriteTermId" name="overWriteTermId" />
            <input type="hidden" id="overWriteSem" name="overWriteSem" />
            <input type="hidden" id="overWriteSY" name="overWriteSY" />
            <input type="hidden" id="overWriteCourse" name="overWriteCourse" value="<?php echo $details->course_id ?>" />
        </div>
        <div class="panel-footer">
            <button id="overWriteBtn" class="btn btn-success pull-right">Overwrite Grade</button>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    function getInitialGrade(sub_id, st_id, term, sem, sy, subject, termName, grade)
    {
        if($('#td_'+sub_id+term+sem).hasClass('editable'))
        {
            $('#classStanding').val($('#raw_'+sub_id+'_1_'+term).val());
            $('#exam').val(grade);
            $('#overWriteSubjects').html(subject);
            $('#overWriteTerm').html(termName);
            $('#overWriteSubId').val(sub_id);
            $('#overWriteSt_id').val(st_id);
            $('#overWriteTermId').val(term);
            $('#overWriteSem').val(sem);
            $('#overWriteSY').val(sy);
            
            
            
            $('#overWriteModal').modal('show');
        }
    }
    
    $('#overWriteBtn').click(function(){
         $.ajax({
                type: "POST",
                url: "<?php echo base_url().'college/gradingsystem/updateGrade' ?>",
                dataType: 'json',
                data:{
                    st_id           : $('#overWriteSt_id').val(),
                    term            : $('#overWriteTermId').val(),
                    exam            : $('#exam').val(),
                    year_level      : '<?php echo $students->year_level ?>',
                    subject         : $('#overWriteSubId').val(),
                    semester        : $('#overWriteSem').val(),
                    school_year     : $('#overWriteSY').val(),
                    course_id       : $('#overWriteCourse').val(),
                    csrf_test_name  : $.cookie('csrf_cookie_name')
                },
                cache: false,
                success: function(data) {
                    alert(data.msg);
                    location.reload();
                }
            });
        return false;    
    });
    
    function setFinalGrade(sub_id, st_id, sem, sy)
    {
        
        $.ajax({
                type: "POST",
                url: "<?php echo base_url().'college/gradingsystem/getFinalGradePerSubject/' ?>"+st_id+'/'+sub_id+'/'+sem+'/'+sy,
                dataType: 'json',
                data:{
                    st_id           : st_id,
                    semester        : sem,
                    school_year     : sy,
                    subject_id      : sub_id,
                    csrf_test_name  : $.cookie('csrf_cookie_name')
                },
                success: function(data) {
                   console.log(data)
                }
            });
        return false;
    }
    
    function checkIfClaim(st_id)
    {
        
        var semester = $('#inputCardSem').val();
        var school_year = $('#inputCardSY').val();
        
        $.ajax({
                type: "POST",
                url: "<?php echo base_url().'college/subjectmanagement/checkIfDocIsClaimed' ?>",
                dataType: 'json',
                data:{
                    st_id           : st_id,
                    semester        : semester,
                    school_year     : school_year,
                    doc_type        : 'Class Card',
                    csrf_test_name  : $.cookie('csrf_cookie_name')
                },
                success: function(data) {
                    if(data.isClaimed)
                    {
                        $('#claimStatus').show();
                        $('#claimStatus').html(data.details);
                        $('#printCardBtn').html('Reprint')
                    }
                }
            });
        return false;
    }
    
    function printClassCard(st_id, sem, sy)
    {
        $('#confirmPrintCard').modal('show');
        
        $('#printCardBtn').click(function(){
            
            var semester = $('#inputCardSem').val();
            var school_year = $('#inputCardSY').val();
            
            if($('#claimedCheck').is(':checked')){
                var url = "<?php echo base_url('college/subjectmanagement/printClassCard')?>/"+st_id+'/'+semester+'/'+school_year+'/'+1;
            }else{
                var url = "<?php echo base_url('college/subjectmanagement/printClassCard')?>/"+st_id+'/'+semester+'/'+school_year;
            }
            window.open(url, '_blank');
            $('#confirmPrintCard').modal('hide');
        });
    }
    
    
</script>
<?php endif;

