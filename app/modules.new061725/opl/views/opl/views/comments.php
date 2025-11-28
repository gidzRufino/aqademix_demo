<?php 
foreach ($comments as $comment): 
    if($comment->com_isStudent==1):
        $profile = Modules::run('opl/opl_variables/getStudentBasicEdInfoByStId', $comment->com_from, $this->session->school_year);
    else:
        $profile = Modules::run('opl/opl_variables/getBasicEmployee', $comment->com_from, $this->session->school_year);
    endif;
?>    
    <div class="card-comment">
        <!-- User image -->
        <img width="50" class="img-circle img-sm" src="<?php echo base_url() . 'uploads/' . $profile->avatar ?>" alt="User Image">

        <div class="comment-text">
            <small>
            <span class="username">
                <?php echo ucwords(strtolower($profile->firstname.' '.$profile->lastname)) ?>
                <span class="text-muted float-right"><?php echo date('F d, Y', strtotime($comment->com_timestamp)) ?></span>
            </span><!-- /.username -->
            <?php echo $comment->com_details; ?>
            </small>
        </div>
        <!-- /.comment-text -->
    </div>
  
<?php
endforeach;
