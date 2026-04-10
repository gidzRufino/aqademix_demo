<table>
 <?php
foreach($section->result() as $sec)
{
        $maleToPm = Modules::run('registrar/getStudentStatus', 1, 'Male', $sec->section_id, $this->uri->segment(3), $this->uri->segment(4), 1);
        $femaleToPm = Modules::run('registrar/getStudentStatus', 1, 'Female', $sec->section_id, $this->uri->segment(3), 2015, 1);
        $totalToPm = $maleToPm->num_rows()+ $femaleToPm->num_rows();
?>
    <tr>
        <td><?php echo $sec->section_id ?></td>
        <td><?php echo $totalToPm ?></td>
        <td><?php echo print_r($femaleToPm->result()) ?></td>
        <td><?php echo $femaleToPm ?></td>
    </tr>
<?php
} 
echo $this->db->last_query();
?>
</table>
