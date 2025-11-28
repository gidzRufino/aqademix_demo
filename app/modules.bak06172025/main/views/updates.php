<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header clearfix">Updates
           
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="panel panel-green col-lg-3 no-padding">
        <div class="panel-heading clearfix">
            Initial Updates <a style="color:white;" href="<?php echo base_url().'web_sync/downloadInitialUpdates/' ?>" class="pull-right"><i class="fa fa-download fa-2x pointer"></i> </a> 
        </div>
        <div class="panel-body">
            <button onclick="getInitialUpdates()" class="btn btn-small btn-success">Get Updates</button>
            <div id="updatesBody">
                
            </div>
        </div>
    </div>
    
</div>

<script type="text/javascript">
    
    function getInitialUpdates(updates)
    {
        var url = "<?php echo base_url().'web_sync/getInitialUpdates/'?> "
        
        $.ajax({
               type: "GET",
               url: url,
               dataType:'json',
               beforeSend: function() {
                    showLoading('updatesBody');
                },
               data: 'csrf_test_name='+$.cookie('csrf_cookie_name'),
               success: function(data)
               {
                   $('#updatesBody').html(data.num_of_updates)

                    var update = (data.updates).split(';')
                    var limit = update.length - 1;
                    //console.log(limit)
                    for (var i=0;i<5;i++)
                    {   
                       // console.log(update[i]);
                       if(i>0){
                         sendToWebSample(update[i]);  
                       }
                        
                        //getData(base_url+'web_sync/getData/'+item[i])
                    }
               }
          })    
      }
      
      function sendToWebSample(updates)
        {
//            var web_address = $('#web_address').val()
//            var url = 'http://'+web_address+'/web_sync/sendToWeb/'+updates
            var url = 'http://localhost/projects/e-sKwela.backup/index.php/web_sync/sendToWeb/'
            $.ajax({
                  type: "POST",
                  crossDomain: true,
                  url: url,
                  data: 'status=1&updates='+updates, // serializes the form's elements.
                  dataType: 'json',
                  success: function(data)
                  {
                      if(data.status){
                          console.log(data.id);
                      }else{
                          console.log(data.msg)
                      }
                    

                  }
                });

               return false; 
        }
</script>