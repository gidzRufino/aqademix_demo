<div class="col-lg-12">
    <table class="table table-stripped">
        <tr>
            <th>Subject</th>
            <th>Action</th>
        </tr>
        <?php
        foreach ($subjects as $s):
        ?>
        <tr
            tr_id ="<?php echo $s->subject_id ?>"
            >
            <td><?php echo $s->subject; ?></td>
            
            <td class="text-center">
                <button 
                    s_id="<?php echo $s->subject_id ?>"
                    
                    class="btn btn-xs btn-danger btn-selectSched" 
                        onclick="fetchSearchSubject('<?php echo $s->subject_id ?>','<?php echo $s->subject ?>');
                        
                        " ><i class="fa fa-plus"></i></button>
            </td>
        </tr>
        <?php    
        endforeach;
        ?>
    </table>
</div>