<div class="container-fluid">
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Product Inventory
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('canteen') ?>'">Dashboard</button>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('canteen/pos') ?>'">POS</button>
              </div>
        </h3>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-success">
                <div class="panel-body">
                    <div class="result">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr style="font-size: small">
                                    <th>#</th>
                                    <th>Item Name</th>
                                    <th>Item Price</th>
                                    <th>Item Left</th>
                                    <th>Item Sold</th>
                                </tr>
                            </thead>
                            <tbody id="result">
                                <?php 
                                    $i = 1;
                                    foreach ($products->result() as $p): 
                                ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td><?php echo $p->canteen_item_name ?></td>
                                    <td class='text-right'><?php echo number_format($p->canteen_item_price, 2, ".", ",") ?></td>
                                    <td><?php echo $p->item_left ?></td>
                                    <td><?php echo $p->item_sold ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4" style="font-size: small">
            <div class="container-fluid">	
                <ul  class="nav nav-pills">
                    <li class="active"><a href="#2b" data-toggle="tab">
                            <i class="fa fa-plus-circle"></i>
                            <span> Add Item</span>
                        </a>
                    </li>
                    <li>
                        <a  href="#1b" data-toggle="tab">
                            <i class="fa fa-dashboard"></i>
                            <span> Update Item</span>
                        </a>
                    </li>

                </ul>

                <div class="tab-content clearfix">
                    <div class="tab-pane" id="1b">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <b>Update Item Quantity</b>
                            </div>
                            <div class="panel-footer">
                                <div class="form-group" id="first" style="font-size: small">
                                    <label class="pull-left">Select Product Name:</label>&nbsp;
                                    <select class="col-md-6 no-padding" id="option_item" onclick="getProductDetails(this.value)" style="margin-left:10px;">
                                        <option>Select Product Name</option>
                                            <?php foreach ($products->result() as $p):  ?>
                                            <option value="<?php echo $p->canteen_item_id ?>"><?php echo $p->canteen_item_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <br/><br/>
                                    <div class="form-group">
                                        <label class="pull-left">When to serve:</label>
                                        <select class="col-md-6 no-padding" id="serve_option" style="margin-left:10px;">
                                            <option value="0">Whole Day</option>
                                            <option value="1">Breakfast</option>
                                            <option value="2">Lunch</option>
                                            <option value="3">Dinner</option>
                                        </select>
                                    </div>
                                        <br/><br/>
                                    <div class="form-group">
                                        <span class="pull-left">Keyboard Assignment</span>
                                         <select class="col-md-6 no-padding" id="key_assign" style="margin-left:10px;">
                                            <option>Select Keyboard Assignment</option>
                                            <option value="F1">F1</option>
                                            <option value="F2">F2</option>
                                            <option value="F3">F3</option>
                                            <option value="F4">F4</option>
                                            <option value="F5">F5</option>
                                            <option value="F6">F6</option>
                                            <option value="F7">F7</option>
                                            <option value="F8">F8</option>
                                            <option value="F9">F9</option>
                                            <option value="F10">F10</option>
                                            <option value="F11">F11</option>
                                            <option value="F12">F12</option>
                                        </select>
                                    </div><br /><br />
                                    <div class="form-group">
                                        <span>Quantity</span>
                                        <input class="form-control input-sm" type="text" id="quantity" name="quantity" placeholder="Quantity">
                                    </div>
                                    <div class="form-group">
                                        <span>Retail Price</span>
                                        <input class="form-control input-sm" type="text" id="price" name="item_price" placeholder="Price">
                                    </div>
                                    <button onclick="updateProduct()" class="btn btn-primary">Submit</button>
                                    <div id="updateNotify" class="pull-right text text-success col-md-8" style="padding: 5px; font-size:12px; display: none">
                                    </div>
                                </div>
                                <span id="imsg" style="color: red;font-size: smaller"></span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane active" id="2b">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <b>Add Product</b>
                            </div>
                            <div class="panel-footer">
                                <div class="form-group" id="first" style="font-size: small">
                                    <div class="form-group">
                                        <label class="pull-left">Select Category:</label>
                                        <select class="col-md-6 no-padding" id="cat_id" style="margin-left:10px;">
                                            <?php foreach ($category as $c):  ?>
                                            <option onclick="selectOption(this.id)" value="<?php echo $c->menu_cat_id ?>"><?php echo $c->menu_cat_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <br/><br/>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control input-sm" type="text" id="pname" name="prodName" placeholder="Product Name">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control input-sm" type="text" id="iprice" name="itemPrice" placeholder="Item Price">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control input-sm" type="text" id="pQuantity" name="productQuantity" placeholder="# of Quantity">
                                    </div>
                                    <button onclick="submitProduct()" class="btn btn-primary">Submit</button>
                                    <div id="addNotify" class="pull-right text text-success col-md-8" style="padding: 5px; font-size:12px; display: none">
                                    </div>
                                </div>
                                <span style="color: red;font-size: smaller" id="errIn"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
 $(document).ready(function () {
     $('#option_item').select2();
     $('#cat_id').select2();
 });
 
 function getProductDetails(value)
 {
     $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . 'canteen/getProductDetails/' ?>'+value,
            data: 'csrf_test_name='+$.cookie('csrf_cookie_name'),
            dataType: 'json',
            success: function (response) {
                $('#price').val(response.price);
            }
        });
 }
 
 function submitProduct()
 {
      $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'canteen/add_product' ?>',
            data: "product="+$('#pname').val()+'&category='+$('#cat_id').val()+'&price='+$('#iprice').val()+'&quantity='+$('#pQuantity').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
            success: function (response) {
                //    alert(response);
                $('#result').html(response);
                $('#addNotify').html('Successfully Saved!!');
                $('#addNotify').show();
                $('#addNotify').hide(5000)
            }
        });
 }
 
 function updateProduct()
 {
      $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'canteen/updateProduct' ?>',
            data: "item_id="+$('#option_item').val()+'&item_quantity='+$('#quantity').val()+'&item_price='+$('#price').val()+'&serve_option='+$('#serve_option').val()+'&key_assign='+$('#key_assign').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
            //dataType: 'json',
            success: function (response) {
                //    alert(response);
                $('#result').html(response);
                $('#updateNotify').html('Successfully Saved!!');
                $('#updateNotify').show();
                $('#updateNotify').hide(5000)
            }
        });
 }
 
 function selectOption(id)
 {
    
 }
 
</script>
