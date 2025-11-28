<div class="form-group">
<label class="pull-left">When to serve:</label>
<select class="col-md-6 no-padding" onclick="loadItems(1, this.value)" id="serve_option" style="margin-left:10px;">
    <option value="0">Whole Day</option>
    <option <?php echo $b ?> value="1">Breakfast</option>
    <option <?php echo $l ?>  value="2">Lunch</option>
    <option <?php echo $d ?> value="3">Dinner</option>
</select>
<br/><br/>
</div>

<input type="hidden" value="<?php echo $bld ?>" id="bld" />
<?php  
 
foreach($result as $r):
    ?>
    <div onmouseover="$('#removeFunction_<?php echo $r->canteen_item_id ?>').show()" onmouseout="$('#removeFunction_<?php echo $r->canteen_item_id ?>').hide()" class="col-md-3 pointer">
        <div class='panel panel-primary'>
            <div class='panel-heading clearfix' style='text-align: left'>
                <?php echo $r->canteen_item_name ?>
                <div id="removeFunction_<?php echo $r->canteen_item_id ?>" style="position:absolute; right:5px; top:-5px; display:none;">
                    <button onclick="removeItem('<?php echo $r->canteen_item_id ?>')" class="btn btn-xs btn-danger"><i class="fa fa-close"></i></button>
                </div>
            </div>
            <div class='panel-footer clearfix' style='text-align: center; font-weight: bold;'  onclick="loadQModal('<?php echo $r->canteen_item_name ?>', '<?php echo $r->canteen_item_price ?>', '<?php echo $r->canteen_item_id ?>' )">
                <div class="pull-left text-muted">
                    <?php echo ($r->shortcut_key==""?"no key":$r->shortcut_key) ?>
                </div>
                <div class="pull-right">
                    <?php echo number_format($r->canteen_item_price, 2, ".", ",") ?>
                </div>
            </div>
        </div>

    </div>
    <?php
endforeach;

?>

                <input type="number" id="itemprice" hidden="">
                <input type="number" id="itemid" hidden="">
                <input type="number" id="profit" hidden="">

<script type="text/javascript">

function removeItem(item_id)
{
    var bld = $('#bld').val();
    var url = "<?php echo base_url().'canteen/removeItem/'?>"+item_id+'/'+bld; // the script where you handle the form input.1
        $.ajax({
          type: "GET",
          url: url,
          data: 'item_id='+item_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
          //dataType:'json',
          success: function(data)
          {
               $('#box_body').html(data);
               $('#serve_option').select2();
               alert('Successfully Removed')
                
          }
        });

       return false; 
}
<?php
    foreach ($result as $r):
?>
    shortcut.add("<?php echo $r->shortcut_key ?>",function() {
            //loadQModal('<?php echo $r->canteen_item_name ?>', '<?php echo $r->canteen_item_price ?>', '<?php echo $r->canteen_item_id ?>' );
            okbtn('<?php echo $r->canteen_item_name ?>', '<?php echo $r->canteen_item_price ?>', '<?php echo $r->canteen_item_id ?>' );
            
    });
<?php    
    endforeach;
?>
</script>