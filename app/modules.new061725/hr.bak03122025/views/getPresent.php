<?php 
    foreach($presents->result() as $basicInfo):
        if($basicInfo->time_in!=""):
            if($basicInfo->time_in<1000){
                
                $time_in = date("g:i a", strtotime($basicInfo->time_in));
            }else{
                $time_in = date("g:i a", strtotime($basicInfo->time_in));
            }
        else:
            $time_in = "";
        endif;

        if($basicInfo->time_out!=""){
            if($basicInfo->time_out<1000    ){
                $time_out = ' - '.date("g:i a", strtotime($basicInfo->time_out));
            }else{
                $time_out =' - '.date("g:i a", strtotime($basicInfo->time_out));
            }
        }else{
            $time_out = "";
        }

        if($basicInfo->time_in_pm!=""){
            if($basicInfo->time_in_pm<1000){
                $time_in_pm = date("g:i a", strtotime($basicInfo->time_in_pm));
            }else{
                $time_in_pm = date("g:i a", strtotime($basicInfo->time_in_pm));
            }
        }else{
            $time_in_pm = "";
        }
        if($basicInfo->time_out_pm!=""){
            if($basicInfo->time_out_pm<1000){
                $time_out_pm = ' - '.date("g:i a", strtotime($basicInfo->time_out_pm));
            }else{
                $time_out_pm = ' - '.date("g:i a", strtotime($basicInfo->time_out_pm));
            }
        }else{
            $time_out_pm = "";
        }

        if($time_in==""):
            $time_in = $time_in_pm;
        endif;
        if($time_out==""):
            $time_out = $time_out_pm;
        endif;
?>
        <div data-content=" 
                    <div class='col-lg-12 form-group' style='width:230px;'>
                        <b>Select Time </b><br />
                        <select id='<?php echo $basicInfo->u_rfid ?>_hr' style='width:50px;'>
                           <?php
                           for ($i=1; $i<=12; $i++)
                           {
                               if($i<10)
                               {
                                   $i='0'.$i;
                               }
                           ?>
                           <option value='<?php echo $i ?>'><?php echo $i ?></option>
                           <?php } ?>
                       </select> :  
                       <select id='<?php echo $basicInfo->u_rfid ?>_min' style='width:50px;'>
                           <?php
                           for ($i=0; $i<=60; $i++)
                           {
                               if($i<10)
                               {
                                   $i='0'.$i;
                               }
                           ?>
                           <option value='<?php echo $i ?>'><?php echo $i ?></option>
                           <?php } ?>
                       </select>
                       <select id='<?php echo $basicInfo->u_rfid ?>_ampm' style='width:60px;'>
                           <option> Select Choice </option>
                           <option value='AM'>AM</option>
                           <option value='PM'>PM</option>
                       </select>

                                           <select id='<?php echo $basicInfo->u_rfid ?>_inout' style='width:60px;'>
                                               <option value='in'>IN</option>
                                               <option value='out'>OUT</option>
                                           </select>
                       <input type='hidden' value='<?php echo $basicInfo->u_rfid ?>' id='<?php echo $basicInfo->u_rfid ?>_dtr' />
                    </div>
                    <div class='col-lg-12 pull-right'>
                         <button data-dismiss='clickover' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                         <a href='#' data-dismiss='clickover' onclick='saveTime(<?php echo $basicInfo->u_rfid ?>)' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</a>
                    </div>

                 " 

            class="alert alert-success clearfix clickover pointer" style="height:70px; padding:2px">
            <div class="col-lg-2">
                <img class="img-circle" style="width:50px; border:5px solid #fff" src="<?php if($basicInfo->avatar!=""):echo base_url().'uploads/'.$basicInfo->avatar;else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
            </div>   
            <div class="col-lg-10" style="margin-top:20px;">
                <h4><?php echo $basicInfo->firstname.' '.$basicInfo->lastname.' [ '. $time_in.$time_out.' ] '?></h4>
            </div>
        </div>
<?php
    endforeach;
?>
<script type="text/javascript">
    $(document).ready(function() {
        $(".clickover").clickover({
                placement: 'top',
                html: true
              });
    })
    
</script>