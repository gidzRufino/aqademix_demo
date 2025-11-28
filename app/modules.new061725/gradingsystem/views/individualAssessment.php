<div id="deactivate" class="emailForm panel panel-yellow clearfix" >
    <div class="panel-heading clearfix">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 id="myModalLabel" class="pull-left"><?php echo $profile->firstname.' '.$profile->lastname ?> <br /><small><?php echo $individualAssessment->row()->category_name ?> Assessment Details</small></h4>
            <h2 class="pull-right" id="totalAssessPerCat"></h2>
    </div>
    
        <div class="panel-body  col-lg-12" style="min-height: 300px; overflow-y: scroll;">
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th>Date</th>
                      <th>Raw Score</th>
                      <th>Number of Items</th>
                      <th>Equivalent</th>
                  </tr>
              </thead>
              <?php foreach ($individualAssessment->result() as $assess){ ?>
                   <tr>
                      <th><?php echo $assess->assess_date ?></th>
                      <th><?php echo $assess->raw_score ?></th>
                      <th><?php echo $assess->no_items ?></th>
                      <th><?php echo $assess->equivalent.' %' ?></th>
                  </tr>
              <?php } ?>
          </table>
            
        </div>
</div>


