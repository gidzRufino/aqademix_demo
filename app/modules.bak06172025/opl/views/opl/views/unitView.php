<section id="gvDetails" class="card">
  <?php 
    foreach($postDetails as $pd): 
      
      ?>
  <div class="card card-widget">
    <div class="card-header">
        <div class="user-block">
            <img class="img-circle" width="50" src="<?php echo base_url() . 'uploads/' . $pd->avatar; ?>" alt="User Image">
            <span class="username"><?php echo $pd->op_task_title ?></span>
            <span class="description"><a href="#"><?php echo $pd->firstname.' '.$pd->lastname; ?></a></span>
        </div>
        <div class="box-tools" style="float: right;">
            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Mark as read">
              <i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fas fa-times"></i></button>
          </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <?php echo $pd->op_post ?>
        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-thumbs-up"></i> Got It!</button>
        <span class="float-right text-muted">127 likes - 3 comments</span>
    </div>
   
    </div>
    <?php endforeach; ?>
</section>






<input type="hidden" id="grade_level_id" value="<?php echo $gradeDetails->grade_level_id ?>" />
<input type="hidden" id="section_id" value="<?php echo $gradeDetails->grade_level_id ?>" />