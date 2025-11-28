<?php

$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $sectionDetails->grade_id);

foreach ($subject_ids as $sp):
    $singleSub = Modules::run('academic/getSpecificSubjects', $sp->sub_id);
?>
<section id="discussDetails" class="col-lg-3 col-xs-6 float-left">
    <div class="card card-blue card-outline">
        <div class="card-header">
            <?php echo $singleSub->short_code ?>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3><?php echo Modules::run('opl/getNumDiscussion',$sectionDetails->grade_id, $sp->sub_id, $school_year) ?></h3>

                    <p>Discussions</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-book"></i>
                  </div>
                  <a href="<?php echo base_url('opl/p/discussionBoard/'.$school_year.'/'.$sectionDetails->grade_id.'/'.$sectionDetails->section_id.'/'.$sp->sub_id) ?>" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                  </a>
                </div>
            </div>
            <div class="col-lg-12">
                <!-- small box -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                      <h3><?php echo Modules::run('opl/getTasks',$sectionDetails->grade_id,$sectionDetails->section_id, $sp->sub_id, $school_year) ?></h3>

                    <p>Tasks</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-book"></i>
                  </div>
                  <a href="<?php echo base_url('opl/classBulletin/'.$school_year.'/List/'.$sectionDetails->grade_id.'/'.$sectionDetails->section_id.'/'.$sp->sub_id) ?>"  class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                  </a>
                </div>
            </div>
          
        </div>
    </div>

</section>

    
<?php
endforeach;
