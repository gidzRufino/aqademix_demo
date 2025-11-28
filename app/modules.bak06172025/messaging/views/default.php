<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <i class="fa fa-envelope fa-fw"></i>
            Short Messaging System
        </h3>
    </div>
    <div class="col-lg-12">
        <div class="col-lg-6 panel panel-primary clearfix no-padding">
            <div class="panel-heading">
                <h6>Create Message</h6>
            </div>
            <div class="panel-body col-lg-12"> 
                <div class="form-group">
                    <label>Choose Option to Send:</label><br />
                    <select onclick="optionControl(this.value)" class="col-lg-12 no-padding" id="txtOption">
                        <option value="0">Individual</option>
                        <option value="1">To All Parents</option>
                        <option value="2">Per Grade Level</option>
                        <option value="3">Per Section</option>
                    </select>
                </div><br />
                <input class="form-control" type="text" name="number" id="number" value="0" placeholder="Mobile Number" required>
                <br />
                <br />
                <textarea class="form-control"  onkeyup="checkTxtLength($('#counter').html())" style="margin-bottom:10px;" name="txtMsg"  id="txtMsg" rows="8" data-provide="limit" data-counter="#counter" placeholder="Enter Text Here" required></textarea>
                <em id="counter" style="">459</em>
                <br />
                    
                <button id="smsBtn" onclick="sendSMS()" class="btn btn-info pull-right disabled" style="margin-top:10px;">Send SMS</button>
            </div>
        </div>
        <div class="col-lg-6 panel panel-yellow clearfix no-padding pull-right">
            <div class="panel-heading">
                <h6>Message Log</h6>
            </div>
            <div class="panel-body col-lg-12" style="height: 100vh; overflow-y: scroll"> 
                <table class="table table-bordered">
                    <tr>
                        <th>Recipient</th>
                        <th>Message</th>
                        <th>Status</th>
                    </tr>
                    <?php foreach($text as $t): ?>
                    <tr>
                        <td><?php echo $t->sms_number ?></td>
                        <td><?php echo $t->sms_message ?></td>
                        <td><?php echo ($t->sms_status?'Message Sent':'Pending'); ?></td>
                    </tr>

                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    <?php
    
    ?>
    
</div>    

<script type="text/javascript">
    
    $(document).ready(function(){
        $('#txtOption').select2();
    });
    
    function optionControl(val)
    {
        switch(val)
        {
            case '0':
                $('#number').show();
            break;    
            case '1':
                $('#number').hide();
            break;    
            case '2':
                
            break;    
            case '3':
                
            break;    
        }
    }
    
    function checkTxtLength(val)
    {
        if(val==458){
           //alert('sorry!')
           $('#smsBtn').addClass('disabled');
        }else{
            $('#smsBtn').removeClass('disabled');
        }
    }
    
    function sendSMS()
    {
        //alert($('#txtMsg').val());
        var url = "<?php echo base_url().'messaging/queText/'?>"; // the script where you handle the form input.
             $.ajax({
                   type: "POST",
                   url: url,
                   data:
                    {
                      number            : $('#number').val(),
                      txtMsg            : $('#txtMsg').val(),
                      txtOption         : $('#txtOption').val(),
                      txtCat            : 2,
                      csrf_test_name    : $.cookie('csrf_cookie_name'),        
                    }, // serializes the form's elements.
                  dataType:'json',
                   success: function(data)
                   {
                      alert(data);
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
