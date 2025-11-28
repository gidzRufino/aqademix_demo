<?php 
$equivalent = 0;
$partial = null;

?>
<script type="text/javascript">
      $(function() {
			$("#tableSort").tablesorter({debug: true});
		});  
    </script>
<table id="tableSort" class="tablesorter table table-striped "> 
<thead style="background: #E6EEEE;">
    <tr> 
        <th>Student</th>   
        <?php
        foreach($category as $cat)
        {
        ?>
            <th class="text-center"><?php echo $cat->component.'<br /> ( '.($cat->weight*100).'% )' ?></th>    
        <?php
        }
        ?>  
            <th class="text-center">Initial Grade</th>
            <th class="text-center">Transmuted Grade</th>
            <td class="text-center">Action</td>
        </tr>
</thead>
<tbody>
<?php 
foreach($students->result() as $student )
{
    ?>
<tr class="main"> 
    <td class="text-center" ><?php echo strtoupper($student->lastname.', '.$student->firstname) ?></td>
    <?php
        $a = 0;
        
        foreach($category as $cat => $k)
        {
        ?>
        <td  class="text-center pointer"  data-target="#assess_details" data-toggle="modal" onclick="getIndividualAssessment('<?php echo $student->st_id ?>',<?php echo $subject_id ?>,<?php echo $k->code ?>, <?php echo $term ?>)" class="values" >
         <?php
          $record = Modules::run('gradingsystem/getTotalScoreByStudent', $student->st_id, $k->code, $term , $subject_id, $this->session->userdata('employee_id'));
          $numberOfAssessment = Modules::run('gradingsystem/getEachScoreByStudent', $this->session->userdata('employee_id'), $k->code,   $term, $subject_id,1, $student->section_id, $this->session->userdata('employee_id'));
          //print_r($numberOfAssessment->row());
          
          if($numberOfAssessment->num_rows()>0){
//                foreach ($record->result() as $r):
//                    echo $r->as_id.' - '.$r->raw_score.' | ';
//                endforeach;
              $record = $record->row()->score;
              $tps = $numberOfAssessment->row()->TPS;
              
              $ps = (($record/$tps)*100);
              $ws = round(($ps*$k->weight), 2);
              //$ws = $record.' | '.$tps;
//              
//              //ps = percentage score
//              //ws = weighted score
              
              echo $ws;
            }

        else{
             echo 0;
           }

        
        $final += $ws;
        ?>
           </td>
           
        <?php
        }

        
        
        
?>    
    <td class="partial text-center">
        <?php
              echo round($final, 2); 
        ?>
    </td>  
    <td class="text-center">
        <?php
         $partialGrade = round($final, 3);
         if($final!==0){
                $plg = Modules::run('gradingsystem/new_gs/getTransmutation', round($final, 2));
                echo $plg;
            }
            ?>
    </td> 
    <td id="<?php echo $student->st_id ?>_btn_validate" >
        
        <?php 
            $isGradeValidated = Modules::run('gradingsystem/isGradeValidated', $student->st_id, $subject_id, $term, $school_year);
            $p_assessment = Modules::run('gradingsystem/getPartialAssessment',$student->st_id, $section_id, $subject_id, $school_year);
            $termValidated = $p_assessment->is_validated;
            $termSelected = $term;
            if(!$isGradeValidated):
                //echo $termValidated.' '. $term;s
                if($term<=$termValidated):
                    ?>
                    <button id="<?php echo $student->st_id ?>_validate" onclick="validateGrade('<?php echo trim($student->st_id) ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $plg ?>)" class="btn btn-small btn-info hide">Validate</button>
                    <button id="<?php echo $student->st_id ?>_invalidate" onclick="invalidateGrade('<?php echo trim($student->st_id) ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $plg ?>)" class="btn btn-small btn-success">Validated</button>
                    <?php
                else:    
                ?>
                   <button id="<?php echo $student->st_id ?>_validate" onclick="validateGrade('<?php echo trim($student->st_id) ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $plg ?>)" class="btn btn-small btn-info">Validate</button>
                   <button id="<?php echo $student->st_id ?>_invalidate" onclick="invalidateGrade('<?php echo trim($student->st_id) ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $plg ?>)" class="btn btn-small btn-success hide">Validated</button>
                <?php
                endif;
            else:
                //echo $termValidated.' '.$term.' '.$this->session->userdata('term');
                if($termValidated==$this->session->userdata('term')):
                    ?>
                    <button id="<?php echo $student->st_id ?>_validate" onclick="validateGrade('<?php echo trim($student->st_id) ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $plg ?>)" class="btn btn-small btn-info hide">Validate</button>
                    <button id="<?php echo $student->st_id ?>_invalidate" onclick="invalidateGrade('<?php echo trim($student->st_id) ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $plg ?>)" class="btn btn-small btn-success">Validated</button>
                    <?php
                else:
                   // echo 'validated in this '.$term.' Quarter';
                    if($termSelected<=$termValidated):
                          ?>
                            <button id="<?php echo $student->st_id ?>_validate" onclick="validateGrade('<?php echo trim($student->st_id) ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $plg ?>)" class="btn btn-small btn-info hide">Validate</button>
                            <button id="<?php echo $student->st_id ?>_invalidate" onclick="invalidateGrade('<?php echo trim($student->st_id) ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $plg ?>)" class="btn btn-small btn-success">Validated</button>
                         <?php
                        else:    
                        ?>
                           <button id="<?php echo $student->st_id ?>_validate" onclick="validateGrade('<?php echo trim($student->st_id) ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $plg ?>)" class="btn btn-small btn-info">Validate</button>
                           <button id="<?php echo $student->st_id ?>_invalidate" onclick="invalidateGrade('<?php echo trim($student->st_id) ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $plg ?>)" class="btn btn-small btn-success hide">Validated</button>
                        <?php
                    endif;
                endif;
            endif;
        ?>
    </td>
</tr>
<?php
    $partial = 0;
    Modules::run('gradingsystem/recordPartialAssessment', $student->uid, $section_id , $subject_id, $term, $school_year, $partialGrade);
    unset($final); 
} //end of foreach

?>
</tbody>
</table>
    
 <script type="text/javascript">

$("td.values").each(function(){
    var sum = 0;
    $(this).nextUntil("td.values").each(function(){
            sum +=  parseInt($(this).find(".sum_values").text(), 10)

     });
    $(this).find(".partial").html(sum);
})


function getIndividualAssessment(st_id, subject, qcode, term){
    
  var total = $('#'+st_id+qcode+'_totalAssessPerCat').val();
  var url = "<?php echo base_url().'gradingsystem/getIndividualAssessment/'?>"; // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: "st_id="+st_id+"&subject_id="+subject+"&qcode="+qcode+"&term="+term, // serializes the form's elements.
           success: function(data)
           {
               $('#assess_details').html(data)
               $('#totalAssessPerCat').html(total)
               //  alert(total);
           }
         });

    return false;
}

function validateGrade(st_id, subject_id, term, rate)
{
        var section_id = $('#section_id').val();
       var answer = confirm("Do you really want to Validate this to Final Rating? Doing so will prevent you from editing.");
        if(answer==true){
           var url = "<?php echo base_url().'gradingsystem/validateGrade/'?>"+st_id+'/'+subject_id+'/'+term+'/'+rate+'/'+section_id ;
           $.ajax({
            type: "GET",
            url: url,
            data: 'qcode='+term, // serializes the form's elements.
            success: function(data)
            {
                $('#'+st_id+'_validate').addClass('hide')     
                  $('#'+st_id+'_invalidate').removeClass('hide')    
            }
          });
        }else{

           return FALSE
        }




}

function invalidateGrade(st_id, subject_id, term, rate)
{
        var section_id = $('#section_id').val();
       var answer = confirm("Do you really want to revoke the validity of this Final Rating.");
        if(answer==true){
           var url = "<?php echo base_url().'gradingsystem/inValidateGrade/'?>"+st_id+'/'+subject_id+'/'+term+'/'+rate+'/'+section_id ;
           $.ajax({
            type: "GET",
            url: url,
            data: 'qcode='+term, // serializes the form's elements.
            success: function(data)
            {
                  $('#'+st_id+'_invalidate').addClass('hide')     
                  $('#'+st_id+'_validate').removeClass('hide')        
                 // $('#'+st_id+'_btn_validate').html($('#'+st_id+'_validate'))     
            }
          });
        }else{

           return FALSE
        }




}

    

     </script>



