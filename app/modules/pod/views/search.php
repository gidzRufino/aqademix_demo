<style type="text/css">
   .vertical{  
      margin-top:50%;
   }
</style>
<div class="row">
   <div class="col-lg-12 page-header">
      <div class="col-md-7">
         <h1 class="clearfix" style="margin:0">Prefect of Discipline</h1>
      </div>
      <div class="col-md-3 pull-right">
         <button onclick="#" id="get_employee()" class="btn btn-info pull-right" style="margin-right: 10px; margin-top:5px;">Employee</button>
         <button onclick="#" id="get_students()" class="btn btn-info pull-right" style="margin-right: 10px; margin-top:5px;" disabled>Students</button>
      </div>
   </div>   
</div>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <div class="row">
               <div class="col-md-8">
                  <div class="input-group">
                     <!-- <input type="text" class="form-control"> -->
                     <input onkeyup="search(this.value)" id="searchBox" class="form-control" type="text" placeholder="Search Name Here" />
                    <div onblur="$(this).hide()" style="min-height: 30px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none" class="resultOverflow" id="searchName">
                    </div>
                     <div class="input-group-btn">
                        <button type="button" class="btn btn-default"><i class="fa fa-search"></i> Search Student</button>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <h4><a href="" class="pull-right" style="margin: 0 20px 0 20px;">Settings</a></h4>
                  <h4><a href="<?php echo base_url('pod/all_time') ?>" class="pull-right" style="margin: 0 20px 0 20px;">All Time Record</a></h4>
                  <h4><a href="<?php echo base_url('pod/dashboard') ?>" class="pull-right" style="margin: 0 20px 0 20px;">Dashboard</a></h4>      
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php 
   $uri = $this->uri->segment(3);
   if ($uri) { // check if id was detected
      $sy = $this->session->userdata('school_year');
      $dnow = date('Y-m-d');
      foreach ($quarter as $q) {
         if ($q->school_year==$sy) {
            if ($dnow>=$q->from_date&&$dnow<=$q->to_date) {
               $quarter_now = $q->quarter;
            }
         switch ($q->quarter) {
            case 'First Quarter':
               $qf1 = $q->from_date;
               $qt1 = $q->to_date;
               break;
            case 'Second Quarter':
               $qf2 = $q->from_date;
               $qt2 = $q->to_date;
               break;
            case 'Third Quarter':
               $qf3 = $q->from_date;
               $qt3 = $q->to_date;
               break;
            case 'Fourth Quarter':
               $qf4 = $q->from_date;
               $qt4 = $q->to_date;
               break;
            }
         }
      }
?>

<div class="row"> <!-- this whole row will be hidden if this->segment->uri(3) is blank -->
   <div class="col-lg-8">
      <div class="panel panel-primary">
         <div class="panel-heading">
            <b>Account Basic Information</b>
            <b class="pull-right"><i class="fa fa-star"></i></b>
         </div>
         <div class="panel-body">
            <div class="row">
               <div class="col-md-1"></div>
               <div class="col-md-2">
                  <img class="img-circle img-responsive" style="width:150px; border:5px solid #F5F5F5" src="<?php if($profile->avatar!=""):echo base_url().'uploads/'.$profile->avatar;else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
                  <!-- <img class="img-circle img-responsive" style="width:150px; border:5px solid #F5F5F5" src="<?php echo base_url().'uploads/31377.png'?>"> -->
               </div>
               <div class="col-md-8">
                  <h2 style="margin:3px 0;">
                     <span id="name" style="color:#BB0000;"><?php echo $profile->lastname.', '.$profile->firstname ?></span>
                  </h2>
                     <h4 style="color:black; margin:3px 0;"><?php echo $profile->level ?> - <span id="a_section"><?php echo $profile->section ?></span>
                  </h4>
                  <h3 style="color:black; margin:3px 0;">
                     <small>
                        <a id="a_user_id"  style="color:#BB0000;">
                        <?php echo $profile->st_id ?>
                        <input type="hidden" id="st_id" name="st_id" value="<?php echo base64_encode($profile->st_id) ?>" />
                        <input type="hidden" id="grade_id" name="grade_id" value="<?php echo base64_encode($profile->grade_level_id) ?>" />
                        </a>
                     </small>
                  </h3>
                  <h4 style="color:black; margin:3px 0;">
                     <small>
                        <a title="double click to edit" id="a_user_id"  style="color:black;">
                        <b>Adviser: <span style="color:#BB0000;"><?php echo $adviser->lastname.', '.$adviser->firstname ?></span></b>
                        </a>
                     </small>
                  </h4>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="panel panel-primary" style="margin-top: 10px;">
                     <div class="panel-heading">
                        <b> Tardy Record
                           <!-- <button class="btn pull-right btn-default btn-sm">Manual Input</button> -->
                        </b>
                        <button onclick="$('#manual_mod').modal()" class="btn btn-warning btn-sm pull-right" style="margin-top:-5px;"><b><i class="fa fa-pencil"></i> Manual Input</b></button>
                     </div>
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-12">
                              <ul class="nav nav-pills nav-justified">
                                 <li role="presentation"  data-toggle="tab" data-target="#all" class="active"><a href="#all">All</a></li>
                                 <li role="presentation"  data-toggle="tab" data-target="#first"><a href="#first">First Quarter</a></li>
                                 <li role="presentation" data-toggle="tab" data-target="#second"><a href="#second">Second Quarter</a></li>
                                 <li role="presentation" data-toggle="tab" data-target="#third"><a href="#third">Third Quarter</a></li>
                                 <li role="presentation" data-toggle="tab" data-target="#fourth"><a href="#fourth">Fourth Quarter</a></li>
                              </ul>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                              <div class="tab-content" style="padding-top: 10px;">
                                 <div class="tab-pane active" id="all">
                                    <table id="student_table" class="table table-bordered table-sm tablesorter">
                                       <thead>
                                          <tr>
                                             <th class="text-center">Date</th>
                                             <th class="text-center">Time</th>
                                             <!-- <th class="text-center">Excess Minutes</th> -->
                                             <th class="text-center">Remarks</th>
                                             <th class="text-center">Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          
                                          <?php 
                                             $ycounts = 0; $icounts = 0;   
                                             foreach ($tardies as $tar) {
                                                $icounts++;
                                                if ($tar->l_status<3) {
                                                   $ycounts = $ycounts + 1;
                                                }elseif ($tar->l_status==5) {
                                                   $ycounts = $ycounts + 0.5;
                                                }
                                                switch ($tar->l_status) {
                                                   case '1':
                                                      $bg = 'bg-success';
                                                      break;
                                                   case '2':
                                                      $bg = 'bg-danger';
                                                      break;
                                                   case '3':
                                                      $bg = 'active';
                                                      break;
                                                   case '4':
                                                      $bg = 'bg-warning';
                                                      break;
                                                   case '5':
                                                      $bg = 'bg-default';
                                                      break;
                                                   default:
                                                      $bg = 'bg-info';
                                                      break;
                                                }
                                                switch ($ycounts) {
                                                   case '3':
                                                      $tcomment = '[action needed: Verbal Warning] ';
                                                      break;
                                                   case '5':
                                                      $tcomment = '[action needed: Conference with parents] ';
                                                      break;
                                                   case '7':
                                                      $tcomment = '[action needed: Community Service] ';
                                                      break;
                                                   case '9':
                                                      $tcomment = '[action needed: Formative Suspension] ';
                                                      break;
                                                   default:
                                                      $tcomment = "";
                                                      break;
                                                }
                                          ?>

                                          <tr class="<?php echo $bg ?>">
                                             <td class="text-center"><?php echo $tar->l_date ?></td>
                                             <td class="text-center"><?php echo $tar->l_actual_time_in ?></td>
                                             <td class="text-center"><?php echo $tar->l_remarks ?></td>
                                             <td class="text-center"><button type="button" class="btn btn-info btn-sm" id="rem<?php echo $tar->l_id ?>" onclick="add_remarks(this.id)" style="text-align:center; margin-right: 5px;"><i class="fa fa-pencil"></i></button>
                                                <input type="hidden" id="iru<?php echo $tar->l_id ?>" name="iru<?php echo $tar->l_id ?>" value="<?php echo $tar->l_remarks ?>" />
                                             </td>
                                          </tr>

                                          <?php } 
                                          
                                          ?>

                                       </tbody>
                                    </table>
                                    
                                 </div> <!-- #all -->

                                 <div class="tab-pane" id="first">
                                    <table id="student_table" class="table table-bordered table-sm tablesorter">
                                       <thead>
                                          <tr>
                                             <th class="text-center">Date</th>
                                             <th class="text-center">Time</th>
                                             <th class="text-center">Remarks</th>
                                             <th class="text-center">Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          
                                          <?php 
                                             $tcounts1 = 0;    
                                             foreach ($tardies as $tar) {
                                                $tdate = $tar->l_date;
                                                if ($tdate>=$qf1&&$tdate<=$qt1) {  // first quarter coverage
                                                   if ($tar->l_status<3) {
                                                      $tcounts1 = $tcounts1 + 1;
                                                   }elseif ($tar->l_status==5) {
                                                      $tcounts1 = $tcounts1 + 0.5;
                                                   }
                                                   switch ($tar->l_status) {
                                                      case '1':
                                                         $bg = 'bg-success';
                                                         break;
                                                      case '2':
                                                         $bg = 'bg-danger';
                                                         break;
                                                      case '3':
                                                         $bg = 'active';
                                                         break;
                                                      case '4':
                                                         $bg = 'bg-warning';
                                                         break;
                                                      case '5':
                                                         $bg = 'bg-default';
                                                         break;
                                                      default:
                                                         $bg = 'bg-info';
                                                         break;
                                                   }
                                                   switch ($tcounts1) {
                                                      case '3':
                                                         $tcomment = '[action needed: Verbal Warning] ';
                                                         break;
                                                      case '5':
                                                         $tcomment = '[action needed: Conference with parents] ';
                                                         break;
                                                      case '7':
                                                         $tcomment = '[action needed: Community Service] ';
                                                         break;
                                                      case '9':
                                                         $tcomment = '[action needed: Formative Suspension] ';
                                                         break;
                                                      default:
                                                         $tcomment = "";
                                                         break;
                                                   }
                                          ?>

                                          <tr class="<?php echo $bg ?>">
                                             <td class="text-center"><?php echo $tar->l_date ?></td>
                                             <td class="text-center"><?php echo $tar->l_actual_time_in ?></td>
                                             <td class="text-center"><span style="color:red;"><?php echo $tcomment?></span> <?php echo $tar->l_remarks ?></td>
                                             <td class="text-center"><button type="button" class="btn btn-info btn-sm" id="rem<?php echo $tar->l_id ?>" onclick="add_remarks(this.id)" style="text-align:center; margin-right: 5px;"><i class="fa fa-pencil"></i></button>
                                                <input type="hidden" id="iru<?php echo $tar->l_id ?>" name="iru<?php echo $tar->l_id ?>" value="<?php echo $tar->l_remarks ?>" />
                                             </td>
                                          </tr>

                                          <?php }}

                                          switch (true) {
                                             case $tcounts1 < 3:
                                                $bar = 'progress-bar-success';
                                                $msg = 'Safe Zone ('.$tcounts1.')';
                                                break;
                                             case $tcounts1 < 5:
                                                $bar = 'progress-bar-info';
                                                $msg = 'Verbal Warning ('.$tcounts1.')';
                                                break;
                                             case $tcounts1 < 7:
                                                $bar = 'progress-bar-warning';
                                                $msg = 'Conference with parents ('.$tcounts1.')';
                                                break;
                                             case $tcounts1 < 9:
                                                $bar = 'progress-bar-danger';
                                                $msg = 'Community Service ('.$tcounts1.')';
                                                break;
                                             case $tcounts1 >= 9:
                                                $bar = 'progress-bar-active';
                                                $msg = 'Formative Suspension ('.$tcounts1.')';
                                                break;
                                             default:
                                                # code...
                                                break;
                                          }
                                          
                                          if ($tcounts1<=10) {
                                           $wide = $tcounts1*10;
                                          }elseif ($tcounts1>10) {
                                             $wide = 100;
                                          }
                                          $width = 'width:'.$wide.'%';

                                          ?>

                                       </tbody>
                                    </table>
                                    <div class="progress">
                                       <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%">
                                       Safe Zone
                                       </div>
                                       <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                          Verbal Warning
                                       </div>
                                       <div class="progress-bar progress-bar-warning role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                          Conference w/ Parents
                                       </div>
                                       <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                          Community Service
                                       </div>
                                       <div class="progress-bar progress-bar-active" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:10%">
                                          Suspension
                                       </div>
                                    </div>
                                    <div class="progress" style="margin-top: -15px;">
                                       <div class="progress-bar <?php echo $bar ?> progress-bar-striped active" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="<?php echo $width ?>">
                                          <b style="font-size: 14px;"><?php echo $msg ?></b>
                                       </div>
                                    </div>

                                 </div> <!-- #first -->
                                 
                                 <div class="tab-pane" id="second">
                                    <table id="student_table" class="table table-bordered table-sm tablesorter">
                                       <thead>
                                          <tr>
                                             <th class="text-center">Date</th>
                                             <th class="text-center">Time</th>
                                             <th class="text-center">Remarks</th>
                                             <th class="text-center">Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          
                                          <?php 
                                             $tcounts2 = 0;
                                             foreach ($tardies as $tar) {
                                                $tdate = $tar->l_date;
                                                if ($tdate>=$qf2&&$tdate<=$qt2) {  // Second Quarter coverage
                                                   
                                                   if ($tar->l_status<3) {
                                                      $tcounts2 = $tcounts2 + 1;
                                                   }elseif ($tar->l_status==5) {
                                                      $tcounts2 = $tcounts2 + 0.5;
                                                   }
                                                   switch ($tar->l_status) {
                                                      case '1':
                                                         $bg = 'bg-success';
                                                         break;
                                                      case '2':
                                                         $bg = 'bg-danger';
                                                         break;
                                                      case '3':
                                                         $bg = 'active';
                                                         break;
                                                      case '4':
                                                         $bg = 'bg-warning';
                                                         break;
                                                      case '5':
                                                         $bg = 'bg-default';
                                                         break;
                                                      default:
                                                         $bg = 'bg-info';
                                                         break;
                                                   }
                                                   switch ($tcounts2) {
                                                      case '3':
                                                         $tcomment = '[action needed: Verbal Warning] ';
                                                         break;
                                                      case '5':
                                                         $tcomment = '[action needed: Conference with parents] ';
                                                         break;
                                                      case '7':
                                                         $tcomment = '[action needed: Community Service] ';
                                                         break;
                                                      case '9':
                                                         $tcomment = '[action needed: Formative Suspension] ';
                                                         break;
                                                      default:
                                                         $tcomment = "";
                                                         break;
                                                   }
                                          ?>

                                          <tr class="<?php echo $bg ?>">
                                             <td class="text-center"><?php echo $tar->l_date ?></td>
                                             <td class="text-center"><?php echo $tar->l_actual_time_in ?></td>
                                             <td class="text-center"><span style="color:red;"><?php echo $tcomment?></span> <?php echo $tar->l_remarks ?></td>
                                             <td class="text-center"><button type="button" class="btn btn-info btn-sm" id="rem<?php echo $tar->l_id ?>" onclick="add_remarks(this.id)" style="text-align:center; margin-right: 5px;"><i class="fa fa-pencil"></i></button>
                                                <input type="hidden" id="iru<?php echo $tar->l_id ?>" name="iru<?php echo $tar->l_id ?>" value="<?php echo $tar->l_remarks ?>" />
                                             </td>
                                          </tr>

                                          <?php }}

                                          switch (true) {
                                             case $tcounts2 < 3:
                                                $bar = 'progress-bar-success';
                                                $msg = 'Safe Zone ('.$tcounts2.')';
                                                break;
                                             case $tcounts2 < 5:
                                                $bar = 'progress-bar-info';
                                                $msg = 'Verbal Warning ('.$tcounts2.')';
                                                break;
                                             case $tcounts2 < 7:
                                                $bar = 'progress-bar-warning';
                                                $msg = 'Conference with parents ('.$tcounts2.')';
                                                break;
                                             case $tcounts2 < 9:
                                                $bar = 'progress-bar-danger';
                                                $msg = 'Community Service ('.$tcounts2.')';
                                                break;
                                             case $tcounts2 >= 9:
                                                $bar = 'progress-bar-active';
                                                $msg = 'Formative Suspension ('.$tcounts2.')';
                                                break;
                                             default:
                                                # code...
                                                break;
                                          }
                                          
                                          if ($tcounts2<=10) {
                                           $wide = $tcounts2*10;
                                          }elseif ($tcounts2>10) {
                                             $wide = 100;
                                          }
                                          $width = 'width:'.$wide.'%';

                                          ?>

                                       </tbody>
                                    </table>
                                    <div class="progress">
                                       <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%">
                                       Safe Zone
                                       </div>
                                       <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                          Verbal Warning
                                       </div>
                                       <div class="progress-bar progress-bar-warning role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                          Conference w/ Parents
                                       </div>
                                       <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                          Community Service
                                       </div>
                                       <div class="progress-bar progress-bar-active" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:10%">
                                          Suspension
                                       </div>
                                    </div>
                                    <div class="progress" style="margin-top: -15px;">
                                       <div class="progress-bar <?php echo $bar ?> progress-bar-striped active" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="<?php echo $width ?>">
                                          <b style="font-size: 14px;"><?php echo $msg ?></b>
                                       </div>
                                    </div>

                                 </div> <!-- #second -->
                                 <div class="tab-pane" id="third">
                                    <table id="student_table" class="table table-bordered table-sm tablesorter">
                                       <thead>
                                          <tr>
                                             <th class="text-center">Date</th>
                                             <th class="text-center">Time</th>
                                             <th class="text-center">Remarks</th>
                                             <th class="text-center">Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          
                                          <?php 
                                             $tcounts3 = 0; 
                                             foreach ($tardies as $tar) {
                                                $tdate = $tar->l_date;
                                                if ($tdate>=$qf3&&$tdate<=$qt3) {  // Third Quarter coverage
                                                   
                                                   if ($tar->l_status<3) {
                                                      $tcounts3 = $tcounts3 + 1;
                                                   }elseif ($tar->l_status==5) {
                                                      $tcounts3 = $tcounts3 + 0.5;
                                                   }
                                                   switch ($tar->l_status) {
                                                      case '1':
                                                         $bg = 'bg-success';
                                                         break;
                                                      case '2':
                                                         $bg = 'bg-danger';
                                                         break;
                                                      case '3':
                                                         $bg = 'active';
                                                         break;
                                                      case '4':
                                                         $bg = 'bg-warning';
                                                         break;
                                                      case '5':
                                                         $bg = 'bg-default';
                                                         break;
                                                      default:
                                                         $bg = 'bg-info';
                                                         break;
                                                   }
                                                   switch ($tcounts3) {
                                                      case '3':
                                                         $tcomment = '[action needed: Verbal Warning] ';
                                                         break;
                                                      case '5':
                                                         $tcomment = '[action needed: Conference with parents] ';
                                                         break;
                                                      case '7':
                                                         $tcomment = '[action needed: Community Service] ';
                                                         break;
                                                      case '9':
                                                         $tcomment = '[action needed: Formative Suspension] ';
                                                         break;
                                                      default:
                                                         $tcomment = "";
                                                         break;
                                                   }
                                          ?>

                                          <tr class="<?php echo $bg ?>">
                                             <td class="text-center"><?php echo $tar->l_date ?></td>
                                             <td class="text-center"><?php echo $tar->l_actual_time_in ?></td>
                                             <td class="text-center"><span style="color:red;"><?php echo $tcomment?></span> <?php echo $tar->l_remarks ?></td>
                                             <td class="text-center"><button type="button" class="btn btn-info btn-sm" id="rem<?php echo $tar->l_id ?>" onclick="add_remarks(this.id)" style="text-align:center; margin-right: 5px;"><i class="fa fa-pencil"></i></button>
                                                <input type="hidden" id="iru<?php echo $tar->l_id ?>" name="iru<?php echo $tar->l_id ?>" value="<?php echo $tar->l_remarks ?>" />
                                             </td>
                                          </tr>

                                          <?php }}

                                          switch (true) {
                                             case $tcounts3 < 3:
                                                $bar = 'progress-bar-success';
                                                $msg = 'Safe Zone ('.$tcounts3.')';
                                                break;
                                             case $tcounts3 < 5:
                                                $bar = 'progress-bar-info';
                                                $msg = 'Verbal Warning ('.$tcounts3.')';
                                                break;
                                             case $tcounts3 < 7:
                                                $bar = 'progress-bar-warning';
                                                $msg = 'Conference with parents ('.$tcounts3.')';
                                                break;
                                             case $tcounts3 < 9:
                                                $bar = 'progress-bar-danger';
                                                $msg = 'Community Service ('.$tcounts3.')';
                                                break;
                                             case $tcounts3 >= 9:
                                                $bar = 'progress-bar-active';
                                                $msg = 'Formative Suspension ('.$tcounts3.')';
                                                break;
                                             default:
                                                # code...
                                                break;
                                          }
                                          
                                          if ($tcounts3<=10) {
                                           $wide = $tcounts3*10;
                                          }elseif ($tcounts3>10) {
                                             $wide = 100;
                                          }
                                          $width = 'width:'.$wide.'%';

                                          ?>

                                       </tbody>
                                    </table>
                                    <div class="progress">
                                       <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%">
                                       Safe Zone
                                       </div>
                                       <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                          Verbal Warning
                                       </div>
                                       <div class="progress-bar progress-bar-warning role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                          Conference w/ Parents
                                       </div>
                                       <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                          Community Service
                                       </div>
                                       <div class="progress-bar progress-bar-active" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:10%">
                                          Suspension
                                       </div>
                                    </div>
                                    <div class="progress" style="margin-top: -15px;">
                                       <div class="progress-bar <?php echo $bar ?> progress-bar-striped active" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="<?php echo $width ?>">
                                          <b style="font-size: 14px;"><?php echo $msg ?></b>
                                       </div>
                                    </div>
                                 </div> <!-- #third -->
                                 <div class="tab-pane" id="fourth">
                                    <table id="student_table" class="table table-bordered table-sm tablesorter">
                                       <thead>
                                          <tr>
                                             <th class="text-center">Date</th>
                                             <th class="text-center">Time</th>
                                             <th class="text-center">Remarks</th>
                                             <th class="text-center">Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          
                                          <?php 
                                             $tcounts4 = 0;  
                                             foreach ($tardies as $tar) {
                                                $tdate = $tar->l_date;
                                                if ($tdate>=$qf4&&$tdate<=$qt4) {  // Fourth Quarter coverage
                                                   
                                                   if ($tar->l_status<3) {
                                                      $tcounts4 = $tcounts4 + 1;
                                                   }elseif ($tar->l_status==5) {
                                                      $tcounts4 = $tcounts4 + 0.5;
                                                   }
                                                   switch ($tar->l_status) {
                                                      case '1':
                                                         $bg = 'bg-success';
                                                         break;
                                                      case '2':
                                                         $bg = 'bg-danger';
                                                         break;
                                                      case '3':
                                                         $bg = 'active';
                                                         break;
                                                      case '4':
                                                         $bg = 'bg-warning';
                                                         break;
                                                      case '5':
                                                         $bg = 'bg-default';
                                                         break;
                                                      default:
                                                         $bg = 'bg-info';
                                                         break;
                                                   }
                                                   switch ($tcounts4) {
                                                      case '3':
                                                         $tcomment = '[action needed: Verbal Warning] ';
                                                         break;
                                                      case '5':
                                                         $tcomment = '[action needed: Conference with parents] ';
                                                         break;
                                                      case '7':
                                                         $tcomment = '[action needed: Community Service] ';
                                                         break;
                                                      case '9':
                                                         $tcomment = '[action needed: Formative Suspension] ';
                                                         break;
                                                      default:
                                                         $tcomment = "";
                                                         break;
                                                   }
                                          ?>

                                          <tr class="<?php echo $bg ?>">
                                             <td class="text-center"><?php echo $tar->l_date ?></td>
                                             <td class="text-center"><?php echo $tar->l_actual_time_in ?></td>
                                             <td class="text-center"><span style="color:red;"><?php echo $tcomment?></span> <?php echo $tar->l_remarks ?></td>
                                             <td class="text-center"><button type="button" class="btn btn-info btn-sm" id="rem<?php echo $tar->l_id ?>" onclick="add_remarks(this.id)" style="text-align:center; margin-right: 5px;"><i class="fa fa-pencil"></i></button>
                                                <input type="hidden" id="iru<?php echo $tar->l_id ?>" name="iru<?php echo $tar->l_id ?>" value="<?php echo $tar->l_remarks ?>" />
                                             </td>
                                          </tr>

                                          <?php }}

                                          switch (true) {
                                             case $tcounts4 < 3:
                                                $bar = 'progress-bar-success';
                                                $msg = 'Safe Zone ('.$tcounts4.')';
                                                break;
                                             case $tcounts4 < 5:
                                                $bar = 'progress-bar-info';
                                                $msg = 'Verbal Warning ('.$tcounts4.')';
                                                break;
                                             case $tcounts4 < 7:
                                                $bar = 'progress-bar-warning';
                                                $msg = 'Conference with parents ('.$tcounts4.')';
                                                break;
                                             case $tcounts4 < 9:
                                                $bar = 'progress-bar-danger';
                                                $msg = 'Community Service ('.$tcounts4.')';
                                                break;
                                             case $tcounts4 >= 9:
                                                $bar = 'progress-bar-active';
                                                $msg = 'Formative Suspension ('.$tcounts4.')';
                                                break;
                                             default:
                                                # code...
                                                break;
                                          }
                                          
                                          if ($tcounts4<=10) {
                                           $wide = $tcounts4*10;
                                          }elseif ($tcounts4>10) {
                                             $wide = 100;
                                          }
                                          $width = 'width:'.$wide.'%';

                                          ?>

                                       </tbody>
                                    </table>
                                    <div class="progress">
                                       <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%">
                                       Safe Zone
                                       </div>
                                       <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                          Verbal Warning
                                       </div>
                                       <div class="progress-bar progress-bar-warning role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                          Conference w/ Parents
                                       </div>
                                       <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                          Community Service
                                       </div>
                                       <div class="progress-bar progress-bar-active" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="width:10%">
                                          Suspension
                                       </div>
                                    </div>
                                    <div class="progress" style="margin-top: -15px;">
                                       <div class="progress-bar <?php echo $bar ?> progress-bar-striped active" role="progressbar" aria-valuenow="20"
                                          aria-valuemin="0" aria-valuemax="100" style="<?php echo $width ?>">
                                          <b style="font-size: 14px;"><?php echo $msg ?></b>
                                       </div>
                                    </div>
                                 </div> <!-- #fourth -->
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-4">
      <div class="panel panel-primary">
         <div class="panel-heading">
            <div class="input-group">
               <b>Account Summary</b>
            </div>
         </div>
         <div class="panel-body">
            <table id="student_table" class="table table-hover table-bordered talbe-condensed table-sm tablesorter">
               <thead>
                  <tr>
                     <th class="text-center">QTD counts</th>
                     <!-- <th class="text-center">QTD min</th> -->
                     <th class="text-center">YTD counts</th>
                     <th class="text-center">Infractions</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>

                     <?php 
                     switch ($quarter_now) {
                        case 'First Quarter':
                           $tcounts = $tcounts1;
                           break;
                        case 'Second Quarter':
                           $tcounts = $tcounts2;
                           break;
                        case 'Third Quarter':
                           $tcounts = $tcounts3;
                           break;
                        case 'Fourth Quarter':
                           $tcounts = $tcounts4;
                           break;
                        }
                     if ($tcounts<3) {
                        $bg = 'bg-success';
                     }elseif ($tcounts>=3||$tcounts<5) {
                        $bg = 'bg-info';
                     }elseif ($tcounts>=5||$tcounts<7) {
                        $bg = 'bg-warning';
                     }elseif ($tcounts>=7||$tcounts<9) {
                        $bg = 'bg-danger';
                     }elseif ($tcounts>=9) {
                        $bg = 'active';
                     }
                     ?>

                     <td class="text-center <?php echo $bg ?>"><?php echo $tcounts ?></td>
                     <!-- <td class="text-center"></td> -->
                     <td class="text-center"><?php echo $ycounts ?></td>
                     <td class="text-center"><?php echo $icounts ?></td>
                  </tr>
               </tbody>
            </table>
            <table id="student_table" class="table table-hover table-bordered talbe-condensed table-sm tablesorter">
               <thead>
                  <tr>
                     <th rowspan="2" style="padding-bottom: 7%;" class="text-center bg-primary">Quarter</th>
                     <th colspan="2" class="text-center bg-primary">Coverage</th>
                  </tr>
                  <tr>
                     <th class="text-center bg-primary">From</th>
                     <th class="text-center bg-primary">To</th>
                  </tr>
               </thead>
               <tbody>
                  <?php 
                     foreach ($quarter as $qr) {
                  ?>
                  <tr>
                     <td class="text-center bg-info"><?php echo $qr->quarter ?></td>
                     <td class="text-center bg-info"><?php echo $qr->from_date ?></td>
                     <td class="text-center bg-info"><?php echo $qr->to_date ?></td>
                  </tr>
                  <?php
                                       }                  
                  ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

<?php } ?>  <!-- check if uri(3) is not blank -->

<div id="manual_mod" class="modal fade" style="width:30%; margin:10px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="panel panel-danger">
      <div class="panel-heading">
         <h4>Manual Infraction Input <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button></h4> 
            
      </div>
      <div class="panel-body">
         <div class="row">
            <div class="col-md-12">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <select class="select2" id="mir_sel" style="width:100%;">
                        <option>Please Select Action</option>
                        <option value="1">Late (excused)</option>
                        <option value="2">Late (un-excused)</option>
                        <option value="4">Other Infractions</option>
                        <option value="5">Half Day (0.5)</option>
                        <!-- <option value="7">Error (delete this)</option> -->
                     </select>
                  </div> 
                  <div class="panel-body">
                     <div class="bootstrap-timepicker">
                        <div class="form-group">
                           <label>Time</label>
                           <div class="input-group">
                              <input type="text" id="time_pick" class="form-control timepicker">
                              <div class="input-group-addon">
                                 <i class="fa fa-clock-o"></i>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Remarks</label>
                           <textarea class="form-control" id="mir_remarks" rows="3" placeholder="Infraction remarks ..."></textarea>
                     </div>
                  </div>
               </div>   
            </div>
         </div>
      </div>
      <div class="panel-footer">
         <div class="row">
            <button type="button" class="btn btn-success pull-right" onclick="save_manual()" style="text-align:center;margin: 5px 20px 5px 5px;"> Save</button>
            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal" aria-hidden="true" style="text-align:center;margin: 5px;"> Cancel</button>
            <!-- <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">Close</button> -->
         </div>     
      </div>
   </div>
</div>

<div id="addrem" class="modal fade" style="width:30%; margin:10px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="panel panel-green">
      <div class="panel-heading">
         <h4>Infraction Action <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button></h4> 
            
      </div>
      <div class="panel-body">
         <div class="row">
            <div class="col-md-12">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <select class="select2" id="ir_sel" style="width:100%;">
                        <option>Please Select Action</option>
                        <option value="1">Late (excused)</option>
                        <option value="2">Late (un-excused)</option>
                        <option value="3">Error (disregard this)</option>
                        <!-- <option value="4">Other Infractions</option> -->
                        <option value="5">Half Day (0.5)</option>
                     </select>
                  </div> 
                  <div class="panel-body">
                     <div class="form-group">
                        <label>Remarks</label>
                           <textarea class="form-control" id="ir_remarks" rows="3" placeholder="Enter ..."></textarea>
                     </div>
                  </div>
               </div>   
            </div>
         </div>
      </div>
      <div class="panel-footer">
         <div class="row">
            <input type="hidden" id="ir_id" name="ir_id"/>
            <button type="button" class="btn btn-success pull-right" onclick="save_action()" style="text-align:center;margin: 5px 20px 5px 5px;"> Save</button>
            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal" aria-hidden="true" style="text-align:center;margin: 5px;"> Cancel</button>
         </div>     
      </div>
   </div>
</div>

<script type="text/javascript">
   $(document).ready(function() {
      $(".select2").select2();
      $(".tablesorter").tablesorter({debug: true});
      $(".timepicker").timepicker({
      showInputs: false,
      showMeridian: false,
    });
   });

   function save_action()
   {
      var ir_id = document.getElementById("ir_id").value;
      var ir_sel = document.getElementById('ir_sel').value;
      var ir_remarks = document.getElementById('ir_remarks').value;
      if (ir_sel<3) {
         var ir_remarks = '[Tardy] '+ir_remarks;
      }else if(ir_sel==3){
         var ir_remarks = '[Disregarded] '+ir_remarks;
      }else if(ir_sel==5){
         var ir_remarks = '[Half-Day] '+ir_remarks;
      }else{
         var ir_remarks = '[Other Infraction] '+ir_remarks;
      }

      var url = '<?php echo base_url().'pod/save_action' ?>';
      $.ajax({
         type: "POST",
         url: url,
         data: {
            ir_id: ir_id,
            ir_sel: ir_sel,
            ir_remarks: ir_remarks,
            csrf_test_name: $.cookie('csrf_cookie_name')
         }, // serializes the form's elements.
         success: function(data){
            alert("Action updated!");
            location.reload();
         }
      });
      return false;
   }

   function save_manual()
   {
      var st_id = $('#st_id').val();
      var ir_sel = $("#mir_sel").val();
      var ir_remarks = $("#mir_remarks").val();
      var grade_id = $("#grade_id").val();
      var ir_time = $("#time_pick").val();
      if (ir_sel<3) {
         var ir_remarks = '[Tardy] '+ir_remarks;
      }else if(ir_sel==5){
         var ir_remarks = '[Half-Day] '+ir_remarks;
      }else{
         var ir_remarks = '[Other Infraction] '+ir_remarks;
      }
      var url = '<?php echo base_url().'pod/save_manual' ?>';
      $.ajax({
         type: "POST",
         url: url,
         data: {
            st_id: st_id,
            ir_sel: ir_sel,
            grade_id: grade_id,
            ir_time: ir_time,
            ir_remarks: ir_remarks,
            csrf_test_name: $.cookie('csrf_cookie_name')
         }, // serializes the form's elements.
         success: function(data){
            alert("Action updated!");
            location.reload();
         }
      });
   }

   function loadDetails(st_id)
   {
      // alert('the id:'+ st_id);
      document.location = '<?php echo base_url().'pod/search/' ?>'+st_id;
   }

   function search(value)
   {
      var url = '<?php echo base_url().'search/searchStudentAccountsK12/' ?>'+value;
         $.ajax({
            type: "GET",
            url: url,
            data: "id="+value, // serializes the form's elements.
            success: function(data)
            {
                  $('#searchName').show();
                  $('#searchName').html(data);
            }
         });
      return false;
   }

  function add_remarks(id)
  {
   var rid = id.slice(3);
   var riu = 'iru' + rid;
   // alert('Add remarks this button:'+rin);
   
   var rem = document.getElementById(riu).value;
   document.getElementById('ir_id').value = rid;
   document.getElementById('ir_remarks').value = rem;
   // document.getElementById("he2").innerHTML = '<b>Grade: </b>'+ rgrade + '<b>  Section: </b>' + rsec;
   // document.getElementById("he3").innerHTML = '<b>Adviser: </b>'+ ria;
   $("#addrem").modal();
  }

  function act_on(id)
  {
      alert('action is on this button:' + id);
  }

</script>
