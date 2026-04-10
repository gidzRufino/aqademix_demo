<h2 class="text-center text-danger">List of Candidates</h2>
        <?php 
             foreach ($candidate_position as $p):
       ?>
        <div class="panel panel-success no-padding" style="width: 80%; margin: 5px auto;" >
            <div class="panel-heading">
                <span class="text-left"><?php echo strtoupper($p->candidate_position) ?></span>
                <span class="text-right">VOTES</span>
            </div>
            <div class="panel-body clearfix">
                <ul class="list-group">
                <?php $candidate = Modules::run('college/election/getCandidateList', $p->pos_id); 
                        foreach ($candidate as $pres):
                            $basicInfo = Modules::run('college/election/getBasicInfoBySTID', $pres->ec_st_id, $this->session->userdata('school_year'));
                            $electionResult = Modules::run('college/election/getVotes', $p->pos_id, $pres->ec_id);
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
                        <div class="col-lg-6">
                            <h4 style="color:black; text-align: left;"><?php echo $basicInfo->firstname.' '.$basicInfo->lastname ?></h4>
                            <h5 class=" no-margin" style="color: red; font-weight: bold; text-align: left;"><span class="text-danger"><?php echo $basicInfo->course ?></span></h5>
                            <h5 class=" no-margin" style="color: red; font-weight: bold; margin-left: 15px; text-align:left;"><span class="text-danger"><?php echo $year ?></span></h5>
                        </div>
                        <div class="col-lg-4 pull-right">
                            <h1 style="color:red; font-size: 50px;" class="text-right"><?php echo $electionResult->num_rows() ?></h1>
                        </div>
                    </li>        
                            <?php
                        endforeach;
                ?>
                </ul>
            </div>
        </div>
        <?php
        endforeach;