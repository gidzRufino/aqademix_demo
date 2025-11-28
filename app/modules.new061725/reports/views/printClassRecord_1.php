<?php
$section = Modules::run('registrar/getSectionById', $this->uri->segment(3));
$students = Modules::run('registrar/getAllStudentsForExternal', '', $this->uri->segment(3));
$category = Modules::run('gradingsystem/getAssessCategory',1);
$settings = Modules::run('main/getSet');

//print_r($category);
?>
<table>
    <?php
   
foreach ($students->result() as $s)
{
    ?>
    <tr>
        <td><?php echo $s->user_id ?></td>
        <?php

        foreach($category as $cat => $k)
        {
            $individualAssessmentBySection = Modules::run('gradingsystem/getIndividualAssessmentForPrint',$s->user_id ,$this->uri->segment(4),$k->code,$this->uri->segment(5));
        ?>
        <td></td>
        
        <?php
        foreach ($individualAssessmentBySection->result() as $IABS){
            echo'<td>'.$k->code.'</td>';
        }
        }
        ?>
    </tr>
    <?php
}


?>
</table>
