<?php
$this->load->helper('file');
$this->load->helper('download');

$new_report=$this->dbutil->csv_from_result($report);


//print_r($new_report);
write_file('uploads/employee_.csv',$new_report);


echo '<h6>employee.csv is successfully exported</h6>';

?>

<button class="btn btn-success" onclick="window.history.back()"><< Back</button>
<script type="text/javascript">

    $(document).ready(function(){
        document.location = '<?php echo base_url('uploads/employee_.csv') ?>';
        
    });

</script>