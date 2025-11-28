<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4>Sales Monitoring</h4>
                </div>
                <div class="panel-body">
                    <div class="result">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr style="font-size: small">
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Item Price</th>
                                    <th>Item Left</th>
                                    <th>Item Sold</th>
                                </tr>
                            </thead>
                            <tbody id="result">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4" style="font-size: small">
            <div class="container-fluid">	
                <ul  class="nav nav-pills">
                    <li class="active">
                        <a  href="#1b" data-toggle="tab">
                            <i class="fa fa-dashboard"></i>
                            <span> Update Item</span>
                        </a>
                    </li>
                    <li><a href="#2b" data-toggle="tab">
                            <i class="fa fa-plus-circle"></i>
                            <span> Add Item</span>
                        </a>
                    </li>

                </ul>

                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="1b">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <b>Update Item Quantity</b>
                            </div>
                            <div class="panel-footer">
                                <div class="form-group" id="first" style="font-size: small">
                                    <span>Select Product Name:
                                        <select class="selectpicker" data-style="btn-default" id="option_item" onchange="optionItem()">

                                        </select>
                                    </span>
                                    <br/><br/>
                                    <div class="form-group">
                                        <span>Quantity ( in Digits )</span>
                                        <input class="form-control input-sm" type="text" id="quantity" name="quantity" placeholder="Enter Quantity ( in DIGITS )">
                                    </div>
                                    <div class="form-group">
                                        <span>Retail Price ( in Digits )</span>
                                        <input class="form-control input-sm" type="text" id="price" name="item_price" placeholder="Enter Price per piece ( in DIGITS )">
                                    </div>
                                    <div class="form-group">
                                        <span>Wholesale Price ( in Digits )</span>
                                        <input class="form-control input-sm" type="text" id="editwsprice" name="wholeSalePrice" placeholder="Wholesale Price">
                                    </div>
                                    <button onclick="submitItem()" class="btn btn-primary">Submit</button>
                                </div>
                                <span id="imsg" style="color: red;font-size: smaller"></span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="2b">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <b>Add Product</b>
                            </div>
                            <div class="panel-footer">
                                <div class="form-group" id="first" style="font-size: small">
                                    <div class="form-group">
                                        <span>Select Category:
                                            <select class="selectpicker" data-style="btn-default" id="cat_id">

                                            </select>
                                        </span>
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
                                    <div class="form-group">
                                        <input class="form-control input-sm" type="text" id="wsprice" name="wholeSalePrice" placeholder="Wholesale Price">
                                    </div>
                                    <button onclick="submitProduct()" class="btn btn-primary">Submit</button>
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

<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script type="text/javascript">
                                    $(function () {
                                        function check() {

                                            var url = '<?php echo base_url() . 'canteen/items_all' ?>';
                                            $.ajax({
                                                url: url,
                                                data: "",
                                                dataType: 'json',
                                                success: function (result) {
                                                    //alert(result);
                                                    var profit = '';
                                                    var trHTML = '';
                                                    var items = '';
                                                    for (i = 0; i < result.length; i++) {
                                                        trHTML += '<tr style="color: gray;font-size: smaller;"><td style="text-align: center">' + result[i].canteen_item_id + '</td><td>' + result[i].canteen_item_name + '</td><td>' + result[i].canteen_item_price + '</td><td>' + result[i].total_quantity + '</td><td>' + result[i].item_sold + '</td><td class="isales">' + result[i].item_sales + '.00</td><td class="iprofit">' + result[i].total_profit + '</td></tr>';
                                                    }

                                                    $('#result').html(trHTML);
                                                },
                                                error: function (msg) {
                                                    alert(msg.responseText);
                                                }
                                            });
                                            var sales_total = calc();
                                            document.getElementById("tsales").innerHTML = 'Php ' + sales_total[0] + '.00';
                                            document.getElementById("tprofit").innerHTML = 'Php ' + sales_total[1];
                                        }
                                        setInterval(check, 5000);
                                    });

                                    $(function () {
                                        var url = '<?php echo base_url() . 'canteen/all_category' ?>';
                                        $.ajax({
                                            url: url,
                                            data: "",
                                            dataType: 'json',
                                            success: function (result) {
                                                var category = '';
                                                var items = '';
                                                for (i = 0; i < result['cat'].length; i++) {
                                                    category += '<option style="text-align: center" id="' + result['cat'][i].menu_cat_id + '">' + result['cat'][i].menu_cat_name + '</option>';
                                                }

                                                for (x = 0; x < result['item'].length; x++) {
                                                    items += '<option style="text-align: center" id="' + result['item'][x].canteen_item_price + '" data-price="' + result['item'][x].canteen_wsprice + '" data-status="' + result['item'][x].total_quantity + '">' + result['item'][x].canteen_item_name + '</option>';
                                                }

                                                $('#quantity').val(result['item'][0].total_quantity);
                                                $('#price').val(result['item'][0].canteen_item_price);
                                                $('#editwsprice').val(result['item'][0].canteen_wsprice);
                                                $('#option_item').html(items);
                                                $('#cat_id').html(category);
                                            },
                                            error: function (msg) {
                                                alert(msg.responseText);
                                            }
                                        });
                                    });

                                    $("#quantity").keypress(function (e) {
                                        //if the letter is not digit then display error and don't type anything
                                        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                            //display error message
                                            $("#imsg").html("* In Digits please").show().fadeOut(1000);
                                            return false;
                                        }
                                    });

                                    $("#price").keypress(function (e) {
                                        //if the letter is not digit then display error and don't type anything
                                        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                            //display error message
                                            $("#imsg").html("* In Digits please").show().fadeOut(1000);
                                            return false;
                                        }
                                    });

                                    $("#iprice").keypress(function (e) {
                                        //if the letter is not digit then display error and don't type anything
                                        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                            //display error message
                                            $("#errIn").html("* In Digits please").show().fadeOut(1000);
                                            return false;
                                        }
                                    });

                                    function optionItem(a) {
                                        var x = document.getElementById("option_item");
                                        var y = x.options[x.selectedIndex].id;
                                        var z = $('#option_item option:selected').data('status');
                                        document.getElementById("price").value = y;
                                        document.getElementById("quantity").value = z;
                                    }

                                    function submitItem() {
                                        var a = document.getElementById("option_item").value;
                                        var b = document.getElementById("quantity").value;
                                        var c = parseInt(document.getElementById("price").value);
                                        var d = parsInt(document.getElementById("editwsprice").value);

                                        if (b == "") {
                                            $("#imsg").html("these fields should not be empty").show().fadeOut(2000);
                                        } else {
                                            var url = '<?php echo base_url() . 'canteen/add_item' ?>';
                                            $.ajax({
                                                type: 'POST',
                                                url: url,
                                                dataType: 'json',
                                                data: {itemName: a, itemQuantity: b, itemPrice: c + '.00', wholeSale: d + '.00'},
                                                success: function (result) {
                                                    $('#imsg').html("Added Successfully").show().fadeOut(3000);
                                                    document.getElementById("quantity").value = "";
                                                },
                                                error: function (result) {
                                                    alert(result);
                                                }
                                            });
                                        }
                                    }

                                    function submitProduct() {
                                        var x = document.getElementById("cat_id");
                                        var a = document.getElementById("pname").value;
                                        var b = document.getElementById("iprice").value;
                                        var c = x.options[x.selectedIndex].id;
                                        var d = document.getElementById("wsprice").value;
                                        var e = document.getElementById("pQuantity").value;
                                        var f = b - (d / e);

                                        if ((a && b && d) == "") {
                                            $("#errIn").html("All fields are required!!!").show().fadeOut(2000);
                                        } else {
                                            var url = '<?php echo base_url() . 'canteen/add_product' ?>';
                                            $.ajax({
                                                type: 'POST',
                                                url: url,
                                                dataType: 'json',
                                                data: {productName: a, productPrice: b + '.00', productCategory: c, wsPrice: d + '.00', pquantity: e, iprofit: f},
                                                success: function (result) {
                                                    //alert(result);
                                                     $('#errIn').html("Added Successfully").show().fadeOut(3000);
                                                     document.getElementById("pname").value = "";
                                                     document.getElementById("iprice").value = "";
                                                     document.getElementById("pQuantity").value = "";
                                                     document.getElementById("wsprice").value = "";
                                                },
                                                error: function (result) {
                                                    alert(result);
                                                }
                                            });
                                        }
                                    }

                                    function calc() {
                                        var cls = document.getElementById("result").getElementsByTagName("td");
                                        var sum = 0;
                                        var sum2 = 0;

                                        for (var i = 0; i < cls.length; i++) {
                                            if (cls[i].className == "isales") {
                                                sum += isNaN(cls[i].innerHTML) ? 0 : parseFloat(cls[i].innerHTML);
                                            }
                                            if (cls[i].className == "iprofit") {
                                                sum2 += isNaN(cls[i].innerHTML) ? 0 : parseFloat(cls[i].innerHTML);
                                            }
                                        }

                                        return [sum, sum2];
                                    }

</script>
