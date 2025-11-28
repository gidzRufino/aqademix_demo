<table class="table table-striped">
    <thead>
        <tr>
            <td>Indicators </td>
            <td class="text-center"># Eq</td>
            
        </tr>
    </thead>
    <tbody style='overflow-y: scroll; height:400px;'>
    <?php 
    $bStatements = Modules::run('gradingsystem/getCustomizedList');
    //print_r($bStatements->result());
    $n = 0;
    $gd = 0;
    $i = 0;
    $numItems = count($bStatements->result());
    
    foreach ($bStatements->result() as $bs):
        $n++;
        $bhs = Modules::run('gradingsystem/new_gs/getBHRating', $st_id, $bs->bhs_id, $term, $sy);
        
        $gid = $bs->bhs_group_id;
        
        if($gid!=$gd&&$gd!=0):
            $bhg = Modules::run('gradingsystem/new_gs/sumBHGroup', $gd, $st_id, $term, $sy);
            $trans = Modules::run('gradingsystem/new_gs/getBHTRansmutation', $gd, $bhg->total);
            echo '<tr style="border-top:2px solid #ccc;"><td style="width:70%; border-right: 1px solid #ccc; text-align:right;">Total</td><td class="text-center text-strong">'.$bhg->total.' / '.$trans.'</td></tr>';
            Modules::run('gradingsystem/saveBH',$st_id, $bhg->total, $term, $sy, $gd);
            
        endif; 
        
    ?>
    <tr>
        <td style='width:70%; border-right: 1px solid #ccc;'><?php echo $bs->bhs_indicators; ?></td>
        <td id="<?php echo $n; ?>" tdn="<?php echo $n; ?>" indi_id="<?php echo $bs->bhs_id ?>"  style="text-align: center" class="bhs_editable"><?php echo $bhs->rate ?></td>

    </tr>
    <?php
        $gd = $gid;
       if($n==$numItems):
            $bhg = Modules::run('gradingsystem/new_gs/sumBHGroup', $gd, $st_id, $term, $sy);
            $trans = Modules::run('gradingsystem/new_gs/getBHTRansmutation', $gd, $bhg->total);
            echo '<tr style="border-top:2px solid #ccc;"><td style="width:70%; border-right: 1px solid #ccc; text-align:right;">Total</td><td class="text-center text-strong">'.$bhg->total.' / '.$trans.'</td></tr>';
            Modules::run('gradingsystem/saveBH',$st_id, $bhg->total, $term, $sy, $gd);
       endif;
    endforeach;
    ?>
        
    </tbody>
</table>

<script type='text/javascript'>
$(function () { 
    $(".bhs_editable").dblclick(function () 
    {   
        //var altLockBtnLabel = $('#altLockBtnLabel').val();
        var OriginalContent = $(this).text(); 
        var ID = $('#student_id').html();
        var indi_id = $(this).attr('indi_id');
        var term = $('#term').val();
        var sy = $('#sy').val();
        var tdn = $(this).attr('tdn');
        $(this).addClass("cellEditing"); 
        $(this).html("<input  type='text' style='height:30px; width:100px; text-align:center' value='" + OriginalContent + "' />"); 
        $(this).children().first().focus(); 
        $(this).children().first().keypress(function (e) 
        { if (e.which == 13) { 
                var newContent = $(this).val(); 

                var dataString = 'rate='+newContent + "&st_id="+ID+"&indi_id="+indi_id+"&term="+term+"&sy="+sy+"&original="+OriginalContent+"&relock=0"+'&csrf_test_name='+$.cookie('csrf_cookie_name')  

                
                $(this).parent().text(newContent); 
                $(this).parent().removeClass("cellEditing");
                //ID.trigger('dblclick'); 

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'gradingsystem/new_gs/getFBR' ?>",
                    dataType: 'json',
                    data: dataString,
                    cache: false,
                    success: function(data) {
                            
                            if(data.status)
                            {
                                $('#success').html(data.msg);
                                $('#alert-info').fadeOut(5000);
                                var nxt = parseInt(1)+parseInt(tdn);
                                getNext(nxt);
                            }
                            
                       
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

function getNext(id)
{
 
        var OriginalContent = $('#'+id).text(); 
        var ID = $('#student_id').html();
        var indi_id = $('#'+id).attr('indi_id');
        var term = $('#term').val();
        var sy = $('#sy').val();
        var tdn = $('#'+id).attr('tdn');
        $('#'+id).addClass("cellEditing"); 
        $('#'+id).html("<input id ='input_"+id+"'type='text' style='height:30px; width:100px; text-align:center' value='" + OriginalContent + "' />"); 
        $('#'+id).children().first().focus(); 
        $('#'+id).children().first().keypress(function (e) 
        { if (e.which == 13) { 

                var newContent = $('#input_'+id).val();

                var dataString = 'rate='+newContent + "&st_id="+ID+"&indi_id="+indi_id+"&term="+term+"&sy="+sy+"&original="+OriginalContent+"&relock=0"+'&csrf_test_name='+$.cookie('csrf_cookie_name')  

                
                $('#'+id).text(newContent); 
                //$('#'+id).text(newContent); 
                $('#'+id).parent().removeClass("cellEditing"); 

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'gradingsystem/new_gs/getFBR' ?>",
                    dataType: 'json',
                    data: dataString,
                    cache: false,
                    success: function(data) {
                            
                            if(data.status)
                            {
                                $('#success').html(data.msg);
                                $('#alert-info').fadeOut(5000);
                                var nxt = parseInt(1)+parseInt(tdn);
                                getNext(nxt);
                            }
                       
                    }
                }); 
            } 
        }); 

            $('#'+id).children().first().blur(function(){ 
                $('#'+id).parent().text(OriginalContent); 
                $('#'+id).parent().removeClass("cellEditing"); 
            }); 
}
</script>