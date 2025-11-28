<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Accounting System - Inventory
        <?php $this->load->view('../accounting_menus'); ?>
    </h3>
</div>
<div class="col-lg-12">
     <ul class="nav nav-tabs" role="tablist" id="inventory_tab">
         <li class="active"><a href="#listOfInventory">List of Inventory</a></li>
         <li><a href="#addInventory">List of Inventory Category</a></li>
     </ul>
    <div class="tab-content col-lg-12 no-padding">
        <div class="col-lg-12 tab-pane active" id="listOfInventory" style="padding-top: 15px;">
            <?php $this->load->view('inventoryList'); ?>
        </div>
        
        <div class="col-lg-12 tab-pane" id="addInventory" style="padding-top: 15px;">
            <div class="col-lg-7 no-padding" style="border-right:1px solid #ccc">
                 <h4 class="text-center">List of Inventory Category</h4>
                 <div class="col-lg-12">
                    <table class="table table-stripped">
                    <thead>
                       <tr>
                           <th>#</th>
                           <th>Account Category</th>
                       </tr>
                    </thead>
                    <tbody id="inventoryCatBody">
                        <?php
                        $i = 1;
                        foreach($category as $cat): ?>
                        <tr>
                            <td><?php echo $i++?></td>
                            <td><?php echo $cat->inv_category ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                 </div>
             </div>
            <div class="col-lg-4 pull-right" id="addCatWrapper" >
                    <h4 class="text-center">Add Inventory Category</h4>
                    <div class="form-group input-group col-lg-12">
                        <label>Category Name</label>
                        <input class="form-control" id="category"  placeholder="Category" type="text">
                    </div>
                    <button onclick="addCategory('<?php echo $i ?>')" class="btn btn-primary btn-block">A D D</button>

                </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    
    $(document).ready(function(){
        $('#inventory_tab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      })
      
    });
    
    function addCategory(i)
    {
        var cat = $('#category').val();
        var url = "<?php echo base_url().'accountingsystem/inventory/addCategory' ?>"
        
        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data: 'category='+cat+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data)
            {   
                    if(data.status)
                    {
                        $('#inventoryCatBody').append('<tr><td>'+(parseInt(i)+1)+'</td><td>'+cat+'</td></tr>')
                    }
            }
        });
    }
    
</script>    