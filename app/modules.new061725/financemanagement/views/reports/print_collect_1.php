<?php
  $stngs=Modules::run('main/getSet');
?>

<div class="clearfix row" style="margin:0;">
  <input type="hidden" name="lastEntry" id="school_sname" value="<?php echo $stngs->short_name; ?>"required>
  <div class="panel panel-success"style="margin-top: 15px;">
    <div class="panel-heading text-center">
      <h3 class="text-center panel-title"><b>Printable Collection Notice / Statement of Account Generator</b></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="pull-left">
          <select name="select_grade_level" style="width:150px; margin: 0 5px 0 20px;" id="select_grade_level" class="controls-row" required>
            <option>Grade Level</option>       
              <?php foreach ($get_level as $gl) { ?>              
            <option value="<?php echo $gl->grade_id ?>"><?php echo $gl->level ?></option>
              <?php } ?>
          </select> 
        </div>
        <div class="pull-left">
          <select name="print_type" id="print_type" style="width:150px; margin-right: 5px;" class="controls-row" required>
            <option value='none'>Select print type</option>                     
            <option value='short'>Short - Summarized SOA</option>
            <option value='long'>Long - Itemized SOA</option>
          </select>
        </div>
        <div class="pull-left">
          <select name="month_advance" id="month_advance" style="width:100px; margin-right: 5px;" class="controls-row" required>
            <option value=''>Current</option>                     
            <option value='1'>+1 Month</option>
            <option value='2'>+2 Months</option>
            <option value='3'>+3 Months</option>
          </select>
        </div>
        <div class="input-group input-group-sm col-md-3">
          <input name="duedate" class="form-control" type="text" data-date-format="mm-dd-yyyy" id="duedate" placeholder="Collection Due Date" required>
          <span class="input-group-btn">
            <button class="btn btn-default" id="calen"  style="font-size:8px;" onclick="$('#duedate').focus()" type="button"><i class="fa fa-calendar fa-lg"></i></button>
          </span>
        </div>
        <div class="input-group">
          <span class="input-group-btn">
            <button onclick="generate_soa()" style="margin-top: -30px; margin-right: 40px;" class="btn btn-success btn-sm pull-right"><i class="fa fa-cog  fa-spin fa-fw"></i>Generate</button> 
          </span>          
        </div>
      </div>
    </div>
    <!-- <iframe class="hide" id="report_iframe" width="100%" height="500" src=""></iframe>  -->
  </div>
  <div id="d_report" class="panel panel-success" style="display:none; margin-top: 15px;">
    <div class="panel-heading text-center">
      <h3 id="report_header" class="text-center panel-title"><b></b></h3>
    </div>
    <div class="panel-body">
      <iframe class="" style="display:none; margin-top:10px;" id="report_iframe" width="100%" height="400" src=""></iframe>
    </div>
  </div>
  <!-- <iframe class="" style="display:none; margin-top:10px;" id="report_iframe" width="100%" height="350" src=""></iframe>  -->
</div>

<!-- <button name="send_sms" id="send_sms" type="button" data-toggle="modal" class="btn btn-medium bg-primary "><i class="fa fa-paper-plane fa-fw"></i> Send Collection Notice through SMS</button> -->

<br /><br /><br />

<script type="text/javascript">

  $(document).ready(function() {
    $('#select_grade_level').select2();
    $('#print_type').select2();
    $('#month_advance').select2();
    $('#duedate').datepicker();

  });

  function generate_soa()
  {
    var gradelevel = $('#select_grade_level').val()
    var due_date = $('#duedate').val()
    var gloptions = 'Select Grade Level';
    var printype = document.getElementById('print_type').value;
    var madvance = document.getElementById('month_advance').value

    if (printype=='none'){
        alert('Please select print type.');
    }else if(printype=='short'){
      if (due_date){
        if (gradelevel==gloptions){
          alert('Please select grade level.');
        }else{
          // document.location = "<?php echo base_url() ?>financemanagement/collect/print_soa/"+gradelevel+'/'+due_date
          var url = "<?php echo base_url() ?>financemanagement/collect/print_soa/"+gradelevel+'/'+due_date+'/'+madvance;
          $('#loading').removeClass('hide');
          $('#loading').html('<img src="<?php echo base_url()?>images/loading.gif" style="width:200px" />');
          document.getElementById('report_header').innerHTML = '<b>Summarized Statement of Account</b>';
          // $('#secretContainer').fadeIn(500)
          // $('#secretContainer').html('<img src="<?php echo base_url() ?>images/library.png" style="width:200px" />')
          document.getElementById('report_iframe').src = url;
          $('#report_iframe').attr('onload', 'iframeloaded()');
          document.getElementById('report_iframe').Window.location.reload(true);
          window.open(url, '_blank');
          document.title = 'Collection Notice';
        }  
      }else{
        alert('Please select due date.')
      }    
    }else if(printype=='long'){
      if (due_date){
        if (gradelevel==gloptions){
          alert('Please select grade level.');
        }else{
         // document.location = "<?php echo base_url() ?>financemanagement/collect/print_soa/el/"+gradelevel+'/'+due_date;
          var url = "<?php echo base_url() ?>financemanagement/collect/print_soa/el/"+gradelevel+'/'+due_date+'/'+madvance;
          $('#loading').removeClass('hide');
          $('#loading').html('<img src="<?php echo base_url()?>images/loading.gif" style="width:200px" />');
          document.getElementById('report_header').innerHTML = '<b>Itemized Statement of Account</b>';
          // $('#secretContainer').fadeIn(500);
          // $('#secretContainer').html('<img src="<?php echo base_url() ?>images/library.png" style="width:200px" />');
          document.getElementById('report_iframe').src = url;
          $('#report_iframe').attr('onload', 'iframeloaded()');
          document.getElementById('report_iframe').Window.location.reload(true);
          window.open(url, '_blank');
          document.title = 'Collection Notice';
        }  
      }else{
        alert('Please select due date.')
      }    
    }
  }

  function iframeloaded()
  {
    $('#secretContainer').hide()
    $('#loading').hide();
    $('#d_report').show();
    $('#report_iframe').show();
  }
</script>
