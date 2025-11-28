<?php 
$total = 0;
?>
<div >
    <div style="position:absolute; top:80px; width:788px;">
            <div style="position: absolute; left:445px; ">
                <table cellpadding="0">
                    <tr>
                        <td style="text-align: right; font-size: 15px;"><?php echo date('F d, Y') ?></td>
                    </tr>
                </table>
            </div>
            <div style="position: absolute; top:50px; left:35px;">
                <table>
                        <tr>
                            <td style="text-align: left;font-size: 13px;"><?php echo $student->uid.' - '. strtoupper($student->lastname.', '.$student->firstname); ?></td>
                        </tr>
                </table>
            </div>
           <div style="position: absolute; top: 163px; left: 20px; width:560px;">
                <?php foreach ($transaction as $tr): ?>
                        <table style="width: 100%;">
                                <tr>
                                    <td style="text-align: left; width: 300px;font-size: 13px; padding-left: 20px;"><?php echo $tr->item_description ?></td>
                                    <td style="text-align: center; width: 10px;font-size: 13px;">1</td>
                                    <td style="text-align: right; width: 110px;font-size: 13px;"><?php echo number_format($tr->t_amount, 2,'.',',') ?></td>
                                    <td style="text-align: right; font-size: 13px; "><?php echo number_format($tr->t_amount, 2,'.',',') ?></td>
                                </tr>
                        </table>
                    <?php
                        $total += $tr->t_amount;
                    endforeach; ?>
            </div>
            <div style="position: absolute; top: 80px; left: 620px; width:125px; ">
                <table style="margin-top:20px;">
                        <tr>
                            <td style="text-align: left; padding-left:50px; font-size: 13px;"><?php echo number_format($total, 2,'.',',') ?></td>
                        </tr>
                </table>
                <table style="margin-top:18px;">
                        <tr>
                            <td style="text-align: left; padding-left:50px; font-size: 13px;"><?php echo number_format($total, 2,'.',',') ?></td>
                        </tr>
                </table>
                <table style="font-size: 14px; font-weight: bold; margin-top:30px;">
                        <tr>
                            <td style="text-align: left; padding-right:20px;"><?php echo number_format($total, 2,'.',',') ?></td>
                        </tr>
                </table>
            </div>
            <div style="position: absolute; top: 278px; left: 640px; width:125px; ">
                <table style="font-size: 14px; font-weight: bold; margin-top:30px;">
                        <tr>
                            <td style="text-align: center; padding-right:20px; width:200px;"><?php echo strtoupper($this->session->name) ?></td>
                        </tr>
                </table>

            </div>
    </div>  
        <?php $total = 0; ?>
<!--        <div style="position:absolute; top:600px; width:100%;">
            <div style="position: absolute; left:445px;  ">
                <table cellpadding="0" >
                    <tr>
                        <td style="text-align: right; font-size: 15px;"><?php echo date('F d, Y') ?></td>
                    </tr>
                </table>
            </div>
            <div style="position: absolute; top:50px; left:35px;">
                <table>
                        <tr>
                            <td style="text-align: left;font-size: 13px;"><?php echo $student->uid.' - '. strtoupper($student->lastname.', '.$student->firstname); ?></td>
                        </tr>
                </table>
            </div>
           <div style="position: absolute; top: 163px; left: 20px; width:560px; ">
                <?php foreach ($transaction as $tr): ?>
                        <table style="width: 100%;">
                                <tr>
                                    <td style="text-align: left; width: 300px;font-size: 13px; padding-left: 20px;"><?php echo $tr->item_description ?></td>
                                    <td style="text-align: center; width: 5px;font-size: 13px;">1</td>
                                    <td style="text-align: right; width: 110px;font-size: 13px;"><?php echo number_format($tr->t_amount, 2,'.',',') ?></td>
                                    <td style="text-align: right; font-size: 13px; "><?php echo number_format($tr->t_amount, 2,'.',',') ?></td>
                                </tr>
                        </table>
                    <?php
                        $total += $tr->t_amount;
                    endforeach; ?>
            </div>
            <div style="position: absolute; top: 80px; left: 620px; width:125px; ">
                <table style="margin-top:20px;">
                        <tr>
                            <td style="text-align: left; padding-left:50px; font-size: 13px;"><?php echo number_format($total, 2,'.',',') ?></td>
                        </tr>
                </table>
                <table style="margin-top:18px;">
                        <tr>
                            <td style="text-align: left; padding-left:50px; font-size: 13px;"><?php echo number_format($total, 2,'.',',') ?></td>
                        </tr>
                </table>
                <table style="font-size: 14px; font-weight: bold; margin-top:30px;">
                        <tr>
                            <td style="text-align: left; padding-right:20px;"><?php echo number_format($total, 2,'.',',') ?></td>
                        </tr>
                </table>
            </div>
            <div style="position: absolute; top: 278px; left: 640px; width:125px; ">
                <table style="font-size: 14px; font-weight: bold; margin-top:30px;">
                        <tr>
                            <td style="text-align: center; padding-right:20px; width:200px;"><?php echo strtoupper($this->session->name) ?></td>
                        </tr>
                </table>

            </div>
    </div>-->
</div>    
