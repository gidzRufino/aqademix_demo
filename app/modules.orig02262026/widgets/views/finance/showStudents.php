<div class="col-lg-3 col-md-12">
   <div class="panel panel-green">         
      <div class="panel-heading">
         <div class="row">
            <div class="col-xs-3">
              <h1><b>PhP</b></h1>  
               <!-- <i class="fa fa-cc-mastercard fa-5x"></i> -->
            </div>
            <div class="col-xs-9 text-right">

<!-- ///////////////////////////////////////// -->

                    <?php

                   
                    $total_display = 0;

                  ?>

<!-- ///////////////////////////////////////// -->

               <div><h3><?php echo number_format($total_display, 2)?></h3></div>
               <div>Current Month Bill</div>
            </div>
         </div>
      </div>
      <a href="<?php echo base_url('pp/getFinanceAccounts/'.base64_encode($child_links))?>">
      <div class="panel-footer">
         <span class="pull-left">View Details</span>
         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
         <div class="clearfix"></div>
      </div>
      </a>
   </div>
</div>