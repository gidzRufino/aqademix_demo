<div class="row"><?php echo $filePath; ?>
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Collection Report 
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url() ?>'">Dashboard</button>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('finance/accounts') ?>'">Accounts</button>
                <button type="button" class="btn btn-default" onclick="generateCollectible()">Generate Collectible</button>
                <div class="form-group pull-right">
                    <select onclick="getStudentByYear(this.value)" tabindex="-1" id="inputSY" style="height:35px; width:200px; font-size: 15px;">
                        <option>School Year</option>
                        <?php 
                            $sySelect = ($this->uri->segment(8) != '' ? $this->uri->segment(8) : $this->session->school_year);
                            foreach ($ro_year as $ro)
                            {   
                                $roYears = $ro->ro_years+1;
                                if($sySelect == $ro->ro_years):
                                    $selected = 'Selected';
                                else:
                                    $selected = '';
                                endif;
                            ?>                        
                            <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$roYears; ?></option>
                            <?php }?>
                    </select>
                </div>
                <div class="form-group pull-right">
                    <select name="finSem" id="finSem" style="height:35px; width: 100%; font-size: 15px;" required title="Select Semester">
                        <option <?php echo ($this->uri->segment(7) == 0 ? 'selected' : '') ?> value="0">Regular Class</option>
                        <option <?php echo ($this->uri->segment(7) == 3 ? 'selected' : '') ?> value="3">Summer Class</option>
                    </select>
                </div>
            </div>
        </h3>
    </div>
    <div class="col-lg-12" style="margin-bottom: 10px;">
        <div class="row pull-right">
            <input name="startDate" type="text" data-date-format="yyyy-mm-dd" value="<?php echo ($this->uri->segment(3)==NULL?date('Y-m-d'):$this->uri->segment(3)) ?>" id="startDate" placeholder="Select Start Date" />
            <input  name="endDate" type="text" data-date-format="yyyy-mm-dd" value="<?php echo ($this->uri->segment(4)==NULL?date('Y-m-d'):$this->uri->segment(4)) ?>" id="endDate" placeholder="Select End Date" />
            
            <div class="btn-group pull-right" role="group" aria-label="">
                <button onclick="generateCollection()" type="button" class="btn btn-medium btn-primary">Generate Collection</button>
                <button onclick="printSales($('#reportType').val())" type="button" class="btn btn-medium btn-info">Print</button>
            </div>
            <!-- <div class="form-group pull-right">
                <select tabindex="-1" id="finCat" name="finCat" class="col-lg-12">
                    <option value="0" readonly>Select Category</option>
                   <?php
                   
                //    foreach($finCat as $f) {
                    ?>
                    <option value="<?php // echo $f->item_id ?>" <?php // echo ($f->item_id == segment_6 ? 'selected' : ''); ?>><?php // echo $f->item_description ?></option>
                    <?php
                   //}
                   ?>
               </select>
             </div> -->
            <div class="form-group pull-right">
                <select tabindex="-1" id="reportType" name="reportType"  class="col-lg-12" style="height:35px; width:200px; font-size: 15px;">
                   <option value="0">Report Per Account</option>
                   <option value="1">Report Per Item</option>
                   
               </select>
             </div>
            <div class="form-group pull-right">
                <select tabindex="-1" id="glevel" name="glevel"  class="col-lg-12" style="height:35px; width:200px; font-size: 15px;">
                    <option value="0">Select Grade Level</option>
                  <?php
                  foreach ($dept_level as $d):
                    $select = ($d->grade_id == $level ? 'selected' : '');
                    echo '<option ' . $select . '  value="' . $d->grade_id . '">' . $d->level . '</option>';
                  endforeach;
                  ?>
               </select>
             </div>
        </div>
    </div>
    <div class="col-lg-2"></div>
    <div id="salesTable" class="col-lg-8">
        <table class="table table-striped">
            <tr>
                <th style="width:10%;">Date</th>
                <th style="width:10%;">OR #</th>
                <th style="width:30%;">Account Name</th>
                <th style="width:30%;">Particulars</th>
                <th style="width:30%;">Teller</th>
                <th style="width: 40%; text-align: right;">Amount</th>
            </tr>
            <tbody id="salesBody">
                    <?php 
                        $total = 0;
                        $overAll = 0;
                        foreach($collection as $d):
                            foreach($d as $c):
                                if($c->t_type != 3 && $c->t_type!=5):
                                    $ctype = $c->acnt_type;
                                    $a_id = $c->t_st_id;
                                    if ($ctype!=1) {
                                    $overAll += $c->t_amount;
                                    $account_name = strtoupper($c->lastname.', '.$c->firstname); 
                                    $grade_level = $c->level;
                                    $teller = Modules::run('hr/getEmployeeName',$c->t_em_id);
                                    $tellerName = strtoupper(substr($teller->firstname, 0,1).'. '.$teller->lastname);

                                    ?>

                                    <tr>
                                        <td><?php echo $c->t_date ?></td>
                                        <td><?php echo $c->ref_number ?></td>
                                        <td><?php echo $account_name ?></td>
                                        <td><?php echo $c->item_description ?></td>
                                        <td><?php echo $tellerName ?></td>
                                        <td style="text-align: right;"><?php echo number_format($c->t_amount, 2, '.',',')?></td>
                                    </tr>
                                    <?php
                                    }
                                    unset($total);
                                endif;
                            endforeach;   
                        endforeach;
                        $cancelReceipt = $this->finance_model->getCollection($from, $to, 3, $school_year);
                        foreach($cancelReceipt->result() as $cr): 
                            $ctype = $cr->acnt_type;
                            $a_id = $cr->t_st_id;
                              $account_name = strtoupper($cr->lastname.', '.$cr->firstname); 
                              $grade_level = $cr->level;
                              $teller = Modules::run('hr/getEmployeeName',$cr->t_em_id);
                              $tellerName = strtoupper(substr($teller->firstname, 0,1).'. '.$teller->lastname);
                              
                            ?>

                            <tr class="strikeout">
                                <td><?php echo $cr->t_date ?></td>
                                <td><?php echo $cr->ref_number ?></td>
                                <td><?php echo $account_name ?></td>
                                <td><?php echo $tellerName ?></td>
                                <td style="text-align: right;"><?php echo number_format($cr->t_amount, 2, '.',',')?></td>
                            </tr>
                        <?php
                        endforeach;
                            if($overAll!=0):
                        ?>
                            <tr>
                                <th colspan="5"></th>
                                <th style="text-align: right;"> <?php echo number_format($overAll, 2, '.',',') ?></th>
                            </tr>
                        <?php
                            endif;
                            
                        ?>
                </tbody>
        </table>
    </div>
    <div class="col-lg-2">
                <label for="example-multiple-select">Select Category:</label><br />
                <em style="color: gray; font-size: 9pt">Press and Hold Ctrl on keyboard to select multiple</em>
                <select id="finCat" name="finCat" multiple="multiple" class="col-lg-12" style="height: 420px">
                <?php
                   $cs = explode('-', $catSelected);
                   foreach($finCat as $f) {
                        for($x = 0; $x < count($cs); $x++):
                            if ($cs[$x] == $f->item_id):
                                $selected = 'selected';
                                break;
                            else:
                                $selected = '';
                            endif;
                        endfor;
                    ?>
                    <option <?php echo $selected ?> style="padding: 5px" value="<?php echo $f->item_id ?>" <?php //echo ($f->item_id == segment_6 ? 'selected' : ''); ?>><?php echo $f->item_description ?></option>
                    <?php
                   }
                   ?>
                </select>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#finCat').multiselect({
            includeSelectAllOption: true,
            buttonWidth: '100%',
            nonSelectedText: 'Select options',
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
        });
    });

    $('#startDate').datepicker({
        orientation: 'left'
    });
    $('#endDate').datepicker({
        orientation: 'left'
    });
    
     function generateCollectible()
    {
        var url = document.location='<?php echo base_url('finance/getCollectible/') ?>'+$('#inputSY').val()+'/1';
        
        document.location = url;
    }
    
     function generateCollection()
    {
        if($('#finCat').val() != null) {
            const cat = $('#finCat').val().toString();
            var arrCat = cat.replaceAll(',', '-');
        } else {
            var arrCat = 0;
        }

        // var url = '<?php echo base_url() . 'finance/collectionReport/' ?>'+$('#startDate').val()+'/'+$('#endDate').val()+'/'+$('#reportType').val()+'/'+$('#finCat').val();
        var url = '<?php echo base_url() . 'finance/collectionReport/' ?>'+$('#startDate').val()+'/'+$('#endDate').val()+'/'+$('#reportType').val()+'/'+arrCat + '/' + $('#finSem').val() + '/' + $('#inputSY').val() + '/' + $('#glevel').val();
        
        document.location = url;
    }
    
     function printSales(option)
    {
        if ($('#finCat').val() != null) {
            const cat = $('#finCat').val().toString();
            var arrCat = cat.replaceAll(',', '-');
        } else {
            var arrCat = 0;
        }

        switch(option)
        {
            case '0':
                var url = '<?php echo base_url() . 'finance/printCollectionReport/' ?>' + $('#startDate').val() + '/' + $('#endDate').val() + '/' + option + '/' + arrCat + '/' + $('#finSem').val() + '/' + $('#inputSY').val() + '/' + $('#glevel').val();
        
                window.open(url, '_blank');
            break;
            case '1':
                var url = '<?php echo base_url() . 'finance/printCollectionReportPerTeller/'.base64_encode($this->session->employee_id) ?>/'+$('#startDate').val()+'/'+$('#endDate').val();
        
                window.open(url, '_blank');
            break;
        }
        
    }
 
    function getSales()
    {
         $.ajax({
               type: 'GET',
               url: '<?php echo base_url() . 'canteen/getSales/' ?>'+$('#startDate').val()+'/'+$('#endDate').val(),
               data: 'csrf_test_name='+$.cookie('csrf_cookie_name'),
               success: function (response) {
                   //    alert(response);
                   $('#salesBody').html(response);
               }
           });
    }
    

</script>    