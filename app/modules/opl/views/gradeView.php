<?php echo Modules::run('opl/opl_widgets/topWidget'); ?>

    <?php
    $cnt = count($postDetails);
    foreach ($postDetails as $pd):
        if($cnt > 1):
            $col = 'col-lg-6';
        else:
            $col = 'col-lg-12';
        endif;
        ?>
<section id="gvDetails" class="<?php echo $col ?> float-left">
        <div class="card card-widget " id="card_<?php echo $pd->op_id?>">
            <div class="card-header">
                <div class="user-block">
                    <img class="img-circle" width="50" src="<?php echo base_url() . 'uploads/' . $pd->avatar; ?>" alt="User Image">
                    <span class="username"><?php echo $pd->op_task_title ?></span>
                    <span class="description"><a href="#"><?php echo $pd->firstname . ' ' . $pd->lastname; ?></a> <small><?php echo date('F d, Y g:i a', strtotime($pd->op_task_start)) ?></small></span>
                </div>
                <?php if($pd->op_owner_id == $this->session->username): ?>
                <div class="box-tools float-right">
                    <div class="float-right">
                        <button type="button" class="btn btn-box-tool btn-xs" data-toggle="tooltip" title="" data-original-title="Mark as read">
                            <i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-box-tool btn-xs" data-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool btn-xs" data-widget="remove"><i class="fas fa-times"></i></button>
                    </div><br />
                    <span class="float-right text-muted danger" style="font-size: 12px;">Submitted by: 0 students</span>
                </div>
                <?php endif; ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?php echo $pd->op_post ?>
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-thumbs-up"></i> Got It!</button>
                <span class="float-right text-muted" style="font-size: 15px;">Task Ends in <span id="op_id_<?php echo $pd->op_id ?>"></span></span>
            </div>

        </div>
 </section>   
        <input class="dateTime" task_id="<?php echo $pd->op_id ?>"  type="hidden" id="dateTime_<?php echo $pd->op_id ?>" value="<?php echo date('M d, Y G:i:s', strtotime($pd->op_task_deadline)) ?>" />
    <?php endforeach; ?>



<script type="text/javascript">
       $(document).ready(function(){
            
            $('.dateTime').each(function(){
                  var id = $(this).attr('task_id');
                  var dateTime = $(this).val();
                  getCountDown(id, dateTime);
            });
            
       });   
       
       
            function getCountDown(id, dateTime) {
                  // Set the date we're counting down to
            var countDownDate = new Date(dateTime).getTime();
    
            // Update the count down every 1 second
            var x = setInterval(function() { 


            // Get today's date and time
                var now = new Date().getTime();
            // Find the distance between now and the count down date
            var distance = countDownDate - now;
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            // Output the result in an element with id="demo"
            document.getElementById("op_id_"+id).innerHTML = days + "d " + hours + "h "
                    + minutes + "m " + seconds + "s ";
            // If the count down is over, write some text 
            if (distance < 0) {
               $('#card_'+id).remove();
            }
        }, 1000);
            };
</script>    