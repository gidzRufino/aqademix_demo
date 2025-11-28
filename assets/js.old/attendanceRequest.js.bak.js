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
             
    }
        xmlhttp.send();
}

