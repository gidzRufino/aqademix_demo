<div class="row absents">
    <?php
        $j = 1;
           ?>
                
           <?php
           foreach ($absents as $abs)
           {
              $m = $j++;  
          ?>
    <h4 class='mobile-panel-name pointer' style='padding:2px; opacity: 0.8;' onclick="saveAttendance('<?php echo $abs->st_id; ?>', '<?php echo $abs->rfid ?>')" id="h6_<?php echo $abs->st_id; ?>">
      <?php echo strtoupper($abs->lastname.', '.$abs->firstname) ?>
    </h4>
               <?php
           }

        ?>
</div>