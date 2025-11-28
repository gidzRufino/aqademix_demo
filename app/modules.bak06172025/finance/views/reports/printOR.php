<?php
$total = 0;
?>
<div >
    <div style="position:absolute; top:65px; width:950px;">
        <div style="position: absolute; left: 670px; ">
            <table cellpadding="0">
                <tr>
                    <td style="text-align: right; font-size: 15px;"></td>
                </tr>
            </table>
        </div>
        <div style="position: absolute; left:40px; top: 35px">
            <table cellpadding="0">
                <tr>
                    <td style="text-align: right; font-size: 17px;"><?php echo $ornum ?></td>
                </tr>
            </table>
        </div>
        <div style="position: absolute; left:750px; top: 35px">
            <table cellpadding="0">
                <tr>
                    <td style="text-align: right; font-size: 17px;"><?php echo date('F d, Y') ?></td>
                </tr>
            </table>
        </div>
        <div style="position: absolute; top:127px; left:50px;">
            <table>
                <tr>
                    <td style="text-align: left;font-size: 17px;"><?php echo $student->uid; ?></td>
                </tr>
            </table>
        </div>
        <div style="position: absolute; top:127px; left:280px;">
            <table>
                <tr>
                    <td style="text-align: left;font-size: 17px;"><?php echo strtoupper($student->lastname . ', ' . $student->firstname); ?></td>
                </tr>
            </table>
        </div>
        <div style="position: absolute; top:129px; left:730px;">
            <table>
                <tr>
                    <td style="text-align: left;font-size: 17px;"><?php echo strtoupper($student->level) . ' - ' . ucwords($student->section); ?></td>
                </tr>
            </table>
        </div>
        <div style="position: absolute; top:165px; left:230px;">
            <?php
            $c = 0;
            foreach ($transaction as $tr):
                $total += $tr->t_amount;
                $c++;
            endforeach;
            $numwords = Modules::run('college/finance/convert_number', $total);
            ?>
            <table>
                <tr>
                    <td style="text-align: left;font-size: 17px;width:650px;"><?php echo $numwords.'( ₱ '.number_format($total, 2).' )'; ?></td>
                </tr>
            </table>

        </div>
        <div style="position: absolute; top:270px; left:50px;">
            <table>
                <?php
                $itm_desc = array();
                $x = 0;
                $y = 0
                ?>
                <?php 
                foreach ($transaction as $desc): 
                    if($desc->fused_category == 0):
                        $des = Modules::run('college/finance/getFinanceItemById',$desc->t_charge_id);
                        
                        $description = $des->item_description;
                    else:
                        $des = Modules::run('college/finance/getFinCategory',$desc->fused_category);
                        $description = $des->fin_category;
                    endif;
                    
                    if($desc->t_remarks!=""):
                        $remarks = ' ( '.$desc->t_remarks.' )';
                    else:
                        $remarks = "";
                    endif;
                ?>
                    <tr>
                        <td style="width: 420px; font-size: 17px"><?php echo $description.$remarks ?></td>
                        <td style="font-size: 17px; text-align: right">&#8369;&nbsp;<?php echo number_format($desc->t_amount, 2) ?></td>
                    </tr>

                    <?php
                endforeach;
                ?>


            </table>
        </div>
        <div style="position: absolute; top:408px; left:410px; font-size: 17px">
            <div>&#8369;&nbsp;<?php echo number_format($total, 2) ?></div>
        </div>
        <div style="position: absolute; top:405px; left:685px; font-size: 17px">
            <div>&nbsp;<?php echo strtoupper($this->session->name) ?></div>
        </div>
        <?php $total = 0; ?>
    </div>
    <script type="text/javascript">
        window.onload = function () {
            window.print();
        }
        
        window.focus(setTimeout(window.close, 5000));
    </script>