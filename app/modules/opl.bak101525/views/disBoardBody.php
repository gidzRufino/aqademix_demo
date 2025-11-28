<?php 
if(count($discussionDetails) != 0):
    $i=1;
    foreach($discussionDetails as $discussion):
       if($section_id == $discussion->dis_section_id || $discussion->dis_section_id==0):
           $reader_count = ($discussion->reader_count != NULL) ? $discussion->reader_count : 0; 
?>
<tr class="pointer" onclick="document.location='<?php echo base_url('opl/discussionDetails/'.$discussion->dis_sys_code.'/'.$this->session->school_year)?>'">
    <td class="text-center"><?php echo $i++; ?></td>
    <td class="text-center col-lg-3"><?php echo ucwords(strtolower($discussion->dis_title)) ?></td>
    <!--<td class="text-center col-lg-3"><?php echo substr($discussion->dis_details,0,50).'...' ?></td>-->
    <td class="text-center col-lg-3"><?php echo $reader_count.' students' ?></td>
    <td class="text-center col-lg-3"><?php echo $discussion->com_count.' comments' ?></td>
</tr>

<?php
        endif;
    endforeach;
else:
    ?>
    <tr><td class="text-center" colspan="5"><h3>No Discussions Available</h3></td></tr>
    <?php
endif;
?>