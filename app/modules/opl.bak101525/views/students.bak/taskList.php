<!--<section>
    <div class="card card-outline card-blue">
        <div class="card-header">
            <h4 class="page-header"><i class="nav-icon fas fa-tasks"></i> New Task</h4>
            <div class="alert alert-info col-12">
                <h6 class="text-center">No Task for Today</h6>
            </div>
        </div>

    </div>
</section>-->
<section>
    <div class="card card-outline card-blue">
        <div class="card-header">
            <h5 class="page-header"><i class="nav-icon fas fa-tasks"></i> List of Task</h5>
            <table class="table table-striped table-responsive-sm col-12">
                <thead>
                    <tr>
                        <th></th>
                        <th>TASK TITLE</th>
                        <th>DATE CREATED</th>
                        <th class="text-center">DEADLINE FOR SUBMISSION</th>
                        <th class="text-center">STATUS</th>
                    </tr>
                </thead>
                <tbody id="taskBody">
                    <?php echo $this->load->view('tr', array('tasks'=>$tasks)); ?>
                </tbody>
            </table>
        </div>

    </div>
</section>
<script type="text/javascript">
       $(document).ready(function(){
            
            $('.dateTime').each(function(){
                  var id = $(this).attr('task_id');
                  var dateTime = $(this).val();
                  getCountDown(id, dateTime);
            });
            
       });   
       
       
            function getCountDown(id, dateTime) {
                  // Set the date we're counting down to
            var countDownDate = new Date(dateTime).getTime();
    
            // Update the count down every 1 second
            var x = setInterval(function() { 


            // Get today's date and time
                var now = new Date().getTime();
            // Find the distance between now and the count down date
            var distance = countDownDate - now;
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            // Output the result in an element with id="demo"
            var d = (days===0?"":days + "d ");
            
            document.getElementById("op_id_"+id).innerHTML = d + hours + "h "
                    + minutes + "m ";
//            document.getElementById("op_id_"+id).innerHTML = days + "d " + hours + "h "
//                    + minutes + "m " + seconds + "s ";
            // If the count down is over, write some text 
            if (distance < 0) {
               $('#op_id_'+id).html(dateTime);
            }
        }, 1000);
            };
</script>    