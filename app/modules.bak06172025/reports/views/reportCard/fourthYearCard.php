 <table class="editableTable table table-striped">
    <tr>
        <td>
            Subjects edit
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
        <td id="<?php echo $s ?>" class="editable" term="<?php echo $term ?>" sy="<?php echo $s ?>" style="text-align: center;">
            <?php 
                if($finalGrade->num_rows()>0):
                    if($s!=17):
                        echo '<strong>'.$finalGrade->row()->final_rating.'</strong>';
                    else:
                        if($finalGrade->row()->final_rating!=0):
                            echo 'Passed';
                        else:
                            echo 'Not Taken';
                        endif;
                    endif;
                else:
                    $i++;
                    echo 'no Final Grade Yet';
                endif;
            ?>

        </td>
        <td id="<?php echo $s ?>_equiv" style="text-align: center;">
            <?php
                //echo $finalGrade->num_rows();
                if($finalGrade->num_rows()>0):
                    $plg = Modules::run('gradingsystem/getLetterGrade', $finalGrade->row()->final_rating);
                        foreach($plg->result() as $plg){
                            if( $finalGrade->row()->final_rating >= $plg->from_grade && $finalGrade->row()->final_rating <= $plg->to_grade){
                                if($s!=17):
                                    echo '<strong>'.$plg->letter_grade.'</strong>';
                                else:
                                    echo '<strong>A</strong>';
                                endif;
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

<script type="text/javascript">

$(function () { 
$(".editable").dblclick(function () 
{   
    //var altLockBtnLabel = $('#altLockBtnLabel').val();
    $(this).text('');   
    var OriginalContent = $(this).text(); 
    var subject_id = $(this).attr('id');
    var st_id = <?php echo $student->uid ?>
   
    $(this).addClass("cellEditing"); 
    $(this).html("<input type='text' style='height:30px; text-align:center' value='" + OriginalContent + "' />"); 
    $(this).children().first().focus(); 
    $(this).children().first().keypress(function (e) 
    { if (e.which == 13) { 
            var newContent = $(this).val(); 
            var term = $('#term').val();
            var sy = $('#sy').val();
            //alert(st_id)
            $(this).parent().text(newContent); 
            $(this).parent().removeClass("cellEditing");
            saveGrade(st_id, subject_id, term, newContent)
//            $.ajax({
//                type: "POST",
//                url: "<?php echo base_url().'gradingsystem/recordScore' ?>",
//                dataType: 'json',
//                data: dataString,
//                cache: false,
//                success: function(data) {
//
//                  
//                }
//            });

        } 
    }); 

        $(this).children().first().blur(function(){ 
        $(this).parent().text(OriginalContent); 
        $(this).parent().removeClass("cellEditing"); 
    }); 
}); 
});

function saveGrade(st_id, subject_id, term, rate)
{
   
       var answer = confirm("Is this the Final Rating? The result will be the printed result. Warning: You cannot undo this action.");
        if(answer==true){
           var url = "<?php echo base_url().'gradingsystem/validateGrade/'?>"+st_id+'/'+subject_id+'/'+term+'/'+rate+'/'+<?php echo $student->section_id ?>+'/'+<?php echo $student->grade_id ?> ;
           $.ajax({
            type: "GET",
            url: url,
            data: 'qcode='+term, // serializes the form's elements.
            success: function(data)
            {
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url().'gradingsystem/getEquivalent/' ?>"+rate,
                    //dataType: 'json',
                    data: rate,
                    cache: false,
                    success: function(data) {
                           $('#'+subject_id+'_equiv').html(data)

                    }
            });
            }
          });
        }else{
           $('#'+subject_id).html('no Final Grade Yet')
           return FALSE
        }




}
    
</script>
