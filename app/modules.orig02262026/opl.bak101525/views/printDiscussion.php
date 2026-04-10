<page size="A4">
    <div style="padding: 30px 50px;">
        <?php if($st_id!=NULL): 
            $subject = Modules::run('opl/opl_variables/getSubjectById', $details->dis_subject_id);
            ?>
        <h3>Name: <?php echo $this->session->details->firstname.' '.$this->session->details->lastname ?></h3>
        <h3>Subject: <?php echo strtoupper($subject->subject) ?></h3>
        <hr />
        <?php endif; ?>
        <h2 style="text-align: center"><?php echo $details->dis_title ?></h2>
        <?php echo $details->dis_details; ?>
    </div>
</page>