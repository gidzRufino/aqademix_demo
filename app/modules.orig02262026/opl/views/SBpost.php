<?php if(count($post) != 1): ?>
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
        if(file_exists(FCPATH."uploads".$this->session->school_year.DIRECTORY_SEPARATOR.'faculty'.DIRECTORY_SEPARATOR.$p->employee_id.DIRECTORY_SEPARATOR.$p->avatar)):
            $avatar = site_url('uploads'.$this->session->school_year.DIRECTORY_SEPARATOR.'faculty'.DIRECTORY_SEPARATOR.$p->employee_id.DIRECTORY_SEPARATOR.$p->avatar);
        endif;
    endif;
?>
    <div class="card direct-chat direct-chat-primary">
      <div class="card-header ui-sortable-handle">
        <div class="user-block">
            <img class="img-circle" width="50" src="<?php echo $avatar ?>" alt="User Image">
            <span class="username"><a href="#"><?php echo ucwords(strtolower($p->firstname.' '.$p->lastname)); ?></a></span>
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


