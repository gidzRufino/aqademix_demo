<!--<div class="card card-widget">
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
</div>-->
<?php
  //  print_r($this->session->userdata());
?>
<?php if(count($post) > 1): ?>
<style>
    @media (min-width: 34em){
        .card-columns{
                -webkit-column-count: 1;
                -moz-column-count: 1;
                column-count: 1;
        }
    }
    @media (min-width: 75em){
        .card-columns{
                -webkit-column-count: 2;
                -moz-column-count: 2;
                column-count: 2;
        }
    }
</style>
<?php else: ?>
<style>
    @media (min-width: 34em){
        .card-columns{
                -webkit-column-count: 1;
                -moz-column-count: 1;
                column-count: 1;
        }
    }
</style>
<?php endif; ?>
<section class="card-columns">
<?php
//print_r($this->session->details);

//if (count($post) > 1):
//    $col = 'col-lg-6';
//else:
//    $col = 'col-lg-12';
//endif;


foreach($post as $p): 
    $avatar = site_url('images'.DIRECTORY_SEPARATOR.'forms'.DIRECTORY_SEPARATOR.$this->eskwela->getSet()->set_logo);
    if($p->avatar != NULL || $p->avatar != ""):
        if(file_exists(FCPATH."uploads".DIRECTORY_SEPARATOR.$p->avatar)):
            $avatar = site_url('uploads'.DIRECTORY_SEPARATOR.$p->avatar);
        endif;
        if(file_exists(FCPATH."uploads".$this->session->school_year.DIRECTORY_SEPARATOR.'faculty'.DIRECTORY_SEPARATOR.$p->avatar)):
            $avatar = site_url('uploads'.$this->session->school_year.DIRECTORY_SEPARATOR.'faculty'.DIRECTORY_SEPARATOR.$p->avatar);
        endif;
    endif;
    $name = ucwords(strtolower($p->firstname.' '.$p->lastname));
    if($p->empid == NULL):
        $student = Modules::run('opl/getStudent', $p->op_owner_id);
        $name = $student->firstname." ".$student->lastname;
        if(file_exists(FCPATH."uploads".$this->session->school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR.$student->avatar)):
            $avatar = site_url('uploads'.$this->session->school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR.$student->avatar);
        endif;
        $query = $this->db->last_query();
    endif;
?>

    <div class="card direct-chat direct-chat-primary">
      <div class="card-header ui-sortable-handle">
        <div class="user-block" hide-query="<?php echo $query; ?>">
            <img class="img-circle" width="50" src="<?php echo $avatar ?>" alt="User Image">
            <span class="username"><a href="#"><?php echo $name; ?></a></span>
            <span class="description">Shared publicly - <time class="timeago" datetime="<?php echo $p->op_timestamp; ?>"><?php echo date('F d, Y g:i a', strtotime($p->op_timestamp)) ?></time> </span>
            
        </div>
          <?php if($p->op_owner_id == $this->session->username || $this->session->isOplAdmin || strcmp($this->session->position, "School Administrator") == 0): ?>
          <button type="button" class="btn btn-outline-danger btn-xs float-right" title="Delete Posts" post-id="<?php echo $p->op_id; ?>" onclick="readyDelete(this)"><i class="fa fa-trash fa-xs"></i></button>
          <?php endif; ?>
      </div>
      <!-- /.card-header -->
      <div class="card-body m-2">
            <?php echo $p->op_post; ?>
      </div>
      <!-- /.card-body -->
      <div class="card-footer pt-1 pb-1" style="background: #F0F0F0">
            <a class="text-xs text-primary" style="cursor: pointer;"><i class="fa fa-thumbs-up fa-xs"></i> Like</a>
      </div>
      <!-- /.card-footer-->
    </div>
<?php endforeach; ?>
</section>
<script type='text/javascript'>

    $(function () {
        $('.textarea').summernote({
            placeholder: "Hey! What's Up! Anything Interesting?"
        });

        submitQuickPost = function (btn)
        {
            var base = $('#base').val();
            var post = $('#postDetails').val();
            var url = base + 'opl/submitQuickPost';
            var subject = $(btn).attr('sub-id');

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    postDetails: post,
                    targets: subject,
                    type: 4,
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