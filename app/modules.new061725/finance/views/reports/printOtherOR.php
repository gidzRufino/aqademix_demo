<?php 
$total = 0;

?>
<page size="LetterHalf" layout="portrait">
    <div style="width:49%; padding-top: 90px; float: left;">
        <table cellpadding="0" style="width:95%; margin:0 auto 10px;">
                <tr>
                    <td style="text-align: right;"><?php echo date('F d, Y') ?></td>
                </tr>
        </table>
        <table style="width:90%; margin:0 auto;">
                <tr>
                    <td style="text-align: left; padding-left:50px;"><?php echo strtoupper($transType) ?></td>
                </tr>
        </table>
        <table style="width:90%; margin:0 auto -8px;">
                <tr>
                    <td style="text-align: left; padding-left:50px;"><?php echo $student->fo_account_id.' - '. strtoupper($student->fo_lastname.', '.$student->fo_firstname); ?></td>
                </tr>
        </table>
        <table style="width:90%; margin:0 auto -8px;">
                <tr>
                    <td style="text-align: left; padding-left:50px;"></td>
                </tr>
        </table>
        <table style="width:90%; margin:0 auto 10px;">
                <tr>
                    <td style="text-align: left; padding-left:50px;">S.Y. : <?php echo $this->session->userdata('school_year').' - '.($this->session->userdata('school_year') + 1) ?></td>
                </tr>
        </table>
        
            <?php foreach ($transaction as $tr): ?>
        <table  style="width:90%; margin:0 auto -8px;">
                <tr>
                    <td style="text-align: left; padding-left:90px;"><?php echo $tr->item_description ?></td>
                    <td style="text-align: right; "><?php echo number_format($tr->t_amount, 2,'.',',') ?></td>
                </tr>
        </table>
            <?php
                $total += $tr->t_amount;
            endforeach; ?>
        
        <table style="width:90%; margin:0 auto -8px;">
                <tr>
                    <td style="text-align: left; padding-left:90px;"><?php echo 'TOTAL' ?></td>
                    <td style="text-align: right; "><?php echo number_format($total, 2,'.',',') ?></td>
                </tr>
        </table>
        <table style="width:90%; margin:0 auto -8px;">
                <tr>
                    <td style="text-align: left; padding-left:90px;"><?php echo 'Amount Received' ?></td>
                    <td style="text-align: right; "><?php echo number_format(($this->uri->segment(6)), 2,'.',',') ?></td>
                </tr>
        </table>
        <table style="width:90%; margin:0 auto -8px;">
                <tr>
                    <td style="text-align: left; padding-left:90px;"><?php echo 'CHANGE' ?></td>
                    <td style="text-align: right; "><?php echo number_format(($this->uri->segment(6)-$total), 2,'.',',') ?></td>
                </tr>
        </table>
        <?php unset($total); ?>
    </div>
    <div style="width:50%; padding-top: 90px; float: left;">
        <table style="width:85%; margin:0 auto 10px;">
                <tr>
                    <td style="text-align: right; padding-right:10px;"><?php echo date('F d, Y') ?></td>
                </tr>
        </table>
        <table style="width:95%; margin:0 auto;">
                <tr>
                    <td style="text-align: left; padding-left:50px;"><?php echo strtoupper($transType) ?></td>
                </tr>
        </table>
        <table style="width:95%; margin:0 auto -8px;">
                <tr>
                    <td style="text-align: left; padding-left:50px;"><?php echo $student->fo_account_id.' - '. strtoupper($student->fo_lastname.', '.$student->fo_firstname); ?></td>
                </tr>
        </table>
        <table style="width:95%; margin:0 auto -8px;">
                <tr>
                    <td style="text-align: left; padding-left:50px;"><?php echo $student->level; ?></td>
                </tr>
        </table>
        <table style="width:95%; margin:0 auto 10px;">
                <tr>
                    <td style="text-align: left; padding-left:50px;">S.Y. : <?php echo $this->session->userdata('school_year').' - '.($this->session->userdata('school_year') + 1) ?></td>
                </tr>
        </table>
                
            <?php 
            $total = 0;
            foreach ($transaction as $tr): ?>
            <table  style="width:85%; margin:0 auto -8px;">
                <tr style="vertical-align: top;">
                    <td style="text-align: left; padding-left:60px;"><?php echo $tr->item_description ?></td>
                    <td style="text-align: right; "><?php echo number_format($tr->t_amount, 2,'.',',') ?></td>
                </tr>
            </table>
            <?php
                $total += $tr->t_amount;
            endforeach; ?>
            <table  style="width:85%; margin:0 auto -8px;">
                <tr>
                    <td style="text-align: left; padding-left:60px;"><?php echo 'TOTAL' ?></td>
                    <td style="text-align: right; "><?php echo number_format($total, 2,'.',',') ?></td>
                </tr>
            </table>    
            <table  style="width:85%; margin:0 auto -8px;">
                <tr>
                    <td style="text-align: left; padding-left:60px;"><?php echo 'Amount Received' ?></td>
                    <td style="text-align: right; "><?php echo number_format(($this->uri->segment(6)), 2,'.',',') ?></td>
                </tr>
            </table>    
            <table  style="width:85%; margin:0 auto -8px;">
                <tr>
                    <td style="text-align: left; padding-left:60px;"><?php echo 'CHANGE' ?></td>
                    <td style="text-align: right; "><?php echo number_format(($this->uri->segment(6)-$total), 2,'.',',') ?></td>
                </tr>
            </table>
    </div>
</page>
