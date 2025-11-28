function saveAdmission(data)
    {
      //alert(num);
       
        var setAction = document.getElementById('setAction').value;
        if(setAction=='doubleChecked'){
            //alert('got it')
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
                case 'generateId':
                     document.getElementById("iA").value=xmlhttp.responseText;
                     document.getElementById("inputIdNum").value=xmlhttp.responseText;
                      
                break;
                case 'setAdmission':
                     showHidePreloader(false);
                     document.getElementById("result").innerHTML=xmlhttp.responseText;
                      
                break;
                case 'changePass':
                     document.getElementById("resultSection").innerHTML=xmlhttp.responseText;
                     //alert('Information Saved');
//                     document.getElementById("userInput").value="";
                    //document.getElementById('check_holder').style.display = 'block'; 
                break;
                case 'saveSection':
                     document.getElementById("resultSection").innerHTML="Section Saved...";
                     document.getElementById("inputSection").innerHTML=xmlhttp.responseText;
//                     document.getElementById("userInput").value="";
                    //document.getElementById('check_holder').style.display = 'block'; 
                break;
                case 'saveId':
                     document.getElementById("resultSection").innerHTML="Identification Card Registered...";
//                     document.getElementById("userInput").value="";
                    //document.getElementById('check_holder').style.display = 'block'; 
                break;
                case 'getRegister':
                     document.getElementById("resultSection").innerHTML="Account Successfully Registered";

                break;
                
                case 'getAllStudent':
                     document.getElementById("tableResult").innerHTML=xmlhttp.responseText;
                break;
                
                case 'getEnrollmentList':
                     document.getElementById("enrollmentResults").innerHTML=xmlhttp.responseText;
                break;
                
                case 'login':
                     document.location ="index.php/studentgate/dashboard";
                break;
                
                case 'getStudent':
                     document.getElementById("tableResult").innerHTML=xmlhttp.responseText;
                break;
                
                case 'saveInfo':
                     document.getElementById("f_con").innerHTML=xmlhttp.responseText;
                break;
                
                case 'scan':
                    document.getElementById("body-scan").innerHTML=xmlhttp.responseText;          
                    document.getElementById("rfid").value="";          
                    document.getElementById("rfid").focus(); 
                    var register = document.getElementById("triggerNotify").value;
                    if(register == 1){
                        startCount(2, 1000, timeIsUp,'countDown')
                        
                    }
                    
                    if(document.getElementById("triggerReload").value==0){
                        startCount(30,1000, reload, 'trigger')
                    }
                    var utype = document.getElementById("utype").value;
                    // comment by gadz
                    if(utype==5){
                        sendMessage('Your '+document.getElementById('gender').value + ' '+document.getElementById('name').value + ' is already '+document.getElementById('AmPm').value+' at '+ document.getElementById('time').value, document.getElementById('number').value,'send'); 
                    }
                    
                   
                break;
                
                case 'scanRfid':
                    document.getElementById("body-scan").innerHTML=xmlhttp.responseText;          
                    document.getElementById("rfid").value="";          
                    document.getElementById("rfid").focus(); 
                    var register = document.getElementById("triggerNotify").value;
                    if(register == 1){
                        startCount(2, 1000, timeIsUp,'countDown')
                        
                    }
                    
                    if(document.getElementById("triggerReload").value==0){
                        startCount(30,1000, reload, 'trigger')
                    }
                    var utype = document.getElementById("utype").value;
                    var number = document.getElementById('number').value
                    var dhContact = document.getElementById('dhContact').value
                    //alert(utype)
                    // comment by gadz
                    if(utype==5){
                        if(number==0 || number==""){
                            //alert("sorry you don't have a number")
                        }else{
                           sendMessage('Your '+document.getElementById('gender').value + ' '+document.getElementById('name').value + ' is already '+document.getElementById('AmPm').value+' at '+ document.getElementById('time').value, document.getElementById('number').value,'send');  
                        }
                        //
                    }else{
                        if(dhContact==0 || dhContact==""){
                            //alert("sorry you don't have a number")
                        }else{
                          var msg = document.getElementById('gender').value + ' '+document.getElementById('name').value + ' is already '+document.getElementById('AmPm').value+' at '+ document.getElementById('time').value;  
                          sendMessage(msg, dhContact,'send');  
                         // alert(dhContact)
                          //alert(msg+' '+dhContact);
                        }
                        
                    }
                    
                   
                break;
                case 'doubleChecked':
                    document.getElementById("body-scan").innerHTML=xmlhttp.responseText;          
                    document.getElementById("rfid").value="";          
                    document.getElementById("rfid").focus();
                    var register = document.getElementById("triggerNotify").value;
                    if(register == 1){
                        startCountDown(2, 1000, timeIsUp)
                        
                    }
                    
                break;
                case 'setDeleteS':
                     document.getElementById("entryTable").innerHTML=xmlhttp.responseText;
                break;
                case 'searchDate':
                     document.getElementById("TableResults").innerHTML=xmlhttp.responseText;
                break;
                case 'savePhysician':
                     document.getElementById("inputFPhy").innerHTML=xmlhttp.responseText;
                break;
                case 'saveOR':
                    document.getElementById("tableResult").innerHTML=xmlhttp.responseText;
                break;
                case 'deactivate':
                    document.getElementById("tableResult").innerHTML=xmlhttp.responseText;
                break;
                case 'generateReport3':
                    document.getElementById("enrollmentResults").innerHTML=xmlhttp.responseText;
                break;

            }        
           }
        }
         switch(setAction){
            case 'deactivate':
                xmlhttp.open("GET","../studentgate/deactivateStudents/"+data,true);
            break;
            case 'saveOR':
                xmlhttp.open("GET","../studentgate/saveOR/"+data,true);
            break;
            case 'generateId':
                xmlhttp.open("GET","../studentgate/generateId/"+data,true);
            break;
            case 'scan':
                xmlhttp.open("GET","../login/scanRfid/"+data,true);
            break;
            case 'scanRfid':
                xmlhttp.open("GET","../login/scanRfid/"+data,true);
            break;
            case 'doubleChecked':
                xmlhttp.open("GET","../login/doubleChecked/"+data,true);
            break;
            case 'changePass':
                xmlhttp.open("GET","../studentgate/changePass/"+data,true);
            break;
            case 'setAdmission':
                xmlhttp.open("GET", "../studentgate/saveAdmission/"+data, true);
            break;    
            case 'saveSection':
                xmlhttp.open("GET", "../studentgate/saveSection/"+data, true);
            break; 
           case 'saveId':
                xmlhttp.open("GET", "../studentgate/saveId/"+data, true);
            break; 
           case 'getRegister':
                xmlhttp.open("GET", "index.php/login/getRegister/"+data, true);
            break; 
           case 'login':
                xmlhttp.open("GET", "index.php/login/getInside/"+data, true);
            break; 
            
            case 'getStudent':
                xmlhttp.open("GET", "../studentgate/getStudents/"+data, true);
            break;
            case 'getAllStudent':
                xmlhttp.open("GET", "../studentgate/getAllStudents/"+data, true);
            break;
            case 'saveInfo':
                xmlhttp.open("GET", "../../studentgate/setUpdatePContact/"+data, true);
            break;
            
            case 'setDeleteS':
                xmlhttp.open("GET", "../studentgate/setDeleteEntry/"+data, true);    
            break;
            
            case 'searchDate':
                xmlhttp.open("GET", "../login/searchDate/"+data, true);    
            break;
            case 'savePhysician':
                xmlhttp.open("GET", "../studentgate/savePhysician/"+data, true);    
            break;
            case 'getEnrollmentList':
                xmlhttp.open("GET", "../studentgate/getEnrollmentList/"+data, true);    
            break;
            case 'generateReport3':
                xmlhttp.open("GET", "../studentgate/generateReport3/"+data, true);    
            break;
    }
        xmlhttp.send();
    }
    
function sendMessage(msg,num,Action)
    {
       // alert('hola');
       
        var setAction = Action;
        if(setAction=='userInput'){
        //alert(str);
        }
        if (msg=="")
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
                case 'userInput':
                     document.getElementById("output").innerHTML=xmlhttp.responseText;
                     document.getElementById("userInput").value="";
                     document.getElementById('sub_task').value = "numInput";
                        //alert("hello");
                     sendMessage(document.getElementById('id_value').value, document.getElementById('name').value +" is already in School at "+document.getElementById('time').value, document.getElementById('number').value )
                
                    //document.getElementById('check_holder').style.display = 'block'; 
                break;
                case 'search' :
                    document.getElementById("result").innerHTML = xmlhttp.responsText;
            }       
           
            }
        }
         switch(setAction){
            case 'send':
                xmlhttp.open("GET","http://localhost:8181/send/sms/"+num+"/"+msg,true);
            break;
           
    }
        xmlhttp.send();
    }

    
function sectionAction(data)
    {
      //alert(num);
       var url = document.getElementById('baseUrl').value;
        var setSection = document.getElementById('setSection').value;
        if(setSection=='getMonthAll'){
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
            var setSection = document.getElementById('setSection').value;
            

            switch(setSection){
                case 'getCriteria':
                    document.getElementById("criteriaList").innerHTML=xmlhttp.responseText;
                   // document.getElementById("inputSectionModal").innerHTML=xmlhttp.responseText;
                break;
                
                case 'selectSection':
                    document.getElementById("inputSection").innerHTML=xmlhttp.responseText;
                    document.getElementById("inputSectionModal").innerHTML=xmlhttp.responseText;
                break;
                case 'selectSectionA':
                    document.getElementById("inputSection").innerHTML=xmlhttp.responseText;
                   // document.getElementById("inputSectionModal").innerHTML=xmlhttp.responseText;
                break;
                case 'getStudentBySection':
                    document.getElementById("recordStudent").innerHTML=xmlhttp.responseText;
                   // document.getElementById("inputSectionModal").innerHTML=xmlhttp.responseText;
                break;
                case 'getStudentBySectionA':
                    document.getElementById("recordStudent").innerHTML=xmlhttp.responseText;
                   // document.getElementById("inputSectionModal").innerHTML=xmlhttp.responseText;
                break;
                case 'getSubjectBySection':
                    document.getElementById("selectSubject").innerHTML=xmlhttp.responseText;
                   // document.getElementById("inputSectionModal").innerHTML=xmlhttp.responseText;
                break;
                
                case 'getSubjectBySectionInCriteria':
                    document.getElementById("selectSubjectInCriteria").innerHTML=xmlhttp.responseText;
                   // document.getElementById("inputSectionModal").innerHTML=xmlhttp.responseText;
                break;
                
                case 'getQuizBySubject':
                    document.getElementById("quizResult").innerHTML=xmlhttp.responseText;
                    document.getElementById('setSection').value ='getStudentBySection'
                    sectionAction(document.getElementById('getSection').value)
                    document.getElementById("inputSectionModal").innerHTML=xmlhttp.responseText;
                break;
                case 'getQuiz':
                    document.getElementById("quizResult").innerHTML=xmlhttp.responseText;
                    
                    if(document.getElementById('getSection').value!="noSection"){
                            document.getElementById('setSection').value ='getStudentBySection'
                            sectionAction(document.getElementById('getSection').value)
                    }
                   // document.getElementById("inputSectionModal").innerHTML=xmlhttp.responseText;
                break;
        
            }        
           }
        }
         switch(setSection){
            
            
           
            case 'getCriteria':
                xmlhttp.open("GET",url+"gradingSystemSettings/getCriteria/"+data,true);
            break;
            
            case 'selectSection':
                xmlhttp.open("GET",url+"studentgate/selectSection/"+data,true);
            break;
            case 'selectSectionA':
                xmlhttp.open("GET",url+"gradingSystem/selectSection/"+data,true);
            break;
            case 'getStudentBySection':
                xmlhttp.open("GET",url+"studentgate/getStudentBySection/"+data,true);
            break;
            case 'getStudentBySectionA':
                xmlhttp.open("GET",url+"studentgate/getStudentBySection/"+data,true);
            break;
            case 'getSubjectBySection':
                xmlhttp.open("GET",url+"gradingSystem/getSubjectBySection/"+data,true);
            break;
            case 'getSubjectBySectionInCriteria':
                xmlhttp.open("GET",url+"gradingSystemSettings/getSubjectBySectionInCriteria/"+data,true);
            break;
            case 'getQuizBySubject':
                xmlhttp.open("GET", url+"gradingSystem/getQuizBySubject/"+data,true);
            break;
            case 'getQuiz':
                xmlhttp.open("GET", url+"gradingSystem/getQuiz/"+data,true);
            break;
            
            
                
             
    }
        xmlhttp.send();
}


function saveParent(parent)
    {
       //alert('hola');
       
         var setAction = document.getElementById('setAction').value;
        if(setAction=='saveAdmission'){
        //alert(csv);
        }
        if (parent=="")
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
                case 'saveAdmission':
                     document.getElementById("result").innerHTML=xmlhttp.responseText;
                    //document.getElementById('check_holder').style.display = 'block'; 
                break;
                case 'searchParent':
                     document.getElementById("parentResults").innerHTML=xmlhttp.responseText;
                    
                break;
                
                case 'selectSection':
                    document.getElementById("inputSection").innerHTML=xmlhttp.responseText;
                    document.getElementById("inputSectionModal").innerHTML=xmlhttp.responseText;
                break;
                
                
            }       
           
            }
        }
         switch(setAction){
             case 'selectSection':
                xmlhttp.open("GET","../studentgate/selectSection/"+data,true);
            break;
            case 'setAdmission':
                xmlhttp.open("GET", "../studentgate/saveParent/"+parent, true);
            break;
            case 'saveMed':
                xmlhttp.open("GET", "../studentgate/saveMed/"+parent, true);
            break;
            case 'searchParent':
                xmlhttp.open("GET", "../studentgate/searchParent/"+parent, true);
            break;
           
    }
        xmlhttp.send();
    }
    
function setTime(timeIn,timeOut, entry,userRole)
    {
       //alert('hola');
       
         var setAction = document.getElementById('setAction').value;
        if(setAction=='setTime'){
        alert(timeIn);
        }
        if (parent=="")
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
                case 'setTime':
                     document.getElementById("entryTable").innerHTML=xmlhttp.responseText;
                    //document.getElementById('check_holder').style.display = 'block'; 
                break;
                
            }       
           
            }
        }
         switch(setAction){
            case 'setTime':
                xmlhttp.open("GET", "../studentgate/setTime/"+timeIn+"/"+entry+"/"+userRole+"/"+timeOut, true);
            break;
           
    }
        xmlhttp.send();
    }

//digital clock

function digital_clock()
{
var date=new Date()
var hours=date.getHours()
var TwentyFour=date.getHours()
var minutes=date.getMinutes()
var seconds=date.getSeconds()

/*
*Calls the addZero function to add a zero infront of minutes or seconds if they are below 10, i.e.
*to make it look like 12:07:09, not 12:7:9
*/
if(hours > 12){
    var hourstoTwelve = hoursLessTwelve(hours);
    hours= addZero(hourstoTwelve)
}
minutes=addZero(minutes)
seconds=addZero(seconds)

/*
*Puts hours in the element with the hours id,
*minutes in the element with the minutes id,
*and seconds in the element with the seconds id
*/
document.getElementById('clock')
.innerHTML = hours+':'+minutes
document.getElementById('clockHidden').value = hours+':'+minutes
document.getElementById('clockReport').value = TwentyFour+''+minutes
//document.getElementById('minutes')
//.innerHTML = minutes
//document.getElementById('seconds')
//.innerHTML = seconds
/*
*Runs every half second
*/
setTimeout('digital_clock()', 500)
}
/*
Adds a zero infront of minutes or seconds
*/
function addZero(min_or_sec)
{
if (min_or_sec < 10)
{min_or_sec="0" + min_or_sec}
return min_or_sec
}
function hoursLessTwelve(hourstoTwelve)
{
    if (hourstoTwelve > 12){
        hourstoTwelve = hourstoTwelve - 12;    
    }
    return hourstoTwelve
}

function launchFullScreen(element) {
  if(element.requestFullScreen) {
    element.requestFullScreen();
  } else if(element.mozRequestFullScreen) {
    element.mozRequestFullScreen();
  } else if(element.webkitRequestFullScreen) {
    element.webkitRequestFullScreen();
  }
}

function emailValidator(elem, helperMsg){
        if(elem.value!=''){
            var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(elem.value.match(emailExp)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
        }else{
            return true;
        }
	
}

function notEmpty(elem, helperMsg){
                if(elem.value.length == 0){
                        alert(helperMsg);
                        elem.focus(); // set the focus to this input
                        return false;
                }
                return true;
        }
        
 function showContent(){
                showHidePreloader(false);
                //document.getElementById('resultDiv').innerHTML=dataReturn;
            }

function showHidePreloader(show){
    if(show)
        document.getElementById('loading').style.display='block';
    else
        document.getElementById('loading').style.display='none';
        location.reload(true);
}

function timeIsUp(){
    document.getElementById("notify").style.display="none";
}

function reload(){
    document.getElementById('setAction').value = 'doubleChecked';
    saveAdmission("1");
}