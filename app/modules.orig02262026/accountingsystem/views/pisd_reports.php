<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Accounting System Reports
        <?php $this->load->view('accounting_menus'); ?>
    </h3>
</div>
<div class="col-lg-12">
    <ul class="nav nav-tabs" role="tablist" id="reports">
         <li class="active"><a href="#incomeStatement">Income Statement</a></li>
         <li><a href="#trialBalance">Trial Balance</a></li>
         <li><a href="#balanceSheet">Balance Sheet</a></li>
         <li class="pull-right">
            <select onclick="getReportsByYear(this.value)" tabindex="-1" id="inputSY" style="width:200px; font-size: 15px;">
                <option>School Year</option>
                <?php 
                      foreach ($ro_year as $ro)
                       {   
                          $roYears = $ro->ro_years+1;
                          if($school_year==$ro->ro_years):
                              $selected = 'Selected';
                          else:
                              $selected = '';
                          endif;
                      ?>                        
                    <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$roYears; ?></option>
                    <?php }?>
            </select>
         </li>
     </ul>
    <div class="tab-content col-lg-12 no-padding">
         <div class="col-lg-12 tab-pane active" id="incomeStatement" style="padding-top: 15px;">
             <?php $this->load->view(strtolower($settings->short_name).'_incomeStatement') ?>
         </div>
        <div class="col-lg-12 tab-pane" id="trialBalance" style="padding-top: 15px;">
            <?php 
                if(file_exists(APPPATH.'modules/accountingsystem/views/'. strtolower($settings->short_name).'_trialBalance.php')):
                    $this->load->view(strtolower($settings->short_name).'_trialBalance');
                else:    
                    $this->load->view('trialBalance');
                endif;
            ?>
        </div>
        <div class="col-lg-12 tab-pane" id="balanceSheet" style="padding-top: 15px;">
            <?php $this->load->view('balanceSheet'); ?>
        </div>
    </div>
</div>

<?php $this->load->view('transaction_modal');?>
<?php $this->load->view('disbursement_modal'); ?>

<script type="text/javascript">
    
    $(document).ready(function(){
        $('#reports a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      });
     
     // $('#totalColumn').html('<?php echo number_format($overAll,2,'.',',') ?>')
      
      $('#tableRevenue').each()
    });
    
    function getReportsByYear(year)
    {
        document.location = '<?php echo base_url('accountingsystem/reports/');?>'+year;
    }
</script>
    
    