<!--Deactivate-->
<div style='width:450px; height:auto;margin-top:50px; margin-bottom: 10px;' id="deactivate" class="emailForm">


</div>

<script type="text/javascript">
  // function submitRemarks() {
  //   var url = "<?php echo base_url() . 'main/saveAdmissionRemarks/' ?>"; // the script where you handle the form input.
  //   var st_id = $('#st_id').val()
  //   var user_id = $('#us_id').val()
  //   var code = $('#inputRemarks').val()
  //   var info = $('#required_information').val()
  //   $.ajax({
  //     type: "POST",
  //     url: url,
  //     data: "codeIndicator_id=" + code + "&required_information=" + info + "&st_id=" + $('#st_id').val() + "&user_id=" + user_id + "&effectivity_date=" + $('#inputEffectivity').val() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
  //     success: function(data) {
  //       $('#remarks_' + st_id + "_td").html(data);
  //       if (code == 1 || code == 3) {
  //         $('#img_' + st_id + "_td img").attr("src", '<?php echo base_url(); ?>images/unofficial.png');
  //       } else {
  //         $('#img_' + st_id + "_td img").attr("src", '<?php echo base_url(); ?>images/official.png');
  //       }
  //       location.reload();
  //     }
  //   });

  //   return false;
  // }
  $(document).ready(function() {
    $('#inputEffectivity').datepicker();
  });
</script>