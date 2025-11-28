<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Hours Worked
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('hr/payroll') ?>'">Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('hr/payroll/create') ?>'">Create Payroll</button>
          </div>
    </h3>
</div>
<div class="col-lg-12 col-md-12 col-xs-12 top-away">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 pull-right">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        <input type="search" onkeydown="searchEmployee(this.value)" id="userSearch" class="form-control" placeholder="Search...">
                    </div>
                </div>
                <div class=" col-lg-3 col-md-3 col-sm-3 col-xs-3" >
                        <select onclick="getPayrollPeriod(this.value)" tabindex="-1" id="payPeriod" name="payPeriod" style="width:300px;">
                            <option>Select Payroll Period</option>
                           <?php foreach($payrollPeriod as $pp): ?>
                                <option <?php echo ($pp_id!=NULL?($pp->per_id==$pp_id?'Selected="Selected"':""):"") ?> id="option_<?php echo $pp->per_id ?>" from="<?php echo $pp->per_from ?>" to="<?php echo $pp->per_to ?>" value="<?php echo $pp->per_id ?>"><?php echo date('F d, Y', strtotime($pp->per_from)).' - '.date('F d, Y', strtotime($pp->per_to)); ?></option>
                           <?php endforeach; ?>

                       </select>
                </div>
            </div>
        </div>
        <div class="table-responsive" id="demo">
            <table class="table table-bordered table-hover" style="font-size:12px;">
                <thead>
                    <tr>
                        <td style="vertical-align: middle; width:15%;" rowspan="3">Name</td>
                        <td style="vertical-align: middle; width:5%; text-align: center" rowspan="2" colspan="2">Days of Work</td>
                        <?php
                            foreach ($manHoursCat as $pmc):
                            $num_cols = count(Modules::run('hr/payroll/getManHourTypeByCat', $pmc->pmc_id));
                            
                        ?>
                            <td colspan="<?php echo $num_cols*2 ?>" class="<?php echo $pmc->class ?> text-center"><?php echo $pmc->pmc_category; ?></td>
                        <?php
                            endforeach;
                        ?>
                            
                        <td style="vertical-align: middle; width:10% !important; text-align: center;" rowspan="3">Gross Pay</td>
<!--                        <td colspan="3" class="success">Overtime</td>
                        <td colspan="3" class="info">Night Shift Differential</td>
                        <td colspan="3" class="warning">Night Differential</td>
                        <td colspan="2" class="danger">Holidays</td>-->
                    </tr>
                    <tr>
                        
                        <?php
                            foreach ($manHoursCat as $pmc):
                                $manHours = Modules::run('hr/payroll/getManHourTypeByCat', $pmc->pmc_id);
                                foreach ($manHours as $pmt):
                                    ?>
                                        <td colspan="2" class="<?php echo $pmc->class ?> text-center"><?php echo $pmt->pmt_type; ?></td>
                                    <?php
                                endforeach;    
                            endforeach;
                        ?>
                    </tr>
                    <tr>
                        <td class="text-center">Days</td>
                        <td class="text-center">Amt</td>
                        <?php
                            foreach ($manHoursCat as $pmc):
                                $manHours = Modules::run('hr/payroll/getManHourTypeByCat', $pmc->pmc_id);
                                foreach ($manHours as $pmt):
                                    ?>
                                        <td class="<?php echo $pmc->class ?> text-center">Hrs</td>
                                        <td class="<?php echo $pmc->class ?> text-center">Amt</td>
                                    <?php
                                endforeach;    
                            endforeach;
                        ?>
                    </tr>
                </thead>
                <tbody id="time-table-body">
                    <?php
                        if($pp_id==NULL):
                            foreach ($employees->result() as $emp):
                                ?>
                                <tr id="<?php echo $emp->employee_id ?>">
                                    <td class="text-left"><?php echo strtoupper($emp->lastname.', '.$emp->firstname); ?></td>
                                    <td class="text-left" id="<?php echo $emp->employee_id.'_1' ?>" formula="basic*hours" ondblclick="doEdit(this.id,'<?php echo $emp->employee_id ?>','<?php echo 1 ?>','<?php echo $emp->salary ?>')"></td>
                                    <td id="<?php echo $emp->employee_id.'_1' ?>_amount" class="<?php echo $pmc->class ?> text-center" ></td>
                                    <?php 
                                    foreach ($manHoursCat as $pmc):
                                        $manHours = Modules::run('hr/payroll/getManHourTypeByCat', $pmc->pmc_id);
                                        foreach ($manHours as $pmt):
                                            ?>
                                                <td id="<?php echo $emp->employee_id.'_'.$pmt->pmt_id ?>" formula="<?php echo $pmt->pmt_calc_formula ?>" ondblclick="doEdit(this.id,'<?php echo $emp->employee_id ?>','<?php echo $pmt->pmt_id ?>','<?php echo $emp->salary ?>')" class="<?php echo $pmc->class ?> text-center"></td>
                                                <td id="<?php echo $emp->employee_id.'_'.$pmt->pmt_id ?>_amount" class="<?php echo $pmc->class ?> text-center" ></td>
                                            <?php
                                        endforeach;    
                                    endforeach;
                                    ?>
                                    <td style="vertical-align: middle; width:10%; text-align: center;"></td>        
                                </tr>
                                <?php  
                            endforeach;
                        else:
                            echo Modules::run('hr/payroll/getManHoursByPP',$pp_id);
                        endif;    
                    ?>
                </tbody>
            </table>
        </div>    
        <script type="text/javascript">
            
                $('#searchDate').datepicker({
                    orientation: 'auto'
                });
                $('#payPeriod').select2();
                
            $(document).ready(function() {
               
                $('#time-table-body tr').each(function(){
                    var id = $(this).attr('id');
                    
                   // $('#'+id+'_grossPayment').text(numberWithCommas(totalSalary));
                });
            });
            
            function calculateGross(id)
            {
                //alert(id)
                var totalSalary = 0;
                $('#'+id+' td.salary').each(function(){
                    //alert($(this).attr('salaryAmount'))
                    if($(this).attr('salaryAmount')!="")
                    {
                        totalSalary += parseFloat($(this).attr('salaryAmount'));
                    }
                });
                $('#'+id+'_grossPayment').text(numberWithCommas(totalSalary));
            }
              
            function getPayrollPeriod(pp_id)
            {
                var url = "<?php echo base_url().'hr/payroll/manHours/'?>"+pp_id;
                document.location = url;
//                var url = "<?php echo base_url().'hr/payroll/getManHoursByPP/'?>";
                
//                     $.ajax({
//                           type: "POST",
//                           url: url,
//                           data: 'pp_id='+pp_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
//                           beforeSend: function() {
//                                },
//                           success: function(data)
//                           {
//                               $('#time-table-body').html(data);
//                           }
//                         });
//
//                    return false; 
            }
            
              
            function searchEmployee(value)
            {
                var pp_id = $('#payPeriod').val();
                var url = "<?php echo base_url().'hr/payroll/searchEmployee/'?>";
                     $.ajax({
                           type: "POST",
                           url: url,
                           data: "value="+value+'&pp_id='+pp_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                           beforeSend: function() {
                                },
                           success: function(data)
                           {
                               $('#time-table-body').html(data);
                           }
                         });

                    return false; 
            }

            function doEdit(cid,pid,col, basic) {
                var val = $("#" + cid).html();
                var formula = $('#'+cid).attr('formula');
                var calc = 0;
                var hours = 0;
                var grossPayment = 0;
                $("#"+cid).html("<input type='number' class='no-border' style='width:50px;' id='userinput' value='" + val + "'>");
                $("#userinput").focus().select();
                $("#userinput").keydown(function(e) {
                    hours = $('#userinput').val();
                    calc = eval(formula);
                    if (e.which == 9) {
                        e.preventDefault();
                        //alert(calc);
                        doInsert(pid,col, $("#userinput").val(), calc.toFixed(2));
                        goNext(pid,col,basic);
                    } else if (e.which == 13) {
                        e.preventDefault();
                        doInsert(pid, col, $("#userinput").val(),calc.toFixed(2));
                    }
                });
                $("#userinput").focusout(function() {
                    hours = $('#userinput').val();
                    calc = eval(formula);
                    doInsert(pid,col, $("#userinput").val(),calc.toFixed(2)); 
                });
                
            }

            function goNext(pid,col,basic) {
                
                var nextIndex = parseInt(col) + 1;
                var formula = $("#" + pid+'_'+nextIndex).attr('formula');
                var calc = 0;
                var hours = 0;
                //var basic = 311;
                $("#" + pid+'_'+nextIndex).html("<input type='number' style='width:50px;' class='no-border' id='userinput' value=''>");
                $("#userinput").focus().select();
                $("#userinput").on('keydown', function(e) {
                    hours = $('#userinput').val();
                    calc = eval(formula);
                    if (e.which == 9) {
                        e.preventDefault();
                        doInsert(pid, nextIndex, $("#userinput").val(), calc.toFixed(2)) 
                        goNext(pid,nextIndex,formula);
                    } else if (e.which == 13) {
                        e.preventDefault();
                        doInsert(pid, nextIndex, $("#userinput").val(), calc.toFixed(2));   
                    }
                });
                $("#userinput").focusout(function() {
                    hours = $('#userinput').val();
                    calc = eval(formula);
                    doInsert(pid,nextIndex, $("#userinput").val(), calc.toFixed(2));
                });
            }

            function doInsert(pid, col, value, amount) {
                //alert(pid+'_'+col)
                var pp_id = $('#payPeriod').val();
                $("#"+pid+'_'+col).html(value);
                $("#"+pid+'_'+col+'_amount').html(amount);
                
                if(value!=0)
                {
                    var url = "<?php echo base_url().'hr/payroll/saveManHours/'?>";
                    $.ajax({
                           type: "POST",
                           url: url,
                           //dataType:'json',
                           data:{ 
                                st_id           : pid,
                                pmt_id          : col,
                                pp_id           : pp_id,
                                num_hours       : value,
                                amount          : amount,
                                csrf_test_name : $.cookie('csrf_cookie_name')
                                },
                           success: function(data)
                           {
                               
                               $("#"+pid+'_'+col+'_amount').attr('salaryAmount',amount);
                               $('#editDTR').modal('hide');
                               calculateGross(pid);
                               getDateFrom(fromdate, todate, owners_id)
                               
                           }
                    });
                }
            }    
            function numberWithCommas(x) {
                if(x==null){
                    x = 0;
                }
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        </script>
</div> 