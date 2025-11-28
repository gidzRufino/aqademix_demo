<table border="1" style="margin:0; border: 1px solid #DDDDDD;"  class="table col-lg-12">
    <tr>
       <td  class="col-lg-2" rowspan="2"><h5 style="margin-top:35px; font-size:12px; text-align: center;">DATE</h5></td>
        <td colspan="2" ><h5>AM</h5></td>
        <td colspan="2"><h5>PM</h5>
        <td class="pointer" width="10%" rowspan="2"><button data-toggle="modal" data-target="#passSlipModal"  class="btn btn-warning" style="margin-top:35px; font-size:12px; text-align: center;">Request for <br />Consideration</button></td>
    </tr>
    <tr>
        <td class="col-lg-2" style="text-align: center">
            <h5>IN</h5>

        </td>
        <td class="col-lg-2" style="text-align: center">
            <h5>OUT</h5>
        </td>
        <td class="col-lg-2" style="text-align: center">
            <h5>IN</h5>

        </td>
        <td class="col-lg-2" style="text-align: center">
            <h5>OUT</h5>
        </td>
    </tr>
</table>
<table class='table table-striped col-lg-12'> 
    <?php 
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
                  $timeInPMCompute = $row->time_in_pm;  
            }else{
                $time_in_pm = "";
            }
            if($row->time_out_pm!=""){
                    $time_out_pm = date("g:i a", strtotime($row->time_out_pm));
                    $timeOutPMCompute = $row->time_out_pm;
            }else{
                $time_out_pm = "";
            }

?>
    <tr>
        <td class="col-lg-2">
            <h5><?php echo $row->date ?></h5>

        </td>
        <td class="col-lg-2" style="text-align: center">
            <h5><?php echo $time_in ?></h5>

        </td>
        <td class="col-lg-2" style="text-align: center">
            <h5><?php echo $time_out ?></h5>
        </td>
        <td class="col-lg-2" style="text-align: center">
            <h5><?php echo $time_in_pm ?></h5>

        </td>
        <td class="col-lg-2" style="text-align: center">
            <h5><?php echo $time_out_pm ?></h5>
        </td>
        <td class="col-lg-2">
            
        </td>
    </tr>
    <?php 
        }  
    ?>

    <!--records is taken from controller dtr-->

</table>