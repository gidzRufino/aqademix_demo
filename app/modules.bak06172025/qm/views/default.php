<div class="col-lg-12 no-padding">
    <div class="page-header no-margin clearfix">
        <h2 class="no-margin col-lg-10">List of Assessment</h2>
        <div class="pull-right btn-group" style="margin-top: 5px;">
            <button onclick="document.location='<?php echo base_url('qm') ?>'" class="btn btn-sm btn-default" >DASHBOARD</button>
            <button onclick="$('#addQuiz').modal('show')" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="col-lg-6">
        <h5>List of Test Created [ Personal ]</h5>
        <?php 
            foreach ($list->result() as $l):
        ?>
        <div onclick="document.location='<?php echo base_url().'qm/createItems/'.$l->qi_id ?>'" class="alert alert-info clearfix pointer">
            <?php echo $l->qi_title ?> <span class="badge" style="<?php if($l->qi_is_final): echo 'background:green;'; else:'background:red;'; endif; ?>"><?php if($l->qi_is_final): echo 'Published'; else:'Unpublished'; endif; ?></span>
            <small class="pull-right">[ <?php echo date('M d, Y', strtotime($l->qi_date_created)) ?> ]</small>
        </div>
        <?php
            endforeach;
        ?>
    </div>
    <div style="border-left:1px solid #bce8f1; min-height: 300px;" class="col-lg-6">
        <h5>List of Test Created [ Public ]</h5>
        
    </div>
</div>

<?php $this->load->view('quizModal');