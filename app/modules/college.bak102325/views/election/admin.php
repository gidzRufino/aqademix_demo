<div class="row">
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Election Management Settings
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
                <button type="button" class="btn btn-default" onclick="$('#addCandidate').modal('show'), $('#searchControls').show(), $('#profile').hide()">Add Candidate</button>
                <button type="button" class="btn btn-default" onclick="$('#registerVoter').modal('show'), setFocus()">Register a Voter</button>
                <?php if($electionSettings->election_is_close): ?>
                    <button type="button" class="btn btn-default" onclick="closeElection(0)">Start the Election</button>
                <?php else: ?>
                    <button type="button" class="btn btn-default" onclick="closeElection(1)">Close the Election</button>
                <?php endif; ?>    
                <button type="button" class="btn btn-default" onclick="openResult(1)">Open Result</button>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/election/electionResult') ?>'">Election Returns</button>
              </div>
        </h3>
    </div>
    <div class="col-lg-12">
        <h2 class="text-center text-danger">List of Candidates</h2>
        <?php 
            foreach ($candidate_position as $p):
       ?>
        <div class="panel panel-success col-lg-6 no-padding" >
            <div class="panel-heading"><?php echo strtoupper($p->candidate_position) ?></div>
            <div class="panel-body clearfix">
                <ul class="list-group">
                <?php $president = Modules::run('college/election/getCandidateList', $p->pos_id); 
                        foreach ($president as $pres):
                            $basicInfo = Modules::run('college/election/getBasicInfoBySTID', $pres->ec_st_id, $this->session->userdata('school_year'));
                        
                            switch ($basicInfo->year_level):
                              case 1:
                                  $year = 'First Year';
                              break;
                              case 2:
                                  $year = 'Second Year';
                              break;
                              case 3:
                                  $year = 'Third Year';
                              break;
                              case 4:
                                  $year = 'Fourth Year';
                              break;
                              case 5:
                                  $year = 'Fifth Year';
                              break;
                            endswitch;
                            ?>
                    <li class="list-group-item clearfix btn btn-primary">
                        <img class="img-circle img-responsive pull-left" style="width:100px; border:5px solid #fff" src="<?php echo base_url().'uploads/'.$basicInfo->avatar;  ?>" />
                        <div class="col-lg-8">
                            <h4 style="color:black; text-align: left;"><?php echo $basicInfo->firstname.' '.$basicInfo->lastname ?></h4>
                            <h5 class=" no-margin" style="color: red; font-weight: bold; text-align: left;"><span class="text-danger"><?php echo $basicInfo->course ?></span></h5>
                            <h5 class=" no-margin" style="color: red; font-weight: bold; margin-left: 15px; text-align:left;"><span class="text-danger"><?php echo $year ?></span></h5>
                        </div>
                        <i class="fa fa-close fa-3x pull-right pointer" onclick="removeCandidate('<?php echo $pres->ec_id ?>')"></i>
                    </li>        
                            <?php
                        endforeach;
                ?>
                </ul>
            </div>
        </div>
        <?php
        endforeach;
        ?>
    </div>
</div>
<?php 
$data['position'] = $candidate_position;
$this->load->view('modalForms', $data); ?>
<script type="text/javascript">
    
    $(document).ready(function(){
        $('#dcms_tab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      })
    })
    
   function openResult(value)
    {
        var r = confirm('Are you sure you want to Finally Announce the Winning Candidate?')
        if(r==true){
            var url = '<?php echo base_url().'college/election/openResult/' ?>'+value;
             $.ajax({
                   type: "GET",
                   url: url,
                   data: '', // serializes the form's elements.
                   success: function(data)
                   {    
                      alert('Successfully POSTED');
                      location.reload();
                   }
                 });

            return false;
        }
    }
    
   function closeElection(value)
    {
        var r = confirm('Are you sure you want to close the Election Period?')
        if(r==true){
            var url = '<?php echo base_url().'college/election/closeElection/' ?>'+value;
             $.ajax({
                   type: "GET",
                   url: url,
                   data: '', // serializes the form's elements.
                   success: function(data)
                   {    
                      alert('Successfully '+(value==0?'Open':'Closed'));
                      location.reload();
                   }
                 });

            return false;
        }
    }
    
    function removeCandidate(value)
    {
        var r = confirm('Are you sure you want to remove this candidate?')
        if(r==true){
            var url = '<?php echo base_url().'college/election/removeCandidate/' ?>'+value;
             $.ajax({
                   type: "GET",
                   url: url,
                   data: '', // serializes the form's elements.
                   success: function(data)
                   {    
                      alert('Successfully Removed');
                      location.reload();
                   }
                 });

            return false;
        }
    }
    
    
</script>