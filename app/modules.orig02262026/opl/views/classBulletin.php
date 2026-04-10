<?php echo Modules::run('opl/opl_widgets/topWidget', $subject_id, $section_id, $grade_level);
//print_r($this->session->oplSessions);
?>
<div id="cbHolder">

</div>

<?php echo $this->load->view('tasks/editTask'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="popover"]').popover({
            html: true
        });
        $('.textarea').summernote({
            toolbar: [
                ['misc', ['print']]
            ]
        });

        console.log("<?php echo base_url('opl/cbPost') ?>");

        $.ajax({
            type: "GET",
            url: '<?php echo base_url('opl/cbPost') ?>',
            beforeSend: function() {
                $('#cbHolder').html('<img style="display:block; margin:0 auto; width:125px;"  src="<?php // echo base_url() 
                                                                                                    ?>/images/loading.gif">');
            },
            success: function(response) {
                // console.log(response);
                // $("#table_dis").html(response);
                $('#cbHolder').html(response);
            },
            error: function() {
                alert("Operation Failed");
            }
        });
    });
</script>