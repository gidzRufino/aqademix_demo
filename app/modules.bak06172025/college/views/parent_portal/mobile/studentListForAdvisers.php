<script type="text/javascript">
      $(function(){
			$("#sorter").tablesorter({debug: true});
	});  
</script>
<?php
     $advisory = $this->session->userdata('advisory');
     $section = Modules::run('registrar/getSectionById', $advisory);
     
    
?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header" style="margin:0;">My Students <small> [ <?php echo $num_of_students; ?> ]</small></h3>
    </div>
</div>
<div class="row">
        <div id="links" class="pull-left">
            <?php echo $links; ?>
    </div>
</div>    
<div class="row">
    <table id="sorter" class="tablesorter table table-striped">
        <thead style="background:#E6EEEE;">
            <tr>
                <th>USER ID</th>
                <th>LAST NAME</th>
                <th>FIRST NAME</th>
            </tr> 
        </thead>

        <?php
           foreach ($students as $s)
           {
        ?>
            <tr>
                <td><a href="<?php echo base_url('registrar/viewDetails/'.base64_encode($s->uid)) ?>"><?php echo $s->uid; ?></a></td>
                <td><?php echo strtoupper($s->lastname); ?></td>
                <td><?php echo strtoupper($s->firstname); ?></td>
        </tr> 
        <?php 
            } 
        ?>
    </table>
</div>

<script type="text/javascript">
    
 function next(value)
 {
     if(value!=""){
         var nextPage = parseInt(value) + parseInt(10)
     }else{
         nextPage = 0;
     }
        
     
     document.location = " <?php echo base_url().'registrar/getAllStudentsBySection/'.$advisory?>/"+nextPage
 }
 
 function prev(value)
 {
     if(value>0){
         var nextPage = parseInt(value) - parseInt(10)
     }else{
         nextPage = "";
     }
        
     
     document.location = " <?php echo base_url().'registrar/getAllStudentsBySection/'.$advisory?>/"+nextPage
 }

</script>