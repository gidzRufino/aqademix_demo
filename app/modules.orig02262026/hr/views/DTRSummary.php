<div class="clearfix row-fluid">

<div class="pull-left span12">
    <h3>Daily Time Record Summary</h3><div id="resultSection" class="help-inline" ></div>
</div>
<div class="control-group  pull-left">
              <div class="controls">
                  <label style="padding:5px" class="control-label pull-left" for="inputAdmissionDate">Select Date</label>
                  <input name="dateFrom"  type="text" data-date-format="mm/dd/yyyy" id="dateFrom" >
                  <button onclick="getDate(document.getElementById('dateFrom').value)" style="margin-left: 10px;" class="btn pull-right">search</button>  
                </div>
            </div>  
        <input type="hidden" id="setAction" />
<div style="margin:0;" class="pull-left span12" id="TableResult">
    <table border="1" style="margin:0; border: 1px solid #DDDDDD;"  class="table">
       
        <tr>
            <td width="15%" rowspan="2"><h5>EMPLOYEE</h5></td>
            <td colspan="2" ><h5>MORNING</h5></td>
            <td colspan="2"><h5>AFTERNOON</h5>
            <td colspan="2"><h5>OVERTIME</h5>
            <td width="10%" rowspan="2"><h5 style="margin-top:35px; font-size:18px; writing-mode: tb-rl; -webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);	">Daily<br>Total</h5></td>

        </tr>
        <tr>
            <td>
                <h5>IN</h5>
        
            </td>
            <td>
                <h5>OUT</h5>
            </td>
            <td>
                <h5>IN</h5>
        
            </td>
            <td>
                <h5>OUT</h5>
            </td>
            <td>
                <h5>IN</h5>
        
            </td>
            <td>
                <h5>OUT</h5>
            </td>
        </tr>
    </table>
    <table class='table table-striped'> 
        <?php 
        $finalhours = 0;
        $finaltardy = 0;
        $finalunder = 0;
        $tard = 0;
        $under = 0;
        foreach ($dtrs as $row)
        {

?>
        <tr>
            <td width="15%">
                <h6><a href="<?php echo base_url().'employee/editEmployeeForm/'.$row->uid ;?>"><?php echo $row->lastname.', '.$row->firstname.' '.$row->middlename ?></a></h6>
        
            </td>
            <td>
                <h5><?php echo $row->time_in ?></h5>
        
            </td>
            <td>
                <h5><?php echo $row->time_out ?></h5>
            </td>
            <td>
                <h5><?php echo $row->time_in_pm ?></h5>
        
            </td>
            <td>
                <h5><?php echo $row->time_out_pm ?></h5>
            </td>
            <td>
                <h5>0</h5>
        
            </td>
            <td>
                <h5>0</h5>
        
            </td>
            <td width="10%">
                <h5>
                    <?php
                        $timeInAM = $row->time_in;
                        $timeOutAM =$row->time_out;
                        $timeInPM = $row->time_in_pm;
                        $timeOutPM =$row->time_out_pm;
                        $date = explode("/", $row->date);
                       
                        
                        // getting the number of hours in the morning
                        $finalTimeAM = $this->employee_model->getNumberOfHours($timeInAM, $timeOutAM, $date, "AM");
                        $finalTimePM = $this->employee_model->getNumberOfHours($timeInPM, $timeOutPM, $date, "PM");
                        $finalTime = ($finalTimeAM['totalTime'])+($finalTimePM['totalTime']) ;
                        
                        echo round($finalTime, 2);
                                
                            
                        
                    ?>
                    
                </h5>
            </td>
        </tr>
        <?php 
            }     
        ?>
            
        <!--records is taken from controller dtr-->
        
    </table>
</div>    
    <div id="main_content">
        
    </div>
   <input type="hidden" id="setAction" />
   <script type="text/javascript">
       function getDate(dateFrom)
        {
             var url = "<?php echo base_url()?>/employee/searchDtrSummary"; // the script where you handle the form input.
            
           $.ajax({
                  type: "POST",
                  url: url,
                  data: "dateFrom="+dateFrom, // serializes the form's elements.
                  success: function(data)
                  {
                     document.getElementById('TableResult').innerHTML=data;
                     
                  }
                });

           return false;
        }
       $(function(){
        window.prettyPrint && prettyPrint();

        $('#dateFrom').datepicker();
    });
   </script>   
   <script src="<?php echo base_url(); ?>assets/js/employeeRequest.js"></script>
</div>
