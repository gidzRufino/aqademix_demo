<div class="container-fluid">
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Point of Sales
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('canteen') ?>'">Dashboard</button>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('canteen/products') ?>'">Product Items</button>
              </div>
        </h3>
    </div>
    <div class="row">
        <div class="col-md-7">
            <ul>
                <li style="float: left; list-style: none; padding-right: 2px; width: 150px">
                    <a href="#1a" onclick="$('#box_title').html('Meals'), loadItems(1)" class="btn btn-danger btn-lg btn-group" style="width: 100%" role="button"><span class="glyphicon glyphicon-grain fa-1x"></span> <br/>Meals</a>
                </li>
                <li style="float: left; list-style: none; padding-right: 2px; width: 150px">
                    <a href="#2a" onclick="$('#box_title').html('Drinks'), loadItems(4)" class="btn btn-warning btn-lg btn-group" style="width: 100%" role="button"><span class="glyphicon glyphicon-glass fa-1x"></span> <br/>Drinks</a>
                </li>
                <li style="float: left; list-style: none; padding-right: 2px; width: 150px">
                    <a href="#3a" onclick="$('#box_title').html('Desserts'), loadItems(3)" class="btn btn-success btn-lg btn-group" style="width: 100%" role="button"><span class="glyphicon glyphicon-ice-lolly-tasted fa-1x"></span> <br/>Desserts</a>
                </li>
                <li style="float: left; list-style: none; padding-right: 2px; width: 150px">
                    <a href="#4a" onclick="$('#box_title').html('Snacks'), loadItems(2)" class="btn btn-info btn-lg btn-group" style="width: 100%" role="button"><span class="glyphicon glyphicon-glass fa-1x"></span> <br/>Snacks</a>
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
                            <input type="hidden" value="<?php echo $stamp ?>" id="trans_id" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>
        </div>
    </div>
    <div class="row-border">
        <div class="col-md-7">
            <div id="canteen_item_box">
                <h2 id="box_title" class="text-primary">Meals</h2>
                <div id="box_body">
                    
                </div>
            </div>
        </div>
        <div class="col-md-5 sidebox" id="transaction_box">
            <?php $this->load->view('canteen_transactions'); ?>
        </div>
    </div>
</div>
<input type="hidden" id="userId" name="userId" value="0" />
<div class="container">
    <div class="modal fade" id="qModal" role="dialog">
        <?php $this->load->view("quantity_modal"); ?>
    </div>
        <?php $this->load->view("credit_modal"); ?>
    <div class="modal fade" id="cashModal" role="dialog">
        <?php $this->load->view("cash_modal"); ?>
    </div>
</div>
<div id="sd"></div>
<script type="text/javascript">
    
    $(document).ready(function(){
        loadItems(1,'');
        $('.num').click(function () {
            var num = $(this);
            var text = $.trim(num.find('.txt').clone().children().remove().end().text());
            var telNumber = $('#cardnum');
            $(telNumber).val(telNumber.val() + text);
        });
        
        $('.num').click(function () {
            var num = $(this);
            var text = $.trim(num.find('.txt').clone().children().remove().end().text());
            var telNumber = $('#cash');
            $(telNumber).val(telNumber.val() + text);
        });
        
        $('.num').click(function () {
            var num = $(this);
            var text = $.trim(num.find('.txt').clone().children().remove().end().text());
            var telNumber = $('#quantity');
            $(telNumber).val(telNumber.val() + text);
        });
        
        shortcut.add("Delete",function() {
            location.reload();
        })
        shortcut.add("PageDown",function() {
            $('#creditModal').modal('show');
            setFocus()
        })
        shortcut.add("Insert",function() {
            $('#searchControls').show();
            $('#profile').hide(); 
            $('#wifi').show();
            window.setTimeout(function () { 
                document.getElementById("inputStudent").focus();
            }, 500);
        })
        
    });
    
    function avoidInvalidKeyStorkes(evtArg) {
        var evt = (document.all ? window.event : evtArg);
        var isIE = (document.all ? true : false);
        var KEYCODE = (document.all ? window.event.keyCode : evtArg.which);

        var element = (document.all ? window.event.srcElement : evtArg.target);
        var msg = "We have disabled this key: " + KEYCODE;

        if (KEYCODE >= "112" && KEYCODE <= "123") {
            if (isIE) {
                document.onhelp = function() {
                    return (false);
                };
                window.onhelp = function() {
                    return (false);
                };
            }
            evt.returnValue = false;
            evt.keyCode = 0;
            window.status = msg;
            evt.preventDefault();
            evt.stopPropagation();
            //alert(msg);
        }

        window.status = "Done";

    }


    if (window.document.addEventListener) {
        window.document.addEventListener("keydown", avoidInvalidKeyStorkes, false);
    } else {
        window.document.attachEvent("onkeydown", avoidInvalidKeyStorkes);
        document.captureEvents(Event.KEYDOWN);
    }
    
    function loadQModal(itemName, itemPrice, itemId)
    {
        $('#qModal').modal('show');
        window.setTimeout(function () { 
            document.getElementById("quantity").focus();
        }, 500);    
            $('#itemname').html(itemName);
            $('#itemprice').html(itemPrice);
            $('#itemid').html(itemId);
        
        
        
    }
    
    function loadItems(id, bld)
    {
        (bld!=""?bld:'')
        var url = "<?php echo base_url().'canteen/loadItems/'?>"+id+'/'+bld; // the script where you handle the form input.1
        $.ajax({
          type: "GET",
          url: url,
          data: 'cat_id='+id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
          //dataType:'json',
          success: function(data)
          {
               $('#box_body').html(data);
               $('#serve_option').select2();
               
                
          }
        });

       return false; 
    }

    
    
    function okbtn(itemName, itemPrice, itemId) {
        document.getElementById("cashBtn").disabled = false;
        document.getElementById("creditBtn").disabled = false;
        //var a = document.getElementById("itemid").innerHTML;
        var a = itemId;
      //  var b = document.getElementById("profit").innerHTML;
        //var x = document.getElementById("quantity").value;
        var x = 1;
        //var y = document.getElementById("itemname").innerHTML;
        var y = itemName;
        //var z = document.getElementById("itemprice").innerHTML;
        var z = itemPrice;
        //var v = sum_up(b, x);
        var option = "<button class='btn btn-primary btn-danger btn-sm delBtn' onclick='delRow(this)'><span class='glyphicon glyphicon-trash'></span></button><b hidden class='item_id'>" + a + "</b>";

        var w = sum_up(x, z);
        $('#table_trans').append(
                '<tr tr_val="'+a+'_'+x+'_'+z+'"><td>'+option+'</td><td class="num_quantity">'+x+'</td><td class="item_name">'+y+'</td><td>'+z+'</td><td class="total">'+w+'.00</td></tr>'
                );
        
        $('#totalInput').val(w);
        calc();
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

        saveData('cash', num);
        $('.delBtn').prop('disabled', true);
        document.getElementById("newTrans").disabled = false;
        document.getElementById("trans_num").innerText = "";

    }
    
    function saveData(option, num) 
    {
        
        var data = [];
        $('#table_trans tr').each(function(){
            data.push($(this).attr('tr_val'));
        });
        
        var idNum = $('#trans_id').val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'canteen/saveTransaction' ?>',
            //dataType: 'json',
            data: {
                transaction: JSON.stringify(data),
                trans_num: idNum,
                user_id: $('#userId').val(),
                csrf_test_name: $.cookie('csrf_cookie_name'),
                option : option,
                total : num
            },
            success: function (response) {
                alert(response);
                window.location.reload();
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
</script>

<!--<script type="text/javascript">


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
                            window.setTimeout(function () { 
                                document.getElementById("quantity").focus();
                            }, 500);
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
                            $('#totalInput').val(w);
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
                                data: {
                                    newData: JSON.stringify(allData),
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


</script>-->
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
<script src="<?php echo base_url(); ?>assets/js/plugins/shortcut.js"></script>
