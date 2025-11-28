<?php
echo Modules::run('templates/html_header');
$website = Modules::run('main/getSet');
?>
<style>
  .myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }

  .myImg:hover {
    opacity: 0.7;
  }

  /* The Modal (background) */
  .modal-img {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    padding-top: 100px;
    /* Location of the box */
    left: 0;
    top: 0;
    width: 100%;
    /* Full width */
    height: 100%;
    /* Full height */
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.9);
    /* Black w/ opacity */
  }

  /* Modal Content (image) */
  .modal-content-img {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
  }

  /* Caption of Modal Image */
  #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
  }

  /* Add Animation */
  .modal-content-img,
  #caption {
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
  }

  @-webkit-keyframes zoom {
    from {
      -webkit-transform: scale(0)
    }

    to {
      -webkit-transform: scale(1)
    }
  }

  @keyframes zoom {
    from {
      transform: scale(0)
    }

    to {
      transform: scale(1)
    }
  }

  /* The Close Button */
  .close-img {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }

  .close-img:hover,
  .close-img:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
  }

  /* 100% Image Width on Smaller Screens */
  @media only screen and (max-width: 700px) {
    .modal-content-img {
      width: 100%;
    }
  }
</style>
<div id="wrapper">
  <input type="hidden" id="portal_address" value="<?php echo base64_encode($website->web_address); ?>" />
  <input type="hidden" id="web_address" value="<?php echo $website->web_address; ?>" />
  <!-- Navigation -->
  <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; ">
    <?php
    echo Modules::run('nav/getDashIcons');
    echo Modules::run('nav/getSideNav');

    ?>
  </nav>

  <div id="page-wrapper">
    <span class="hide" id="countdown"></span>
    <?php $this->load->view($modules . '/' . $main_content); ?>

  </div>
  <input type="hidden" id="chat_url" value="<?php echo base_url() . 'chat_system/chat/' ?>" />
  <input type="hidden" id="base_url" value="<?php echo base_url() ?>" />
  <div id="submitLoad" class="hide">
    <div class="submitLoadDesktop " style="z-index: 2000">
      <img src="<?php echo base_url() . 'assets/img/loading.gif' ?>" style="width:150px" />
    </div>
  </div>
  <div id="notify_me" style="position:absolute; bottom:5%; right:1%;display: none; " class="alert alert-danger" data-dismiss="alert-message">

  </div>
  <!-- /#page-wrapper -->
  <script src="<?php echo base_url(); ?>assets/js/plugins/countdown.js"></script>
  <script type="text/javascript">
    //startCount(15, 1000, checkPortal,'countdown');
    function checkPortal() {
      var web_address = $('#portal_address').val()
      var url = "<?php echo base_url() . 'main/checkPortal/' ?>" + web_address; // the script where you handle the form input.

      $.ajax({
        type: "POST",
        dataType: 'json',
        url: url,
        data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
        success: function(data) {
          // alert(data.msg)
          if (data.status) {

            $('#portal_status').removeClass('fa-spinner fa-spin')
            $('#portal_status').addClass('fa-circle')
            $('#portal_status').attr('status', '1')
            $('#portal_status').attr('style', 'color:#33EF26')
          } else {
            if ($('#portal_status').attr('status') == 1) {
              $('#portal_status').attr('status', '0')
              $('#portal_status').removeClass('fa-wifi')
              $('#portal_status').addClass('fa-spinner fa-spin')
            }

          }
          startCount(15, 1000, checkPortal, 'countdown');

        }
      });

      return false;

    }
  </script>

  <!-- The Modal -->
  <div id="imgModal" class="modal-img">
    <span class="close">&times;</span>
    <img class="modal-content-img" id="img01">
    <div id="caption"></div>
  </div>
  <div id="selectNewOption" class="modal fade col-lg-2 col-xs-10" style="margin:30px auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="col-lg-12 modal-header" style="background: #FFF; box-shadow: 3px 3px 5px 5px #ccc; border-radius: 5px; border: 1px solid #ccc;">
      <p class="text-center">Please select an option to enroll</p>
      <?php
      switch ($website->level_catered):
        case 0:
      ?>
          <button id="gs" onclick="document.location = '<?php echo base_url('registrar/admission/2') ?>'" class="btn btn-block btn-primary">PRE-SCHOOL & <br /> GRADE SCHOOL</button>
          <button id="jhs" onclick="document.location = '<?php echo base_url('registrar/admission/3') ?>'" class="btn btn-block btn-warning">JUNIOR HIGH SCHOOL</button>
          <button id="shs" onclick="document.location = '<?php echo base_url('registrar/admission/4') ?>'" class="btn btn-block btn-success">SENIOR HIGH SCHOOL</button>
          <button id="college" onclick="document.location = '<?php echo base_url('registrar/admission') ?>'" class="btn btn-block btn-danger">COLLEGE LEVEL</button>
        <?php
          break;
        case 1:
        case 2:
        ?>
          <button id="gs" onclick="document.location = '<?php echo base_url('registrar/admission/2') ?>'" class="btn btn-block btn-primary">PRE-SCHOOL & <br /> GRADE SCHOOL</button>

        <?php
          break;
        case 3:
        ?>
          <button id="gs" onclick="document.location = '<?php echo base_url('registrar/admission/2') ?>'" class="btn btn-block btn-primary">PRE-SCHOOL & <br /> GRADE SCHOOL</button>
          <button id="jhs" onclick="document.location = '<?php echo base_url('registrar/admission/3') ?>'" class="btn btn-block btn-warning">JUNIOR HIGH SCHOOL</button>

        <?php
          break;
        case 4:
        ?>
          <button id="gs" onclick="document.location = '<?php echo base_url('registrar/admission/2') ?>'" class="btn btn-block btn-primary">PRE-SCHOOL & <br /> GRADE SCHOOL</button>
          <button id="jhs" onclick="document.location = '<?php echo base_url('registrar/admission/3') ?>'" class="btn btn-block btn-warning">JUNIOR HIGH SCHOOL</button>
          <button id="shs" onclick="document.location = '<?php echo base_url('registrar/admission/4') ?>'" class="btn btn-block btn-success">SENIOR HIGH SCHOOL</button>

      <?php
          break;
      endswitch;
      // switch ($settings->level_catered):
      //   case 1:
      // 
      ?>
      <!-- <button id="gs" onclick="document.location='<?php // echo base_url('registrar/admission/2') 
                                                        ?>'" class="btn btn-block btn-primary">PRE-SCHOOL & <br /> GRADE SCHOOL</button> -->

      <?php
      //     break;
      //   case 2:
      //   
      ?>
      <!-- <button id="gs" onclick="document.location='<?php // echo base_url('registrar/admission/2') 
                                                        ?>'" class="btn btn-block btn-primary">PRE-SCHOOL & <br /> GRADE SCHOOL</button>
           <button id="jhs" onclick="document.location='<?php  //echo base_url('registrar/admission/3') 
                                                        ?>'" class="btn btn-block btn-warning">JUNIOR HIGH SCHOOL</button> -->

      <?php
      //     break;
      //   case 3:
      //   
      ?>
      <!-- <button id="gs" onclick="document.location='<?php // echo base_url('registrar/admission/2') 
                                                        ?>'" class="btn btn-block btn-primary">PRE-SCHOOL & <br /> GRADE SCHOOL</button>
           <button id="jhs" onclick="document.location='<?php // echo base_url('registrar/admission/3') 
                                                        ?>'" class="btn btn-block btn-warning">JUNIOR HIGH SCHOOL</button>
           <button id="shs" onclick="document.location='<?php // echo base_url('registrar/admission/4') 
                                                        ?>'" class="btn btn-block btn-success">SENIOR HIGH SCHOOL</button> -->

      <?php
      //     break;
      //   default:
      //   
      ?>
      <!-- <button id="gs" onclick="document.location='<?php // echo base_url('registrar/admission/2') 
                                                        ?>'" class="btn btn-block btn-primary">PRE-SCHOOL & <br /> GRADE SCHOOL</button>
           <button id="jhs" onclick="document.location='<?php // echo base_url('registrar/admission/3') 
                                                        ?>'" class="btn btn-block btn-warning">JUNIOR HIGH SCHOOL</button>
           <button id="shs" onclick="document.location='<?php // echo base_url('registrar/admission/4') 
                                                        ?>'" class="btn btn-block btn-success">SENIOR HIGH SCHOOL</button> -->
      <?php
      // endswitch; 
      ?>
    </div>
  </div>

  <script>
    // Get the modal
    var modal = document.getElementById("imgModal");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementsByClassName("myImg");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");

    $('.myImg').click(function() {
      modal.style.display = "block";
      modalImg.src = $(this).attr('src');
      captionText.innerHTML = $(this).attr('alt');
    });

    $('#imgModal').click(function() {
      modal.style.display = "none";
    });

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
  </script>
  <script type="text/javascript">
    function logout() {
      var con = confirm('Are you sure you want to logout?');
      if (con == true) {
        document.location = "<?php echo base_url('login/logout'); ?>"
      }
    }
  </script>
  <!-- chat Javascript -->
  <script src="<?php echo base_url('assets/js/plugins/chat.js'); ?>"></script>

  <?php
  echo Modules::run('templates/html_footer');
