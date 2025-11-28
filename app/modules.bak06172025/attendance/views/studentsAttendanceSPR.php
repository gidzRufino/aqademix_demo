<h3 style="text-align: center; margin-top: 10px">Generate Attendance Present</h3><br>
<table class="table table-stripped">
    <tr>
        <th>Name</th>
        <?php for($i=6; $i<=16; $i++): 
            if($i>12):
               $m =$i-12;
            else:
                $m = $i;
            endif;
            ?>
        <th><?php echo date('F', strtotime(date('Y-'.$m.'-01'))); ?></th>
        <?php endfor; ?>
    </tr>
    <?php 
    $cnt = 0;
    foreach($students->result() as $s): 
    $cnt++;     
    if($s->st_id != "" && $s->lastname!=""):
        ?>
        <tr id="<?php echo $cnt; ?>" stdnt="<?php echo $s->st_id ?>" sprid ="<?php echo $s->spr_id ?>">
            <td><?php echo strtoupper($s->firstname) . ' ' . strtoupper($s->lastname); ?></td>
            <?php for($i=6; $i<=16; $i++): 
                if($i>12):
                   $m =$i-12;
                else:
                    $m = $i;
                endif;
                ?>
            <td id="td_<?php echo $s->st_id.'_'.$m ?>"></td>
            <?php endfor; ?>
        </tr>
    <?php 
    endif;
    endforeach; 
    ?>
</table>
<input type="hidden" id="totalStudents" value="<?php echo $students->num_rows()?>" />
<input type="hidden" id="school_year" value="<?php echo $school_year ?>" />
<input type="hidden" id="date_m" value="<?php echo (date('n')<7?date('n')+12:date('n')) ?>" />
<script type="text/javascript">
    $(document).ready(function(){
       var month = $('#inputMonth').val();
        
        getNext(1,month, month)
        
    });
    
    var records = 0;
    
    function getNext(id, month, m)
    {
        var stid = $('#'+id).attr('stdnt');
        var sprid = $('#'+id).attr('sprid');
        var school_year = $('#school_year').val();
        
        if(id <= $('#totalStudents').val()){
            
            id = id+1;
            
            if(m>12)
            {
                var year = parseInt(school_year) + 1;
            }else{
                year = school_year;
            }
            
            getIndividualMonthlyAttedance(stid, month, year, school_year, id,m, sprid);
            
        }
    }
    
    
    function getIndividualMonthlyAttedance(st_id, month, year, school_year, id,m, sprid)
    {
        if(month>12){
            month = month - 12;
        }
        records = records + 1;
        var url = '<?php echo base_url('attendance/attendance_reports/getIndividualMonthlyAttedance/') ?>'+st_id+'/'+month+'/'+year+'/'+school_year+'/'+sprid;
        $.ajax({
               type: "POST",
               url: url,
               data: "data="+""+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               beforeSend: function() {
                     $('#message').html('Please Wait while the system is fetching '+records+' records...');
                     $('#td_'+st_id+'_'+month).html('<i class="fa fa-spinner fa-spin "></i>')
                },
               success: function(data)
               {
                   
                   $('#td_'+st_id+'_'+month).text(data);
                   
                    if(m <= parseInt($('#date_m').val()))
                    {
                        
                        if(id > $('#totalStudents').val())
                        {
                            month = parseInt(month)+1;
                            getNext(1, month, month);
                        }else{
                             getNext(id, month,m);
                        }
                    }else{
                        $('#message').html('Successfully Fetched');
                    }
                       
               }
             });

        return false;
    }
</script>