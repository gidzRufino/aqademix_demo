<?php
    $subject = Modules::run('academic/getSpecificSubjectPerlevel',$grade_id);
    $singleSub = explode(',', $subject->subject_id);
    //print_r($subject);
?>
<table class="table table-striped">
    <tr>
        <td>Rank</td>
        <td>Name</td>
        <td>Section</td>
        <td>Partial Number Grade</td>
    </tr>
    
       <?php
            $rank = 0;
            foreach ($topTen->result() as $tops)
            {
                $rank++;
                ?>
                <tr>
                    <td><?php echo $rank; ?></td>
                    <td><?php echo strtoupper($tops->lastname.', '.$tops->firstname) ?></td>
                    <td><?php echo $tops->section ?></td>
                    <?php if($perSubject): ?>
                        <td><?php echo round($tops->total,2) ?></td>
                    <?php else: ?>
                        <td><?php echo round($tops->total/count($singleSub),2) ?></td>
                    <?php endif; ?>
                </tr>
                <?php
            }
        ?>  
    
</table>





<script type="text/javascript">
    function generateTopTenByGradeLevel()
    {
        var grade_id = $('#inputGrade').val();
        var subject_id = $('#inputSubject').val();
        var term = $('#inputTerm').val();
        var sy = $('#sy').val();
        var url = "<?php echo base_url().'division/topTen/'?>"+grade_id+'/'+subject_id+'/'+term+'/'+sy ;
            $.ajax({
                type: "GET",
                url: url,
                data: 'grade_id='+grade_id, // serializes the form's elements.
                success: function(data)
                {
                    $('#result').html(data);

              }
            });
        
    }
    
</script>