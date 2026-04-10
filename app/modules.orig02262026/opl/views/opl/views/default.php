<div class="card card-widget">
    <div class="card-header">
        <h6>Quick Post</h6>
    </div>
    <div class="card-body">
        <div class="form-group">
            <textarea class="textarea" id="postDetails" placeholder="Hey! What's Up!"
                      style="font-size: 14px; line-height: 15px; border: 1px solid #dddddd; padding: 10px;"></textarea>
        </div>

        <button class="btn btn-primary btn-sm" onclick="submitQuickPost()">POST</button>
    </div>
</div>
<div id="quickPost">

</div>
<?php 
if (count($post) > 1):
    $col = 'col-lg-6';
else:
    $col = 'col-lg-12';
endif;

foreach($post as $p): 
    
?>

<section class="<?php echo $col; ?> float-left">
    <div class="card card-widget">
        <div class="card-header">
            <div class="user-block">
                <img class="img-circle" width="50" src="<?php echo base_url() . 'uploads/' . $p->avatar; ?>" alt="User Image">
                <span class="username"><a href="#"><?php echo ucwords(strtolower($p->firstname.' '.$p->lastname)); ?></a></span>
                <span class="description">Shared publicly - <?php echo date('F d, Y g:i a', strtotime($p->op_timestamp)) ?> </span>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <?php echo $p->op_post; ?>
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-thumbs-up"></i> Like</button>
        </div>
        <!-- /.card-body -->
    <!--    <div class="card-footer card-comments">
            <div class="card-comment">
                 User image 
                <img width="50" class="img-circle img-sm" src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>" alt="User Image">

                <div class="comment-text">
                    <span class="username">
                        Maria Gonzales
                        <span class="text-muted float-right">8:03 PM Today</span>
                    </span> /.username 
                    It is a long established fact that a reader will be distracted
                    by the readable content of a page when looking at its layout.
                </div>
                 /.comment-text 
            </div>

        </div>-->
        <!-- /.card-footer -->
        <div class="card-footer">
            <form action="#" method="post">
                <img class="img-fluid img-circle img-sm" width="50" src="<?php echo base_url() . 'uploads/' . $this->session->basicInfo->avatar; ?>" alt="">
                <!-- .img-push is used to add margin to elements next to floating images -->
                <div class="img-push">
                    <input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">
                </div>
            </form>
        </div>
        <!-- /.card-footer -->
    </div>
</section>
<?php endforeach; ?>
<script type='text/javascript'>

    $(function () {
        $('.textarea').summernote({
            placeholder: "Hey! What's Up! Anything Interesting?"
        });

        submitQuickPost = function ()
        {
            var base = $('#base').val();
            var post = $('#postDetails').val();
            var url = base + 'opl/submitQuickPost';

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    postDetails: post,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                }, // serializes the form's elements.
                //dataType: 'json',
                beforeSend: function () {
                    $('#loadingModal').modal('show');
                },
                success: function (data)
                {
                    alert(data);
                    location.reload();
                }
            });

        }

    });
</script>