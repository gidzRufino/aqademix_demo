<?php
$total = 0;
//$stInfo = Modules::run('college/finance/getStudentInfo',)
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
        <div style="position: absolute; left:30px; top: 35px">
            <table cellpadding="0">
                <tr>
                    <td style="text-align: right; font-size: 15px;"><?php echo $ornum ?></td>
                </tr>
            </table>
        </div>
        <div style="position: absolute; left:550px; top: 45px">
            <table cellpadding="0">
                <tr>
                    <!--<td style="text-align: right; font-size: 15px;"><?php echo date('F d, Y') ?></td>-->
                    <td id="ordate" style="text-align: right; font-size: 15px;"><?php echo $tDate?></td>
                </tr>
            </table>
        </div>
        <div style="position: absolute; top:127px; left:50px;">
            <table>
                <tr>
                    <td style="text-align: left;font-size: 15px;"><?php echo $student->uid; ?></td>
                </tr>
            </table>
        </div>
        <div style="position: absolute; top:127px; left:210px;">
            <table>
                <tr>
                    <td style="text-align: left;font-size: 15px;"><?php echo strtoupper($student->lastname . ', ' . $student->firstname); ?></td>
                </tr>
            </table>
        </div>
        <?php
        switch ($student->year_level):
            case 1:
                $st_level = 'I';
                break;
            case 2:
                $st_level = 'II';
                break;
            case 3:
                $st_level = 'III';
                break;
            case 4:
                $st_level = 'IV';
                break;
        endswitch;
        ?>
        <div style="position: absolute; top:129px; left:550px;">
            <table>
                <tr>
                    <td style="text-align: left;font-size: 15px;"><?php echo strtoupper($student->short_code) . ' - ' . $st_level; ?></td>
                </tr>
            </table>
        </div>
        <div style="position: absolute; top:165px; left:210px;">
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
                    <td style="text-align: left;font-size: 15px;width:645px;"><?php echo $numwords.'( ₱ '.number_format($total, 2).' )'; ?></td>
                </tr>
            </table>

        </div>
        <div style="position: absolute; top:260px; left:30px;">
            <table>
                <?php
                $itm_desc = array();
                $x = 0;
                $y = 0
                ?>
                <?php 
                //print_r($transaction);
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
                        <td style="width: 420px; font-size: 15px"><?php echo $description.$remarks ?></td>
                        <td style="font-size: 15px; text-align: right">&#8369;&nbsp;<?php echo number_format($desc->t_amount, 2) ?></td>
                    </tr>

                    <?php
                endforeach;
//                    foreach ($transaction as $desc):
//                        $itm_desc[] = $desc->item_description;
//                    endforeach;
//                    $str_desc = implode(',',$itm_desc);
                ?>


            </table>
        </div>
        <div style="position: absolute; top:390px; left:320px; font-size: 15px">
            <div>&#8369;&nbsp;<?php echo number_format($total, 2) ?></div>
        </div>
        <div style="position: absolute; top:390px; left:540px; font-size: 15px">
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