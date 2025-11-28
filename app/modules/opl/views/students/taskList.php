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
    <!-- List of Task -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-tasks mr-2"></i> List of Tasks</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <?php echo $this->load->view('tr', array('tasks' => $tasks)); ?>
                <!-- <table class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>TASK TITLE</th>
                            <th>DATE STARTED</th>
                            <th class="text-center">DEADLINE FOR SUBMISSION</th>
                            <th class="text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody id="taskBody"> -->
                <?php //echo $this->load->view('tr', array('tasks' => $tasks)); 
                ?>
                <!-- <tr>
                            <td>1</td>
                            <td><i class="fas fa-book text-primary mr-2"></i> Math Assignment</td>
                            <td>Written Work</td>
                            <td>2025-08-20</td>
                            <td><span class="badge badge-success"><i class="fas fa-check mr-1"></i> Completed</span></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><i class="fas fa-flask text-info mr-2"></i> Science Project</td>
                            <td>Performance Task</td>
                            <td>2025-08-25</td>
                            <td><span class="badge badge-warning"><i class="fas fa-hourglass-half mr-1"></i> Pending</span></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><i class="fas fa-pencil-alt text-secondary mr-2"></i> English Essay</td>
                            <td>Written Work</td>
                            <td>2025-08-10</td>
                            <td><span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Missed</span></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr> -->
                <!-- </tbody>
                </table> -->
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    //        $(document).ready(function(){

    //             $('.dateTime').each(function(){
    //                   var id = $(this).attr('task_id');
    //                   var dateTime = $(this).val();
    //                   getCountDown(id, dateTime);
    //             });

    //        });   


    //             function getCountDown(id, dateTime) {
    //                   // Set the date we're counting down to
    //             var countDownDate = new Date(dateTime).getTime();

    //             // Update the count down every 1 second
    //             var x = setInterval(function() { 


    //             // Get today's date and time
    //                 var now = new Date().getTime();
    //             // Find the distance between now and the count down date
    //             var distance = countDownDate - now;
    //             // Time calculations for days, hours, minutes and seconds
    //             var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    //             var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    //             var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    //             var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    //             // Output the result in an element with id="demo"
    //             var d = (days===0?"":days + "d ");

    //             document.getElementById("op_id_"+id).innerHTML = d + hours + "h "
    //                     + minutes + "m ";
    // //            document.getElementById("op_id_"+id).innerHTML = days + "d " + hours + "h "
    // //                    + minutes + "m " + seconds + "s ";
    //             // If the count down is over, write some text 
    //             if (distance < 0) {
    //                $('#op_id_'+id).html(dateTime);
    //             }
    //         }, 1000);
    //             };
</script>