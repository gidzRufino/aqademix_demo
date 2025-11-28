<div class="col-lg-12">
 <h5 class="text-center"><b><?php echo strtoupper($settings->set_school_name) ?></b></h5>
 <h5 class="text-center"><b>Income Statements</b></h5>
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
                                   <td class="text-right subTotal"><b><?php echo number_format($total->totalBalance,2,'.',',') ?></b></td>
                               </tr>
                               <?php
                                  $overAll += $total->totalBalance;
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