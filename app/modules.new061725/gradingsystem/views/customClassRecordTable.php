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
    <tr > 
        <th style="text-align:left; vertical-align: middle;">Student</th>   
        <?php
        foreach($category as $cat)
        {
        ?>
            <th style="text-align:center; vertical-align: middle;"><?php echo $cat->category_name.'<br /> ( '.($cat->weight*100).'% )' ?></th>    
        <?php
        }
        ?>  
            <th style="text-align:center; vertical-align: middle;">Knowledge & Understanding</th>
            <th style="text-align:center; vertical-align: middle;">Individual Grade</th>
            <th style="text-align:center; vertical-align: middle;">Partial Grade</th>
            <td style="text-align:center; vertical-align: middle;">Action</td>
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
        <td style="cursor:pointer; text-align: center; vertical-align: middle; " data-target="#assess_details" data-toggle="modal" onclick="getIndividualAssessment('<?php echo $student->st_id ?>',<?php echo $subject_id ?>,<?php echo $k->code ?>, <?php echo $term ?>)" class="values" >
         <?php
          $record = Modules::run('gradingsystem/getTotalScoreByStudent', $student->st_id, $k->code, $term , $subject_id);
          $numberOfAssessment = Modules::run('gradingsystem/getEachScoreByStudent', $student->st_id, $k->code,   $term, $subject_id, 1);
          ///echo $numberOfAssessment->num_rows();
          
          if($numberOfAssessment->num_rows()>0){
              $record = $record->row()->score;
              $tps = $numberOfAssessment->row()->TPS;
              
              if($record==""):
                 $ws = 0;
              else:
                $ps = (($record/$tps)*60+40);
              
              
                $ws = round(($ps*$k->weight), 2);

                //ps = percentage score
                //ws = weighted score

                echo $ps;
              endif;
              
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
    <td style="text-align:center; vertical-align: middle; font-weight: bold;">
        <?php
         $KU = ($final * .9);
         echo $final;
            ?>
    </td> 
    <td style="text-align:center; vertical-align: middle; font-weight: bold;" onmouseover="$('#gs_stid').val('<?php echo $student->st_id ?>'), $('#gs_stname').val('<?php echo strtoupper($student->lastname.', '.$student->firstname) ?>')"data-target="#addInGr"  data-toggle="context" >
    <?php
        $in_gr = Modules::run('gradingsystem/getInGrDetails',$subject_id, $student->st_id, $term, $school_year);
        foreach ($in_gr as $ingr):
            $p_ingr += $ingr->rating;
            
        endforeach;
            $f_ingr = ($p_ingr / count($in_gr));
            $final_f_ingr = ($f_ingr * .1);
        echo round($f_ingr,2);
        unset($p_ingr);
    ?>
    </td>
    <td style="text-align:center; vertical-align: middle; font-weight: bold;">
        <?php
            $partialGrade = $KU + $final_f_ingr;
            echo round($partialGrade, 2);
        ?>
    </td>
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
    Modules::run('gradingsystem/recordPartialAssessment', $student->uid, $section_id , $subject_id, $term, $school_year, $partialGrade);
    unset($final); 
} //end of foreach

?>
</tbody>
</table>
<div id="addInGr">
    <ul class="dropdown-menu" role="menu">
       <li  class="pointer"><a onclick="showInGr()"><i class="fa fa-plus-square fa-fw"></i>Add Individual Grade</a></li>
    </ul>
</div>    
    
<input type="hidden" id="gs_stid" />    
<input type="hidden" id="gs_stname" />    
 <script type="text/javascript">

$("td.values").each(function(){
    var sum = 0;
    $(this).nextUntil("td.values").each(function(){
            sum +=  parseInt($(this).find(".sum_values").text(), 10)

     });
    $(this).find(".partial").html(sum);
})

function showInGr()
{
    $('#gsInGr_modal').modal('show')
    $('#stname').html($('#gs_stname').val())
    $('#gs_stid_value').val($('#gs_stid').val())
    var subject_id = $('#subject_id').val()
    var term = $('#inputTerm').val()
    var sy = $('#inputSY').val()
    
      var url = "<?php echo base_url().'gradingsystem/getInGr/'?>"; // the script where you handle the form input.

      $.ajax({
           type: "POST",
           url: url,
           data: "st_id="+$('#gs_stid').val()+"&subject_id="+subject_id+"&term="+term+"&school_year="+sy+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
               
               $('#gs_modal_body').html(data)
           }
         });
}


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
<?php $this->load->view('gradeModals'); ?>


