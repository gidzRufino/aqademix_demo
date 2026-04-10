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
        if($subject_id!=20):
            foreach($category as $cat)
            {
            ?>
                <th><?php echo $cat->category_name.'<br /> ( '.($cat->weight*100).'% )' ?></th>    
            <?php
            }
            ?>
             <th>Partial Number Grade</th>
            <td>Partial Letter Grade</td>
            <?php    
        else:
           ?>
                <th>Score</th>
           <?php
        endif;
            ?>  
            <td>Action</td>
        </tr>
</thead>
<tbody>
<?php 
foreach($students->result() as $student )
{
    ?>
<tr class="main"> 
    <td ><?php echo strtoupper($student->lastname.', '.$student->firstname) ?></td>
    <?php
        $a = 0;
        if($subject_id!=20):
            foreach($category as $cat => $k)
            {
            ?>
            <td style="cursor:pointer;" data-target="#assess_details" data-toggle="modal" onclick="getIndividualAssessment('<?php echo $student->st_id ?>',<?php echo $subject_id ?>,<?php echo $k->code ?>, <?php echo $term ?>)" class="values" >
             <?php
              $record = Modules::run('gradingsystem/getTotalScoreByStudent', $student->st_id, $k->code, $term , $subject_id);
              $numberOfAssessment = Modules::run('gradingsystem/getEachScoreByStudent', $student->st_id, $k->code,   $term, $subject_id);
             // echo $numberOfAssessment->num_rows();
              if($numberOfAssessment->num_rows()>0){
                  $record = $record->row();

                  $partialAssess = round(($record->total/$numberOfAssessment->num_rows())*$record->weight, 3);

                  echo round(($record->total/$numberOfAssessment->num_rows()), 3);

                }

            else{
                $a++;
                $partialAssess = $record->row()->weight*65;
                 echo 0;
               }
            if($a==4):
               $partialAssess = 0; 
            endif;
            $partial = $partial + $partialAssess; 


            $final = $partial;
            ?>
               </td>

            <?php
            }
        else:
             foreach($category as $cat => $k)
            {
               if($k->code==11):
            ?>
                <td style="cursor:pointer;" data-target="#assess_details" data-toggle="modal" onclick="getIndividualAssessment('<?php echo $student->st_id ?>',<?php echo $subject_id ?>,<?php echo $k->code ?>, <?php echo $term ?>)" class="values" >
                 <?php
                  $record = Modules::run('gradingsystem/getTotalScoreByStudent', $student->st_id, $k->code, $term , $subject_id);
                  $numberOfAssessment = Modules::run('gradingsystem/getEachScoreByStudent', $student->st_id, $k->code,   $term, $subject_id);
                 // echo $numberOfAssessment->num_rows();
                  if($numberOfAssessment->num_rows()>0){
                      $record = $record->row();

                      $partialAssess = $record->total;

                      echo $record->total;

                    }

                else{
                    $a++;
                    //$partialAssess = $record->row()->weight*65;
                     echo 0;
                   }
                if($a==4):
                   $partialAssess = 0; 
                endif;
                $partial = $partialAssess; 


                $final = $partial;
                $partialGrade = $final;
                ?>
                   </td>

                <?php
                endif;
            }
        endif;
        
        
        unset($partial);
        
    if($subject_id!=20):    
?>    
        <td class="partial">
            <?php
                if($final<=65):
                  echo $final = 65;
                else:
                   echo round($final, 3); 
                endif;

            ?>
        </td>  

        <td>
            <?php
             $partialGrade = round($final, 3);
             if($final!==0){
                $plg = Modules::run('gradingsystem/getLetterGrade', $final);
                    foreach($plg->result() as $plg){
                        if( $final > $plg->from_grade && $final <= $plg->to_grade){
                            echo $plg->letter_grade;
                            //echo $this->session->userdata('term');

                        }
                    }

                } ?>
        </td> 
    <?php
    
                
    endif;
?>
    <td id="<?php echo $student->st_id ?>_btn_validate" >
        
        <?php 
            $isGradeValidated = Modules::run('gradingsystem/isGradeValidated', $student->st_id, $subject_id, $term, $school_year);
            $p_assessment = Modules::run('gradingsystem/getPartialAssessment',$student->st_id, $section_id, $subject_id, $school_year);
            $termValidated = $p_assessment->is_validated;
            $termSelected = $term;
            if(!$isGradeValidated):
                //echo $termValidated.' '. $term;
                if($term<=$termValidated):
                    ?>
                    <button id="<?php echo $student->st_id ?>_validate" onclick="validateGrade('<?php echo $student->st_id ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $partialGrade ?>)" class="btn btn-small btn-info hide">Validate</button>
                    <button id="<?php echo $student->st_id ?>_invalidate" onclick="invalidateGrade('<?php echo $student->st_id ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $partialGrade ?>)" class="btn btn-small btn-success">Validated</button>
                    <?php
                else:    
                ?>
                   <button id="<?php echo $student->st_id ?>_validate" onclick="validateGrade('<?php echo $student->st_id ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $partialGrade ?>)" class="btn btn-small btn-info">Validate</button>
                   <button id="<?php echo $student->st_id ?>_invalidate" onclick="invalidateGrade('<?php echo $student->st_id ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $partialGrade ?>)" class="btn btn-small btn-success hide">Validated</button>
                <?php
                endif;
            else:
                //echo $termValidated.' '.$term.' '.$this->session->userdata('term');
                if($termValidated==$this->session->userdata('term')):
                    //echo 'validated in this '.$this->session->userdata('term').' Quarter';
                    ?>
                    <button id="<?php echo $student->st_id ?>_validate" onclick="validateGrade('<?php echo $student->st_id ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $partialGrade ?>)" class="btn btn-small btn-info hide">Validate</button>
                    <button id="<?php echo $student->st_id ?>_invalidate" onclick="invalidateGrade('<?php echo $student->st_id ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $partialGrade ?>)" class="btn btn-small btn-success">Validated</button>
                    <?php
                else:
                   // echo 'validated in this '.$term.' Quarter';
                    if($termSelected==$termValidated):
                          ?>
                            <button id="<?php echo $student->st_id ?>_validate" onclick="validateGrade('<?php echo $student->st_id ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $partialGrade ?>)" class="btn btn-small btn-info hide">Validate</button>
                            <button id="<?php echo $student->st_id ?>_invalidate" onclick="invalidateGrade('<?php echo $student->st_id ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $partialGrade ?>)" class="btn btn-small btn-success">Validated</button>
                         <?php
                    endif;
                endif;
            endif;
        ?>
    </td>
</tr>
<?php
    $partial = 0;
    $final = 0;
    Modules::run('gradingsystem/recordPartialAssessment', $student->uid, $section_id , $subject_id, $term, $school_year, $partialGrade);
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



