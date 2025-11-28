<style>
    .dl-horizontal
    {
        margin-bottom: 5px !important;
    }
</style>
<div class="well col-lg-12" id="profBody">
    <div class="col-lg-2">
        <div>
            <img class="img-circle img-responsive" style="width:120px; border:5px solid #fff" src="<?php if($basicInfo->avatar!=""):echo base_url().'uploads/'.$basicInfo->avatar;else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
        </div>
    </div>
    <div class="col-lg-6">
        <h2 style="margin:3px 0;">
            <span id="name" style="color:#BB0000;"><?php echo strtoupper($basicInfo->firstname." ". $basicInfo->lastname) ?></span>

        </h2>
        <h3 style="color:black; margin:3px 0;">
            <small>
                <a id="account_number" profile_id="<?php echo $basicInfo->user_id ?>" detail="<?php echo $basicInfo->cad_account_no ?>" style="color:#BB0000;">
                     <?php echo Modules::run('coopmanagement/decodeAccount',$basicInfo->cad_account_no) ?>
                 </a>
            </small>
        </h3>
    </div>
    <div class="col-lg-4">
        <dl class="dl-horizontal">
            <dt>
            Savings Deposit:
            </dt>
            <dd>
                <span id="a_savings"  style="color:#BB0000;">
                    <?php echo '&#8369; '.number_format($basicInfo->cad_savings,2,'.',',') ?>
                </span>
              
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                Share Capital:
            </dt>
            <dd>
                <span id="a_share_capital" val="<?php echo $basicInfo->cad_share_capital ?>" style="color:#BB0000;">
                    <?php echo '&#8369; '.number_format($basicInfo->cad_share_capital,2,'.',',') ?>
                </span>
              
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                Salary:
            </dt>
            <dd>
                <span id="a_salary"   style="color:#BB0000;">
                    <?php echo '&#8369; '.number_format($basicInfo->salary,2,'.',',').' '. ucfirst($basicInfo->pst_type) ?>
                </span>
              
            </dd>
        </dl>
        <dl class="dl-horizontal">
            <dt>
                Loan Balance:
            </dt>
            <dd>
                <?php
                    $totalBalance = 0;
                    $balance = Modules::run('coopmanagement/loans/getPersonalLoanBalance',$basicInfo->cad_account_no, $lrn);
//                    foreach ($balance->result() as $b):
//                        $totalBalance += $b->lad_balance;
//                    endforeach;
                ?>
                <span id="a_salary"   style="color:#BB0000;">
                    <?php echo '&#8369; '.number_format($balance,2,'.',','); ?>
                </span>
              
            </dd>
        </dl>
    </div>
</div>