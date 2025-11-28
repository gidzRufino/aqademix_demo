<div class="col-lg-12">
    <h3 style="margin:10px 0;" class="page-header">Finance Accounts
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location = '<?php echo base_url('main/dashboard') ?>'">Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location = '<?php echo base_url('finance') ?>'">Settings</button>
            <button type="button" class="btn btn-default" onclick="$('#searchOR').modal('show')" >Search OR</button>
            <button type="button" class="btn btn-default" onclick="document.location = '<?php echo base_url('college/finance/accounts') ?>'" >College Accounts</button>


        </div>
    </h3>
    <div class='col-lg-12'>

        <div class="row" id="searchWrapper">
            <div class="col-lg-1"></div>
            <div class="col-lg-8">
                <div class="input-group col-lg-12">
                    <input onkeyup="search(this.value)" id="searchBox" class="form-control input-lg" type="text" placeholder="Search Name Here" />
                    <div onblur="$(this).hide()" style="min-height: 30px; margin-top:46px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none" class="resultOverflow" id="searchName">

                    </div>
                    <div class="input-group-btn">
                        <button style="height: 46px; width: 150px;" type="button" class="btn btn-default dropdown-toggle" id="btnControl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $school_year . ' - ' . ($school_year + 1) ?> <span class="caret"></span></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <?php
                            $ro_years = Modules::run('registrar/getROYear');

                            foreach ($ro_years as $ro) {
                                $roYears = $ro->ro_years + 1;
                                ?>    
                                <li onclick="$('#btnControl').html('<?php echo $ro->ro_years . ' - ' . $roYears; ?>  <span class=\'caret\'></span>'), $('#inputSchoolYear').val('<?php echo $ro->ro_years ?>')"><a href="#"><?php echo $ro->ro_years . ' - ' . $roYears; ?></a></li>
                            <?php } ?>
                        </ul> 
                        <input type="hidden" id="inputSchoolYear" value="<?php echo $school_year ?>" />

                    </div><!-- /btn-group -->

                </div>
            </div>
            <div class="col-lg-2">
                <select tabindex="-1" id="inputSem" style="width:200px; font-size: 15px;" class=" ">
                    <option value="0">Regular School Year</option>
                    <option value="3">Summer</option>
                </select>
            </div>
        </div>

        <div class='col-lg-12'  id="AccountBody">
            <?php
            if ($id != NULL):
                echo Modules::run('finance/loadAccountDetails', $id, $school_year, $semester);
            endif;
            ?>
        </div>
    </div>
</div>
<div id="searchOR"  style="width:50%; margin: 70px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green" style='width:100%;'>
        <div class="panel-heading">
            <h3>
                <i class="fa fa-info-circle fa-fw"></i> Search Receipts
                <button class="btn btn-danger pull-right btn-sm" data-dismiss="modal"><i class="fa fa-close"></i></button>
            </h3>
        </div>
        <div class="panel-body">
            <div class="col-lg-2"></div>
            <div class="input-group col-lg-8">
                <input onkeyup="searchOR(this.value)" id="searchReceiptBox" class="form-control input-lg" type="text" placeholder="Search Receipts Here" />
                <div onblur="$(this).hide()" style="min-height: 30px; margin-top:46px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none" class="resultOverflow" id="searchReceipt">

                </div>
                <div class="input-group-btn">
                    <button style="height: 46px; width: 150px;" type="button" class="btn btn-default dropdown-toggle" id="btnReceiptControl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $school_year . ' - ' . ($school_year + 1) ?> <span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <?php
                        $ro_years = Modules::run('registrar/getROYear');

                        foreach ($ro_years as $ro) {
                            $roYears = $ro->ro_years + 1;
                            ?>    
                            <li onclick="$('#btnReceiptControl').html('<?php echo $ro->ro_years . ' - ' . $roYears; ?>  <span class=\'caret\'></span>'), $('#inputSchoolYearReceipts').val('<?php echo $ro->ro_years ?>')"><a href="#"><?php echo $ro->ro_years . ' - ' . $roYears; ?></a></li>
                        <?php } ?>
                    </ul> 
                    <input type="hidden" id="inputSchoolYearReceipts" value="<?php echo $school_year ?>" />
                </div><!-- /btn-group -->
            </div>
            <hr class="col-lg-12" />
            <div class="col-lg-12" id="orDetails">

            </div>
        </div>
    </div>
</div>
<?php
?>

<script type="text/javascript">
    $(document).ready(function () {
        shortcut.add("alt+p", function () {
            $('#cashRegister').modal('show');
        });
        shortcut.add("shift+i", function () {
            window.setTimeout(function () {
                document.getElementById("ptAmountTendered").focus();
            }, 500);
        });
        shortcut.add("shift+0", function () {
            window.setTimeout(function () {
                document.getElementById("searchBox").focus();
            }, 500);
        });
        shortcut.add("shift+1", function () {
            setFocus();
        });
        shortcut.add("F1", function () {
            document.location = '<?php echo base_url() ?>college/finance/accounts';
        });

    });

    function loadDetails(st_id, sy, semester)
    {
       
        var url = '<?php echo base_url() . 'finance/accounts/' ?>' + st_id + '/' + sy+'/'+semester;
        document.location = url;
    }

    function loadORDetails(ref_number, sy)
    {
        var url = '<?php echo base_url() . 'finance/loadORDetails/' ?>' + ref_number + '/' + sy;
        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + ref_number, // serializes the form's elements.
            success: function (data)
            {
                $('#orDetails').html(data);
            }
        });

        return false;
    }

    function search(value)
    {
        var school_year = $('#inputSchoolYear').val()
        var url = '<?php echo base_url() . 'search/searchStudentAccountsK12/' ?>' + value + '/' + school_year+'/'+$('#inputSem').val();
        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + value, // serializes the form's elements.
            success: function (data)
            {
                $('#searchName').show();
                $('#searchName').html(data);

            }
        });

        return false;
    }

    function searchOR(value)
    {
        var school_year = $('#inputSchoolYearReceipts').val()
        var url = '<?php echo base_url() . 'finance/searchReceipt/' ?>' + value + '/' + school_year;
        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + value, // serializes the form's elements.
            success: function (data)
            {
                $('#searchReceipt').show();
                $('#searchReceipt').html(data);
            }
        });

        return false;
    }


    function numberWithCommas(x) {
        if (x == null) {
            x = 0;
        }
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }


    function avoidInvalidKeyStorkes(evtArg) {
        var evt = (document.all ? window.event : evtArg);
        var isIE = (document.all ? true : false);
        var KEYCODE = (document.all ? window.event.keyCode : evtArg.which);

        var element = (document.all ? window.event.srcElement : evtArg.target);
        var msg = "We have disabled this key: " + KEYCODE;

        if (KEYCODE >= "112" && KEYCODE <= "123") {
            if (isIE) {
                document.onhelp = function () {
                    return (false);
                };
                window.onhelp = function () {
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

</script>

<script src="<?php echo base_url(); ?>assets/js/plugins/shortcut.js"></script>

<?php
$this->load->view('financeModals');
