<?php
    echo link_tag('assets/css/crop/jquery.Jcrop.css');
    echo link_tag('assets/css/crop/demos.css');
?>
<script src="<?php echo base_url(); ?>assets/js/crop/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/crop/jquery.Jcrop.min.js"></script>
<script type="text/javascript">

  $(function(){

    $('#cropbox').Jcrop({
      aspectRatio: 1,
      onSelect: updateCoords
    });
    
    $("#imageCrop").click(function() {
        $('#frmCrop').submit();
    });

  });

  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function checkCoords()
  {
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
  };

</script>
<div class="row-fluid contentHeader sticky" style="width:1080px; background: #FFF; z-index: 2000">
        <h3 class="pull-left" style="margin:0">Crop Image</h3>
        <button class="btn btn-info pull-right"id="imageCrop">Crop</button>
</div>
<div style="width:500px; margin:0 auto;">
    <img src="<?php echo base_url().'uploads/'.$students->avatar  ?>" id="cropbox" />

    <!-- This is the form that our event handler fills -->
    <form id="frmCrop" action="<?php echo base_url().'main/processCropping/'.$students->avatar.'/'.$this->uri->segment(3); ?>" method="post" onsubmit="return checkCoords();">
            <input type="hidden" id="x" name="x" />
            <input type="hidden" id="y" name="y" />
            <input type="hidden" id="w" name="w" />
            <input type="hidden" id="h" name="h" />
    </form>
</div>
                