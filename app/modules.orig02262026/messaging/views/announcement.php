<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="margin:0">News and Announcements
        <button class="btn btn-success pull-right" data-toggle="modal" data-target="#createNews">NEW</button>
        </h1>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-green">
                <div class="panel-heading ">
                    <h4>Published</h4>
                </div>
                <div class="panel-body">
                    <div id="published_news">
                        <?php
                            $published = Modules::run('messaging/getAnnouncement', 1);
                            foreach ($published->result() as $published){
                                if($published->ticker_title!=""):
                                    $title = '<strong> '. $published->ticker_title.' </strong> <br> ';
                                else:
                                    $title = "";
                                endif;
                        ?>
                        <div id="pub_<?php echo $published->id ?>">
                            <div style='cursor:pointer; margin-bottom:5px;' class='alert alert-success alert-dismissable span11'>
                                <button title="Unpublish Announcement"  onclick="unpublished('<?php echo $published->id ?>')" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <div class="notify">
                                   <?php echo $title.$published->ticker_msg ; 

                                   ?>
                                </div>    
                            </div>
                        </div>

                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
                        
            
        </div>
        <div class="col-lg-6 pull-right">
            <div class="panel panel-red">
                <div class="panel-heading ">
                    <h4>Unpublished</h4>
                </div>
                <div class="panel-body">
                    <div id="unpublished_news">
                        <?php
                        $unpublished = Modules::run('messaging/getAnnouncement', 0);
                        foreach ($unpublished->result() as $unpublished){
                            if($unpublished->ticker_title!=""):
                                $title = '<strong>'. $unpublished->ticker_title.' </strong> <br>';
                            else:
                                $title = "";
                            endif;
                        ?>
                        <div id="unpub_<?php echo $unpublished->id ?>" onclick="published('<?php echo $unpublished->id ?>')"> 
                            <div style='cursor:pointer; margin-bottom:5px;' class='alert alert-success alert-dismissable span11'>
                                <button onclick="deleteNews('<?php echo $unpublished->id ?>')" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <div class="notify">
                                   <?php echo $title.$unpublished->ticker_msg ; 

                                   ?>
                                </div>    
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="createNews">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4>Create News</h4>
      </div>
      <div class="modal-body clearfix">
        <?php
                $attributes = array('class' => 'form-horizontal', 'id'=>'addNews');
                echo form_open(base_url().'messaging/saveAnnouncement', $attributes);
         ?>
                <input class="form-control" type="text" name="newsTitle" id="newsDate" placeholder="Short Title" required>
                <br />
                <br />
                <textarea class="form-control"  onkeyup="checkTxtLength($('#counter').html())" style="margin-bottom:10px;" name="txtMsg"  id="txtMsg" rows="5" data-provide="limit" data-counter="#counter" placeholder="Enter Text Here" required></textarea>
                <br />
                <em id="counter" style="">50</em>
                <br />
                <input style="vertical-align: baseline;" type="checkbox" name="activate" id="activate" value="1" >&nbsp;<span style="font-size: 12px;">Publish</span>
         <?php echo form_close(); ?>
                    
                <button onclick="addNews()" class="btn btn-info pull-right" style="margin-top:10px;">Save</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="hide" >
    <div style="margin:30px auto; width:300px; border-radius: 5px; background: #fff; height:320px; padding:10px;">
        <div class="pull-left" style="border-bottom: 1px solid gray; width:100%; margin-bottom: 10px;">
            
        </div>
         
    </div>
    
</div>


<script type="text/javascript">
    function checkTxtLength(val)
    {
        if(val==0){
            alert('sorry!')
        }
    }
    
    function showCreateNews()
    {
        
        $('#secretContainer').html($('#createNews').html());
        $('#secretContainer').removeClass('hide');
        $('#createNews').show();
    }
    
    function unpublished(id)
    {
        var url = "<?php echo base_url().'messaging/updateAnnouncement/'?>"; // the script where you handle the form input.
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "id="+id+"&status=0"+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       location.reload()
                   }
                 });

            return false;  
    }
    
    function addNews()
    {
        var url = "<?php echo base_url().'messaging/saveAnnouncement/'?>"; // the script where you handle the form input.
             $.ajax({
                   type: "POST",
                   url: url,
                   data: $('#addNews').serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   //dataType:'json',
                   success: function(data)
                   {
                      alert('Successfully Saved!');
                      location.reload();
                   }
                 });

            return false;  
    }
    
    function published(id)
    {
        var url = "<?php echo base_url().'messaging/updateAnnouncement/'?>"; // the script where you handle the form input.
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "id="+id+"&status=1"+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   dataType:'json',
                   success: function(data)
                   {
                      if(data.status)
                      {
                          alert(data.msg);
                          location.reload()
                      }else{
                          alert(data.msg);
                      }
                   }
                 });

            return false;  
    }
    
    function deleteNews(id)
    {
        var url = "<?php echo base_url().'messaging/deleteAnnouncement/'?>"; // the script where you handle the form input.
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "id="+id+"&status=1"+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                      location.reload()
                   }
                 });

            return false;  
    }
    
</script>
<script src="<?php echo base_url('assets/js/plugins/bootstrap-limit.js'); ?>"></script>
