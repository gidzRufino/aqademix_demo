<table class="table table-bordered">
    <tr>
        <th></th>
        <th>Rating</th>
    </tr>
    <?php
        $n=0;
        foreach ($getInGrDetails as $igd):
            $n++;
            $in_gr = Modules::run('gradingsystem/getInGrDetails',$subject_id, $st_id, $term, $sy, $igd->in_gr_id);
     ?>
    <tr>
        <td><?php echo $igd->in_gr_desc ?></td>
        <td id="<?php echo $n; ?>" ingrid="<?php echo $igd->in_gr_id ?>" onmouseover="$('#in_gr_id').val('<?php echo $igd->in_gr_id ?>')" class="editable"><?php echo $in_gr->rating; ?></td>
    </tr>
    <?php
        endforeach;
    ?>
</table>
<div id="gs_result" class="col-lg-12"></div>
<input type="hidden" id="in_gr_id" />
<script type="text/javascript">
    $(function () { 
$(".editable").dblclick(function () 
{   
    var OriginalContent = $(this).text(); 
    var tdn = $(this).attr('id');
    var ingrid = $(this).attr('ingrid');
   
    $(this).addClass("cellEditing"); 
    $(this).html("<input  type='text' style='height:30px; text-align:center' value='" + OriginalContent + "' />"); 
    $(this).children().first().focus(); 
    $(this).children().first().keypress(function (e) 
    { if (e.which == 13) { 
            var newContent = $(this).val(); 
            
            
                var dataString = 'rating='+newContent + "&st_id="+<?php echo $st_id ?>+"&term="+<?php echo $term ?>+"&subject_id="+<?php echo $subject_id ?>+"&school_year="+<?php echo $sy ?>+"&in_gr_id="+$('#in_gr_id').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name')  
            
            
            $(this).parent().text(newContent); 
            $(this).parent().removeClass("cellEditing");
            //ID.trigger('dblclick'); 
            

            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'gradingsystem/recordInGr' ?>",
                dataType: 'json',
                data: dataString,
                cache: false,
                success: function(data) {
                  $('#gs_result').html(data.msg);
                  $('#alert-info').fadeOut(5000);
                  
                    var nxt = parseInt(1)+parseInt(tdn);
                    getNext2(nxt)
                }
            });

        } 
    }); 

        $(this).children().first().blur(function(){ 
        $(this).parent().text(OriginalContent); 
        $(this).parent().removeClass("cellEditing"); 
    }); 
}); 
});

function getNext2(id)
{
            //alert(id)
            var tdn = $('#'+id).attr('id');
            
            var ingrid = $('#'+id).attr('ingrid');
            var OriginalContent = $('#'+id).text(); 
            $('#'+id).addClass("cellEditing"); 
            $('#'+id).html("<input id ='input_"+tdn+"'type='text' style='height:30px; text-align:center' value='" + OriginalContent + "' />"); 
            $('#'+id).children().first().focus(); 
            $('#'+id).children().first().keypress(function (e) 
            { if (e.which == 13) { 
                    
                    var newContent = $('#input_'+id).val();
                    
                    $('#'+id).text(newContent); 
                    $('#'+id).parent().removeClass("cellEditing");
                    
                    var nxt = parseInt(1)+parseInt(tdn);
                    getNext2(nxt);

                    var dataString2 = 'rating='+newContent + "&st_id="+<?php echo $st_id ?>+"&term="+<?php echo $term ?>+"&subject_id="+<?php echo $subject_id ?>+"&school_year="+<?php echo $sy ?>+"&in_gr_id="+ingrid+'&csrf_test_name='+$.cookie('csrf_cookie_name') 
                      
                     

                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url().'gradingsystem/recordInGr' ?>",
                            dataType: 'json',
                            data: dataString2,
                            cache: false,
                            success: function(data) {
                              $('#gs_result').html(data.msg);
                              $('#alert-info').fadeOut(5000);

                                var nxt = parseInt(1)+parseInt(tdn);
                                getNext2(nxt)
                            }
                        });
                }
                   
            });

        $('#'+id).children().first().blur(function(){ 
            $('#'+id).text(OriginalContent); 
            $('#'+id).parent().removeClass("cellEditing"); 
        });
}
</script>