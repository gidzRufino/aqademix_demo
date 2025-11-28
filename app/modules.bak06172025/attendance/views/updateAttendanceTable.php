
<button class="btn btn-primary" onclick="getAttendance(), startTime()">update</button><br /><br />
<div style="font-size: 12px;"  id="refreshTimer"></div><br /><br />
<span class="hide" id="counter">0</span><br/><br/>
<span style="font-size: 15px; font-weight: bold; float:right;" id="timer">0 : 0   </span>
Number of Updated Rows : <span id="count">0</span><br/><br/>


   <script>
   function startTime(){
     var hou = 0;
     var sec = 0;
     setInterval(function(){

       document.getElementById("timer").innerHTML = hou +" : " + sec ;
       sec++;
       if(sec == 60)
       {
         hou++;
         sec = 00;
         if (hou == 60)
         {
            hou = hou+1;
         }
       }
      },1000);
    }
    </script>
<table id="" class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Student ID</th>
        <th>Previous Date</th>
        <th>Current Date</th>
    </tr>
    
</table>
<table id="tableResult" class="table table-striped table-bordered">
    
</table>
<script type="text/javascript">

    
    var cnt = 0;
    var cntr = 0;
    var num = $('#counter').html()
    function getAttendance(limit)
    {
      // alert(num) 
        var url = '<?php echo base_url().'attendance/getAttendanceSheetsM/' ?>'
        var update
        $.ajax({
               type: "POST",
               url: url,
               dataType: 'json',
               data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
              
               success: function(data)
               {
                   //console.log(data)
                  update = data.updates
                  var item = update.split(';')
                    var limit = item.length - 1;
                    for (var i=0;i<limit;i++)
                   {   
                       
                       //console.log(item[i])
                       var item2 = item[i].split('_')
                       //console.log()
                       updateAttendance(item2[0], item2[1], i)
                      // sendToWeb(item[i])
                       //sentos(item[i])
                   }

               }
             });

        return false;
            
        
    }
    
    function updateAttendance(updates, dates, count)
    {
        var url = '<?php echo base_url().'attendance/updateAttendancePerRow/' ?>'+updates+'/'+dates
        var num = $('#counter').html()
        var counter = $('#count').html()
        
        
        $.ajax({
               type: "POST",
               url: url,
               //dataType: 'json',
               data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
              
               success: function(data)
               {
                   //console.log(data)
                 $('#tableResult').prepend(data)
                 $('#counter').html(parseInt(num)+1);
                 $('#count').html(parseInt(counter)+1);
                 
                 getAttendance()
                if(parseInt(num)==20)
                    {
                         $('#tableResult').html('')
                         $('#counter').html(0)
                         //console.clear()
                    }
                if(parseInt(num)==2 || parseInt(num)==4 || parseInt(num)==6 || parseInt(num)==8 || parseInt(num)==10 || parseInt(num)==12 || parseInt(num)==14 || parseInt(num)==16 || parseInt(num)==18 || parseInt(num)==20){
                    console.clear()
                }
                         
               }
             });

        return false;
    }
</script>