function AttendRequest(data)
    {
      //alert(num);
       
        var setAction = document.getElementById('setAction').value;
        if(setAction=='getMonthAll'){
         // alert(data);
        }
        if (data=="")
        {
        document.getElementById("output").innerHTML="";
        return;
        }
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            var setAction = document.getElementById('setAction').value;
            

            switch(setAction){
                case 'getToday':
                     document.getElementById("TableResults").innerHTML=xmlhttp.responseText;
                     
                break;
                
                case 'getTodayAll':
                     document.getElementById("TableResults").innerHTML=xmlhttp.responseText;
                     //alert(data);
                     
                break;
                case 'getMonth':
                   document.getElementById("TableResults").innerHTML=xmlhttp.responseText;
                     //alert(data);
                     
                break;
                
                case 'getMonthAll':
                   document.getElementById("TableResults").innerHTML=xmlhttp.responseText;
                     //alert(data);
                     
                break;
                
                case 'setSchoolName':
                     document.getElementById("schoolName").innerHTML=xmlhttp.responseText;
                     //alert(data);
                     
                break;
                case 'searchDtrbyDate':
                     document.getElementById("TableResult").innerHTML=xmlhttp.responseText;
                     //alert(data);
                     
                break;
                case 'QuarterOn':
                     document.getElementById("TableResults").innerHTML=xmlhttp.responseText;
                     //alert(data);
               
                break;
                case 'year':
                     document.getElementById("TableResults").innerHTML=xmlhttp.responseText;
                     //alert(data);
               
                break;
                case 'getMonthForParents':
                     document.getElementById("monthlyResults").innerHTML=xmlhttp.responseText;
                     //alert(data);
               
                break;
                case 'getDailyAttendance':
                     document.getElementById("nameOfStudent").innerHTML=xmlhttp.responseText;
                     //alert(data);
               
                break;
                case 'getStudentByFname':
                     document.getElementById("tableResult").innerHTML=xmlhttp.responseText;
                     document.getElementById('linkParentBtn').style.display = '';
                     //alert(data);
               
                break;
                case 'getVerified':
                    document.getElementById("confirm").innerHTML=xmlhttp.responseText;
                    var results = document.getElementById('vResults').value;
                    if(results==='1'){
                        document.getElementById('regUname').disabled="";
                        document.getElementById('pass0').disabled="";
                        document.getElementById('pass1').disabled="";
                        document.getElementById('regUname').focus();
                    }else{
                        document.getElementById('confirmation').value = 'Sorry Information not Found';
                        document.getElementById("verifyP").className = "input-prepend input-append control-group error";
                        document.getElementById('regUname').disabled="disabled";
                        document.getElementById('pass0').disabled="disabled";
                        document.getElementById('pass1').disabled="disabled";
                        document.getElementById('verify').focus();
                        
                    }
                    
                break;
                
                
               
               
            }        
           }
        }
         switch(setAction){
           
            case 'getToday':
                xmlhttp.open("GET", "../../login/getToday/"+data, true);
            break; 
            
            case 'getTodayAll':
                xmlhttp.open("GET", "../login/getToday/"+data, true);
            break;   
            
            case 'getMonth':
                xmlhttp.open("GET", "../../login/getMonth/"+data, true);
            break;    
            
            case 'getMonthAll':
                xmlhttp.open("GET", "../login/getMonthAll/"+data, true);
            break;    
            
            case 'setSchoolName':
                xmlhttp.open("GET", "../employee/setSchoolName/"+data, true);
            break;    
            case 'searchDtrbyDate':
                xmlhttp.open("GET", "../../employee/searchDtrbyDate/"+data, true);
            break;    
            case 'QuarterOn':
                xmlhttp.open("GET", "../login/quarterOn/"+data, true);
            break;
            case 'year':
                xmlhttp.open("GET", "../login/yearOn/"+data, true);
            break;
            case 'getMonthForParents':
                xmlhttp.open("GET", "../login/getMonthForParents/"+data, true);
            break;
            case 'getDailyAttendance':
                xmlhttp.open("GET", "../attendance/getDailyAttendance/"+data, true);
            break;
            
            case 'getStudentByFname':
                xmlhttp.open("GET", "../studentgate/searchStudentsByFName/"+data, true);
            break;
            
            case 'getVerified':
                xmlhttp.open("GET", "../studentgate/login/getVerified/"+data, true);
            break;
           
             
    }
        xmlhttp.send();
}

function saveGetAttendance(data)
{
        var setAction = document.getElementById('setAction').value;
        if(setAction=='attendanceUpdate'){
          alert(data);
        }
        if (data=="")
        {
        document.getElementById("output").innerHTML="";
        return;
        }
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            var setAction = document.getElementById('setAction').value;
            

            switch(setAction){
                case 'attendanceUpdate':
                     document.getElementById("attendanceResult").innerHTML=xmlhttp.responseText;
                     
                break;
                case 'getIndividual':
                     document.getElementById("Daily").innerHTML=xmlhttp.responseText;
                     //alert(data);
               
                break;
                
               
            }        
           }
        }
         switch(setAction){
           
            case 'attendanceUpdate':
                xmlhttp.open("GET", "attendance/attendanceOveride/"+data, true);
            break;    
             case 'getIndividual':
                xmlhttp.open("GET", "../../attendance/indivualMonthlyAttendance/"+data, true);
            break;
    }
        xmlhttp.send();
}

function webSync(data)
{
       var xmlhttp;
       //alert(data);
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
           
            document.getElementById("display").innerHTML=xmlhttp.responseText;
            
        }
    }

    xmlhttp.open("GET",data,true);
    xmlhttp.send();
}

