
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content=""> 

        <title><?php echo $title; ?></title>

        <!--     Fonts and icons     -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

        <!-- CSS Files -->
        <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" />
        <link href="<?php echo base_url('assets/css/material-kit.css?v=1.2.1'); ?>" rel="stylesheet"/>

        


    </head>



<body class="index-page " style="background-color: white">

    <div class="container ">
        <div class="card"  style="background-color: whitesmoke">
            <form class="navbar-form navbar-left" role="search" >
                <div class="form-group">                             
                    <input type="text" class="form-control" placeholder="Search Student Name...">
                </div>
                <button type="submit" class="btn btn-white btn-raised btn-fab btn-fab-mini"><i class="material-icons" >search</i></button>
            </form>
            <div style="margin-top: 30px; margin-left: 50px;">
                <button class="btn btn-facebook btn-round btn-sm" data-toggle="modal" data-target="#register">Add New Student</button>
            </div>


            <div class="col-md-2 col-md-offset-2">           
                <div class="row">

                    <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-signup">
                            <div class="modal-content">
                                <div class="card card-signup card-plain">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                                        <nav class="navbar " style="background-color: #01579b;">
                                            <h2 class="modal-title card-title text-center" id="myModalLabel" ><font color="white">Add New Student</font></h2>
                                        </nav>
                                    </div>


                                    <div class="">
                                        <form action="/action_page.php">
                                            <span class="title" style="margin-left: 30px;">Name:</span> 
                                            <span> 
                                                <input type="text" name="" value="">
                                            </span>
                                            <span class="title" style="margin-left: 295px;">Gender:</span>
                                            <span> 
                                                <input type="text" name="" value="">
                                            </span>
                                            <br><br>

                                            <span class="title" style="margin-left: 30px;">Date of Birth:</span>
                                            <span > 
                                                <input type="date" value="10/10/2016" style="width: 160px;">
                                            </span>
                                            <span class="title" style="margin-left: 220px;">Place of Birth:</span>
                                            <span> 
                                                <input type="text" name="" value="">
                                            </span>
                                            <br><br>

                                            <span class="title" style="margin-left: 30px;">Home Address:</span>
                                            <span > 
                                                <input type="text" name="" value="">
                                            </span>
                                            <span class="title" style="margin-left: 176px;">Parent/Guardian:</span>
                                            <span> 
                                                <input type="text" name="" value="">
                                            </span>
                                            <br><br>

                                            <span class="title" style="margin-left: 30px;">Intermediate Course Completed:</span>
                                            <span > 
                                                <input type="text" name="" value="">
                                            </span>
                                            <span class="title" style="margin-left: 95px;">School Year:</span>
                                            <span> 
                                                <input type="text" name="" value="">
                                            </span>
                                            <br><br>

                                            <span class="title" style="margin-left: 30px;">Secondary Course Completed:</span>
                                            <span > 
                                                <input type="text" name="" value="">
                                            </span>
                                            <span class="title" style="margin-left: 110px;">School Year:</span>
                                            <span> 
                                                <input type="text" name="" value="">
                                            </span>
                                            <br><br>

                                            <span class="title" style="margin-left: 30px;">Basis of Admission:</span>
                                            <span > 
                                                <input type="text" name="" value="">
                                            </span>
                                            <span class="title" style="margin-left: 215px;">ID No.:</span>
                                            <span> 
                                                <input type="text" name="" value="">
                                            </span>
                                            <br><br>

                                            <span class="title" style="margin-left: 30px;">Degree/Program:</span>
                                            <span > 
                                                <input type="text" name="" value="">
                                            </span>
                                            <span class="title" style="margin-left: 235px;">Major:</span>
                                            <span> 
                                                <input type="text" name="" value="">
                                            </span>                             
                                            <br><br>

                                            <span class="title" style="margin-left: 30px;">Date of Graduation:</span>
                                            <span > 
                                                <input type="text" name="" value="">
                                            </span>
                                            <br><br>

                                        </form> 
                                        <div style="margin-left: 700px;">
                                            <button class="btn btn-facebook  " data-toggle="modal" data-target="#register">Save</button>
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




<!--   Core JS Files   -->
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/material.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/material-kit.js?v=1.2.1'); ?>"type="text/javascript"></script>


</body>

</html>
