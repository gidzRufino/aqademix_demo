<div class="absents">
    <input style="margin:0 10px; float: left;" onclick="saveAttendance('<?php echo 0; ?>', '<?php echo 0 ?>')"  type="checkbox" value="0" />Select All
    <?php
        $j = 1;
           ?>
                
           <?php
           foreach ($absents as $abs)
           {
              $m = $j++;  
          ?>
    <h6 id="h6_<?php if($abs->s_id!=""):echo $abs->s_id; else: echo $abs->user_id; endif ; ?>">
        <input style="margin:0 10px; float: left;" onclick="saveAttendance('<?php echo $abs->s_id; ?>', '<?php echo $abs->rfid ?>')"  type="checkbox" value="<?php echo $abs->st_id;?>" /> 
        <a href="<?php echo base_url();?>index.php/registrar/viewDetails/<?php echo base64_encode($abs->st_id); ?>"><?php echo strtoupper($abs->lastname.', '.$abs->firstname) ?></a></h6>
               <?php
           }

        ?>
</div>