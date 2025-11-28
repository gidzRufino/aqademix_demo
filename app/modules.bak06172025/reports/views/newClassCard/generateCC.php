<div class="well col-lg-12">
    <div class="col-lg-2">
        <img class="img-circle img-responsive" style="width:100px; border:5px solid #fff" src="<?php if($student->avatar!=""):echo base_url().'uploads/'.$student->avatar;else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
    </div>
    <div class="col-lg-6">
        <h3 style="color:black; margin:3px 0;">
            <span id="name">
            <?php echo $student->firstname." ". $student->lastname ?></span> </h3>
        <h4 style="color:black; margin:3px 0;">
        <span id="grade">
            <?php echo $student->level ?> - <?php echo $student->section ?> </span> </h4>
        <h5 style="color:black; margin:3px 0;">
        <span  style="color:#BB0000;">
            <?php echo $student->uid ?></span> </h5>
        <input type="hidden" id="user_id" value="<?php echo base64_encode( $student->uid) ?>" />
    </div>
    <div class="col-lg-4 pull-right">
        <button style="margin-top:15px; margin-right:10px; font-size:280%;" id="genCardEnabled" onclick="printCard('<?php echo base64_encode($student->uid) ?>', <?php echo $sy ?>, <?php echo $term ?>)" class="btn btn-small btn-success"><i class="fa fa-book fa-fw"></i> Generate Card  </button>
    </div>
</div>
        
<div class="col-lg-6 pull-left">
    <input type="hidden" id="term" value="<?php echo $term ?>" />
    <input type="hidden" id="sy" value="<?php echo $sy ?>" />
    <h5>Final Grade</h5>
    <hr />
    <table class="table table-striped">
        <tr>
            <td>
                Subjects
            </td>
            <td>
                Final Number Grade
            </td>
            <td>
                Final Letter Grade
            </td>
        </tr>
        <?php $subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id); 
            $subject = explode(',', $subject_ids->subject_id);
            $i=0;
            foreach($subject as $s){  
            $singleSub = Modules::run('academic/getSpecificSubjects', $s);
            $finalGrade = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s, $term, $sy);              
            //if($singleSub->parent_subject==0):
        ?>
        <tr>
            <td><?php echo $singleSub->subject ?></td>
            <td style="text-align: center;">
                <?php 
                    if($finalGrade->num_rows()>0):
                        echo '<strong>'.$finalGrade->row()->final_rating.'</strong>';
                    else:
                        $i++;
                        echo 'no Final Grade Yet';
                    endif;
                ?>
               
            </td>
            <td style="text-align: center;">
                <?php
                    if($finalGrade->num_rows()>0):
                        $plg = Modules::run('gradingsystem/getLetterGrade', $finalGrade->row()->final_rating);
                            foreach($plg->result() as $plg){
                                if( $finalGrade->row()->final_rating > $plg->from_grade && $finalGrade->row()->final_rating <= $plg->to_grade){
                                    echo '<strong>'.$plg->letter_grade.'</strong>';
                                    //echo $this->session->userdata('term');

                                }
                            }
                    endif;
                ?>
                
            </td>
        </tr>
        <?php 
            //endif;
        }?>
    </table>
   <input type="hidden" id="no_subject" value="<?php echo $i ?>" /> 
   <?php
        $remarks = Modules::run('gradingsystem/getCardRemarks', $student->uid,$term, $sy);
   ?>
   <br /><br /><br />
    <h5 class="pull-left">Remarks for the Card</h5>
    <button onclick="saveRemarks('<?php echo $student->uid?>',<?php echo $term ?>,<?php echo $sy ?>)" class="pull-right btn btn-small btn-success"> Save Remarks</button>
    <br />
    <hr />   
    <textarea id="cardRemarks" style="width:100%;" rows="5">
        <?php 
            if($remarks->num_rows()>0):
                echo $remarks->row()->remarks;
            else:
                echo '';
            endif;
        ?>
    </textarea>
</div>
<div class="col-lg-6 pull-right">
    <h5>Personal Attribute</h5>
    <hr />
    <table class="table table-striped">
        <tr>
            <td>Details</td>
            <td>Ratings</td>
        </tr>
        <?php 
            foreach($behavior as $beh)
            {
                $behaviorRating = Modules::run('gradingsystem/getBHRating', $student->uid,$term, $sy, $beh->bh_id);    
                ?>
        <tr>
            <td><?php echo $beh->bh_name ?></td>
            <td>
               
             <select onclick="submitRating('<?php echo $student->uid?>', this.value, <?php echo $term ?>,<?php echo $sy ?>, <?php echo $beh->bh_id ?>)" tabindex="-1" style="width:200px" class="span2">
                    <?php if($behaviorRating->num_rows()>0):
                            switch ($behaviorRating->row()->rate){
                              case 1:
                                  $one = 'selected';
                                  $two = '';
                                  $three = '';
                                  $four = '';
                              break;    
                              case 2:
                                  $one = '';
                                  $two = 'selected';
                                  $three = '';
                                  $four = '';
                              break;    
                              case 3:
                                  $one = '';
                                  $two = '';
                                  $three = 'selected';
                                  $four = '';
                              break;    
                              case 4:
                                  $one = '';
                                  $two = '';
                                  $three = '';
                                  $four = 'selected';
                              break;    
                            }
                        else:
                                    $one = '';
                                  $two = '';
                                  $three = '';
                                  $four = '';
                    endif; ?> 
                    <option>Select Rating</option>
                    <option <?php echo $four ?> value="4">Outstanding</option>
                    <option <?php echo $three ?> value="3">Very Satisfactory</option>
                    <option <?php echo $two ?> value="2">Satisfactory</option>
                    <option <?php echo $one ?> value="1">Improving but not yet Satisfactory</option>
              </select>
            </td>
        </tr>
        
        <?php
            }
        ?>
        
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#searchAssessDate").select2();
        var noSubject =  $("#no_subject").val();
        if(noSubject!=0){
            $('#genCardDisabled').hide();
            $('#genCardEnabled').show();
        }else{
             $('#genCardDisabled').hide();
            $('#genCardEnabled').show();
        }
    });
    
    function submitRating(st_id, rating, grading, school_year, bh_id)
    {
        
        var url = "<?php echo base_url().'gradingsystem/saveBH/'?>"+st_id+'/'+rating+'/'+grading+'/'+school_year+'/'+bh_id ;
           $.ajax({
            type: "GET",
            url: url,
            data: 'qcode='+grading, // serializes the form's elements.
            success: function(data)
            {
                      
                      
            }
          });
    }
    
    function saveRemarks(st_id,grading, school_year)
    {
        var remarks = $('#cardRemarks').val();
        
        var url = "<?php echo base_url().'gradingsystem/saveRemarks/'?>"+st_id+'/'+remarks+'/'+grading+'/'+school_year ;
           $.ajax({
            type: "GET",
            url: url,
            data: 'qcode='+grading, // serializes the form's elements.
            success: function(data)
            {   
               alert('Remarks Save')
            }
          });
    }
    function printCard(st_id, sy, term)
    {
        var url = "<?php echo base_url().'reports/cc/printCC/'?>"+st_id+'/'+sy+'/'+term
        window.open(url, '_blank');
    }
</script>





