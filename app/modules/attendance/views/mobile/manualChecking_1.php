<div data-role="page" id="absentPage">
    <div style="margin:0 10%;" class="row">
        <div class="control-group pull-left">
            <div class="controls">
                <input name="inputBdate" type="text" data-date-format="mm/dd/yyyy" value="<?php echo date("m/d/Y"); ?>" id="inputBdate" placeholder="Search for Date" required>
            </div>

        </div>
        <button class=" btn-success btn-small pull-right" onclick="searchAttendance($('#inputBdate').val())">SEARCH</button>

        
    </div>
    
    <div id="attendanceSearchResult"> 
        <div class="" id="absent">
            <?php 
                echo Modules::run('attendance/getAbsents', $section_id, $this->session->userdata('attend_auto')) ;
            ?>
        </div>
    </div>
    <div data-position="fixed"  data-theme="b" data-role="footer" >
        <div data-role="navbar">
            <ul>
                <li><a onclick="document.location=this.href" data-transition="slideup"  href="<?php echo base_url().'attendance/dailyPerSubject' ?>#presentPage"  data-icon="plus">Present</a></li>
                <li><a data-transition="slideup"  href="#absentPage" class="ui-btn-active" data-icon="delete">Absent</a></li>
                                
            </ul>
        </div>

    </div>         
</div>

<div data-role="page" id="presentPage">
     <div data-position="fixed" data-role="header" data-theme="b">
        <button onclick="document.location='<?php echo base_url().'main/dashboard' ?>'" class="ui-btn-left ui-btn ui-btn-b ui-btn-inline ui-corner-all ui-btn-icon-notext ui-icon-home"></button> 
        <h4 id="myModalLabel">Daily Attendance</h4>
        <button onclick="window.history.back()" class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-corner-all ui-btn-icon-right ui-icon-back">Back</button>
    </div>
    <div id="present" class="row">
            <h4 style="background:white; padding:5px;"  class="text-center ">Present [ <span id="att_total" style="margin:0px;"><?php echo $records->num_rows() ?></span> ] </h4>
            <div class="col-xs-12 table-responsive">
                <table id="table_present" style="width:100%; padding:0; margin:0;" align="center" class='table table-stripped table-bordered'>
                    <tr>
                        <td style="width:55%">Name of Student</td>
                        <td id="getRemarks"  >Remarks
                            <a href="#"><i  class="fa fa-plus-circle fa-2x clickover pointer pull-right"  ></i></a>
                        </td>
                    </tr>
                    <?php
                        $i = 1;
                        //print_r($records->result());
                        foreach ($records->result() as $row)
                        {
                            $remarks = Modules::run('attendance/getAttendanceRemark', $row->rfid, $row->date);
                    ?>
                    <tr  valign="middle" id="<?php echo $row->rfid ?>_tr">
                        <td  onclick="getMe('<?php echo $row->rfid ?>')" id="remarks_<?php echo $row->rfid ?>_td" style="padding:5px 0 5px 5px">
                            <h5><?php echo strtoupper($row->lastname.', '.$row->firstname) ?>
                            </h5>

                        </td>

                        <td>
                            <strong class="pull-left"><?php echo $remarks->row()->category_name ?></strong>
                            <i onclick="deleteAttendance('<?php echo $row->att_id ?>','<?php echo $row->rfid ?>')" class="fa fa-trash fa-2x pull-right"></i>

                        </td>

                    </tr>
                     <?php
                        }
                     ?>
                </table>
        </div>
  </div>
<div data-position="fixed"  data-theme="b" data-role="footer" >
    <div data-role="navbar">
        <ul>
            <li><a data-transition="slideup" onclick="document.location=this.href" href="<?php echo base_url().'attendance/dailyPerSubject' ?>#presentPage" class="ui-btn-active" data-icon="plus">Present</a></li>
            <li><a data-transition="slideup" onclick="document.location=this.href"  href="<?php echo base_url().'attendance/dailyPerSubject' ?>#absentPage" data-icon="delete">Absent</a></li>

        </ul>
    </div>

</div>        

<div id="remarksModal">
    <div id="enterRemarks" class="hide clearfix" style="width:90%; margin:50px auto 0; z-index: 3000 !important; border-radius:5px; height:auto; padding:5px; background:white;">
        <div class="contentHeader">
            <h4>Add Attendance Remark</h4>
        </div>
        <select name='inputRemark' id='inputRemark' class='' required>
            <option>Select Remark</option>                     
            <option value='1'>Late</option>                     
            <option value='2'>Cutting Classes</option>                     

          </select>
        <div class="col-md-12">
            <button onclick="saveAttendanceRemarks(),$('#secretContainer').addClass('hide')"  data-dismiss="modal" id="saveScoreBtn" class="btn btn-primary pull-right">Save </button>
            <button class="btn btn-danger pull-right" onclick="$('#secretContainer').addClass('hide')"  data-dismiss="modal" aria-hidden="true" >Close</button>
            
        </div>
    </div>
</div>

</div>
<input type="text" id="remarks_st_id" name="selectStudentId" />
<input type="hidden" id="prevSelected" name="selectStudentId" />


<script type="text/javascript">
    $('#getRemarks').click(function(){
         //  alert('got')
          $('#secretContainer').removeClass('hide');
            $('#secretContainer').html($('#remarksModal').html()) 
            $('#enterRemarks').removeClass('hide');
            $('#enterRemarks').fadeIn();
          
        });
     $(document).ready(function() {
          
           $('#inputBdate').datepicker();
           $(".clickover").clickover({
                placement: 'left',
                html: true
              });
          
     });
     $('body').bind("swiperight", function(e){
              document.location='<?php echo base_url().'attendance/dailyPerSubject' ?>#presentPage'
     })
     $('body').bind("swipeleft", function(e){
              document.location='<?php echo base_url().'attendance/dailyPerSubject' ?>#absentPage'
     })
     

     
     function showWindow(show, hide)
    {
        $('#'+hide).hide('500');
        $('#'+show).show('500');

    }
    
    function getRemarks()
    {
        $('#secretContainer').removeClass('hide');
            $('#secretContainer').html($('#remarksModal').html()) 
            $('#enterRemarks').removeClass('hide');
            $('#enterRemarks').fadeIn();
    }
    
    function getMe(id)
    {
        var prev = $('#prevSelected').val()
        if(prev=="")
            {
                document.getElementById("prevSelected").value = id;
                document.getElementById(id+'_tr').style.background='#9F9F9F'
                document.getElementById("remarks_st_id").value = id;
            }
        if(prev==id){
            if(document.getElementById(id+'_tr').style.background !='#FFF'){
                document.getElementById(id+'_tr').style.background='#FFF'
            }else{
                document.getElementById(id+'_tr').style.background='#9F9F9F'
            }
            
        }
        if(prev!=id){
            document.getElementById(id+'_tr').style.background='#9F9F9F'
            document.getElementById(prev+'_tr').style.background='#FFF'
            document.getElementById("prevSelected").value = id;
        }
        
        document.getElementById("remarks_st_id").value = id;
        
    }
    
    function saveAttendance(st_id, rfid)
       {
          //; alert(rfid)
          var date  = $('#inputBdate').val()
            var url = "<?php echo base_url().'attendance/saveAttendance' ?>"; // the script where you handle the form input.
            $("#h6_"+st_id).fadeOut();
            var att_total = $('#att_total').html();
            var totalAtt = parseInt(att_total)+parseInt(1);
            $('#att_total').html(totalAtt);
            $.ajax({
                   type: "POST",
                   url: url,
                   data: "id="+rfid+"&st_id="+st_id+"&date="+date+"&section_id="+<?php echo $section_id; ?>, // serializes the form's elements.
                   success: function(data)
                   {
                       //$("form#quoteForm")[0].reset()
                       $('#present').html(data)
                   }
                 });

            return false;
    } 
    
    function searchAttendance(date)
    {
            var url = "<?php echo base_url().'attendance/searchAttendance' ?>"; // the script where you handle the form input.
            
            $.ajax({
                   type: "POST",
                   url: url,
                   data: "date="+date+"&section_id="+<?php echo $section_id; ?>, // serializes the form's elements.
                   success: function(data)
                   {
                       //$("form#quoteForm")[0].reset()
                       document.location = data
                   }
                 });

            return false;
    }
    
    function saveSearchAttendance(rfid, user_id, date)
       {
            var url = "<?php echo base_url().'attendance/saveSearchAttendance' ?>"; // the script where you handle the form input.
            $("#h6_"+rfid).fadeOut();
            $.ajax({
                   type: "POST",
                   url: url,
                   data: "id="+rfid+"&section_id="+<?php echo $section_id; ?>+"&user_id="+user_id+"&date="+date, // serializes the form's elements.
                   success: function(data)
                   {
                       //$("form#quoteForm")[0].reset()
                       $('#attendanceResult').html(data);
                   }
                 });

            return false;
    } 
    
    function saveAttendanceRemarks()
    {
        var url = "<?php echo base_url().'attendance/saveAttendanceRemark' ?>";
        var remark = $('#inputRemark').val()
        var st_id = $('#remarks_st_id').val()
        var date = $('#inputBdate').val()
        var remark_from = "<?php echo $this->session->userdata('username') ?>"
        $.ajax({
               type: "POST",
               url: url,
               data: "date="+date+"&st_id="+st_id+"&remark="+remark+"&remark_from="+remark_from+"&section_id="+<?php echo $section_id; ?>, // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                  
                  //location.reload();
               }
             });
        alert('successfully saved');  
        location.reload();
            return false;
    }
    
    function deleteAttendance(id, st_id)
     { //alert(st_id)
         var url = "<?php echo base_url().'attendance/deleteAttendance' ?>"; // the script where you handle the form input.
            var att_total = $('#att_total').html();
            var totalAtt = parseInt(att_total - 1);
            $('#att_total').html(totalAtt);
            $("#"+st_id+"_tr").fadeOut();
            $.ajax({
                   type: "POST",
                   url: url,
                   data: "att_id="+id+"&section_id="+<?php echo $section_id ?>, // serializes the form's elements.
                   success: function(data)
                   {
                       //$("form#quoteForm")[0].reset()
                     
                   }
                 });

            return false;
     }

</script>
