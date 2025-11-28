<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <!--      <li class="nav-item d-none d-sm-inline-block">
                <a href="../index3.html" class="nav-link">Home</a>
              </li>
              <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
              </li>-->
    </ul>

    <!-- SEARCH FORM -->
    <?php
      if(strtolower($this->uri->segment(2)) != 'college'):
        echo Modules::run('opl/searchBar', $this->uri->segment(2), $grade_level, $section_id, $subject_id);
      else:
        echo Modules::run('opl/college/searchBar', $this->uri->segment(3), $section_id, $semeseter, $subject_id);
      endif;
    ?>

    <ul class="navbar-nav ml-auto">
        <?php if(!$this->session->isParent && !$this->session->isStudent): ?>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fas fa-question-circle"></i>
              <span class="badge badge-danger navbar-badge">4</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#open_video" onclick="$('#vidTitle').html('The Lesson Library'), $('#vidLink').attr('src','https://eskwelacampus.com/vidz/LMSeries-TheLessonLibrary.mp4')" data-toggle="modal" class="dropdown-item">
                <div class="media">
                   <i class="fa fa-notes"></i>
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      The Lesson Library
                      <span class="float-right text-sm text-danger"><i class="fas fa-book"></i></span>
                    </h3>
                    <p class="text-sm text-muted">Building up Lessons</p>
                  </div>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#open_video" onclick="$('#vidTitle').html('Task - Use Editor'), $('#vidLink').attr('src','https://eskwelacampus.com/vidz/LMSeries-AddingATask.mp4')" data-toggle="modal"  class="dropdown-item">
                <div class="media">
                   <i class="fa fa-notes"></i>
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      Task - Use Editor
                      <span class="float-right text-sm text-danger"><i class="fas fa-edit"></i></span>
                    </h3>
                      <p class="text-sm text-muted">Adding Task using <b>Use Editor</b> submission type</p>
                  </div>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#open_video" onclick="$('#vidTitle').html('Task - File Submission'), $('#vidLink').attr('src','https://eskwelacampus.com/vidz/LMSeries-AddingTask-FileAttachment.mp4')" data-toggle="modal"  class="dropdown-item">
                <div class="media">
                   <i class="fa fa-notes"></i>
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      Task - File Submission
                      <span class="float-right text-sm text-danger"><i class="fas fa-file"></i></span>
                    </h3>
                      <p class="text-sm text-muted">Adding Task using <b>File Submission</b> submission type</p>
                  </div>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#open_video" onclick="$('#vidTitle').html('Task - File Submission'), $('#vidLink').attr('src','https://eskwelacampus.com/vidz/LMSeries-AddingTask-OnlineQuizForm.mp4')" data-toggle="modal"  class="dropdown-item">
                <div class="media">
                   <i class="fa fa-notes"></i>
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      Task - Online Quiz
                      <span class="float-right text-sm text-danger"><i class="fas fa-edit"></i></span>
                    </h3>
                      <p class="text-sm text-muted">Adding Task using <b>Online Quiz Form</b> submission type</p>
                  </div>
                </div>
              </a>
              <div class="dropdown-divider"></div>
            </div>
          </li>
        <?php endif; ?>
        <li class="nav-item" onclick="mycal()">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                My Calendar <i class="fas fa-calendar"></i>
                <!--<span class="badge badge-success navbar-badge">^_^</span>-->
            </a>
        </li>
        <li class="nav-item" onclick="logout()">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                Logout <i class="fas fa-arrow-circle-right"></i>
                <!--<span class="badge badge-success navbar-badge">^_^</span>-->
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <!--    <ul class="navbar-nav ml-auto">
           Messages Dropdown Menu
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-comments"></i>
              <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <a href="#" class="dropdown-item">
                 Message Start
                <div class="media">
                  <img src="../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      Brad Diesel
                      <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">Call me whenever you can...</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                  </div>
                </div>
                 Message End
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                 Message Start
                <div class="media">
                  <img src="../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      John Pierce
                      <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">I got your message bro</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                  </div>
                </div>
                 Message End
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                 Message Start
                <div class="media">
                  <img src="../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      Nora Silvester
                      <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">The subject goes here</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                  </div>
                </div>
                 Message End
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
          </li>
           Notifications Dropdown Menu
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell"></i>
              <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header">15 Notifications</span>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fas fa-envelope mr-2"></i> 4 new messages
                <span class="float-right text-muted text-sm">3 mins</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> 8 friend requests
                <span class="float-right text-muted text-sm">12 hours</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> 3 new reports
                <span class="float-right text-muted text-sm">2 days</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
              <i class="fas fa-th-large"></i>
            </a>
          </li>
        </ul>-->
</nav>


   <div id="open_video" class="modal fade" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
        <div class="modal-content">
           <div class="modal-header bg-primary">
              <h3><i class="fa fa-video fa-fw"></i> <span id="vidTitle">My Video</span></h3>
              <button type="button" class="close" onclick="$('#vidLink').attr('src','')" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
           </div>
           <div class="modal-body no-padding" id="vidBody" style="background:#000">
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe id="vidLink" class="embed-responsive-item" src="" allowfullscreen></iframe>
                </div>
           </div>
        </div>
     </div>
   </div>

   <div id="open_mycalendar" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
        <div class="modal-content">
           <div class="modal-header bg-primary">
             <h3><i class="fa fa-calendar"></i> My Calendar</h3>
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
           </div>
           <div class="modal-body">
             <div class="row">
                <div class="col-md-12">
                    <div id="calendario" ></div>
                </div>
             </div>
             <div class="row">
                <div class="col-md-12 text-center" style="margin-top: 15px;">
                   <span><b>Legend: &nbsp;&nbsp;</b>
                      <span class="badge" style="color: white;background-color:#13cc10;"> School Activities </span>
                     <span class="badge" style="color: white;background-color:#A9A9A9;"> Lessons/Discussions </span>
                     <span class="badge" style="color: white;background-color:#3c8dbc;"> Quizzes </span>
                     <span class="badge" style="color: white;background-color:#f39c12;"> Assignments </span>
                     <span class="badge" style="color: white;background-color:#00c0ef;"> Exercises </span>
                     <span class="badge" style="color: white;background-color:#f56954;"> Major Exams </span>
                  </span>
                </div>
             </div>
           </div>
        </div>
     </div>
   </div>

<script type="text/javascript">

    $(document).ready(function () {
        var date = new Date();
        var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();
        $("#calendario").fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                today: 'today',
                month: 'month',
                week: 'week',
                day: 'day'
            },
            events: '<?php echo base_url("opl/events") ?>'
        });
    });

    function mycal()
    {
        $("#open_mycalendar").modal();

    }

    window.onscroll = function () {
        myFunction()
    };

    var header = document.getElementById("myHeader");
    var sticky = header.offsetTop;

    function readNoti(user_id) {
        $.ajax('<?php echo base_url('notification_system') ?>/readNoti/' + user_id, {
            type: 'GET',
            success: function (data) {
                $('.badge').hide(3000);
                //document.location = '<?php echo base_url('notification_system'); ?>';
            }
        });
    }

    function logout() {
        document.location = '<?php echo base_url() . 'opl/student/logout' ?>';
    }
</script>
