<div id="accessControls">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h5>Menu Access</h5>
        </div>
        <div class="panel-body">
            <div class="col-lg-6">
                        <h4 class="alert alert-success text-center">Assigned</h4>
                    <div id="cma_personal_accessAssigned" class="panel-body">
                        <?php
                        $menu = $positionAccess; //this is taken from the template.php
                        if($menu!=""){
                        $item = ($menu!=""?explode(',', $menu->cma_personal_access):"");
                            foreach ($item as $m){
                                $menuItem = Modules::run('college/getMenu', $m);
                             ?>
                             <div style='cursor:pointer; margin-bottom:5px;' onclick='unAssignAccess("<?php echo $menuItem->cmenu_id?>", "menuAccess", "cma_personal_access"), $(this).fadeOut(500)' class='alert alert-success alert-dismissable span11'>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <div id="un_<?php echo $menuItem->cmenu_id ?>_name" class="notify">
                                   <?php echo $menuItem->cmenu_name; ?>
                                </div>    

                           </div>
                            <?php
                            }
                        }
                     ?>
                    </div>
            </div>
            <div class="col-lg-6">
                        <h4 class="alert alert-danger text-center">Unassigned</h4>
                    <div id="menu_accessUnAssigned" class="panel-body">
                       <?php 
                            foreach ($menuAccess as $mnA){
                         
                             ?>
                             <div id="<?php echo $mnA->cmenu_id ?>" column="cma_personal_access" accessValue="menuAccess" onclick="assignAccess('<?php echo $mnA->cmenu_id?>', 'menuAccess', 'cma_personal_access')" style='cursor:pointer; margin-bottom:5px;' class='alert alert-danger alert-dismissable span11'>
                                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&DoubleLeftArrow;</button>
                                <div id="<?php echo $mnA->cmenu_id ?>_name" class="notify">
                                   <?php echo $mnA->cmenu_name; ?>
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


   
    <input type ="hidden" value="<?php echo $menu->cma_personal_access ?>" id="menuAccess" />


</div>

<script type="text/javascript">
    
    function unAssignAccess(id, access, db_column)
    {
        var accessValue = $('#'+access).val();
        var newValue = accessValue.replace(id+',',"");
        if(newValue==accessValue){
            newValue = accessValue.replace(','+id,"");
            if(newValue==accessValue){
                newValue = accessValue.replace(id,"");
            }
        }else{
            newValue = accessValue.replace(id+',',"");
        }

        alert(newValue)
        var url = "<?php echo base_url().'college/settings/unlinkAccess/'?>"
        var accessName = $('#un_'+id+"_name").html()
        $.ajax({
               type: "POST",
               url: url,
               data: "column="+db_column+"&id="+newValue+"&user_id="+<?php echo $user_id ?>+"&accessValue="+accessValue+"&accessName="+accessName+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#'+db_column+"UnAssigned").append(data)
                   $('#'+access).val(newValue)
               }
         });

            return false;
    }
    
    
    function assignAccess(id,access, db_column)
    {
       
        var url = "<?php echo base_url().'college/settings/saveAccess/'?>"
       
        var accessValue = $('#'+access).val();
        var accessName = $('#'+id+"_name").html()
       // alert(accessValue)
        $.ajax({
               type: "POST",
               url: url,
               data: "column="+db_column+"&id="+id+"&user_id="+<?php echo $user_id ?>+"&accessValue="+accessValue+"&accessName="+accessName+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#'+db_column+"Assigned").append(data)
                   if(accessValue!=""){
                       $('#'+access).val(accessValue+','+id)
                   }else{
                      $('#'+access).val(id) 
                   }
                   
               }
         });

            return false;
    }

</script>