function saveRequest(data)
    {
      //alert(num);
       
        var setAction = document.getElementById('setAction').value;
        if(setAction=='getPosition'){
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
                case 'setEmployee':
                     //document.getElementById("result").innerHTML=xmlhttp.responseText;
                     
                break;
                case 'getEmployee':
                     document.getElementById("employeeResult").innerHTML=xmlhttp.responseText;
                     
                break;
                
                case 'getPosition':
                     document.getElementById("inputPosition").innerHTML=xmlhttp.responseText;
                     //alert(data);
                     
                break;
                
                //gadz
                case 'getPositionEdit':
                    document.getElementById("inputPosition").innerHTML=xmlhttp.responseText;
                     //alert(data);
                     
                break;
                
                case 'saveNewPosition':
                     document.getElementById("inputPosition").innerHTML=xmlhttp.responseText;
                     //alert(data);
                     
                break;
                case 'saveContact':
                     showHidePreloader(false);
                     //alert("Employee Information Saved");
                    // document.getElementById("inputPosition").innerHTML=xmlhttp.responseText;
                     //alert(data);
                     
                break;
                
                case 'saveAcademe':
                    // document.getElementById("inputPosition").innerHTML=xmlhttp.responseText;
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
                case 'setAssignment':
                     document.getElementById("assignmentResults").innerHTML=xmlhttp.responseText;
                     var register = document.getElementById("triggerNotify").value;
                    if(register == 1){
                        startCountDown(3, 1000, timeIsUp)
                    }
                     
                break;
                
                case 'checkAdvisory':
                    document.getElementById("warning").innerHTML=xmlhttp.responseText;
                     var register = document.getElementById("triggerNotify").value;
                    if(register == 1){
                        startCountDown(3, 1000, timeIsUp)
                    }
                     
                break;
                
                case 'setAdviser':
                     document.getElementById("inputPosition").innerHTML=xmlhttp.responseText;
                     document.getElementById("isAdviser").value = 1;
                     document.getElementById("labelPosition").innerHTML = "Grade Level";
                break;
                
                case 'generateReport2':
                     document.getElementById("form2Results").innerHTML=xmlhttp.responseText;

                break;
               
            }        
           }
        }
         switch(setAction){
           
            case 'setEmployee':
                xmlhttp.open("GET", "../employee/saveEmployee/"+data, true);
            break; 
            case 'getEmployee':
                xmlhttp.open("GET", "../../employee/getEmployee/"+data, true);
            break; 
            
            case 'getPosition':
                xmlhttp.open("GET", "../employee/getPosition/"+data, true);
            break;   
            case 'getPositionEdit':
                xmlhttp.open("GET", "../../employee/getPosition/"+data, true);
            break; 
            case 'saveNewPosition':
                xmlhttp.open("GET", "../employee/saveNewPosition/"+data, true);
            break;   
            
            case 'saveContact':
                xmlhttp.open("GET", "../employee/saveContact/"+data, true);
            break;    
            
            case 'saveAcademe':
                xmlhttp.open("GET", "../employee/saveAcademe/"+data, true);
            break;    
            
            case 'setSchoolName':
                xmlhttp.open("GET", "../employee/setSchoolName/"+data, true);
            break;    
            case 'searchDtrbyDate':
                xmlhttp.open("GET", "../../employee/searchDtrbyDate/"+data, true);
            break;    
            case 'setAssignment':
                xmlhttp.open("GET", "../employee/setAssignment/"+data, true);
            break;    
            case 'setAdviser':
                xmlhttp.open("GET", "../employee/setAdviser/"+data, true);
            break;    
            case 'checkAdvisory':
                xmlhttp.open("GET", "../employee/checkAdvisory/"+data, true);
            break;    
            case 'generateReport2':
                xmlhttp.open("GET", "../studentgate/generateReport2/"+data, true);
            break;    
             
    }
        xmlhttp.send();
}

function adminRequest(data)
{
    var setAction = document.getElementById('setAction').value;
        if(setAction=='getPosition'){
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
                case 'deleteAdvisory':
                     document.getElementById("assignmentResults").innerHTML=xmlhttp.responseText;
                     var register = document.getElementById("triggerNotify").value;
                    if(register == 1){
                        startCountDown(3, 1000, timeIsUp)
                    }
                     
                break;

                case 'checkAdvisory':
                    document.getElementById("warning").innerHTML=xmlhttp.responseText;
                     var register = document.getElementById("triggerNotify").value;
                    if(register == 1){
                        startCountDown(3, 1000, timeIsUp)
                    }
                     
                break;
                
                case 'setAdviser':
                     document.getElementById("inputPosition").innerHTML=xmlhttp.responseText;
                     document.getElementById("isAdviser").value = 1;
                     document.getElementById("labelPosition").innerHTML = "Grade Level";
                break;
                
                case 'getEmployee':
                     document.getElementById("EmResult").innerHTML=xmlhttp.responseText;
                     document.getElementById("saveAccess").disabled = ''
                break;
                
                case 'saveDbAccess':
                     //document.getElementById("EmResult").innerHTML=xmlhttp.responseText;
                     
                break;

            }        
           }
        }
         switch(setAction){
           
            case 'deleteAdvisory':
                xmlhttp.open("GET", "../studentgateProcess/deleteAdvisory/"+data, true);
            break; 
            
            case 'getEmployee':
                 xmlhttp.open("GET", "../admin/getEmployee/"+data, true);
             break;
            case 'saveMenuAccess':
                 xmlhttp.open("GET", "../admin/saveMenuAccess/"+data, true);
             break;
            
             
    }
        xmlhttp.send();
}
function hrRequest(data)
{
    var setAction = document.getElementById('setAction').value;
        if(setAction=='saveAssociates'){
            //alert(data);
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
                case 'saveAssociates':
                     document.getElementById("whereYouBelong").innerHTML=xmlhttp.responseText;
                     var register = document.getElementById("triggerNotify").value;
                    if(register == 1){
                        startCountDown(3, 1000, timeIsUp)
                    }
                     
                break;
                
                case 'validateReport':

                break;

            }        
           }
        }
         switch(setAction){
           
            case 'saveAssociates':
                xmlhttp.open("GET", "../employee/saveDepartmentHeadsAssociates/"+data, true);
            break; 
            
            
            case 'validateReport':
                xmlhttp.open("GET", "../employee/validateReport/"+data, true);
            break; 
            
            
            
             
    }
        xmlhttp.send();
}



