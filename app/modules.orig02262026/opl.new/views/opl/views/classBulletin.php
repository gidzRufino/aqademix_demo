  
<?php echo Modules::run('opl/opl_widgets/topWidget'); ?>

<?php
$cnt = count($postDetails);
foreach ($postDetails as $pd):
    $submittedTask = Modules::run('opl/opl_variables/getSubmittedTask', $pd->task_auto_id, $this->session->school_year);
    if ($cnt > 1):
        $col = 'col-lg-6';
    else:
        $col = 'col-lg-12';
    endif;
    ?>
    <section id="gvDetails" class="<?php echo $col ?> float-left">
        <div class="card card-widget " id="card_<?php echo $pd->task_auto_id ?>">
            <div class="card-header">
                <div class="user-block">
                    <img class="img-circle" width="50" src="<?php echo base_url() . 'uploads/' . $pd->avatar; ?>" alt="User Image">
                    <span class="username"><?php echo $pd->task_title . ' - ' . $pd->tt_type ?></span>
                    <span class="description"><a href="#"><?php echo $pd->firstname . ' ' . $pd->lastname; ?></a> <small><?php echo date('F d, Y g:i a', strtotime($pd->task_start_time)) ?></small></span>
                </div>
                <?php if ($pd->task_author_id == $this->session->username): ?>
                    <div class="box-tools float-right">
                        <div class="float-right">
                            <button type="button" class="btn btn-box-tool btn-xs" data-toggle="tooltip" title="" data-original-title="Mark as read">
                                <i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-box-tool btn-xs" data-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool btn-xs" data-widget="remove"><i class="fas fa-times"></i></button>
                        </div><br />
                        <span class="float-right text-muted danger pointer" 
                              style="font-size: 12px;"
                              data-container="body" data-toggle="popover" data-placement="right" 
                              data-content="
                              <?php
                                  $data['submittedTask'] = $submittedTask->result();
                                  $data['totalStudents'] = count($submittedTask->result());
                                  $this->load->view('submittedTask', $data);
                              ?>
                              "
                              >
                            Submitted by: <?php echo count($submittedTask->result()) ?> student(s)
                        </span>
                    </div>
                <?php endif; ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?php echo $pd->task_details ?>
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-thumbs-up"></i> Got It!</button>
            </div>

        </div>
    </section>   
    <input class="dateTime" task_id="<?php echo $pd->task_auto_id ?>"  type="hidden" id="dateTime_<?php echo $pd->task_auto_id ?>" value="<?php echo date('M d, Y G:i:s', strtotime($pd->task_end_time)) ?>" />
<?php endforeach; ?>

<script type="text/javascript">
    $(document).ready(function(){
         $('[data-toggle="popover"]').popover({
                    html: true
                });
    });
</script>