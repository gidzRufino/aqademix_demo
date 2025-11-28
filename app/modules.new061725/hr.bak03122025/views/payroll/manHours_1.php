<div class="col-lg-12 col-md-12 col-xs-12 top-away">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 pull-right">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        <input type="search" id="userSearch" class="form-control" placeholder="Search...">
                    </div>
                </div>
                <div class=" col-lg-3 col-md-3 col-sm-3 col-xs-3" >
                    <div class='input-group date'>
                        <input type="text" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d') ?>" class="form-control" id="searchDate">
                        <span class="input-group-btn">

                            <button class="btn btn-success"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive" id="demo">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td style="vertical-align: middle;" rowspan="2">Name</td>
                        <td width="9%" style="vertical-align: middle;" rowspan="2">Last Entry</td>
                        <td width="6%" style=" vertical-align: middle;" rowspan="2">Regular Hours</td>
                        <td colspan="3" class="success">Overtime</td>
                        <td colspan="3" class="info">Night Shift Differential</td>
                        <td colspan="3" class="warning">Night Differential</td>
                        <td colspan="2" class="danger">Holidays</td>
                    </tr>
                    <tr>
                        <td width="6%">Regular</td>
                        <td width="6%">Special</td>
                        <td width="6%">Holiday</td>
                        <td width="6%">Regular</td>
                        <td width="6%">Special</td>
                        <td width="6%">Holiday</td>
                        <td width="6%">Regular</td>
                        <td width="6%">Special</td>
                        <td width="6%">Holiday</td>
                        <td width="6%">Special(day/s)</td>
                        <td width="6%">Regular(day/s)</td>
                    </tr>
                </thead>
                <tbody id="time-table-body">
                </tbody>
            </table>
        </div>    
        <script type="text/javascript">
            
                $('#searchDate').datepicker({
                    orientation: 'auto'
                });
            $(document).ready(function() {
               
                const colnames = ['userName', 'userDate', 'userRegHrs', 'userRegOT',
                        'userSpOT', 'userHdOT', 'userRegNSD', 'userSpNSD', 'userHdNSD',
                        'userRegND', 'userSpND', 'userHdND', 'userRegHol', 'userSpHol'
                    ],
                    tempdata = [
                        ['Matsunada, Shinichi K.', '2018, November 15', 12, 14, 2, 15, 6, 16, 8, 12, 2, 3, 4, 1],
                        ['Matsunada, Garry V.', '2018, November 6', 130, 4, 2, 1, 2, 7, 2, 1, 2, 3, 4, 1],
                        ['Lockwood, Harkless D.', '2018, January 15', 65, 4, 2, 15, 6, 16, 8, 12, 2, 3, 4, 1],
                        ['Taxers, Snyth A.', '2018, April 12', 48, 5, 1, 1, 0, 7, 2, 1, 2, 3, 4, 1]
                    ];
                var collength = colnames.length,
                    rowlength = tempdata.length;
                for (var i = 0, j = rowlength; i < j; i++) {
                    var rowname = i,
                        tr = document.createElement("tr");
                    tr.setAttribute('id', rowname);

                    for (var k = 0, l = collength; k < l; k++) {
                        var colname = rowname + colnames[k];
                        var col = tr.insertCell(k);
                        if (k > 1) {
                            col.innerHTML = "<td ondblclick='doEdit(this.parentNode.id, this.id)'>" +
                                tempdata[i][k] + "</td>";
                            col.setAttribute('class', 'time-table');
                            col.setAttribute('id', colname);
                            col.setAttribute('ondblclick', 'doEdit(this.parentNode.id, this.id)');
                        } else {
                            col.innerHTML = "<td>" +
                                tempdata[i][k] + "</td>";
                            col.setAttribute('class', 'time-table');
                            col.setAttribute('id', colname);
                        }
                    }
                    document.getElementById('time-table-body').append(tr);
                }
            });

            function doEdit(pid, cid) {
                var index = document.getElementById(cid).cellIndex;
                var val = $("#" + pid + " #" + cid).html();
                $("#" + pid + " #" + cid).html("<input type='number' class='no-border' style='width:50px;' id='userinput' value='" + val + "'>");
                $("#userinput").focus().select();
                $("#userinput").keydown(function(e) {
                    if (e.which == 9) {
                        e.preventDefault();
                        doInsert(pid, cid, $("#userinput").val())
                        goNext(pid, cid, index);
                    } else if (e.which == 13) {
                        e.preventDefault();
                        doInsert(pid, cid, $("#userinput").val())
                    }
                });
                $("#userinput").focusout(function() {
                    doInsert(pid, cid, $("#userinput").val());
                });
            }

            function goNext(pid, cid, index) {
                var
                    newindex = index + 1,
                    col = $("#" + pid).find('td').eq(newindex),
                    newval = col.html(),
                    newid = col.attr('id');
                    col.html("<input type='number' style='width:50px;' class='no-border' id='userinput' value='" + newval + "'>");
                $("#userinput").focus().select();
                $("#userinput").on('keydown', function(e) {
                    if (e.which == 9) {
                        e.preventDefault();
                        doInsert(pid, newid, $("#userinput").val())
                        goNext(pid, newid, newindex);
                    } else if (e.which == 13) {
                        e.preventDefault();
                        doInsert(pid, newid, $("#userinput").val())
                    }
                });
                $("#userinput").focusout(function() {
                    doInsert(pid, newid, $("#userinput").val());
                });
            }

            function doInsert(pid, cid, value) {
                var obj = {
                    insert: {}
                }
                /*fs = require('fs');
                obj.insert = {
                    id: cid.replace(/\d+/g, ''),
                    value: value
                };
                fs.writeFileSync('src/pages/test.json', JSON.stringify(obj), finished);

                window.location = "customizehours.html";

                function finished(err) {}*/
                $("#" + pid + " #" + cid).html(value);
            }
        </script>
</div> 