<?php foreach($details as $detail):?>
    <section id="discussDetails" class="col-lg-12 col-xs-12 float-left">
        <div class="card card-blue card-outline">
            <div class="card-header">
                <div class="user-block">
                    <!-- <img class="img-circle" width="50" src="<?php echo base_url() . 'uploads/' . $discussionDetails->avatar; ?>" alt="User Image"> -->
                    <span class="username"><?php echo $detail->resource_title?></span>
                    <span class="description"><a href="#"></a> <small></small></span>
                </div>
                <div>
                    <i class="fa fa-trash fa-xs float-right text-danger" style="cursor:pointer;" resource-id="<?php echo $detail->resource_id?>" resource-title="<?php echo $detail->resource_title?>" onclick="readyDelete(this)"></i>
                    <!-- <i class="fa fa-file-pdf fa-xs float-right mr-2 text-primary" style="cursor:pointer;" resource-id="<?php echo $detail->resource_id?>" onclick="toPDF(this)"></i> -->
                    <i class="fa fa-edit fa-xs float-right mr-2 text-success" style="cursor:pointer;" resource-id="<?php echo $detail->resource_id?>" resource-title="<?php echo $detail->resource_title?>" resource-details="<?php echo $detail->resource_details?>" resource-tags="<?php echo $detail->tags?>" grade-id="<?php echo $detail->grade_id?>"  onclick="showEditDiscussion(this)"></i>
                </div>
            </div>
            <div class="card-body">
                <h5 class="font-weight-bold">Details</h5>
                <?php echo $detail->resource_details?>
            </div>
        </div>
    </section>
<?php endforeach; ?>


<?php echo $this->load->view('editResource'); ?>
