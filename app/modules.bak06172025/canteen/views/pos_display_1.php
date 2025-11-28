<div class="container-fluid">
    <div class="row">
        <div class="col-md-7">
            <ul>
                <li style="float: left; list-style: none; padding-right: 2px; width: 150px">
                    <a href="#1a" data-toggle="tab" class="btn btn-danger btn-lg btn-group" style="width: 100%" role="button"><span class="glyphicon glyphicon-grain fa-1x"></span> <br/>Meals</a>
                </li>
                <li style="float: left; list-style: none; padding-right: 2px; width: 150px">
                    <a href="#2a" data-toggle="tab" class="btn btn-warning btn-lg btn-group" style="width: 100%" role="button"><span class="glyphicon glyphicon-apple fa-1x"></span> <br/>Snacks</a>
                </li>
                <li style="float: left; list-style: none; padding-right: 2px; width: 150px">
                    <a href="#3a" data-toggle="tab" class="btn btn-success btn-lg btn-group" style="width: 100%" role="button"><span class="glyphicon glyphicon-ice-lolly-tasted fa-1x"></span> <br/>Desserts</a>
                </li>
                <li style="float: left; list-style: none; padding-right: 2px; width: 150px">
                    <a href="#4a" data-toggle="tab" class="btn btn-info btn-lg btn-group" style="width: 100%" role="button"><span class="glyphicon glyphicon-glass fa-1x"></span> <br/>Drinks</a>
                </li>
            </ul>

        </div>
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <em id="todate"></em>
                        </div>
                        <div class="col-sm-12" id="trans_num"><br/>
                            Transaction #: <?php
                            $stamp = date("mdhis");
                            echo($stamp);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>
        </div>
    </div>
    <div class="row-border">
        <div class="col-md-7">
            <div class="tab-content clearfix sidebox">
                <div class="tab-pane active" id="1a">
                    <div class="container-fluid">
                        <h2>Meals</h2>
                        <div class="row">
                            <ul id="result1">

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="2a">
                    <div class="container-fluid">
                        <h2>Snacks</h2>
                        <div class="row">
                            <ul id="result2">

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="3a">
                    <div class="container-fluid">
                        <h2>Desserts</h2>
                        <div class="row">
                            <ul id="result3">

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="4a">
                    <div class="container-fluid">
                        <h2>Drinks</h2>
                        <div class="row">
                            <ul id="result4">

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 sidebox">
            <div class="row">
                <div class="col-md-12" style="overflow-y: scroll; max-height: 300px">

                    <table id="tbl1" class="table table-responsive" style="font-size: 10px">
                        <thead>
                            <tr>
                                <th>Options</th>
                                <th>Quantity</th>
                                <th>Item Name</th>
                                <th>Each</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody id="table_trans">

                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <table id="tbl2" class="table table-responsive" style="font-size: 10px">

                    </table>
                </div>
                <div class="col-md-8">
                    <h4>Total Transaction</h4>
                </div>
                <div class="col-md-4">
                    <h4 id="total-price">Php</h4>
                </div>
                <div class="col-md-4">
                    <button type="button" style="width: 100%" class="btn btn-primary btn-lg delBtn" id="creditBtn" data-toggle='modal' data-target='#carNumber' disabled=""><span class="fa fa-1x fa-credit-card"></span> Credit</button>
                </div>
                <div class="col-md-4">
                    <button type="button" style="width: 100%" class="btn btn-info btn-lg delBtn" id="cashBtn" data-toggle='modal' data-target='#cashModal' disabled=""><span class="fa fa-1x fa-money"></span> Cash</button>
                </div>
                <div class="col-md-4">
                    <button type="button" style="width: 100%" id="newTrans" onclick="winReload();" class="btn btn-success btn-lg delBtn" disabled=""><span class="fa fa-1x fa-dashboard"></span> New</button>
                </div>
                <div id="addSuccess"></div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="modal fade" id="myModal" role="dialog">
        <?php $this->load->view("quantity_modal"); ?>
    </div>
    <div class="modal fade" id="carNumber" role="dialog">
        <?php $this->load->view("credit_modal"); ?>
    </div>
    <div class="modal fade" id="cashModal" role="dialog">
        <?php $this->load->view("cash_modal"); ?>
    </div>
</div>

<div id="test"></div>
<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>

<script type="text/javascript">


                        $(function () {

                            var url = '<?php echo base_url() . 'canteen/items_all' ?>';
                            $.ajax({
                                url: url,
                                data: "",
                                dataType: 'json',
                                success: function (result) {
                                    var trHTML1 = '';
                                    var trHTML2 = '';
                                    var trHTML3 = '';
                                    var trHTML4 = '';
                                    var resVar = '';
                                    var array1 = [];
                                    var array2 = [];
                                    var array3 = [];
                                    var array4 = [];
                                    for (i = 0; i < result.length; i++) {
                                        resVar = result[i].canteen_item_cat;
                                        if (resVar == 1) {
                                            array1.push([result[i].canteen_item_name, result[i].canteen_item_price, result[i].canteen_item_id, result[i].item_profit]);
                                        } else if (resVar == 2) {
                                            array2.push([result[i].canteen_item_name, result[i].canteen_item_price, result[i].canteen_item_id, result[i].item_profit]);
                                        } else if (resVar == 3) {
                                            array3.push([result[i].canteen_item_name, result[i].canteen_item_price, result[i].canteen_item_id, result[i].item_profit]);
                                        } else {
                                            array4.push([result[i].canteen_item_name, result[i].canteen_item_price, result[i].canteen_item_id, result[i].item_profit]);
                                        }
                                    }

                                    for (a = 0; a < array1.length; a++) {
                                        trHTML1 += "<li class='col-md-3' style='list-style: none;padding-right:1px'><a class='delBtn' role='button' onclick='testFunction(\"" + array1[a][0] + "\",\"" + array1[a][1] + "\",\"" + array1[a][2] + "\",\"" + array1[a][3] + "\")' style='text-decoration: none' data-toggle='modal' data-target='#myModal'><div class='panel panel-primary'><div class='panel-heading' style='text-align: center'>" + array1[a][0] + "</div><div class='panel-footer' style='text-align: center'>P" + array1[a][1] + "</div></div></a></li>";
                                    }

                                    for (a = 0; a < array2.length; a++) {
                                        trHTML2 += "<li class='col-md-3' style='list-style: none;padding-right:1px'><a class='delBtn' role='button' onclick='testFunction(\"" + array2[a][0] + "\",\"" + array2[a][1] + "\",\"" + array2[a][2] + "\",\"" + array2[a][3] + "\")' style='text-decoration: none' data-toggle='modal' data-target='#myModal'><div class='panel panel-primary'><div class='panel-heading' style='text-align: center'>" + array2[a][0] + "</div><div class='panel-footer' style='text-align: center'>P" + array2[a][1] + "</div></div></a></li>";
                                    }

                                    for (a = 0; a < array3.length; a++) {
                                        trHTML3 += "<li class='col-md-3' style='list-style: none;padding-right:1px'><a class='delBtn' role='button' onclick='testFunction(\"" + array3[a][0] + "\",\"" + array3[a][1] + "\",\"" + array3[a][2] + "\",\"" + array3[a][3] + "\")' style='text-decoration: none' data-toggle='modal' data-target='#myModal'><div class='panel panel-primary'><div class='panel-heading' style='text-align: center'>" + array3[a][0] + "</div><div class='panel-footer' style='text-align: center'>P" + array3[a][1] + "</div></div></a></li>";
                                    }

                                    for (a = 0; a < array4.length; a++) {
                                        trHTML4 += "<li class='col-md-3' style='list-style: none;padding-right:1px'><a class='delBtn' role='button' onclick='testFunction(\"" + array4[a][0] + "\",\"" + array4[a][1] + "\",\"" + array4[a][2] + "\",\"" + array4[a][3] + "\")' style='text-decoration: none' data-toggle='modal' data-target='#myModal'><div class='panel panel-primary'><div class='panel-heading' style='text-align: center'>" + array4[a][0] + "</div><div class='panel-footer' style='text-align: center'>P" + array4[a][1] + "</div></div></a></li>";
                                    }
                                    $('#result1').html(trHTML1);
                                    $('#result2').html(trHTML2);
                                    $('#result3').html(trHTML3);
                                    $('#result4').html(trHTML4);
                                },
                                error: function (msg) {
                                    alert(msg.responseText);
                                }
                            });
                        });

                        function testFunction(x, y, a, b) {
                            document.getElementById("itemname").innerHTML = x;
                            document.getElementById("itemprice").innerHTML = y;
                            document.getElementById("itemid").innerHTML = a;
                            document.getElementById("profit").innerHTML = b;
                        }

                        function okbtn() {
                            document.getElementById("cashBtn").disabled = false;
                            document.getElementById("creditBtn").disabled = false;
                            var a = document.getElementById("itemid").innerHTML;
                            var b = document.getElementById("profit").innerHTML;
                            var x = document.getElementById("quantity").value;
                            var y = document.getElementById("itemname").innerHTML;
                            var z = document.getElementById("itemprice").innerHTML;
                            var v = sum_up(b, x);
                            var option = "<button class='btn btn-primary btn-danger btn-sm delBtn' onclick='delRow(this)'><span class='glyphicon glyphicon-trash'></span></button><b hidden class='item_id'>" + a + "</b>";
                            var table = document.getElementById("table_trans");
                            var row = table.insertRow(0);
                            var cell1 = row.insertCell(0);
                            var cell2 = row.insertCell(1);
                            var cell3 = row.insertCell(2);
                            var cell4 = row.insertCell(3);
                            var cell5 = row.insertCell(4);
                            var cell6 = row.insertCell(5);
                            var w = sum_up(x, z);

                            cell1.innerHTML = option;
                            cell2.className = "num_quantity";
                            cell2.innerHTML = x;
                            cell3.innerHTML = y;
                            cell3.className = "item_name";
                            cell4.innerHTML = z;
                            cell5.className = "total";
                            cell5.innerHTML = w + '.00';
                            cell6.innerHTML = v;
                            cell6.className = "profit";
                            cell6.style.display = "none";
                            calc();
                            clearing();
                        }

                        function cashbtn() {
                            var a = document.getElementById("cash").value;
                            var b = document.getElementById("total-price").innerText;
                            var num = b.replace(/[^\d.]/g, '');
                            var change = a - num;
                            var table2 = document.getElementById("tbl2");
                            var row1 = table2.insertRow(0);
                            var cell1 = row1.insertCell(0);
                            var cell2 = row1.insertCell(1);
                            var row2 = table2.insertRow(1);
                            var cell3 = row2.insertCell(0);
                            var cell4 = row2.insertCell(1);

                            cell1.innerHTML = "<h4>Cash</h4>";
                            cell2.innerHTML = "<h4 style='text-align: right' id='custom_cash'>Php " + a + ".00</h4>";
                            cell3.innerHTML = "<h4>Change</h4>";
                            cell4.innerHTML = "<h4  style='text-align: right' id='custom_change'>Php " + change + ".00</h4>";

                            saveData();
                            $('.delBtn').prop('disabled', true);
                            document.getElementById("newTrans").disabled = false;
                            document.getElementById("trans_num").innerText = "";

                        }

                        function saveData() {
                            var count = document.getElementById("table_trans").getElementsByTagName("tr");
                            var idNum = document.getElementById("trans_num").innerText;
                            var customCash = document.getElementById("custom_cash").innerText;
                            var customChange = document.getElementById("custom_change").innerText;
                            var priceTotal = document.getElementById("total-price").innerText;
                            var data1 = [];
                            var data2 = [];
                            var data3 = [];
                            var data4 = [];
                            var data5 = [];
                            var allData = [];

                            for (var a = 0; a < count.length; a++) {
                                data1.push(document.getElementsByClassName("item_name")[a].innerHTML);
                                data2.push(document.getElementsByClassName("num_quantity")[a].innerHTML);
                                data3.push(document.getElementsByClassName("total")[a].innerHTML);
                                data4.push(document.getElementsByClassName("item_id")[a].innerHTML);
                                data5.push(document.getElementsByClassName("profit")[a].innerHTML);
                            }

                            for (var x = 0; x < count.length; x++) {
                                allData.push([data1[x], data2[x], data3[x], data4[x], data5[x], idNum]);
                            }
                            //alert(JSON.stringify(allData));

                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url() . 'canteen/save_transaction' ?>',
                                dataType: 'json',
                                data: {newData: JSON.stringify(allData),
                                    totalCash: customCash,
                                    totalChange: customChange,
                                    totalTrans: priceTotal
                                },
                                success: function (response) {
                                    //    alert(response);

                                    var trHTML = '';
                                    trHTML += '<p style="color: green"> Transaction Saved</p>';
                                    $('#addSuccess').html(trHTML);
                                },
                                error: function (response) {
                                    alert(response);
                                }

                            });
                        }

                        function winReload() {
                            window.location.reload();
                            $('.delBtn').prop('disabled', false);
                            document.getElementById("newTrans").disabled = true;
                            document.getElementById("cashBtn").disabled = true;
                            document.getElementById("creditBtn").disabled = true;
                            clearing();
                        }

                        function delRow(x) {
                            $(x).parent().parent().remove();
                            calc();
                        }

                        function calc() {
                            var cls = document.getElementById("table_trans").getElementsByTagName("td");
                            var sum = 0;

                            for (var i = 0; i < cls.length; i++) {
                                if (cls[i].className == "total") {
                                    sum += isNaN(cls[i].innerHTML) ? 0 : parseInt(cls[i].innerHTML);
                                }
                            }

                            document.getElementById("total-price").innerHTML = 'Php ' + sum + '.00';
                        }

                        function sum_up(a, b) {
                            x = a * b;
                            return x;
                        }
                        $(document).ready(function () {

                            $('.num').click(function () {
                                var num = $(this);
                                var text = $.trim(num.find('.txt').clone().children().remove().end().text());
                                var telNumber = $('#quantity');
                                $(telNumber).val(telNumber.val() + text);
                            });

                        });

                        $(document).ready(function () {

                            $('.num').click(function () {
                                var num = $(this);
                                var text = $.trim(num.find('.txt').clone().children().remove().end().text());
                                var telNumber = $('#cardnum');
                                $(telNumber).val(telNumber.val() + text);
                            });

                        });

                        $(document).ready(function () {

                            $('.num').click(function () {
                                var num = $(this);
                                var text = $.trim(num.find('.txt').clone().children().remove().end().text());
                                var telNumber = $('#cash');
                                $(telNumber).val(telNumber.val() + text);
                            });

                        });

                        function clearing() {
                            document.getElementById("quantity").value = "";
                            document.getElementById("cardnum").value = "";
                            document.getElementById("cash").value = "";
                        }

                        function display_time() {
                            var strcount;
                            document.getElementById('todate').innerHTML = new Date();
                            tt = display_c();
                        }

                        function display_c() {
                            var refresh = 1000;

                            mytime = setTimeout('display_time()', refresh);
                        }


</script>
<style>

    p
    {
        margin: 0;
        padding: 0 0 10px 0;
        line-height: 20px;
    }
    .span4
    {
        width: 80px;
        float: left;
        margin: 0 8px 10px 8px;
    }

    .phone
    {
        margin-top: 15px;
        background: #fff;
    }
    .tel
    {
        margin-bottom: 10px;
        margin-top: 10px;
        border: 1px solid #9e9e9e;
        border-radius: 0px;
    }
    .num-pad
    {
        padding-left: 15px;
    }


    .num
    {
        border: 1px solid #9e9e9e;
        -webkit-border-radius: 999px;
        border-radius: 999px;
        -moz-border-radius: 999px;
        height: 80px;
        background-color: #fff;
        color: #333;
        cursor: pointer;
    }
    .num:hover
    {
        background-color: #9e9e9e;
        color: #fff;
        transition-property: background-color .2s linear 0s;
        -moz-transition: background-color .2s linear 0s;
        -webkit-transition: background-color .2s linear 0s;
        -o-transition: background-color .2s linear 0s;
    }
    .txt
    {
        font-size: 30px;
        text-align: center;
        margin-top: 15px;
        font-family: 'Lato' , sans-serif;
        line-height: 30px;
        color: #333;
    }
    .small
    {
        font-size: 15px;
    }

    .btn
    {
        font-weight: bold;
        -webkit-transition: .1s ease-in background-color;
        -webkit-font-smoothing: antialiased;
        letter-spacing: 1px;
    }
    .btn:hover
    {
        transition-property: background-color .2s linear 0s;
        -moz-transition: background-color .2s linear 0s;
        -webkit-transition: background-color .2s linear 0s;
        -o-transition: background-color .2s linear 0s;
    }
    .spanicons
    {
        width: 72px;
        float: left;
        text-align: center;
        margin-top: 40px;
        color: #9e9e9e;
        font-size: 30px;
        cursor: pointer;
    }
    .spanicons:hover
    {
        color: #3498db;
        transition-property: color .2s linear 0s;
        -moz-transition: color .2s linear 0s;
        -webkit-transition: color .2s linear 0s;
        -o-transition: color .2s linear 0s;
    }
    .active
    {
        color: #3498db;
    }

    @media screen and (min-width: 768px) {

        .modal-dialog {

            width: 700px; /* New width for default modal */

        }

        .modal-sm {

            width: 400px; /* New width for small modal */

        }

    }

    @media screen and (min-width: 992px) {

        .modal-lg {

            width: 950px; /* New width for large modal */

        }

    }

    .btn-huge{
        width: 100%;
        padding: 50px;
    }
</style>

