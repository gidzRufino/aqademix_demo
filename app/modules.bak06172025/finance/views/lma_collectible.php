<div class="row">
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Remaining Collectibles - <span id="totalBalance"></span>
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url() ?>'">Dashboard</button>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('finance/accounts') ?>'">Accounts</button>
                <!--<button type="button" class="btn btn-default" onclick="generateCollectibles('<?php echo $school_year ?>')">Update Collectibles</button>--> 
            </div>
        </h3>
    </div>
    <div class="col-lg-1"></div>
    <div id="salesTable" class="col-lg-10">
        <div id="links" class="pull-left">
            <?php 
                echo $links; ?>
        </div>
        <div class="col-lg-3 pull-right">
            <div class="form-group input-group" id="searchBox" >
                   <input style="width:250px;" onkeyup="search(this.value)" class="form-control" id="verify" placeholder="Search" type="text">
                   <span class="input-group-btn">
                       <button class="btn btn-default">
                           <i id="verify_icon" class="fa fa-search"></i>
                       </button>     
                   </span> 
           </div>
        </div>
        <div class="col-lg-12">
            <table class="table table-striped">
                <tr>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th class="text-right">Total Charges</th>
                    <th class="text-right">Total Balance</th>
                    <th class="text-right">Amount Due</th>
                    <th>Action</th>
                    <th></th>
                </tr>

            <?php 
                $penalty = 0;
                $totalDue = 0;
                foreach($students as $s):
                    //if($s->rfid!=""):
                        $financeAccount = Modules::run('finance/getFinanceAccount', $s->user_id);
                        $accountDetails = json_decode(Modules::run('finance/getRunningBalance', base64_encode($s->st_id), $school_year));
                        $balance = $accountDetails->charges - $accountDetails->payments;
                        $btype = $financeAccount->billing_type;

                        $amountDue = json_decode(Modules::run('finance/finance_lma/getAmountDue',$s, $btype, $accountDetails->charges));
                        $penaltys = Modules::run('finance/finance_lma/getPenalty',$s->st_id,0, $school_year);
                        if($penaltys->result()):
                            foreach($penaltys->result() as $pen):
                                $penalty += $pen->pen_amount;
                            endforeach;
                        endif;

                        ?>
                            <tr>
                                <td><?php echo strtoupper($s->lastname) ?></td>
                                <td><?php echo strtoupper($s->firstname) ?></td>
                                <td class="text-right"><?php echo number_format($accountDetails->charges,2,'.',',') ?></td>
                                <td class="text-right"><?php echo number_format(($balance+$penalty),2,'.',',') ?></td>
                                <td class="text-right"><?php echo number_format($amountDue->due+$penalty,2,'.',',') ?></td>
                                <td class="text-center">
                                    <a href="<?php echo base_url('finance/accounts/'. base64_encode($s->st_id).'/'.$school_year) ?>" target="_blank" class="btn btn-warning btn-xs">View Details</a>
                                    <button onclick="$('#sendSMS_<?php echo $s->user_id ?>').modal('show'), $('#number_<?php echo $s->user_id ?>').val('<?php echo $s->ice_contact ?>'),checkTxtLength($('#counter_<?php echo $s->user_id ?>').html(), '<?php echo $s->user_id ?>')" class="btn btn-success btn-xs">Send SMS</button>
                                </td>
                            </tr>
                        <?php 
                        $totalDue = $amountDue->due+$penalty;
    $message = "Little Me Advisory #5 s2018:  Good Day Dear Parents! This is a gentle reminder of ".strtoupper($s->firstname)."'s account in the amount of P".$totalDue.". Downpayment should be fully paid first then you can proceed with your regular monthly tuition. Pls be guided that penalties will apply to late payments. For any queries, pls do not hesitate to visit us in the office. God bless and welcome to Little Me Academy!!!";
                    $penalty = 0; 
                    ?>
                        <div id="sendSMS_<?php echo $s->user_id ?>" class="modal fade" style="width:50%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="col-lg-6 panel panel-primary clearfix no-padding">
                                <div class="panel-heading">
                                    <h6>Send SMS Billing</h6>
                                </div>
                                <div class="panel-body col-lg-12"> 
                                    <div class="form-group">
                                    <input class="form-control" type="text" name="number" id="number_<?php echo $s->user_id ?>" value="0" placeholder="Mobile Number" required>
                                    <br />
                                    <br />
                                    <textarea class="form-control"  onkeyup="checkTxtLength($('#counter_<?php echo $s->user_id ?>').html(), '<?php echo $s->user_id ?>')" style="margin-bottom:10px; text-align: left;" name="txtMsg"  id="txtMsg_<?php echo $s->user_id ?>" rows="8" data-provide="limit" data-counter="#counter_<?php echo $s->user_id ?>" placeholder="Enter Text Here" required>
    <?php echo $message ?>
                                    </textarea>
                                    <em id="counter_<?php echo $s->user_id ?>" style=""><?php echo 459-strlen($message) ?></em>
                                    <br />

                                    <button id="smsBtn_<?php echo $s->user_id ?>" onclick="sendSMS('<?php echo $s->user_id ?>')" class="btn btn-info pull-right disabled" style="margin-top:10px;">Send SMS</button>
                                </div>
                            </div>
                        </div>   
                    <?php        
                endforeach;
            ?>
            </table>
        </div>    
    </div>
</div>

<script type="text/javascript">
    
    $('#startDate').datepicker({
        orientation: 'left'
    });
    
    $('#endDate').datepicker({
        orientation: 'left'
    });
   
    function generateCollectibles(year)
    {
        var url = '<?php echo base_url().'finance/generateCollectibles/'?>'+year;

        $.ajax({
               type: "GET",
               url: url,
               dataType:'json',
               data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                beforeSend:function(){
                    $('#loadingModal').modal('show');
                },
               success: function(data)
               {
                   $('#loadingModal').modal('hide');
                   $('#totalBalance').html(data.totalBalance)
               }
             });

        return false; 
    } 
    
    function checkTxtLength(val, id)
    {
        if(val==458){
           //alert('sorry!')
           $('#smsBtn_'+id).addClass('disabled');
        }else{
            $('#smsBtn_'+id).removeClass('disabled');
        }
    }
    
    function sendSMS(id)
    {
        //alert($('#txtMsg').val());
        var url = "<?php echo base_url().'messaging/queText/'?>"; // the script where you handle the form input.
             $.ajax({
                   type: "POST",
                   url: url,
                   data:
                    {
                      number            : $('#number_'+id).val(),
                      txtMsg            : $('#txtMsg_'+id).val(),
                      txtCat            : 2,
                      txtOption         : 0,
                      csrf_test_name    : $.cookie('csrf_cookie_name'),        
                    }, // serializes the form's elements.
                   dataType:'json',
                   success: function(data)
                   {
                      alert(data.msg);
                      location.reload();
                          
                   }
                 });

            return false;  
    }
    
    !function( $ ){

        "use strict"

        var Limit = function ( element, options ) {
          this.$element = $(element)
          this.options = $.extend({}, $.fn.limit.defaults, options)
          this.maxChars = this.options.maxChars || this.maxChars
          this.counter = $(this.options.counter) || this.counter
          this.listen()

          this.check()
        }

        Limit.prototype = {

          constructor: Limit

        , listen: function () {
            this.$element
              .on('keypress', $.proxy(this.keypress, this))
              .on('keyup',    $.proxy(this.keyup, this))

            if ($.browser.webkit || $.browser.msie) {
              this.$element.on('keydown', $.proxy(this.keypress, this))
            }
          }

        , check: function () {
            this.query = this.$element.val()

            if(!this.query) {
              this.counter.text(this.maxChars)
              this.counter.css('color', 'red')
              this.$element.trigger('uncross')
            }

            this.counter.text(this.maxChars - this.query.length)

            if (this.query.length > this.maxChars) {
              this.counter.css('color', 'red')
              this.$element.trigger('cross')
            } else if (this.query.length > this.maxChars - 10) {
              this.counter.css('color', 'red')
              this.$element.trigger('uncross')
            } else {
              this.counter.css('color', '')
              this.$element.trigger('uncross')
            }

        }

        , keyup: function (e) {

            this.check()

            e.stopPropagation()
            e.preventDefault() 
        }

        , keypress: function (e) {

            this.check()

            e.stopPropagation()
          }
        }


        /* limit PLUGIN DEFINITION
         * =========================== */

        $.fn.limit = function ( option ) {
          return this.each(function () {
            var $this = $(this)
              , data = $this.data('limit')
              , options = typeof option == 'object' && option
            if (!data) $this.data('limit', (data = new Limit(this, options)))
            if (typeof option == 'string') data[option]()
          })
        }

        $.fn.limit.defaults = {
          maxChars: 459
        , counter: ''
        }

        $.fn.limit.Constructor = Limit


       /* limit DATA-API
        * ================== */

        $(function () {
          $('body').on('focus.limit.data-api', '[data-provide="limit"]', function (e) {
            var $this = $(this)
            if ($this.data('limit')) return
            e.preventDefault()
            $this.limit($this.data())
          })
        })

      }( window.jQuery )
    

</script>    