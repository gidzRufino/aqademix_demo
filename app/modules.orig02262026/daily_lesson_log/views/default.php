<?php
if($this->uri->segment(3)===FALSE):
    if($this->uri->segment(4)===FALSE):
        $from = date("Y-m-d", strtotime('monday this week'));
    else:
        $from = $this->uri->segment(4);
    endif;
    if($this->uri->segment(5)===FALSE):
        
        $to = date("Y-m-d", strtotime('friday this week'));
    else:
        $to = $this->uri->segment(5);
    endif;
else:
    if($this->uri->segment(4)===FALSE):
        $from = date("Y-m-d", strtotime('monday this week'));
    else:
        $from = $this->uri->segment(4);
    endif;
    if($this->uri->segment(5)===FALSE):
        
        $to = date("Y-m-d", strtotime('friday this week'));
    else:
        $to = $this->uri->segment(5);
    endif;
endif;
?>
<div class="row">
    <div class="col-lg-12">
        <div style="margin-top:10px;">
            <div class="control-group pull-right">
              <div class="controls">
                  <label style="padding:5px" class="control-label pull-left" for="inputAdmissionDate">Date to</label>
                  <input name="dateTo" type="text" value="<?php echo $to;?>" data-date-format="yyyy-mm-dd" id="dateTo" >
                  <button onclick="getDLL(document.getElementById('dateFrom').value, document.getElementById('dateTo').value)" style="margin-left: 10px;" class="btn btn-success btn-xs pull-right">search</button>  
                </div>

            </div>
            <div class="control-group  pull-right">
              <div class="controls">
                  <label style="padding:5px" class="control-label pull-left" for="inputAdmissionDate">Date From</label>
                  <input name="dateFrom"  type="text" value="<?php echo $from;?>" data-date-format="yyyy-mm-dd" id="dateFrom" >
                </div>
            </div>
        </div>
        <h3 class="page-header clearfix" style="margin:0">Daily Lesson Log</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-6 pull-left">
            <div class="panel panel-primary" style="margin:0;">
                <div class="panel-heading">
                    <h4>Has Submitted</h4>
                </div>
                <div class="panel-body clearfix" id="present_em" style="max-height: 450px; overflow-y: scroll; ">
                    <?php 
                        foreach($submitted->result() as $basicInfo):
                            ?>
                    
                    <div onclick="getSingleDLL('<?php echo base64_encode($basicInfo->employee_id) ?>',document.getElementById('dateFrom').value, document.getElementById('dateTo').value)" class="alert alert-success clearfix clickover pointer" style="height:70px; padding:2px">
                                <div class="col-lg-2">
                                    <img class="img-circle" style="width:50px; border:5px solid #fff" src="<?php if($basicInfo->avatar!=""):echo base_url().'uploads/'.$basicInfo->avatar;else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
                                </div>   
                                <div class="col-lg-10" style="margin-top:20px;">
                                    <h4><?php echo $basicInfo->firstname.' '.$basicInfo->lastname;?></h4>
                                </div>
                            </div>
                    <?php
                        endforeach;
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 pull-right">
            <div class="panel panel-danger" style="margin:0;">
                <div class="panel-heading">
                    <h4>No DLL's</h4>
                </div>
                <div class="panel-body clearfix" style="max-height: 450px; overflow-y: scroll; ">
                    <?php 
                        foreach($employees->result() as $basicInfo):
                            if(!empty($submitted->result())):
                                foreach($submitted->result() as $s):
                                    if($s->t_id != $basicInfo->employee_id):
                                        ?>

                                    <div  class="alert alert-danger clearfix clickover pointer" style="height:70px; padding:2px">
                                            <div class="col-lg-2">
                                                <img class="img-circle" style="width:50px; border:5px solid #fff" src="<?php if($basicInfo->avatar!=""):echo base_url().'uploads/'.$basicInfo->avatar;else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
                                            </div>   
                                            <div class="col-lg-8" style="margin-top:20px;">

                                                <h4><?php echo $basicInfo->firstname.' '.$basicInfo->lastname?></h4>
                                            </div>
                                        </div>
                               <?php
                                    endif;
                                endforeach;
                            else:
                                ?>

                                    <div class="alert alert-danger clearfix clickover pointer" style="height:70px; padding:2px">
                                            <div class="col-lg-2">
                                                <img class="img-circle" style="width:50px; border:5px solid #fff" src="<?php if($basicInfo->avatar!=""):echo base_url().'uploads/'.$basicInfo->avatar;else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
                                            </div>   
                                            <div class="col-lg-8" style="margin-top:20px;">

                                                <h4><?php echo $basicInfo->firstname.' '.$basicInfo->lastname?></h4>
                                            </div>
                                        </div>
                               <?php
                            endif;
                        endforeach;
                    ?>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('#dateFrom').datepicker();
        $('#dateTo').datepicker();
        $('.addButton').clickover({
            placement: 'top',
            html: true
      });
    });
    
    function saveMatType()
    {
       var ref = $('#matType').val();
       var page_num = $('#mat_page_num').val()
       var dll_id = $('#dll_id_value').val();
       var url = "<?php echo base_url().'daily_lesson_log/addMaterial/'?>"+ref+'/'+page_num+'/'+dll_id; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "data="+""+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       alert('Material Reference Saved!')
                       $('#materialUsed').append(data);
                       
                       location.reload
                   }
                 });

            return false;
    }
    function addReference()
    {
       var ref = $('#refType').val();
       var page_num = $('#page_num').val()
       var dll_id = $('#dll_id_value').val();
       var url = "<?php echo base_url().'daily_lesson_log/addReference/'?>"+ref+'/'+page_num+'/'+dll_id; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "data="+""+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       alert('Reference Successfully Added!')
                       location.reload
                   }
                 });

            return false;
    }
    
    function submitDLL()
    {
       var dll_id = $('#dll_id_value').val();
       var url = "<?php echo base_url().'daily_lesson_log/submitDLL/'?>"+dll_id; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: "data="+""+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       alert('Successfully Submitted!')
                       $('#fa_'+dll_id).removeClass('fa-info');
                       $('#fa_'+dll_id).addClass('fa-send');
                       $('#badge_'+dll_id).removeClass('danger');
                       $('#fa_'+dll_id).addClass('info');
                       
                   }
                 });

            return false;
    }
    
    function getDLL(from, to)
    {
        var url = "<?php echo base_url().'daily_lesson_log/index/'?>"+from+'/'+to
        document.location = url;
    }
    
    function getSingleDLL(user_id, from, to)
    {
        var url = "<?php echo base_url().'daily_lesson_log/getDLL/'?>"+user_id+'/'+from+'/'+to
        document.location = url;
    }
</script>