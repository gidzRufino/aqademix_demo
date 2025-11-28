<?php 
$total = 0;
?>
<page size="Letter" layout="portrait">
    <div style="position:relative; top:70px;">
        <div style="position: relative;">
            <table cellpadding="0" style="width:320px; margin:0 auto 0">
                <tr>
                    <td style="text-align: right; font-size: 15px;"><?php echo date('F d, Y') ?></td>
                </tr>
            </table>
        </div>
      <!-- <div style="position: relative; top:90px; left:20px;">
            <table style="width:90%;">
                    <tr>
                        <td style="text-align: left;font-size: 13px;"><?php echo $student->uid.' - '. strtoupper($student->lastname.', '.$student->firstname); ?></td>
                    </tr>
            </table>
        </div>
        <div style="position: relative; top: 185px; left: 20px; width:70%; border-right:1px solid black;">
            <?php foreach ($transaction as $tr): ?>
                    <table style="width: 100%;">
                            <tr>
                                <td style="text-align: left; width: 330px;font-size: 13px; padding-left: 20px;"><?php echo $tr->item_description ?></td>
                                <td style="text-align: left; width: 15px;font-size: 13px;">1</td>
                                <td style="text-align: right; width: 100px;font-size: 13px;"><?php echo number_format($tr->t_amount, 2,'.',',') ?></td>
                                <td style="text-align: right; font-size: 13px; "><?php echo number_format($tr->t_amount, 2,'.',',') ?></td>
                            </tr>
                    </table>
                <?php
                    $total += $tr->t_amount;
                endforeach; ?>
        </div>
        <div style="position: relative; top: 80px; left: 620px; width:25%; ">
            <table style="width:100%; ">
                    <tr>
                        <td style="text-align: left; padding-left:70px;"><?php echo number_format($total, 2,'.',',') ?></td>
                    </tr>
            </table>
            <table style="width:100%;margin-top:20px;">
                    <tr>
                        <td style="text-align: left; padding-left:70px;"><?php echo number_format($total, 2,'.',',') ?></td>
                    </tr>
            </table>
            <table style="width:100%; font-size: 14px; font-weight: bold; margin-top:35px;">
                    <tr>
                        <td style="text-align: left; padding-right:20px;"><?php echo number_format($total, 2,'.',',') ?></td>
                    </tr>
            </table>
        </div> -->
    </div>  
    <?php $total = 0; ?>
    <div style="position:relative; top:588px;"></div>
    <div style="position:relative; top:588px;">
        <div style="position: relative;">
            <table cellpadding="0" style="width:320px; margin:0 auto 0">
                <tr>
                    <td style="text-align: right; font-size: 15px;"><?php echo date('F d, Y') ?></td>
                </tr>
            </table>
        </div>
       <!-- <div style="position: relative; top:90px; left:20px;">
            <table style="width:90%;">
                    <tr>
                        <td style="text-align: left;font-size: 13px;"><?php echo $student->uid.' - '. strtoupper($student->lastname.', '.$student->firstname); ?></td>
                    </tr>
            </table>
        </div>
        <div style="position: relative; top: 185px; left: 20px; width:70%; border-right:1px solid black;">
            <?php foreach ($transaction as $tr): ?>
                    <table style="width: 100%;">
                            <tr>
                                <td style="text-align: left; width: 330px;font-size: 13px; padding-left: 20px;"><?php echo $tr->item_description ?></td>
                                <td style="text-align: left; width: 15px;font-size: 13px;">1</td>
                                <td style="text-align: right; width: 100px;font-size: 13px;"><?php echo number_format($tr->t_amount, 2,'.',',') ?></td>
                                <td style="text-align: right; font-size: 13px; "><?php echo number_format($tr->t_amount, 2,'.',',') ?></td>
                            </tr>
                    </table>
                <?php
                    $total += $tr->t_amount;
                endforeach; ?>
        </div>
        <div style="position: relative; top: 80px; left: 620px; width:25%; ">
            <table style="width:100%; ">
                    <tr>
                        <td style="text-align: left; padding-left:70px;"><?php echo number_format($total, 2,'.',',') ?></td>
                    </tr>
            </table>
            <table style="width:100%;margin-top:20px;">
                    <tr>
                        <td style="text-align: left; padding-left:70px;"><?php echo number_format($total, 2,'.',',') ?></td>
                    </tr>
            </table>
            <table style="width:100%; font-size: 14px; font-weight: bold; margin-top:35px;">
                    <tr>
                        <td style="text-align: left; padding-right:20px;"><?php echo number_format($total, 2,'.',',') ?></td>
                    </tr>
            </table>
        </div>-->
    </div>
   
</page>
