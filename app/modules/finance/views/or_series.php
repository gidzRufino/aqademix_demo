<div class="col-lg-12">
    <h3 style="margin:10px 0;" class="page-header">Finance Settings
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('finance/accounts') ?>'">Accounts</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('finance') ?>'">Settings</button>
          </div>
    </h3>
    <div class='col-lg-12'>
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Use Automated OR Printing</label><br />
                        <div class="form-check form-check-inline pull-left">
                            <input onclick="setPrintSettings(1)" class="form-check-input" <?php echo ($FinSettings->print_receipts==1?'checked=""':'') ?> type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1">
                            <label class="form-check-label" for="inlineRadio1">Yes &nbsp;&nbsp;</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input  onclick="setPrintSettings(0)" class="form-check-input" <?php echo ($FinSettings->print_receipts==0?'checked=""':'') ?> type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2">
                            <label class="form-check-label" for="inlineRadio2">No</label>
                          </div>
                    </div>   
                </div>
            </div>
            
            <div class="panel panel-primary">
                <div class="panel-heading">Currently Loaded OR Series
                    <button class="btn btn-warning btn-xs pull-right" onclick="$('#addORSeries').modal('show')">Add OR Series</button>
                </div>
                <div class="panel-body" style="min-height: 200px;">
                    <table class="table table-striped">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Beginning Series</th>
                            <th class="text-center">Ending Series</th>
                            <th class="text-center">Currently Loaded OR</th>
                            <th class="text-center">Last Printed Date</th>
                            <th></th>
                        </tr>
                        <?php 
                        $i = 1;
                        foreach ($ORSeries as $or): ?>
                        <tr>
                            <td class="text-center"><?php echo $i++ ?></td>
                            <td class="text-center"><?php echo $or->or_begin ?></td>
                            <td class="text-center"><?php echo $or->or_end ?></td>
                            <td class="text-center"><?php echo $or->or_current+1 ?></td>
                            <td class="text-center"><?php echo ($or->or_last_printing!='0000-00-00 00:00:00'?date('F d, Y g:i:s', strtotime($or->or_last_printing)): 'Nothing Printed') ?></td>
                            <td><button onclick="useSeries(<?php echo $or->or_id ?>)" class="btn btn-danger btn-xs <?php echo ($or->or_status?'disabled':'') ?>">Use Series</button></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
  

<!--Modals-->

<div id="addORSeries" style="width:35%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading clearfix">
            <h6 class="col-lg-8">Add OR Series</h6>
            <button class="btn btn-xs btn-danger pull-right" data-dismiss="modal"><i class="fa fa-close"></i></button>
            
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label>Beginning Series</label>
                <input onblur="getSeries()"  type="text" id="or_begin" class="form-control"  placeholder="Beginning Series" />
            </div>
            <div class="form-group">
                <label>Ending Series</label>
                <input onblur="getSeries()" type="text" id="or_end" class="form-control"  placeholder="Ending Series" />
            </div>
            
            <div class="form-group">
                <label>Currently Loaded OR</label> <br />
                <select style="width:100%;"  name="inputCSY" id="or_current" required>
                </select>
            </div>
            
        </div>
        <div class="panel-footer clearfix">
            <button id="addSeriesBtn" class="btn btn-success pull-right">ADD Series</button>
        </div>
    </div>
</div>

<!--scripts-->

<script type="text/javascript">
    
    function getSeries()
    {
        var begin = $('#or_begin').val();
        var end = $('#or_end').val();
        if(begin!=0 && begin!="")
        {
            for(var i=begin; i<=end; i++ ){
                $('#or_current').append("<option value='"+i+"'>"+i+"</option>");
            }
        }
    }
    
    function useSeries(id)
    {
         $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/useSeries' ?>',
            //dataType: 'json',
            data: {
                id: id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                location.reload();
            }

        });
    }
    
    function setPrintSettings(id)
    {
         $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/setPrintSettings/' ?>'+id,
            //dataType: 'json',
            data: {
                id: id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                location.reload();
            }

        });
    }
    
    $('#addSeriesBtn').click(function(){
        var begin = $('#or_begin').val();
        var end = $('#or_end').val();
        var current = $('#or_current').val();
        
         $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/addSeries' ?>',
            //dataType: 'json',
            data: {
                beginning: begin,
                ending: end,
                current:current,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                location.reload();
            }

        });
    });
    
    
    
</script>
