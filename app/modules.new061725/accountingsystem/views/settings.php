<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Accounting System
        <?php $this->load->view('accounting_menus'); ?>
    </h3>
</div>
<div class="col-lg-12">
     <ul class="nav nav-tabs" role="tablist" id="amSettings_tab">
         <li class="active"><a href="#listOfAccounts">List of Account Titles</a></li>
         <li><a href="#addTitles">Add Account Titles</a></li>
         <li><a href="#addAccountCategories">Add Account Categories</a></li>
         <li class="pull-right"><a href="#payrollLinks">Payroll Account Links</a></li>
         <li class="pull-right"><a href="#cashieringLinks">Cashiering Account Links</a></li>
     </ul>
     <div class="tab-content col-lg-12 no-padding">
         <div class="col-lg-12 tab-pane" id="payrollLinks" style="padding-top: 15px;">
             <div class="col-lg-2"></div>
             <div class="col-lg-8">
                 <table class="table table-stripped">
                    <thead>
                       <tr>
                           <th>#</th>
                           <th style="width:350px;">Name</th>
                           <th>Account Title</th>
                           <th>Debits To</th>
                           <th>Credits To</th>
                           <th>Action</th>
                       </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i=1;
                        foreach ($employees as $e): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo strtoupper($e->firstname.' '.$e->lastname); ?></td>
                            <td><?php echo (Modules::run('accountingsystem/getAccountTitleById', $e->pp_act_to)!=NULL?Modules::run('accountingsystem/getAccountTitleById', $e->pp_act_to)->coa_name:""); ?></td>
                            <td></td>
                            <td></td>
                            <td>
                              <button onclick="editPayrollLinks('<?php echo strtoupper($e->firstname.' '.$e->lastname); ?>', '<?php echo $e->pp_id ?>')" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></button>

                            </td>
                               
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                 </table>
             </div>
             <div class="col-lg-2"></div>
         </div>
         <div class="col-lg-12 tab-pane" id="cashieringLinks" style="padding-top: 15px;">
             <div class="col-lg-2"></div>
             <div class="col-lg-8">
                <table class="table table-stripped">
                    <thead>
                       <tr>
                           <th>#</th>
                           <th>Items</th>
                           <th>Account Title</th>
                           <th>Debits To</th>
                           <th>Credits To</th>
                           <th>Action</th>
                       </tr>
                    </thead>
                    <tbody>
                       <?php
                       $n=1;
                          foreach ($finItems as $i):
                              
                       ?>
                           <tr>
                               <td><?php echo $n++ ?></td>
                               <td><?php echo $i->item_description?></td>
                               <td><?php echo (Modules::run('accountingsystem/getAccountTitleById', $i->as_account_id)!=NULL?Modules::run('accountingsystem/getAccountTitleById', $i->as_account_id)->coa_name:""); ?></td>
                               <td><?php echo (Modules::run('accountingsystem/getAccountTitleById', $i->debit_to)!=NULL?Modules::run('accountingsystem/getAccountTitleById', $i->debit_to)->coa_name:""); ?></td>
                               <td><?php echo (Modules::run('accountingsystem/getAccountTitleById', $i->credit_to)!=NULL?Modules::run('accountingsystem/getAccountTitleById', $i->credit_to)->coa_name:""); ?></td>
                               <td>
                                   <button onclick="editFinanceLinks('<?php echo $i->item_description; ?>', '<?php echo $i->item_id ?>')" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></button>
                               </td>
                           </tr>
                           <?php 
                      endforeach;
                      ?>
                    </tbody>
                </table>
                 
             </div>
             <div class="col-lg-2"></div>
         </div>
        <div class="col-lg-12 tab-pane" id="addTitles" style="padding-top: 15px;">
            <div class="col-lg-2"></div>
            <div class="col-lg-8" id="addAccountWrapper">
                <div class="form-group input-group col-lg-12">
                    <label>Account Code</label>
                    <input class="form-control" id="accountCode"  placeholder="Account Code" type="text">
                </div>
                <div class="form-group input-group col-lg-12">
                    <label>Account Name</label>
                    <input class="form-control" id="accountName"  placeholder="Account Name" type="text">
                </div>
                <div class="form-group input-group col-lg-12">
                    <label>Category</label>
                    <select id="inputCategory" class="form-control">
                        <option>Select Category</option>
                        <?php foreach($category as $cat): ?>
                            <option value="<?php echo $cat->cat_id ?>"><?php echo $cat->cat_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group input-group col-lg-12">
                    <label>Account Type</label>
                    <select id="accountType" class="form-control">
                        <option value="0">Credit</option>
                        <option value="1">Debit</option>
                    </select>
                </div>
                <button onclick="addAccount()" class="btn btn-primary btn-block">A D D</button>

            </div>
            <div class="col-lg-2"></div>
        </div>
         <div class="col-lg-12 tab-pane " id="addAccountCategories" style="padding-top: 15px;">
             <div class="col-lg-7 no-padding" style="border-right:1px solid #ccc">
                 <h4 class="text-center">List of Account Category</h4>
                 <div class="col-lg-12">
                    <table class="table table-stripped">
                    <thead>
                       <tr>
                           <th>#</th>
                           <th>Account Category</th>
                           <th>Parent Category</th>
                           <th>Show in Reports</th>
                       </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach($category as $cat): ?>
                        <tr>
                            <td><?php echo $i++?></td>
                            <td><?php echo $cat->cat_name ?></td>
                            <td><?php echo (Modules::run('accountingsystem/getCategory', $cat->cat_parent_id)?Modules::run('accountingsystem/getCategory', $cat->cat_parent_id)->cat_name:'None') ?></td>
                            <td id="tdCat_<?php echo $cat->cat_id ?>" class="text-center"><?php
                                    if($cat->cat_show):
                                    ?>
                                   <i class="fa fa-check-square text-success pointer" onclick="showCatInReports('<?php echo $cat->cat_id ?>', 0)"></i>
                                    <?php
                                    else:
                                    ?>    
                                   <i class="fa fa-square-o text-danger pointer" onclick="showCatInReports('<?php echo $cat->cat_id ?>', 1)"></i>
                                    <?php
                                    endif;
                               ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                 </div>
             </div>
                <div class="col-lg-4 pull-right" id="addCatWrapper" >
                    <h4 class="text-center">Add Category</h4>
                    <div class="form-group input-group col-lg-12">
                        <label>Category Name</label>
                        <input class="form-control" id="category"  placeholder="Category" type="text">
                    </div>
                    <div class="form-group input-group col-lg-12">
                        <label>Parent Category</label>
                        <select id="parentCategory" class="form-control">
                            <option value="0">No Parent</option>
                            <?php foreach($category as $cat): ?>
                                <option value="<?php echo $cat->cat_id ?>"><?php echo $cat->cat_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button onclick="addCategory()" class="btn btn-primary btn-block">A D D</button>

                </div>
         </div>
         <div class="col-lg-12 tab-pane active" id="listOfAccounts" style="padding-top: 15px;">
             <div class="col-lg-2"></div>
             <div class="col-lg-8">
                 <?php echo $links ?>
                <table class="table table-stripped">
                    <thead>
                       <tr>
                           <th>CODE</th>
                           <th>Account Title</th>
                           <th>Account Category</th>
                           <th>Show in Income Statement</th>
                           <th>Show in Trial Balance</th>
                           <th>Show in Balance Sheet</th>
                       </tr>
                    </thead>
                    <tbody>
                       <?php
                          foreach ($accountTitles as $acnt):
                       ?>
                           <tr>
                               <td><?php echo $acnt->coa_code?></td>
                               <td><?php echo $acnt->coa_name?></td>
                               <td><?php echo strtoupper($acnt->cat_name)?></td>
                               <td id="td_is_displayed_<?php echo $acnt->coa_id ?>" class="text-center"><?php
                                    if($acnt->is_displayed):
                                    ?>
                                   <i class="fa fa-check-square text-success pointer" onclick="showInReports('<?php echo $acnt->coa_id ?>', 0, 'is_displayed')"></i>
                                    <?php
                                    else:
                                    ?>    
                                   <i class="fa fa-square-o text-danger pointer" onclick="showInReports('<?php echo $acnt->coa_id ?>', 1,'is_displayed')"></i>
                                    <?php
                                    endif;
                               ?></td>
                               <td id="td_tb_show_<?php echo $acnt->coa_id ?>" class="text-center"><?php
                                    if($acnt->tb_show):
                                    ?>
                                   <i class="fa fa-check-square text-success pointer" onclick="showInReports('<?php echo $acnt->coa_id ?>', 0,'tb_show')"></i>
                                    <?php
                                    else:
                                    ?>    
                                   <i class="fa fa-square-o text-danger pointer" onclick="showInReports('<?php echo $acnt->coa_id ?>', 1,'tb_show')"></i>
                                    <?php
                                    endif;
                               ?></td>
                               <td id="td_bs_show_<?php echo $acnt->coa_id ?>" class="text-center"><?php
                                    if($acnt->bs_show):
                                    ?>
                                   <i class="fa fa-check-square text-success pointer" onclick="showInReports('<?php echo $acnt->coa_id ?>', 0,'bs_show')"></i>
                                    <?php
                                    else:
                                    ?>    
                                   <i class="fa fa-square-o text-danger pointer" onclick="showInReports('<?php echo $acnt->coa_id ?>', 1,'bs_show')"></i>
                                    <?php
                                    endif;
                               ?></td>
                           </tr>
                           <?php 
                      endforeach;
                      ?>
                    </tbody>
                </table>
             </div>
             <div class="col-lg-2"></div>
         </div>
     </div>
</div>

<?php $this->load->view('as_modal'); ?>



<script type="text/javascript">
    
    $(document).ready(function(){
        $('#amSettings_tab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      })
      
    });
    
    function showCatInReports(id, value)
    {
        var url = "<?php echo base_url().'accountingsystem/showCatInReport' ?>"
        
        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            beforeSend: function (){
                $('#td_'+id).html('<i style="color:#F70000" class="fa fa-spinner fa-spin fa-fw" ></i>');
            },
            data: 'id='+id+'&value='+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data)
            {   
                if(value==0){
                    $('#tdCat_'+id).html('<i class="fa fa-square-o text-danger pointer" onclick="showInReports(\''+id+'\', 1)"></i>');
                }else{    
                    $('#tdCat_'+id).html('<i class="fa fa-check-square text-success pointer" onclick="showInReports(\''+id+'\', 0)"></i>');
                }
            }
        });
    }
    
    function showInReports(id, value, column)
    {
        var url = "<?php echo base_url().'accountingsystem/showInReport' ?>"
        
        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            beforeSend: function (){
                $('#td_'+column+'_'+id).html('<i style="color:#F70000" class="fa fa-spinner fa-spin fa-fw" ></i>');
            },
            data: 'id='+id+'&value='+value+'&column='+column+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data)
            {   
                if(value==0){
                    $('#td_'+column+'_'+id).html('<i class="fa fa-square-o text-danger pointer" onclick="showInReports(\''+id+'\', 1)"></i>');
                }else{    
                    $('#td_'+column+'_'+id).html('<i class="fa fa-check-square text-success pointer" onclick="showInReports(\''+id+'\', 0)"></i>');
                }
            }
        });
    }
    
    function editFinanceLinks(title, id)
    {
        $('.editLinks').select2();
        $('#financeLinks').modal('show');
        $('#finLinkTitle').html(title)
        $('#finItem_id').val(id)
    }
    
    function editPayrollLinks(title, id)
    {
        $('.editLinks').select2();
        $('#payroll').modal('show');
        $('#payLinkTitle').html(title)
        $('#payItem_id').val(id)
    }
    
    function addAccount()
    {
        var code = $('#accountCode').val();
        var account = $('#accountName').val();
        var category = $('#inputCategory').val();
        var accountType = $('#accountType').val();
        var url = "<?php echo base_url().'accountingsystem/addAccount' ?>"
        
        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            beforeSend: function (){
                $('#tempWrapper').html($('#addAccountWrapper').html());
                $('#addAccountWrapper').html('<i style="color:#F70000" class="fa fa-5x fa-spinner fa-spin fa-fw" ></i>');
            },
            data: 'account='+account+'&code='+code+'&category='+category+'&accountType='+accountType+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data)
            {   
                    $('#addAccountWrapper').html($('#tempWrapper').html());
                    if(data.status){
                        alert('Successfully Added');
                        location.reload();
                    }
            }
        });
    }
    
    function addCategory()
    {
        var cat = $('#category').val();
        var parent = $('#parentCategory').val();
        var url = "<?php echo base_url().'accountingsystem/addCategory' ?>"
        
        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            beforeSend: function (){
                $('#tempWrapper').html($('#addCatWrapper').html());
                $('#addCatWrapper').html('<i style="color:#F70000" class="fa fa-5x fa-spinner fa-spin fa-fw" ></i>');
            },
            data: 'category='+cat+'&parent='+parent+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data)
            {   
                    $('#addCatWrapper').html($('#tempWrapper').html());
                    if(data.status){
                        $('#parentCategory').append('<option value="'+data.id+'">'+cat+'</option>');
                        $('#inputCategory').append('<option value="'+data.id+'">'+cat+'</option>');
                        alert('Successfully Added');
                        location.reload();
                    }
            }
        });
    }
    
</script>