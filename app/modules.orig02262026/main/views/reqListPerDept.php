<ul>
    <?php foreach ($list as $l): ?>
        <li>
            <span class="pull-right" style="cursor: pointer; color: red" onclick="deleteItem('<?php echo $l->eReq_id ?>','<?php echo $dept ?>')"><i class="fa fa-trash"></i></span>
            <?php echo $l->eReq_desc ?>
        </li>
    <?php endforeach; ?>
</ul>