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
                    if($rev->cat_show): 

                    ?>
                    <li>
                        <?php    
                               $accountTitles = Modules::run('accountingsystem/getAccountTitles', $rev->cat_id);
                               $totalTitles = count($accountTitles);
                               echo $rev->cat_name 
                           ?>
                        <table id="revenueTable" style="margin-left:20px; width:100%">
                            <?php foreach($accountTitles as $act):
                                $i++;
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


                    $overAllItems = $totalItems+$totalTitles;

                            ?>
                        </table>
                    </li>

                    <?php  
                        //unset($i);
                        endif; 
                       endforeach;
                    ?>
         </ul>

                    <table style="width:105%; margin-top:20px;">
                        <tr>
                            <td style="width:90%;"><b><?php echo 'TOTAL'?></b></td>
                            <td style="text-align:right; font-weight:bold; border-bottom: 3px double black;" id="totalColumn">
                                 <?php echo number_format($overAll,2,'.',','); ?>
                            </td>
                        </tr>
                    </table>
     </div>

 </div>
 <div class="col-lg-6">

     <div class="col-lg-12" style="margin-top:20px">
         <h5><b>LESS: Expenses</b></h5>
         <ul style="margin-left:0px; list-style: none">
            <?php 
            $expense = Modules::run('accountingsystem/getCategoryByParent', 17);

            foreach ($expense as $ex):
                $expenseTitle = Modules::run('accountingsystem/getAccountTitles', $ex->cat_id);
                echo $ex->cat_name 
               ?>
             <li>
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

               </table>
             </li>     
               <?php
            endforeach;
            ?>
         
         </ul>

     </div>
 </div>