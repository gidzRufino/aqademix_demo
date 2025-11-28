    <form id="initialTransaction">
    <div id="itemRef" style="display:none;" >
      <table id="itemRefTable">
        <tr>
          <th>ID</th>
          <th>Item Description</th>
        </tr>
        <?php 
          $numb = 0;
          foreach($initialLevel as $initLevel){
          if($initLevel->level_id == $slevelID){ ?>
        <tr>
          <?php $numb = $numb + 1 ?>
          <td id="itid<?php echo $numb ?>"><?php echo $initLevel->item_id ?></td>
          <td id="itdesc<?php echo $numb ?>"><?php echo $initLevel->item_description ?></td>
        </tr>

        <?php  }
        } ?>
      </table>
      <input type="hidden" name="last_item_number" id="last_item_number" value="<?php echo $numb ?>" required>
        
    </div>
        <div class="row">
          <div class="span8 offset1">
            <div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <strong>Heads Up!</strong> You can select an item from the drop-down list to add items for payment. 
            </div>
          </div>
        </div>
        <div class="span 9 well">
          <div class="row"> 
            <div class="span9">
              <div class="row">
                <div class="span3 pull-left">
                  <h4 id="testMe">Payment Transaction</h4>
                </div>
                <div class="pull-right span3" style="margin-top:5px;">
                  <select name="selectItems" tabindex="-1" onclick="addPayment()" id="selectItems" class="span2">
                     <option value="" selected="selected">Please select an item</option>
                     <?php
                       foreach($ar_itemChoice as $key => $value){
                          echo '<option value="'.$value.'">'.$value.'</option>';
                      } ?>
                  </select>  
                  <!-- <input type="hidden" name="htbalance" id="htbalance" value="<?php echo number_format($tbalance,2) ?>" required> -->
                  &nbsp;<button type="button" onclick="addPayment()" class="btn btn-success btn-small">add</button>
                </div>      
              </div>    
            </div>
          </div>
          <div class="row">
            <div class="span9">
              <div class="row">
                <div class="span7 offset1">
                  <table id="paymentTable" class="table table-hover table-responsive table-condensed">
                    <tr>
                      <th style="text-align:center; font-size: 15px; font-weight: bold; color:#379EBC" class="span3">Item Description</th>
                      <th style="text-align:center; font-size: 15px; font-weight: bold; color:#379EBC" class="span2">Balance Due</th>
                      <th style="text-align:center; font-size: 15px; font-weight: bold; color:#379EBC" class="span3">Allocated Amount</th>
                      <th style="text-align:center; font-size: 15px; font-weight: bold; color:#379EBC" class="span1"></th>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="span2 well well-small">
              <div class="row">
                <div class="span2" >
                  <label class="control-label" for="input" style="color:#BB0000;">Discount</label>
                  <input type="text" onblur="calcDiscount()" name="ptDiscount" id="ptDiscount" placeholder="Discount" required>
                </div>
              </div>  
              <div class="row">
                <div class="span2">
                  <label class="control-label" for="input" style="color:#BB0000;">Remarks</label>
                  <input type="text" name="ptRemarks" id="ptRemarks" placeholder="Remarks" required>
                </div>
              </div> 
            </div>
            <div class="span2 offset1 well well-small">
              <div class="row">
                <div class="span2" >
                  <label class="control-label" for="input" style="color:#BB0000;">Total Amount</label>
                  <input type="text" name="pttAmount" id="pttAmount" syle="width: 600px; "placeholder="Total Amount" disabled>
                </div>
              </div>  
              <div class="row">
                <div class="span2">
                  <label class="control-label" for="input" style="color:#BB0000;">Amount Tendered</label>
                  <input type="text" onblur="calChange()" name="ptAmountTendered" id="ptAmountTendered" placeholder="Amount Tendered" required>
                </div>
              </div> 
            </div>
            <div class="span2 offset1 well well-small">
              <div class="row">
                <div class="span2" >
                  <label class="control-label" for="input" style="color:#BB0000;">Referrence Number</label>
                  <input type="text" name="ptRefNum" id="ptRefNum" syle="width: 600px; "placeholder="OR / Referrence Number" required>
                </div>
              </div>  
              <div class="row">
                <div class="span2">
                  <label class="control-label" for="input" style="color:#BB0000;">Change</label>
                  <input type="text" name="ptChange" id="ptChange"  disabled>
                </div>
              </div> 
            </div>
          </div>
          <div class="row">
            <div class="span3 pull-right">
              <span style="padding-left: 65px;"><button onclick="showReceipt()" id="processPayBtn" data-toggle="modal" aria-hidden="true" class="btn btn-small btn-success">Process Payment </button>&nbsp;<button onclick="closePay()" type="button" data-toggle="modal" class="btn btn-danger btn-small">Cancel</button></span> 
              <input type="hidden" name="lastEntry" id="lastEntry" value=""required> <!-- last detail key -->
            </div>
          </div>
        </div>
        </form>