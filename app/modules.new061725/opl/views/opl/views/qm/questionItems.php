<li  style="margin-bottom:5px;"><?php echo $q->question; ?><span id="li_<?php echo $q->qq_id ?>"> </span>  
<?php
if($qtype!=2):?>
<input class="form-control" style="width:50%;" placeholder="answer" type="text" id="<?php echo $q->qq_id ?>" name="<?php echo $q->qq_id ?>"/>
<?php
else: 
    foreach ($selection->result() as $choice):
    ?>
<input type="radio" name="sel_<?php echo $q->qq_id ?>" onclick="$('#<?php echo $q->qq_id ?>').val(this.value)" value="<?php echo $choice->qs_selection ?>" /> <?php echo $choice->qs_selection.'. '.$choice->qs_choice ?><br />

<?php
    endforeach;
?>
    <input  type="hidden" id="<?php echo $q->qq_id ?>" name="<?php echo $q->qq_id ?>" />
<?php
endif;