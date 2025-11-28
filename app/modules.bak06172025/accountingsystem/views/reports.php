<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Accounting System Reports
        <?php $this->load->view('accounting_menus'); ?>
    </h3>
</div>
<div class="col-lg-12">
    <ul class="nav nav-tabs" role="tablist" id="reports">
         <li class="active"><a href="#incomeStatement">Income Statement</a></li>
         <li><a href="#addTitles">Statement of Cash Flow</a></li>
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
             <div class="col-lg-12">
                 <h5 class="text-center"><b><?php echo strtoupper($settings->set_school_name) ?></b></h5>
                 <h5 class="text-center"><b>Income Statement</b></h5>
                 <h5 class="text-center"></h5>
             </div>
             <div class="col-lg-6">
                 <div class="col-lg-12" style="margin-top:20px">
                     <h5><b>Revenue</b></h5>
                     <ul style="margin-left:0px; list-style: none">
                         <?php
                            $revenue = Modules::run('accountingsystem/getCategoryByParent', 9);
                            $totalItems =  count($revenue);
                            $i = 0;
                            $overAll=0;
                            foreach ($revenue as $rev):
                                $i++;
                                ?>
                                <li>
                                    <?php 
                                           $accountTitles = Modules::run('accountingsystem/getAccountTitles', $rev->cat_id);
                                           echo $rev->cat_name 
                                       ?>
                                    <table id="revenueTable" style="margin-left:20px; width:100%">
                                        <?php foreach($accountTitles as $act):
                                            $total = Modules::run('accountingsystem/fetchRevenue', $act->coa_id, $school_year);
                                           if($act->is_displayed): 
                                               ?>
                                               <tr id="coa_<?php echo $act->coa_id; ?>">
                                                   <td style="width:90%;"><?php echo $act->coa_name ?></td>
                                                   <td class="text-right subTotal"><b><?php echo number_format($total->row()->subTotal,2,'.',',') ?></b></td>
                                               </tr>
                                               <?php
                                                  $overAll += $total->row()->subTotal;
                                           endif;
                                        endforeach;
                                        ?>
                                        <tr>
                                            <td><b><?php echo ($i==7?'TOTAL':'') ?></b></td>
                                            <td  <?php 
                                           // $overAll = number_format($overAll,2,'.',',');
                                            echo ($i==7?'style="border-top:1px solid black; text-align:right; font-weight:bold; border-bottom: 3px double black;" id="totalColumn"':'') ?>>

                                            </td>
                                        </tr>
                                    </table>
                                </li>

                                <?php       
                                   endforeach;
                                ?>
                     </ul>
                 </div>
                 
             </div>
             <div class="col-lg-6">
                 
                 <div class="col-lg-12" style="margin-top:20px">
                     <h5><b>LESS: Expenses</b></h5>
                     
                     <?php 
                     $expenseTitle = Modules::run('accountingsystem/getAccountTitles', 17);
                     
                     ?>
                     <table id="expenseTable"  style="margin-left:20px; width:100%">
                         <?php
                     foreach($expenseTitle as $exp):
                        if($exp->is_displayed):
                            $expenseTotal = Modules::run('accountingsystem/fetchExpense', $exp->coa_id);
                            
                            ?>
                            <tr>
                                <td style="width:90%;"><?php echo $exp->coa_name ?></td>
                                <td class="text-right"><b><?php echo number_format($expenseTotal->row()->subTotal,2,'.',',') ?></b></td>
                            </tr>
                            <?php
                        endif;
                     endforeach;
                                 
                                    //
                                    
                            
                             ?>
                         <?php?>
                     </table>
                           
                     
                 </div>
             </div>
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
     
      $('#totalColumn').html('<?php echo number_format($overAll,2,'.',',') ?>')
      
      $('#tableRevenue').each()
    });
    
    function getReportsByYear(year)
    {
        document.location = '<?php echo base_url('accountingsystem/reports/');?>'+year;
    }
</script>
    
    