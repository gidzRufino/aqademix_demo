<section class="card card-cyan card-outline mb-0">
    <div class="card-header">
        <p><i class="fas fa-info-circle fa-2x"></i> Discussions are a good way to encourage your students to think critically about the topic or subject. This is also the page where
    you can put the details of your lessons.</p>
    </div>
    
</section>
    <table class="table table-info table-striped mt-0">
        <tr>
            <th class="text-center" style="width:20px;">#</th>
            <th class="text-center col-lg-3">Title</th>
            <!--<th class="text-center col-lg-4">Details</th>-->
            <th class="text-center col-lg-2">Read By</th>
            <th class="text-center col-lg-2">Comments</th>
        </tr>
        <tbody id="discussionBody">
            <?php echo $this->load->view('disBoardBody', array('discussionDetails'=>$discussionDetails)); ?>
        </tbody>
<?php // print_r($this->session->userdata()); ?>
    </table>