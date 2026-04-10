<?php 
$equivalent = 0;
$partial = null;

?>
<div class="row">
    <div class="col-xs-12 table-responsive">
    <table class="table table-stripped table-bordered"> 
        <thead style="background: #E6EEEE;">
    <tr> 
        <th>Student</th>   
        <?php
        foreach($category as $cat)
        {
        ?>
            <th><?php echo $cat->category_name.'<br /> ( '.($cat->weight*100).'% )' ?></th>    
        <?php
        }
        ?>  
            <th>Partial Number Grade</th>
            <td>Partial Letter Grade</td>
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
        
        foreach($category as $cat => $k)
        {
        ?>
        <td style="cursor:pointer;" onclick="getIndividualAssessment('<?php echo $student->user_id ?>',<?php echo $subject_id ?>,<?php echo $k->code ?>, <?php echo $term ?>)" class="values" >
         <?php
          $record = Modules::run('gradingsystem/getTotalScoreByStudent', $student->user_id, $k->code, $term , $subject_id);
          $numberOfAssessment = Modules::run('gradingsystem/getEachScoreByStudent', $student->user_id, $k->code,   $term, $subject_id);
          //$numberOfAssessment->num_rows();
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

        unset($partial);
        
        
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
    <td id="<?php echo $student->user_id ?>_btn_validate" >
        
        <?php 
            $isGradeValidated = Modules::run('gradingsystem/isGradeValidated', $student->user_id, $subject_id, $term);
            if(!$isGradeValidated):
      
        ?>
        <button id="<?php echo $student->user_id ?>_validate" onclick="validateGrade('<?php echo $student->user_id ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $partialGrade ?>)" class="btn btn-small btn-info">Validate</button>
        <button id="<?php echo $student->user_id ?>_invalidate" onclick="invalidateGrade('<?php echo $student->user_id ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $partialGrade ?>)" class="btn btn-small btn-success hide">Validated</button>
        <?php 
            else:
        ?>
        <button id="<?php echo $student->user_id ?>_validate" onclick="validateGrade('<?php echo $student->user_id ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $partialGrade ?>)" class="btn btn-small btn-info hide">Validate</button>
        <button id="<?php echo $student->user_id ?>_invalidate" onclick="invalidateGrade('<?php echo $student->user_id ?>',<?php echo $subject_id ?>,<?php echo $term ?>, <?php echo $partialGrade ?>)" class="btn btn-small btn-success">Validated</button>
        <?php
            endif;
        ?>
    </td>
</tr>
<?php
    $partial = 0;
    Modules::run('gradingsystem/recordPartialAssessment', $student->uid, $section_id , $subject_id, $term, $this->session->userdata('school_year'), $partialGrade);
} //end of foreach

?>
        </tbody>
    </table>
    </div>
</div>
    
 <script type="text/javascript">

$("td.values").each(function(){
    var sum = 0;
    $(this).nextUntil("td.values").each(function(){
            sum +=  parseInt($(this).find(".sum_values").text(), 10)

     });
    $(this).find(".partial").html(sum);
})


function getIndividualAssessment(st_id, subject, qcode, term){
          var url = "<?php echo base_url().'gradingsystem/getIndividualAssessment/'?>"; // the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "st_id="+st_id+"&subject_id="+subject+"&qcode="+qcode+"&term="+term, // serializes the form's elements.
                   success: function(data)
                   {
                       $('#secretContainer').html(data)
                       $('#secretContainer').fadeIn(500)     
                   }
                 });

            return false;
}

function validateGrade(st_id, subject_id, term, rate)
{
   
       var answer = confirm("Do you really want to Validate this to Final Rating? Doing so will prevent you from editing.");
        if(answer==true){
           var url = "<?php echo base_url().'gradingsystem/validateGrade/'?>"+st_id+'/'+subject_id+'/'+term+'/'+rate ;
           $.ajax({
            type: "GET",
            url: url,
            data: 'qcode='+term, // serializes the form's elements.
            success: function(data)
            {
                  $('#'+st_id+'_validate').hide()     
                  $('#'+st_id+'_invalidate').show()    
            }
          });
        }else{

           return FALSE
        }




}

function invalidateGrade(st_id, subject_id, term, rate, section_id)
{
   
       var answer = confirm("Do you really want to revoke the validity of this Final Rating.");
        if(answer==true){
           var url = "<?php echo base_url().'gradingsystem/inValidateGrade/'?>"+st_id+'/'+subject_id+'/'+term+'/'+rate ;
           $.ajax({
            type: "GET",
            url: url,
            data: 'qcode='+term, // serializes the form's elements.
            success: function(data)
            {
                  $('#'+st_id+'_invalidate').hide()     
                  $('#'+st_id+'_validate').show()     
                 // $('#'+st_id+'_btn_validate').html($('#'+st_id+'_validate'))     
            }
          });
        }else{

           return FALSE
        }




}

    

     </script>


