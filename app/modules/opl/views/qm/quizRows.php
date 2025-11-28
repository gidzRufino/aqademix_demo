<tr>
    <th>#</th>
    <th class="col-lg-6">Quiz Title</th>
    <th class="text-center">Number of Items</th>
    <th class="text-center">Action</th>
</tr>
<?php
$i = 1;
if($page != 0):
    $i = ($limit * $page) + 1;
endif;

foreach ($quizes as $q) :
?>
    <tr>
        <td><?php echo $i++; ?></td>
        <td class="pointer"><?php echo $q->qi_title; ?></td>
        <td class="text-center"><?php echo ($q->qi_qq_ids != "" ? count(explode(',', $q->qi_qq_ids)) : 0); ?></td>
        <td class="text-center">
            <button onclick="document.location='<?php echo base_url('opl/qm/quizDetails/' . $q->qi_sys_code . '/' . $school_year); ?>'" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></button>
            <button onclick="deleteQuiz('<?php echo $q->qi_sys_code ?>')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php
endforeach;
?>