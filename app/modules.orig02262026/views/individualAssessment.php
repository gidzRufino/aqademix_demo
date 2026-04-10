<div style='width:450px; height:auto; margin-top:50px; margin-bottom: 10px;' id="deactivate" class="emailForm" >
    <div class="modal-header">
            <button type="button" class="close" onclick="$('#secretContainer').fadeOut(500),$('#deactivate').fadeOut(500)">&times;</button>
            <h4 id="myModalLabel"><?php echo $profile->firstname.' '.$profile->lastname ?> <br /><small><?php echo $individualAssessment->row()->category_name ?> Assessment Details</small></h4>
        </div>
    
        <div class="modal-body" style="min-height: 300px; overflow-y: scroll;">
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


