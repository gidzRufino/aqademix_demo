<?php
echo doctype('html5');
echo header("Content-Type: text/html; charset=UTF-8");
echo '<head>';   
?>
    <title>[ e-sKwela ]</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<?php
    echo link_tag('assets/css/bootstrap.min.css');
    echo link_tag('assets/css/sb-admin-2.css');
    echo link_tag('assets/css/plugins/morris.css');
    echo link_tag('assets/css/plugins/select2.css');
    echo link_tag('assets/font-awesome-4.2.0/css/font-awesome.min.css');
    echo link_tag('assets/css/plugins/datepicker.css');

?>
   <script src="<?php echo base_url('assets/js/jquery-1.11.0.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-datepicker.js'); ?>"></script>
</head>
<body style="background: #000">
<style scoped>
    body{
        background: url('<?php echo base_url("images/css.png") ?>') no-repeat 0 center fixed #004160 !important;
        -webkit-background-size: cover !important;
        -moz-background-size: cover !important;
        -o-background-size: cover !important;
        background-size: cover !important;
    }
     
</style> 
<div style="margin:100px auto 0; width:600px;">
    <div class="panel panel-warning">
        <div class="panel-heading">
            <span class="panel-header">Install Eskwela</span>
        </div>
        <div class="panel-body">
            <div id="dbWrapper">
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input class="form-control" id="username"  placeholder="username" type="text">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <input class="form-control"  id="password" placeholder="password" type="password" >
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-database"></i></span>
                    <input class="form-control"  id="dbName" placeholder="DB Name" type="text" >
                </div>
            </div>
            <div id="schoolWrapper" style="display:none;">
                <h6>School Details</h6>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-university"></i></span>
                    <input class="form-control" id="school_id"  placeholder="ID Number of School" type="text">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-university"></i></span>
                    <input class="form-control" id="set_school_name"  placeholder="Name of School" type="text">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                    <input class="form-control" id="short_name"  placeholder="Short Name" type="text">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input class="form-control" id="set_school_address"  placeholder="Address of School" type="text">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-adjust"></i></span>
                    <input class="form-control" id="region"  placeholder="Region" type="text">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-university"></i></span>
                    <input class="form-control" id="division"  placeholder="Division" type="text">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-university"></i></span>
                    <input class="form-control" id="district"  placeholder="District" type="text">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input class="form-control" id="division_address"  placeholder="Address of Division" type="text">
                </div>
                
            </div>
        </div>
        <div class="clearfix panel-footer">
            <button class="btn btn-primary btn-sm pull-right" id="btnNext" onclick="checkDB()">NEXT</button>
            <button class="btn btn-success btn-sm pull-right" id="btnSave" style="display: none;" onclick="saveInfo()">SAVE</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    function checkDB()
    {
        var name = $('#username').val();
        var pass = $('#password').val();
        var dbName = $('#dbName').val();

        var url = "<?php echo base_url().'install/checkDB/'?>";
        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data: 'name='+name+"&pass="+pass+"&dbName="+dbName+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data)
            {   
                    alert(data.msg);
                    if(data.status)
                    {
                        $('#dbWrapper').hide(500);
                        $('#schoolWrapper').show();
                        $('#btnNext').hide();
                        $('#btnSave').show();
                    }
            }
        });
    }
    
    function saveInfo()
    {
        var name = $('#username').val();
        var pass = $('#password').val();
        var dbName = $('#dbName').val();

        var data = []
        $('#schoolWrapper input').each(function(){
            var id = {
                    'id':this.id,
                    'value': this.value,
                }
            data.push(id);
        });
       
        
        var url = "<?php echo base_url().'install/saveInfo/'?>";
        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data: 'data='+JSON.stringify(data)+'&name='+name+"&pass="+pass+"&dbName="+dbName+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data)
            {   
                   alert(data)
            }
        });
    }
</script>    

<script src="<?php echo base_url(); ?>assets/js/attendanceRequest.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/select2.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/bootstrap.clickover.js"></script> 
 <!--Cookie Javascript-->
<script src="<?php echo base_url('assets/js/plugins/jquery.cookie.js'); ?>"></script> 
</body>
</html>