<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header clearfix" style="margin:0">New Database Installation</h1>
    </div>

    <div class="col-lg-12">
        <div class="col-lg-10 clearfix" style="margin:0 auto; float: none">
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
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input class="form-control"  id="school_year" placeholder="School Year" type="text" >
                        </div>
                    </div>
                    <div id="resultWrapper">
                        
                    </div>
                </div>
                <div id="footerWrapper" class="clearfix panel-footer">
                    <button class="btn btn-primary btn-sm pull-right" id="btnNext" onclick="createDB()">GO</button>
                </div>
            </div>
        </div>
        
    </div>
    
</div> 
        

<script type="text/javascript">
    
    var name = $('#username').val();
    var pass = $('#password').val();
    var year = $('#school_year').val();
    
    function createDB()
    {
        
        var url = "<?php echo base_url().'install/create_database/'?>";
        $.ajax({
            type: "POST",
            url: url,
            beforeSend: function() { 
                $('#footerWrapper').html('<div class="alert alert-info">Creating Database...<span id="createDB">Please Wait...</span></div>')
            },
            data: 'name='+name+"&pass="+pass+"&year="+year+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data)
            {   
                $('#createDB').html('Done!');
                $('#footerWrapper').append('<div class="alert alert-success">Database Created</div>');
                createTables();
            }
        });
    }
    
    function createTables()
    {
        var url = "<?php echo base_url().'install/createTables/'?>";
        $.ajax({
            type: "POST",
            url: url,
            beforeSend: function() { 
                $('#footerWrapper').append('<div class="alert alert-info">Generating Tables...<span id="createDB">Please Wait...</span></div>')
            },
            data: 'name='+name+"&pass="+pass+"&year="+year+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data)
            {   
                $('#footerWrapper').html('<div class="alert alert-success">Database Created</div>');
            }
        });
    }
    
    
</script>   
        
