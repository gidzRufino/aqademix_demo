<?php if ($this->uri->segment(3) != '') { ?>

    <div class="tab-pane active" id="accountDetail">
        <div class="span12">
            <div class="row"> 

            <?php } ?>
            <?php if ($this->uri->segment(3) != '') { ?>

                <div class="span2 pull-left">
                    <h4>Account History</h4>
                </div>
                <div class="span1 pull-right"> 
                </div>
                <div class="span5 pull-right">
                    <span class="pull-right">
                        <button onclick="showPay()" type="button" class="btn btn-danger btn-mini"><i class="icon-fire icon-white"></i> Void Transaction</button>
                        <button onclick="showPay()" type="button" class="btn btn-success btn-mini"><i class="icon-shopping-cart icon-white"></i> Pay Now!</button>
                        <button type="button" onclick="createMe()" class="btn btn-info btn-mini"><i class="icon-user icon-white"></i> Customize Account</button>
                    </span>
                </div>

            <?php } ?>

        </div>
        <div class="row">
            <div class="span12"> 

                <?php if ($this->uri->segment(3) != '') { ?>

                    <table class="table table-hover table-responsive table-condensed"> <!-- table-condensed -->
                        <tr class="info">
                            <th class="span2" style="text-align:center">Date</th>
                            <th class="span1" style="text-align:center">Control #</th>
                            <th class="span2" style="text-align:center">Description</th>
                            <th class="span2" style="text-align:center">Charges</th>
                            <th class="span2" style="text-align:center">Credit</th>
                        </tr>
                        <?php
                        $stud_id = $searched_student->user_id;
                        $tcharge = 0;
                        $tcredit = 0;
                        $istCharge = 0;
                        $istCredit = 0;
                        $stPlanGen = 0;
                        $stLevel_id = $searched_student->grade_level_id;
                        $stPlan_id = $finance_plan->plan_id;
                        foreach ($initialLevel as $ist) {
                            if ($ist->level_id == $stLevel_id && $ist->plan_id == $stPlan_id || $ist->level_id == $stLevel_id && $ist->plan_id == $stPlanGen) {
                                ?>
                                <tr class="info">
                                    <td style="text-align:center;"><?php echo $ist->implement_date ?></td> 
                                    <td style="text-align:center;">Initial</td>        
                                    <td style="text-align:center;"><?php echo $ist->item_description ?></td>        

                                    <?php
                                    if ($ist->ch_cr == 0) {
                                        $istCharge = $ist->item_amount;
                                        $istCredit = 0;
                                        $tcharge = $tcharge + $istCharge;
                                        $dis_charge = 'PhP ' . number_format($istCharge, 2);
                                        $dis_credit = '-';
                                    } elseif ($ist->ch_cr == 1) {
                                        $istCharge = 0;
                                        $istCredit = $ist->item_amount;
                                        $tcredit = $tcredit + $istCredit;
                                        $dis_charge = '-';
                                        $dis_credit = 'PhP ' . number_format($istCredit, 2);
                                    }
                                    ?>

                                    <td style="text-align:center;"><?php echo $dis_charge ?></td>        
                                    <td style="text-align:center;"><?php echo $dis_credit ?></td>        
                                </tr>

        <?php }
    } foreach ($sTransaction as $st) {
        if ($st->stud_id == $stud_id) { ?>

                                <tr class="info">
                                    <td style="text-align:center;"><?php echo $st->tdate ?></td>
                                    <td style="text-align:center;"><?php echo $st->ref_number ?></td>
                                    <td style="text-align:center;"><?php echo $st->item_description ?></td>  

            <?php
            if ($st->charge_credit == 1) {
                $scredit = $st->d_amount;
                $tcredit = $tcredit + $scredit;
                ?>

                                        <td style="text-align:center;"> - </td>
                                        <td style="text-align:center;">PhP &nbsp;<?php echo number_format($st->d_amount, 2) ?></td>

            <?php
            } elseif ($st->charge_credit == 0) {
                $scharge = $st->d_amount;
                $tcharge = $tcharge + $scharge;
                ?>

                                        <td style="text-align:center;">PhP &nbsp;<?php echo number_format($st->d_amount, 2) ?></td>
                                        <td style="text-align:center;"> - </td>

            <?php } ?> 

                                </tr>                   

        <?php }
    } ?>
    <?php $tbalance = $tcharge - $tcredit; ?>

                        <tr>
                            <th colspan="3" style="text-align:right;"><span style="color:black; margin:3px 0;">T O T A L </span></th>
                            <th style="text-align:center;"><span style="color:#BB0000;">PhP &nbsp;<?php echo number_format($tcharge, 2) ?></span></th>
                            <th style="text-align:center;"><span style="color:#BB0000;">PhP &nbsp;<?php echo number_format($tcredit, 2) ?></span></th>
                        </tr>
                        <tr>
                            <th colspan="3" style="text-align:right;"><span style="color:black; margin:3px 0;">TOTAL BALANCE</span></th>
                            <th colspan="2" style="text-align:center;"><span style="color:#BB0000;">PhP &nbsp;<?php echo number_format($tbalance, 2) ?></span></th>
                        </tr>
                    </table>
                    <input type="hidden" name="htcharge" id="htcharge" value="<?php echo number_format($tcharge, 2) ?>" required>
                    <input type="hidden" name="htcredit" id="htcredit" value="<?php echo number_format($tcredit, 2) ?>" required>
                    <input type="hidden" name="htbalance" id="htbalance" value="<?php echo number_format($tbalance, 2) ?>" required>
<?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="span12">
<?php if ($this->uri->segment(3) != '') { ?>
                    <div class="span1 pull-right"> 
                    </div>
                    <div class="span5 pull-right">
                        <span class="pull-right">
                            <button onclick="showPay()" type="button" class="btn btn-danger btn-mini"><i class="icon-fire icon-white"></i> Void Transaction</button>
                            <button onclick="showPay()" type="button" class="btn btn-success btn-mini"><i class="icon-shopping-cart icon-white"></i> Pay Now!</button>
                            <button type="button" onclick="createMe()" class="btn btn-info btn-mini"><i class="icon-user icon-white"></i> Customize Account</button>
                        </span>
<?php } ?>
                </div>
            </div>
        </div> 
        <div class="row">
            &nbsp;
        </div>
    </div>  

    /* 
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */

