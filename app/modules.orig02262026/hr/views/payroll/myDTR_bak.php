<?php
    $payDay = date('d');
    if($payDay>15){
        $from = date('Y').'-'.date('m').'-16';
        $to = date('Y').'-'.date('m').'-30';
    }else
    {
        $from = date('Y').'-'.date('m').'-01';
        $to = date('Y').'-'.date('m').'-15';
    }
?>
<div class="row">
    <div class="col-lg-12">
        <div class="pull-left span8" style="margin-top:5px; font-size: 13px;">
            
            <div class="control-group  pull-left">
              <div class="controls">
                  <label style="padding:5px" class="control-label pull-left" for="inputAdmissionDate">Date From</label>
                  <input name="dateFrom"  type="text" value="<?php echo $from;?>" data-date-format="yyyy-mm-dd" id="dateFrom" >
                  <input type="hidden" name="owners_id" value="<?php echo $info->uid?>" id="owners_id" />
                </div>
            </div>
            <div class="control-group pull-left">
              <div class="controls">
                  <label style="padding:5px" class="control-label pull-left" for="inputAdmissionDate">Date to</label>
                  <input name="dateTo" type="text" value="<?php echo $to;?>" data-date-format="yyyy-mm-dd" id="dateTo" >
                  <a href="#editDTR" data-toggle="modal" style="margin-left: 10px;" class="btn btn-warning btn-xs pull-right">Edit</a>  
                  <button onclick="getDateFrom(document.getElementById('dateFrom').value, document.getElementById('dateTo').value)" style="margin-left: 10px;" class="btn btn-success btn-xs pull-right">search</button>  
                </div>

            </div>
        </div>   
        <div class="pull-right">
            <i class="fa fa-print fa-2x pull-left pointer" id="print" onclick="print(document.getElementById('dateFrom').value, document.getElementById('dateTo').value, '<?php echo $this->uri->segment(3)?>')" >
            </i>
        </div>
    </div>
</div>
<div class="pull-left col-lg-12" id="TableResult">
    <table border="1" style="margin:0; border: 1px solid #DDDDDD;"  class="table">
        <tr>
           <td width="10%" rowspan="2"><h5 style="margin-top:35px; font-size:18px; text-align: center;">DATE</h5></td>
            <td colspan="2" ><h5>MORNING</h5></td>
            <td colspan="2"><h5>AFTERNOON</h5>
            <td colspan="2"><h5>OVERTIME</h5>
            <td width="10%" rowspan="2"><h5 style="margin-top:35px; font-size:18px; text-align: center;">Daily<br>Total</h5></td>
        </tr>
        <tr>
            <td style="width:12%">
                <h5>IN</h5>
        
            </td>
            <td style="width:12%">
                <h5>OUT</h5>
            </td>
            <td style="width:12%">
                <h5>IN</h5>
        
            </td>
            <td style="width:12%">
                <h5>OUT</h5>
            </td>
            <td style="width:12%">
                <h5>IN</h5>
        
            </td>
            <td style="width:12%">
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
        foreach ($records as $row)
        {
                if($row->time_in!=""){
                    if($row->time_in<1000){
                        $time_in = date("g:i a", strtotime($row->time_in));
                        $timeInCompute = '0'.$row->time_in;
                    }else{
                        $time_in = date("g:i a", strtotime($row->time_in));
                        $timeInCompute = $row->time_in;
                    }
                    
                }else{
                    $time_in = "";
                }
                
                if($row->time_out!=""){
                    if($row->time_out<1000){
                        
                        $time_out = date("g:i a", strtotime($row->time_out));
                    }else{
                        $time_out = date("g:i a", strtotime($row->time_out));
                    }
                    $timeOutCompute = $row->time_out;
                }else{
                    $time_out = "";
                }
                
                if($row->time_in_pm!=""){
                        $time_in_pm = date("g:i a", strtotime($row->time_in_pm));
                      $timeInCompute = $row->time_in_pm;  
                }else{
                    $time_in_pm = "";
                }
                if($row->time_out_pm!=""){
                        $time_out_pm = date("g:i a", strtotime($row->time_out_pm));
                        $timeOutCompute = $row->time_out_pm;
                }else{
                    $time_out_pm = "";
                }

?>
        <tr>
            <td width="10%">
                <h5><?php echo $row->date ?></h5>
        
            </td>
            <td style="width:12%">
                <h5><?php echo $time_in ?></h5>
        
            </td>
            <td style="width:12%">
                <h5><?php echo $time_out ?></h5>
            </td>
            <td style="width:12%">
                <h5><?php echo $time_in_pm ?></h5>
        
            </td>
            <td style="width:12%">
                <h5><?php echo $time_out_pm ?></h5>
            </td>
            <td style="width:12%">
                <h5>0</h5>
        
            </td>
            <td style="width:12%">
                <h5>0</h5>
        
            </td>
            <td width="10%">
                <h5>
                    <?php
                       
                      $Hours = $hrdb->getManHours($timeInCompute, $timeOutCompute, $row->date); 
                      $totaltime = json_decode($Hours);
                      //echo $Hours['early'].'<br>';
                      //echo $Hours['over'].'<br>';
                      echo $totaltime->totalTime.'h '.$totaltime->minutes.'m';
                       
                                
                            
                        
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
       function print(from, to, id)
       {
            
            
            var url = '<?php echo base_url();?>hr/printDTR/'+from+'/'+to+'/'+id;
            window.open(url, '_blank');
             
       }
       function getDateFrom(dateFrom, dateTo)
        {
             var url = "<?php echo base_url()?>hr/searchDtrbyDate"; // the script where you handle the form input.
             var owners_id = document.getElementById("owners_id").value
           $.ajax({
                  type: "POST",
                  url: url,
                  data: "owners_id="+owners_id+"&dateFrom="+dateFrom+"&dateTo="+dateTo+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                  success: function(data)
                  {
                     document.getElementById('TableResult').innerHTML=data;
                     
                  }
                });

           return false; // avoid to execute the actual submit of the form.
        }
        
       $(function(){
        window.prettyPrint && prettyPrint();

        $('#dateFrom').datepicker();
        $('#dateTo').datepicker();
    });
   </script>   
   <script src="<?php echo base_url(); ?>assets/js/employeeRequest.js"></script>

<?php
    $data['user_id'] = $info->uid;
    $data['rfid'] = $info->rfid;
    $this->load->view('editDTR', $data);