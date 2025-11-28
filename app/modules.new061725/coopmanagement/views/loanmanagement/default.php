<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Loans Management
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('coopmanagement') ?>'">Coop Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('coopmanagement/loans/application') ?>'">Loan Application</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('coopmanagement/loans/settings') ?>'">Loan Management Settings</button>
          </div>
    </h3>
</div>
<div class="col-lg-12 col-sm-12">
    <div class="col-lg-4 col-xs-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <?php $pendingLoans = Modules::run('coopmanagement/loans/getLoanStatus',0) ?>
                    <div class="col-xs-3">
                        <i  class="fa fa-table fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo ($pendingLoans->num_rows() >0?$pendingLoans->num_rows():0); ?></div>
                        <div>Number of Loans for Approval</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url().'coopmanagement/loans/pending' ?>">
                <div class="panel-footer">  
                    <span onclick="" class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-xs-12">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <?php $loansForDisbursement = Modules::run('coopmanagement/loans/getLoanStatus',1) ?>
                    <div class="col-xs-3">
                        <i  class="fa fa-money fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo ($loansForDisbursement->num_rows() >0?$loansForDisbursement->num_rows():0); ?></div>
                        <div>Number of Loans for Disbursement</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url().'coopmanagement/loans/forDisbursement' ?>">
                <div class="panel-footer">  
                    <span onclick="" class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    
    <div class="col-lg-4 col-xs-12">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <?php $loansForDisbursement = Modules::run('coopmanagement/loans/getLoanStatus',2) ?>
                    <div class="col-xs-3">
                        <i  class="fa fa-money fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo ($loansForDisbursement->num_rows() >0?$loansForDisbursement->num_rows():0); ?></div>
                        <div>Total Loans Released</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url().'coopmanagement/loans/loanReleased' ?>">
                <div class="panel-footer">  
                    <span onclick="" class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
