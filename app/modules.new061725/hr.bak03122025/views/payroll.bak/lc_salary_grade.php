<div class="panel panel-primary">
    <div class="panel-heading">
        <h5>Salary Grade List and Statutory Benefits  <i class="fa fa-plus fa-fw fa-2x pull-right pointer addSG" rel="clickover"  
                         <?php if($this->session->userdata('is_admin')): ?>
                               data-content=" 
                                        <div class='col-lg-12 form-group' style='width:230px; color:black;'>
                                            <label class='control-label'>Add Salary Grade</label>
                                            <div class='controls' id=''>
                                            <input type='text' id='inputSG' />
                                            </div>
                                        </div>
                                        <div class'col-lg-12'>
                                             <button data-dismiss='clickover' class='btn btn-xs btn-danger'>Cancel</button>&nbsp;&nbsp;
                                             <a href='#' data-dismiss='clickover' onclick='addSG()' style='margin-right:10px;' class='btn btn-xs btn-success pull-left'>Save</a>
                                        </div> 
                                     "
                             <?php endif; ?> ></i></h5>
    </div>
    <div class="panel-body">
        <table class="col-lg-12 table table-bordered text-center" style="margin-bottom:0;" >
            <tr>
                <th style="width:16.6%; text-align: center">Salary Grade</th>
                <th style="width:16.6%; text-align: center">Salary</th>
                <?php foreach($defaultDeductions as $deductions): ?>
                    <th style="width:16.6%; text-align: center"><?php echo $deductions->pi_item_name ?></th>
                <?php endforeach; ?>
            </tr>
        </table>
        <div style="max-height:500px; overflow-y: scroll; width:100%; overflow-x: hidden">
            <table id="sgTable" class="table table-striped col-lg-12 table-bordered text-center" >
            <?php
                foreach($salaryGrade as $sg)
                {    
            ?>
            <tr>
                <td dbTable="profile_employee_salary_grade" style="width:16.6%"><?php echo $sg->sg; ?></td>
                <td dbTable="profile_employee_salary_grade" style="width:16.6%"><?php echo number_format($sg->salary, 2, '.', ','); ?></td>
                
                <?php foreach($defaultDeductions as $deductions): 
                    $statBen = Modules::run('hr/payroll/getStatBen', $sg->sg, $deductions->pi_item_id);
                    ?>
                    <td style="width:16.6%; text-align: center"><?php echo ($statBen!=NULL? $statBen->stat_amount:'') ?></td>
                <?php endforeach; ?>
            </tr>
            <?php } ?>
        </table>
        </div>
    </div>


</div>

<script type="text/javascript">
        $(function () { 
        $(".addSG").clickover({
                placement: 'left',
                html: true
              });
        
        $("#sgTable td").dblclick(function () 
        {   
            var OriginalContent = $(this).text(); 
            var ID = $(this).attr('id');
            var col = $(this).attr('col');
            var dbtable = $(this).attr('dbtable');
            
            
            $(this).addClass("cellEditing"); 
            $(this).html("<input type='text' style='width:auto; text-align:center;' value='" + OriginalContent + "' />"); 
            $(this).children().first().focus(); 
            $(this).children().first().keypress(function (e) 
            { if (e.which == 13) { 
                    var newContent = $(this).val(); 
                    if(col=='pag_ibig'){
                        newContent = newContent*.02 
                    }
                    var dataString = 'value='+newContent+"&column="+col+"&id="+ID+"&table="+dbtable+'&csrf_test_name='+$.cookie('csrf_cookie_name');
                    $(this).parent().text(newContent); 
                    $(this).parent().removeClass("cellEditing");
                    //alert(dbtable);
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url().'hr/editSGList_Deductions' ?>",
                        data: dataString,
                        cache: false,
                        success: function(data) {
                            
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
     
     function addSG()
     {
       var sg = $('#inputSG').val()
         
         var url = "<?php echo base_url().'hr/addSG/' ?>"; // the script where you handle the form input.
            $.ajax({
                   type: "POST",
                   url: url,
                   dataType: 'json',
                   data: 'value='+sg+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       if(data.status){
                           alert(data.msg)
                           $('#sgTable').append('<tr><td>'+data.id+'</td><td>'+data.value+'</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0</td></tr>')
                       }else{
                           alert(data.msg)
                       }

                   }
                 });

            return false; 
     }
</script>