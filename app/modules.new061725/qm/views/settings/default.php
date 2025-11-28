<div class="col-lg-12 no-padding">
    <div class="page-header no-margin clearfix">
        <div class="col-lg-5 pull-right" style="margin-top: 5px;">
            <button onclick="document.location='<?php echo base_url('qm') ?>'" class="btn btn-sm btn-default pull-right" >DASHBOARD</button>
        </div>
        <h2 class="no-margin col-lg-7">Questions Bank Settings</h2>
    </div>
</div>
                  <div  style="padding-top: 150px; padding-left: 150px;" >
                <div class="table-responsive col-md-4" " >
                      <div class="panel panel-info">
                          <div class="panel-heading"><h4>List of Quiz Type</h4> </div>
                        <div class="panel-body">
                     <table class="table table-hover ">
                                          <thead>
                                            <tr >
                                              <th scope="col" ><a class="btn btn-xs btn-default" data-toggle="modal" data-target="#addQT"><i class="fa fa-plus"></i></a></th>
                                              
                                            </tr>
                                          </thead>
                                             <?php foreach($QuizType as $quizname): ?>
                                          <tbody>         
                                            <tr>
                                              <td scope="row"><?php echo $quizname->qm_type ?></td>

                                              <td align="right"><button onclick="deleteQT('<?php echo $quizname->qm_type_id ?>')" class="btn btn-danger"><i class="fa fa-remove"></i></button></td>
                                            </tr>    
                                                              
                                          </tbody>
                                            <?php endforeach;?>
                                        </table>
                            </div>
                            </div>
                            <div class="panel panel-success">
                          <div class="panel-heading"><h4>List of Skills</h4> </div>
                        <div class="panel-body">
                                         <table class="table table-hover">
                                          <thead>
                                            <tr>
                                              <th scope="col"><a class="btn btn-xs btn-default" data-toggle="modal" data-target="#addskills"><i class="fa fa-plus"></i></a></th>
                                               
                                            </tr>
                                          </thead>
                                             <?php foreach($skills as $skillsname): ?>
                                          <tbody>         
                                            <tr>
                                              <td scope="row"><?php echo $skillsname->qm_skills?></td>

                                              <td align="right"><button  onclick="deleteSKILL('<?php echo $skillsname->qm_skills_id ?>')" class="btn btn-danger"><i class="fa fa-remove"></i></button></td>
                                               
                                            </tr>    
                                                              
                                          </tbody>
                                            <?php endforeach;?>
                                        </table>
                    </div>
                    </div>
                </div>
                <div class="table-responsive col-md-4">
                     <div class="panel panel-primary">
                          <div class="panel-heading"><h4>Manage user Access level</h4></div>
                        <div class="panel-body">
                           
                                      <table class="table table-hover" id="tbl1">
                                          <thead>
                                            <tr>
                                                <th>user ID Number</th>
                                              <th> <input type="text" placeholder="search user ID"> <a class="btn btn-xs btn-default" ><i class="fa fa-search"></i></a></th>   
                                            </tr>
                                          </thead>
                                             <?php foreach($disp_user as $user): ?>
                                          <tbody>         
                                            <tr>
                                              <td scope="row"><?php echo $user->qm_ua_user_id ?> <a onclick="editToAccess('<?php echo $user->qm_ua_user_id ?>')"><i class="fa fa-edit"></i></a></td>
                                                
                                            </tr>    
                                                              
                                          </tbody>
                                            <?php endforeach;?>
                                        </table>
                    </div>
                    </div>
                </div>
</div>

                <!-- Modal  here -->
                  <div id="edit" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-sm" >
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Module to Access</h4>
                      </div>
                       
                      <div class="modal-body">
                           <p id="iddisplay"></p>
                        <select id="id_module">
                        <?php foreach($select_Access as $level):?>
                         <option value="<?php echo $level->qm_access_id?>"><?php echo $level->qm_access_level?> </option> 
                            <?php endforeach; ?></select>
                      </div>
                      <div class="modal-footer">
                         <button id="selectModule" class="btn btn-success">save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                       
                    </div>

                  </div>
                </div>
                <div id="addQT" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-sm" >
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add new type of quiz</h4>
                      </div>
                       
                      <div class="modal-body">
                        <input type="text" id="qtype">
                      </div>
                      <div class="modal-footer">
                         <button id="insertQT" class="btn btn-success">save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                       
                    </div>

                  </div>
                </div>
                <div id="addskills" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-sm" >
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add new type of quiz</h4>
                      </div>
                       
                      <div class="modal-body">
                        <input type="text" id="skills">
                      </div>
                      <div class="modal-footer">
                         <button id="insertskills" class="btn btn-success">save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                       
                    </div>

                  </div>
                </div>
                <script>
                   $(function(){
                       $("#insertQT").click(function(){
                        var qtname=($("#qtype").val());
                         $.ajax({
                           type: "POST",
                           url: "<?php echo base_url().'qm/qm_settings/addQuiztypedata'?>",
                           data: 'qtname='+qtname+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
                           success: function(data)
                           {
                               alert("success");
                           }

                         });

                      });
                      
                   });
                    $(function(){
                       $("#insertskills").click(function(){
                        var skills=($("#skills").val());
                         $.ajax({
                           type: "POST",
                           url: "<?php echo base_url().'qm/qm_settings/addSkilldata'?>",
                           data: 'skills='+skills+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
                           success: function(data)
                           {
                               alert("success");
                           }

                         });


                      });
                      
                   });
                    
                    function deleteQT(id){
                          $.ajax({
                           type: "POST",
                           url: "<?php echo base_url().'qm/qm_settings/deleteQuiztypedata'?>",
                           data: 'qt_id='+id+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
                           success: function(data)
                           {
                               alert("success");
                           }

                         });
                      
                   }
                         function deleteSKILL(skill_id){
                          $.ajax({
                           type: "POST",
                           url: "<?php echo base_url().'qm/qm_settings/deleteskillsdata'?>",
                           data: 'skill_id='+skill_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
                           success: function(data)
                           {
                               alert("success");
                           }

                         });     
                   }
                     function editToAccess(id_user){
                            //alert(id_access);
                            $('#edit').modal('show');
                            $('#selectModule').click(function ()
                            {   
                                id_mod=($('#id_module').val());
                                   $.ajax({
                                   type: "POST",
                                   url: "<?php echo base_url().'qm/qm_settings/updateModuleToAccessdata'?>",
                                   data: 'id_user='+id_user+'&id_mod='+id_mod+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
                                   success: function(data)
                                   {
                                       alert("success");
                                   }

                                   });     
                            });
                         
                        }
                </script>

