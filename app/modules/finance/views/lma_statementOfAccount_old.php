<div class="col-lg-12">
    <div class='panel panel-red'>
        <div class='panel-heading clearfix'>
            <h5 class="pull-left">Student Billing Status History</h5>
        </div>
        <div class='panel-body'>
            <table class="table">
                <tr>
                    <th style="width:20%;">Charge Description</th>
                    <th style="width:30%;" class="text-center">Month</th>
                    <th class="text-right">Amount</th>
                    <th class="text-right">Amount Due</th>
                    <th class="text-center">Status</th>
                </tr>
                <?php 
                for($i = 1; $i<=$numMonth; $i++):
                    $status = 'UNPAID';
                    $color = 'alert-info';
                    $show = '';
                    $expectedPayment = $monthlyFee * $i;
                
                    
                    $monthNums = (($i+5)+$addMonth);
                    $monthNum = ($monthNums>12?$monthNums-12:$monthNums);
                    $monthNum = ($monthNum < 10?'0'.$monthNum:$monthNum);
                    
                    $cy = (date('Y')>$this->session->school_year?date('Y'):(abs($monthNum)<6?($this->session->school_year+1):$this->session->school_year));
                    
                    
                    $mop = Modules::run('finance/getMOP', $btype);
                    
                    if($totalPaymentLessDP<$expectedPayment):
                        switch ($btype):
                            case 1: // Monthly
                                $m = Modules::run('finance/billing/getBillingSched',$btype, abs($monthNum));
                                if(abs(date('m'))==($i+5)):
                               // echo $m->row()->bill_date.' > '.date('Y-m-d').'<br />';
                                    if( strtotime($m->row()->bill_date) > strtotime(date('Y-m-d'))):
                                        $status = 'UNPAID';
                                        $color = 'alert-info';
                                        $penalty = 0;
                                    else:
                                        //$status = 'OVERDUE';
                                        $color = 'alert-danger';
                                        if($isPriviledge):
                                            $penalty = $mop->special_penalty;
                                        else:
                                            $penalty = $mop->regular_penalty;
                                        endif;
                                        
                                        Modules::run('finance/billing/savePenalty', $st_id,$monthNum,$penalty, $this->session->school_year);
                                    endif;
                                else:
                                    if($isPriviledge):
                                        $penalty = $mop->special_penalty;
                                    else:
                                        $penalty = $mop->regular_penalty;
                                    endif;
                                    $status = 'OVERDUE';
                                    $color = 'alert-danger';
                                    //echo $m->row()->bill_date;
                                    if( strtotime($m->row()->bill_date) < strtotime(date('Y-m-d'))):
                                        Modules::run('finance/billing/savePenalty', $st_id,$monthNum,$penalty,$this->session->school_year);
                                    endif;
                                endif;
                            break;    
                            case 2: 
                                $q = Modules::run('finance/billing/getBillingSched',$btype, abs($monthNum));
                                
                                //echo $q->row()->bill_date.' > '.date('Y-m-d').'<br />';
                                if( strtotime($q->row()->bill_date) > strtotime(date('Y-m-d'))):
                                    $status = 'UNPAID';
                                    $color = 'alert-info';
                                else:
                                    $status = 'OVERDUE';
                                    $color = 'alert-danger';
                                    if($isPriviledge):
                                        $penalty = $mop->special_penalty;
                                    else:
                                        $penalty = $mop->regular_penalty;
                                    endif;
                                        Modules::run('finance/billing/savePenalty', $st_id,$monthNum,$penalty, $this->session->school_year);
                                endif;
                                
                            break;    
                            
                            case 3:
                                $q = Modules::run('finance/billing/getBillingSched',$btype, abs($monthNum));
                                echo $expectedPayment.' | '.$totalPaymentLessDP ;
                                //echo $q->row()->bill_date.' > '.date('Y-m-d').'<br />';
                                if( strtotime($q->row()->bill_date) > strtotime(date('Y-m-d')) ):
                                    $status = 'UNPAID';
                                    $color = 'alert-info';
                                else:
                                    $status = 'OVERDUE';
                                    $color = 'alert-danger';
                                    if($monthNum==6 || $monthNum==10):
                                        if($isPriviledge):
                                            $penalty = $mop->special_penalty;
                                        else:
                                            $penalty = $mop->regular_penalty;
                                        endif;
                                            Modules::run('finance/billing/savePenalty', $st_id,$monthNum,$penalty, $this->session->school_year);
                                    endif;        
                                endif;
                            break;    
                        endswitch;
                        
                        $show = (date('Y')>$this->session->school_year?(abs($monthNum)> abs(date('m'))?'hide':''):($monthNums > abs(date('m'))?'hide':''));
                        //echo $monthNums.' '.abs(date('m'));
                    else:
                        
                        $penalty = 0;
                        $hasPen = Modules::run('finance/billing/getPenalty',$st_id, 0, $this->session->school_year, abs($monthNums));
                        if($hasPen):
                            $penalty = $hasPen->row()->pen_amount;
                        endif;
                        $status = 'PAID';
                        $color = 'alert-success';
                    endif;
                    
                    
                ?>
                <tr class="<?php echo $color.' '.$show; ?>">
                    <td>Tuition</td>
                    <td class="text-center"><?php echo date('F', strtotime(date('Y-'.$monthNum.'-01'))) ?></td>
                    <td class="text-right"><?php echo number_format($monthlyFee,2,".",",") ?></td>
                    <td class="text-right"><?php echo number_format($monthlyFee+$penalty,2,".",",") ?></td>
                    <td class="text-center"><?php echo $status ?></td>
                </tr>
                <?php    
                    switch ($btype):
                        case 1:
                            $addM = 0;
                        break;    
                        case 2:
                            $addM = 1;
                        break;    
                        case 3:
                           $addM = 4;
                        break;    
                    endswitch;
                   $addMonth = $addMonth + $addM;
                endfor;
                ?>
            </table>
            
        </div>
    </div>
</div>