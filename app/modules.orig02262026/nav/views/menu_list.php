<div class="row" style="height: 100vh;" >
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Menu Management</h3>
    </div>
    <div class="col-lg-12">
    <?php 
    if($this->session->userdata('user_id')==1):
    ?>
        <table class="table table-striped table-hover">
            <tr>
                <th>id</th>
                <th>Menu Name</th>
                <th>Menu Link</th>
                <th>FA Icon</th>
                <th>Li Class</th>
                <th class="text-center "><button onclick="$('#menuManager').modal('show'), $('#mm_title').html('Add Menu'), $('#menuSelect').show(), $('#menu_type').val('menu')" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></button></th>
            </tr>
            <?php
                foreach($menuList as $menus):
                    if($menus->menu_type=="menu"):
                        ?>
                        <tr>
                            <td><?php echo $menus->menu_id ?></td>
                            <td><a href='<?php echo base_url().$menus->menu_link?>'><strong><?php echo $menus->menu_name; ?></strong></a></td>
                            <td><?php echo $menus->menu_link ?></td>
                            <td><i class="fa <?php echo $menus->menu_a_class ?>"></i></td>
                            <td><?php echo $menus->menu_li_class?></td>
                            <td class="text-center ">
                                <button onclick="editMenuManager('<?php echo $menus->menu_id ?>', '<?php echo $menus->menu_name; ?>','<?php echo $menus->menu_link; ?>', '<?php echo $menus->menu_a_class; ?>', '<?php echo $menus->menu_li_class; ?>', 'menu','0')" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php
                    endif;
                    if ($menus->menu_li_class=='dropdown'):
                        foreach($menuList as $ml):
                            $submenu =  Modules::run('nav/getSubMenu', $menus->menu_id, $ml->menu_id);
                            if($submenu!='0'):
                                if($submenu->menu_type=='submenu'):
                                    ?>
                                    <tr>
                                        <td><?php echo $ml->menu_id ?></td>
                                        <td style="padding-left:20px;"><a href='<?php echo base_url().$ml->menu_link?>'><?php echo $ml->menu_name; ?></a></td>
                                        <td style="padding-left:20px;"><?php echo $ml->menu_link ?></td>
                                        <td><i class="fa <?php echo $ml->menu_a_class ?>"></i></td>
                                        <td><?php echo $ml->menu_li_class?></td>
                                        <td class="text-center ">
                                            <button onclick="editMenuManager('<?php echo $ml->menu_id ?>', '<?php echo $ml->menu_name; ?>','<?php echo $ml->menu_link; ?>', '<?php echo $ml->menu_a_class; ?>', '<?php echo $ml->menu_li_class; ?>', 'submenu','<?php echo $menus->menu_id; ?>')" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php
                                endif;
                            endif;
                        endforeach;
                    endif;   
                    
                endforeach;
            ?>
        </table>
    <?php   
    else:
        echo '<div class="alert alert-danger text-center"><h3><i class="fa fa-exclamation fa-fw"></i> Sorry you are not allowed to access this Area.</h3></div>';
    endif;
    ?>
    </div>
</div>
<div id="menuManager" style="width:30%; margin: 25px auto 0; box-shadow: 10px;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <i data-dismiss="modal" class="pull-right fa fa-close pointer"></i>
            <h6 class="no-margin" id="mm_title">ADD Menu</h6>
            <input type="hidden" id="menu_id" />
            <input type="hidden" id="menu_type" />
            <input type="hidden" id="menu_parent" value="0" />
        </div>
        <div class="panel-body clearfix">
            <div style="display: none" class="control-group" id="menuSelect">
                <div class="controls">
                    <label>Select Menu Type</label>
                    <select onclick="$('#menu_type').val(this.value)" class="form-control">
                        <option onclick="$('#menuParent').hide()" value="menu">Main Menu</option>
                        <option onclick="$('#menuParent').show()" value="submenu">Sub Menu</option>
                       
                    </select>
                </div>
            </div>
            <div style="display: none" class="control-group" id="menuParent">
                <div class="controls">
                    <label>Select Parent Menu</label>
                    <select onclick="$('#menu_parent').val(this.value)" class="form-control">
                        <?php
                        foreach($menuList as $menus):
                            if($menus->menu_type=="menu"):
                        ?>
                            <option value="<?php  echo $menus->menu_id?>"><?php  echo $menus->menu_name?></option>
                        <?php
                            endif;
                        endforeach;    
                        ?>
                       
                    </select>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <label>Menu Title</label>
                    <input type="text" placeholder="Menu Title" class="form-control" id="menu_name" />
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <label>Menu Link</label>
                    <input type="text" placeholder="Menu Link" class="form-control" id="menu_link" />
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <label>Menu Icon</label>
                    <input type="text" placeholder="Menu Icon" class="form-control" id="menu_icon" />
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <label>Menu Class</label>
                    <input type="text" placeholder="Menu Class" class="form-control" id="menu_class" />
                </div>
            </div>
            
        </div>
        <div class="panel-footer clearfix">
            <button onclick="saveMenu()" type="button" class="btn btn-xs btn-success pull-right">Save</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    function editMenuManager(id, name, link, icon, menuClass, menuType, menuParent)
    {
        $('#menuManager').modal('show');
        $('#menu_id').val(id);
        $('#menu_name').val(name);
        $('#menu_link').val(link);
        $('#menu_icon').val(icon);
        $('#menu_class').val(menuClass);
        $('#menu_type').val(menuType);
        $('#menu_parent').val(menuParent);
        $('#mm_title').html('Edit Menu');
    }
    
    function saveMenu()
    {
        var url = "<?php echo base_url().'nav/saveMenu/'?>";
        $.ajax({
           type: "POST",
           url: url,
           data:'menu_id='+$('#menu_id').val()+"&menu_name="+$('#menu_name').val()+'&menu_link='+$('#menu_link').val()+'&menu_icon='+$('#menu_icon').val()+'&menu_type='+$('#menu_type').val()+'&menu_class='+$('#menu_class').val()+'&menu_parent='+$('#menu_parent').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements. 
           success: function(data)
           {
               alert(data)
               location.reload()
           }
         });
    }
</script>