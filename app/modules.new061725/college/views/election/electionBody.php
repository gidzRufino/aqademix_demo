<?php if($electionSettings->result_is_open): ?>

 <div id="carouselExampleSlidesOnly" class="carousel slide">
    <div class="carousel-inner">
<?php
      foreach ($candidate_position as $p):
        $president = Modules::run('college/election/getCandidateList', $p->pos_id);
        if(!empty($president)):
            ?>

            <div class="item <?php echo ($p->pos_id==1?'active':'') ?>"> 
                  <div class="col-lg-12">
                      <h1 class="text-center" style="color:#003399; font-size: 60px; margin:0;"><?php echo strtoupper($p->candidate_position) ?></h1>
                  </div>
              <?php
              foreach ($president as $pres):
                  $basicInfo = Modules::run('college/election/getBasicInfoBySTID', $pres->ec_st_id, $this->session->userdata('school_year'));
                  $electionResult = Modules::run('college/election/getVotes', $p->pos_id, $pres->ec_id);
                  $totalVotes = $electionSettings->total_votes;
                  $votePerCandidate = number_format(100-($electionResult->num_rows()/$totalVotes)*100)
            ?> 
                  <div class="col-lg-6 clearfix no-margin">
                      <div style="margin:0 auto; width:60%;">
                          <div style="margin: 0 auto; width: 90%;">
                              <img src="<?php echo base_url().'uploads/'.$basicInfo->avatar;  ?>"  style="width:450px; height:450px; "/>
                          </div>
                          <h1 class="text-center" style="font-weight: bold;"><?php echo strtoupper($basicInfo->firstname.' '.$basicInfo->lastname) ?></h1>
                          <div class="progress" style="height:30px; margin-top:30px;">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $votePerCandidate ?>%; font-size:25px; font-weight: bold; padding-top:5px;" aria-valuenow="<?php echo $votePerCandidate ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $votePerCandidate ?>%</div>
                          </div>
                      </div>
                  </div>
        <?php 
                endforeach;
        ?>
            </div>    
<?php          
        endif;
    endforeach;
    
?>    
    </div>
</div>
<?php
else: 
    
    ?>
<div id="carouselExampleSlidesOnly" class="carousel slide">
    <div class="carousel-inner">
<?php
      foreach ($candidate_position as $p):
        $president = Modules::run('college/election/getCandidateList', $p->pos_id);
        if(!empty($president)):
            ?>

            <div class="item <?php echo ($p->pos_id==1?'active':'') ?>"> 
                  <div class="col-lg-12">
                      <h1 class="text-center" style="color:#003399; font-size: 60px; margin:0;"><?php echo strtoupper($p->candidate_position) ?></h1>
                  </div>
              <?php
              $i = 'A';
              foreach ($president as $pres):
                  $electionResult = Modules::run('college/election/getVotes', $p->pos_id, $pres->ec_id);
                  $totalVotes = $electionSettings->total_votes;
                  $basicInfo = Modules::run('college/election/getBasicInfoBySTID', $pres->ec_st_id, $this->session->userdata('school_year'));
                  $votePerCandidate = (($electionResult->num_rows()/$totalVotes))==0?0:number_format((100-($electionResult->num_rows()/$totalVotes)*100)==0?100:100-($electionResult->num_rows()/$totalVotes)*100);
            ?> 
                  
                <div class="col-lg-6 clearfix no-margin">
                    <div style="margin:0 auto; width:60%;">
                        <img src="<?php echo base_url().'images/icons/who.jpg' ?>"  style="width:100%; "/>
                        <h1 class="text-center" style="font-weight: bold;">CANDIDATE <?php echo $i++ ?></h1>
                        <div class="progress" style="height:30px; margin-top:30px;">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $votePerCandidate ?>%; font-size:25px; font-weight: bold; padding-top:5px;" aria-valuenow="<?php echo $votePerCandidate ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $votePerCandidate ?>%</div>
                        </div>
                    </div>
                  </div>
        <?php 
                endforeach;
        ?>
            </div>    
<?php          
        endif;
    endforeach;
    
?>    
    </div>
</div>

<?php endif;
