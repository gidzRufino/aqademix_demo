<?php
$is_admin = $this->session->userdata('is_admin');
$userid = $this->session->userdata('user_id');
$stngs=Modules::run('main/getSet');
?>

<div class="clearfix row" style="margin:0;">
<input type="hidden" name="lastEntry" id="school_sname" value="<?php echo $stngs->short_name; ?>"required>
  <div class="panel panel-success"style="margin-top: 15px;">
    <div class="panel-heading text-center">
      <h3 class="text-center panel-title"><b>Generate Collection Notice</b></h3>
    </div>
    <div class="panel-body">
      <div class="center" style="margin-top: 10px;">
        <button name="send_sms" id="send_sms" type="button" data-toggle="modal" class="btn btn-medium bg-primary " disabled><i class="fa fa-paper-plane fa-fw"></i> Send Collection Notice through SMS</button>
        <button name="gen_print" id="gen_print" type="button" data-toggle="modal" class="btn btn-medium bg-primary "><i class="fa fa-newspaper-o fa-fw"></i> Generate Printable Collection Notice</button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="collapse" data-toggle="collapse" id="send_sms_notification">
      <div class="panel panel-success"style="margin-top: 15px;">
        <div class="panel-heading text-center">
          <h3 class="text-center panel-title"><b>Broadcast SMS Collection Notice</b></h3>
        </div>
        <div class="panel-body">
          <div class="col-md-4 well well-small offset1" style="height: 175px;">
            <div class="col-md-12">
              <div class="control-group pull-left">
                <label class="control-label" for="duedate">Set Due Date for collection</label>
                <div class="input-group">
                  <input style="width: 190px;" name="duedate" type="text" class="form-control" data-date-format="mm-dd-yyyy" id="duedate" placeholder="Collection Due Date" required>
                  <span class="input-group-btn">
                    <button class="btn btn-default" id="calen" onclick="$('#duedate').focus()" type="button"><i class="fa fa-calendar"></i></button>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="control-group pull-left" style="margin-top: 15px;">
                <label class="control-label" >Send SMS Collection Notice to</label>
                <div class="controls">
                  <select onclick="destination()" tabindex="-1" id="select_destination" style="width:225px;" >   
                    <option>Select Destination</option>
                    <option value="1">All Year Level</option>
                    <option value="2">Specific Level</option>
                    <option value="3">Specific Account</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
  </div>
</div>


<script type="text/javascript">

  $(document).ready(function() {
    $('#duedate').datepicker();
    $("#select_destination").select2();
    $("#selected_all").select2();
    $("#selected_level").select2();
    $("#selected_account").select2();

  });

  $("#send_sms").click(function()
  {
    $('#send_sms_notification').collapse('show');
    $('#print_notification').collapse('hide');
  });

  $("#gen_print").click(function()
  {
    document.location = '<?php echo base_url()?>financemanagement/collect/print_soa/'
  });

  function send_all()
  {
    $('#secretContainer').fadeIn(500)
    $('#secretContainer').html('<img src="<?php echo base_url() ?>images/library.png" style="width:200px" />')
    var sa_sname = document.getElementById('school_sname').value;
    var lastcount = document.getElementById('last_count').value;
    var cdate = document.getElementById('duedate').value;
    var detail_container = document.getElementById('trans_details');

    for (dcounter = 1; dcounter <= lastcount; dcounter++) {
      var run_name = 'an' + dcounter;
      var run_balance = 'tbd' + dcounter;
      var run_mother = 'ma' + dcounter;
      var run_father = 'pa' + dcounter;

      var a_name = document.getElementById(run_name).innerHTML;
      var a_mother = document.getElementById(run_mother).innerHTML;
      var a_father = document.getElementById(run_father).innerHTML;
      var a_balance = document.getElementById(run_balance).innerHTML;

      if (a_mother) {
        var a_number = a_mother;
      } else {
        if (a_father) {
          var a_number = a_father;
        } else {
          var a_number = 'none'
        }
      }

      if (a_number != 'none') {
        var numlength = a_number.length;
        if (numlength >= 11) {
          var msg = sa_sname + ' SMS: Your student, ' + a_name + ', has an outstanding balance of PhP ' + a_balance + '. Please settle this on or before ' + cdate + ' Thanks';
          sendMessage(msg, a_number, 'send');

          // var msg_entry = document.createElement('input');           // msg_entry.type = 'text';           // msg_entry.name = 'msg_entry';          // msg_entry.value = 'sendMessage(' + msg + '| Number: ' + a_number + ', send)'          // trans_details.appendChild(msg_entry);

        }
      }
    }

    $('#secretContainer').hide()

    alert('Collection Notice succesfully sent to All Year Level. The receipients may receive the notification sms depending on the speed and ability of the carrier network to process bulk messages.');
  }

  function send_level()
  {
    var lastcount = document.getElementById('last_count').value;
    var cdate = document.getElementById('duedate').value;
    var clevel = document.getElementById('selected_level').value;
    var detail_container = document.getElementById('trans_details');
    var sa_sname = document.getElementById('school_sname').value;
    $('#secretContainer').fadeIn(500)
    $('#secretContainer').html('<img src="<?php echo base_url() ?>images/library.png" style="width:200px" />')

    // alert(clevel);

    if (clevel != 'Select Destination') {

      for (dcounter = 1; dcounter <= lastcount; dcounter++) {
        // alert(dcounter);
        var run_name = 'an' + dcounter;
        var run_level = 'ag' + dcounter;
        var run_balance = 'tbd' + dcounter;
        var run_mother = 'ma' + dcounter;
        var run_father = 'pa' + dcounter;

        var a_name = document.getElementById(run_name).innerHTML;
        var a_level = document.getElementById(run_level).innerHTML;
        var a_mother = document.getElementById(run_mother).innerHTML;
        var a_father = document.getElementById(run_father).innerHTML;
        var a_balance = document.getElementById(run_balance).innerHTML;

        if (a_level == clevel) {

          if (a_mother) {
            var a_number = a_mother;
          } else {
            if (a_father) {
              var a_number = a_father;
            } else {
              var a_number = 'none'
            }
          }

          if (a_number != 'none') {
            var numlength = a_number.length;
            if (numlength >= 11) {

              var msg = sa_sname + ' SMS: Your student, ' + a_name + ', has an outstanding balance of PhP ' + a_balance + '. Please settle this on or before ' + cdate + ' Thanks';
              sendMessage(msg, a_number, 'send');

              // alert(msg);
            }
          }
        }
      }

      $('#secretContainer').hide()
      alert('Collection Notice succesfully sent to ' + clevel + '. Receipients may receive the notification sms depending on the speed and ability of the carrier network to process bulk messages.');

    } else {
      alert('Please select year level to send notification to and press send.')
    }
  }


  function send_account()
  {
    var lastcount = document.getElementById('last_count').value;
    var cdate = document.getElementById('duedate').value;
    var caccount = document.getElementById('selected_account').value;
    var detail_container = document.getElementById('trans_details');
    var sa_sname = document.getElementById('school_sname').value;

    $('#secretContainer').fadeIn(500)
    $('#secretContainer').html('<img src="<?php echo base_url() ?>images/library.png" style="width:200px" />')
    // alert(clevel);

    if (caccount != 'Select Destination') {

      for (dcounter = 1; dcounter <= lastcount; dcounter++)
      {
        var run_name = 'an' + dcounter;
        var run_balance = 'tbd' + dcounter;
        var run_mother = 'ma' + dcounter;
        var run_father = 'pa' + dcounter;

        var a_name = document.getElementById(run_name).innerHTML;
        var a_mother = document.getElementById(run_mother).innerHTML;
        var a_father = document.getElementById(run_father).innerHTML;
        var a_balance = document.getElementById(run_balance).innerHTML;

        if (a_name == caccount) {

          if (a_mother) {
            var a_number = a_mother;
          } else {
            if (a_father) {
              var a_number = a_father;
            } else {
              var a_number = 'none'
            }
          }

          if (a_number != 'none') {
            var numlength = a_number.length;
            if (numlength >= 11) {

              var msg = sa_sname + ' SMS: Your student, ' + a_name + ', has an outstanding balance of PhP ' + a_balance + '. Please settle this on or before ' + cdate + ' Thanks';
              alert(msg);
              sendMessage(msg, a_number, 'send');
            }
          }
        }
      }

      $('#secretContainer').hide()
      alert('Collection Notice succesfully sent to the guardian / parent of ' + caccount + '. The receipient may receive the notification sms depending on the speed and ability of the carrier network to process bulk messages.');

    } else {
      alert('Please select year level to send notification to and press send.')
    }
  }



  function destination()
  {
    var dest_value = document.getElementById('select_destination').value;
    var ddate = document.getElementById('duedate').value;

    if (ddate != '') {
      document.getElementById('cald1').innerHTML = ddate;
      document.getElementById('cald2').innerHTML = ddate;
      document.getElementById('cald3').innerHTML = ddate;

      if (dest_value == 1) {
        $(".sms_all").show();
        $(".sms_level").hide();
        $(".sms_account").hide();
        $(".sms_default").hide();
      } else if (dest_value == 2) {
        $(".sms_all").hide();
        $(".sms_level").show();
        $(".sms_account").hide();
        $(".sms_default").hide();
      } else if (dest_value == 3) {
        $(".sms_all").hide();
        $(".sms_level").hide();
        $(".sms_account").show();
        $(".sms_default").hide();
      }

    } else {
      $('#select_destination').prop('selectedIndex', 0);
      alert('Please enter collection date and repick send to choice.');

    }
  }

  function cancel()
  {
    $(".sms_all").hide();
    $(".sms_level").hide();
    $(".sms_account").hide();
    $(".sms_default").show();
    $('#select_destination').prop('selectedIndex', 0);
    document.getElementById('select_destination').value = '';
    document.getElementById('duedate').value = '';
  }


</script>
