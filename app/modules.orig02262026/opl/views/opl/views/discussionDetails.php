<section id="discussDetails" class="col-lg-6 col-xs-12 float-left">
    <div class="card card-blue card-outline">
        <div class="card-header">
            <div class="user-block">
                <img class="img-circle" width="50" src="<?php echo base_url() . 'uploads/' . $discussionDetails->avatar; ?>" alt="User Image">
                <span class="username"><?php echo $discussionDetails->dis_title ?></span>
                <span class="description"><a href="#"><?php echo $discussionDetails->firstname . ' ' . $discussionDetails->lastname; ?></a> <small><?php echo date('F d, Y g:i a', strtotime($discussionDetails->dis_start_date)) ?></small></span>
            </div>
        </div>
        <div class="card-body">
            <?php echo $discussionDetails->dis_details ?>
        </div>
    </div>

</section>
<section id="commentDetails" class="col-lg-6 col-xs-12 float-left">
    <div class="card card-indigo card-outline">
        <div class="card-header">
            Discussion Comments and Questions
        </div>
        <div id="discussComments" class="card-body card-comments">
            <?php 
                echo Modules::run('opl/opl_variables/getComments', $discussionDetails->dis_sys_code, 3, $this->session->school_year); 
            ?>
            
        </div>

        <div class="card-footer">
            <img class="img-fluid img-circle img-sm" width="50" src="<?php echo base_url() . 'uploads/' . ($this->session->isStudent ? $this->session->details->avatar : $this->session->basicInfo->avatar); ?>" alt="">
            <!-- .img-push is used to add margin to elements next to floating images -->
            <div class="img-push">
                <!--<input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">-->
                <textarea id="commentArea" class="form-control form-control-sm clearfix textarea" placeholder="Type here to Post a Comment or a Question"></textarea>
                <button onclick="sendComment('3', '<?php echo ($this->session->isStudent ? $this->session->details->st_id : $this->session->employee_id) ?>', '<?php echo $discussionDetails->dis_sys_code ?>','<?php echo ($this->session->isStudent ? 1 : 0) ?>')" class="btn btn-xs btn-primary float-right col-xs-12">send</button>
            </div>
        </div>
    </div>

</section>

<script type="text/javascript">
    $(function () {
        
        $('.textarea').summernote();
        sendComment = function (com_type, st_id, post_id, isStudent) {

            var base = $('#base').val();
            var url = base + 'opl/sendComment';

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    com_type: com_type,
                    com_details: $('#commentArea').val(),
                    com_from: st_id,
                    com_to: post_id,
                    is_student: isStudent,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function (data)
                {
                    $('#discussComments').html(data);
                    $('#commentArea').val('');
                }
            });

            return false;

        };
    });
</script>