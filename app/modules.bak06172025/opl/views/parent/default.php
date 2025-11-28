<?php 
   // print_r($this->session->userdata());
?>

<?php 
if (count($post) > 1):
    $col = 'col-lg-6';
else:
    $col = 'col-lg-12';
endif;

foreach($post as $p):
    if ($p->op_target_type == 2):
        ?>

        <section class="<?php echo $col; ?> float-left">
            <div class="card card-widget">
                <div class="card-header">
                    <div class="user-block">
                        <img class="img-circle" width="50" src="<?php echo base_url() . 'uploads/' . $p->avatar; ?>" alt="User Image">
                        <span class="username"><a href="#"><?php echo ucwords(strtolower($p->firstname . ' ' . $p->lastname)); ?></a></span>
                        <span class="description">Shared publicly - <?php echo date('F d, Y g:i a', strtotime($p->op_timestamp)) ?> </span>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <?php echo $p->op_post; ?>
                </div>
                <!-- /.card-body -->
            </div>
        </section>
        <?php
    endif;
endforeach;