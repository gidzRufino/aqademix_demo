<tr>
    <th style="width:20px; text-align: center;">#</th>
    <th class="col-lg-8">Question</th>
    <th class="text-center">Type</th>
    <th class="text-center">Action</th>
</tr>
<?php
$i = 1;
if($page != 0):
    $i = ($limit * $page) + 1;
endif;

foreach ($questions as $q) :
?>
    <tr class="questionsList" id="tr_<?php echo $q->sys_code ?>">
        <td><?php echo $i++ ?></td>
        <td><?php $question = $q->plain_question; $strLimit = 50; echo (strlen($question) >= $strLimit) ? substr($question, 0, $strLimit)."..." : $question; ?></td>
        <td class="text-center"><?php echo $q->qm_type ?></td>
        <th class="text-center">
            <button onclick="deleteQuestion('<?php echo $q->sys_code ?>')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
        </th>
    </tr>

<?php
endforeach;
?>