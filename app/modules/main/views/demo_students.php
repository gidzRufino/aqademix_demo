
<div class="container-fluid row">
    <div style="margin-top: 10px">
        <button type="button" onclick="location.href='<?php echo site_url('main/demographics/').$city_id."/".$barangay_id; ?>'" class="btn btn-default btn-sm pull-left"><i class="fa fa-arrow-left"></i></button>
        <div class="col-md-4 pull-right input-group">
            <input type="text" class="form-control" placeholder="Search (e.g Firstname, lastname, student id, Section, grade level)" onkeypress="if(event.which == 13) doSearch(this.value)">
            <div class="input-group-addon"><i class="fa fa-search"></i></div>
        </div>
    </div>
    <script>
        function doSearch(value) {
            $.ajax("<?php echo site_url('main/fetchDemoStudents/'); ?>",{
                type: "POST",
                data:{
                    city_id: "<?php echo $city_id; ?>",
                    barangay_id: "<?php echo $barangay_id; ?>",
                    student: value,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function(data){
                    $("#demoTable").html(data)
                }
            });
        }
    </script>
    <div id="studentTable" class="row table-responsive" style="margin-top: 50px;">
        <table style="font-size:12px;" class="tablesorter table table-striped">
            <thead style="background:#E6EEEE;">
                <tr>
                    <th>Image</th>
                    <th>USER ID</th>
                    <th>LAST NAME</th>
                    <th>FIRST NAME</th>
                    <th>MIDDLE NAME</th>
                    <th>GRADE</th>
                    <th>SECTION</th>
                    <th>GENDER</th>
                    <td>School Year</td>
                </tr> 
            </thead>
            <tbody id='demoTable'>
                <?php $this->load->view('demograph_table', array('students' => $students)); ?>
            </tbody>
        </table>
    </div>
</div>