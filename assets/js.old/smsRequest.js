$("#sendBtn").click(function() {
     
    var url = "../index.php/messaging/sendSMS/"; // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#MessagingSystem").serialize(), // serializes the form's elements.
           success: function(data)
           {
               $("form#MessagingSystem")[0].reset()
               
              //$("#msgResult").innerHTML='<textarea id="inputMessage" name="message"  onclick="" placeholder="Type in Your Message..." style="margin-left:4px;width:550px; "></textarea>'
               //alert(data); // show response from the php script.
           }
         });
    
    return false; // avoid to execute the actual submit of the form.
    });

function send(num, msg)
   {
       var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
          var data = xmlhttp.responseText;
          

            alert(data);
            //document.getElementById('instance').value = 1
        }
    }

    xmlhttp.open("GET","../index.php/messaging/sendSMS/"+num+"/"+msg,true);
    xmlhttp.send();
   }
   
   function sendToGateWay(num, msg)
   {
       var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
          var data = xmlhttp.responseText;
          

            alert(data);
            //document.getElementById('instance').value = 1
        }
    }

    xmlhttp.open("GET","http://192.168.2.100:8181/send/sms/"+num+"/"+msg,true);
    xmlhttp.send();
   }
