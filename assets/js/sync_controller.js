function saveOnlineData(onlineData)
{
    
    var base_url = $('#base_url').val();
    var url = base_url+'web_sync/saveOnlineData/'; // the script where you handle the form input.
    $.ajax({
          type: "POST",
          url: url,
          data: 'status=1&updates='+onlineData+'&csrf_test_name='+$.cookie('csrf_cookie_name'),  // serializes the form's elements.
          //dataType: 'json',
          success: function(data)
          {
              console.log(data)
                
          }
        });

   return false;
    
}
function getOnlineData()
{
    var web_address = $('#web_address').val()
    var url = 'https://'+web_address+'/web_sync/checkOnlineData/'
    $.ajax({
          type: "POST",
          crossDomain: true,
          url: url,
          data: 'status=1&csrf_test_name='+$.cookie('csrf_cookie_name'),  // serializes the form's elements.
          //dataType: 'json',
          success: function(data)
          {
             
             var item = data.split(';')
             var limit = item.length - 1;
             for (var i=0;i<limit;i++)
            {   
                //console.log(item[i]);
                saveOnlineData(item[i]);
            }
          }
          
        });

       return false; 
    
}


function getNumData()
{
    var base_url = $('#base_url').val()
    var url = base_url+'web_sync/getNumData'; // the script where you handle the form input.
    $.ajax({
          type: "POST",
          url: url,
          data: 'status=1'+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
          //dataType: 'json',
          success: function(data)
          {
              //alert(data)
              $('#noOfRecords').html(data)
              $('#noOfRecordsRemaining').html(data)
              $('#checkRemaining').val(data)
              checkRemainingRecords(data)

          }
        });

   return false;  
}

function checkRemainingRecords(numOfRecords)
{
    if(numOfRecords==0){
        $('#onSyncMessage').addClass('hide');
        $('#onSyncComplete').removeClass('hide');
        
    }else{
       // alert('hey')
    }
}

function checkData()
{
    var base_url = $('#base_url').val()
    var url = base_url+'web_sync/checkData'; // the script where you handle the form input.
    $.ajax({
          type: "GET",
          url: url,
          data: 'status=1'+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
          //dataType: 'json',
          success: function(data)
          {
              //alert('hey')
             var item = data.split(';')
             var limit = item.length - 1;
             for (var i=0;i<limit;i++)
            {   
                //console.log(item[i]);
                sendToWeb(item[i])
                //sentos(item[i])
            }

          }
        });

   return false;  
}

function sendToWeb(updates)
{
    var web_address = $('#web_address').val()
    var url = 'https://'+web_address+'/web_sync/sendToWeb/'
    $.ajax({
          type: "POST",
          crossDomain: true,
          url: url,
          data: 'status=1&updates='+updates+'&csrf_test_name='+$.cookie('csrf_cookie_name'),  // serializes the form's elements.
          dataType: 'json',
          success: function(data)
          {
              //console.log(data)
              if(data.status){
                  resetUpdate(data.id);
                  var updateCounter = $('#updateCounter').val()
                  var checkRemaining = $('#checkRemaining').val()
                  var numOfRecords = $('#noOfRecordsRemaining').html()
                  $('#noOfRecordsRemaining').html(parseInt(numOfRecords)-1)
                  $('#updateCounter').val(parseInt(updateCounter)+1)
                  $('#checkRemaining').val(parseInt(numOfRecords)-1)
                  var remaingRecords = parseInt(numOfRecords)-1;
                  checkRemainingRecords(remaingRecords)
              }else{
                  $('#updateCounter').val(parseInt(updateCounter)+1)
              }
              if(updateCounter==20){
                  //checkData()
                  $('#updateCounter').val(0)
              }

          }
        });

       return false; 
}

function resetUpdate(id)
{
    var base_url = $('#base_url').val()
    var url = base_url+'web_sync/emptyTable/'+id
    $.ajax({
          type: "POST",
          crossDomain: true,
          url: url,
          data: 'status=1'+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
          dataType: 'json',
          success: function(data)
          {
              if(data.status){
                  console.log(data.id)
                  //checkData()
              }

          }
        });

       return false; 
}

function sentos(id)
{
    var base_url = $('#base_url').val()
    var url = base_url+'web_sync/send/'+id
    $.ajax({
          type: "POST",
          //crossDomain: true,
          url: url,
          data: 'status=1'+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
          //dataType: 'json',
          success: function(data)
          {
              console.log(data)

          }
        });

       return false; 
}

function syncDataToWeb()
{
    var web_address = $('#web_address').val()
    var url = 'https://'+web_address+'/web_sync/catchData/'
}



function getData(url)
{
      $.ajax({
              type: "POST",
              url: url,
              data: 'status=1', // serializes the form's elements.
              dataType: 'json',
              success: function(data)
              {
                  //alert(data.updates);
                  sendToWeb(data.id, data.updates, data.action, data.table, data.pk, data.pk_value);
              }
            });

       return false; 
}

function sendToWebold(id, updates, action, table, pk, pk_value)
{
    var web_address = $('#web_address').val()
    var url = 'http://'+web_address+'/web_sync/catchData/'+updates+'/'+action+'/'+table+'/'+pk+'/'+pk_value
    $.ajax({
          type: "POST",
          crossDomain: true,
          url: url,
          data: 'status=1', // serializes the form's elements.
          dataType: 'json',
          success: function(data)
          {
              if(data.status){
                  resetUpdate(id);
                  var updateCounter = $('#updateCounter').val()
                  var checkRemaining = $('#checkRemaining').val()
                  var numOfRecords = $('#noOfRecordsRemaining').html()
                  $('#noOfRecordsRemaining').html(parseInt(numOfRecords)-1)
                  $('#updateCounter').val(parseInt(updateCounter)+1)
                  $('#checkRemaining').val(parseInt(numOfRecords)-1)
                  var remaingRecords = parseInt(numOfRecords)-1;
                  checkRemainingRecords(remaingRecords)
              }else{
                  $('#updateCounter').val(parseInt(updateCounter)+1)
              }
              if(updateCounter==20){
                 // checkData()
                  $('#updateCounter').val(0)
              }

          }
        });

       return false; 
}

function timestamp(time)
{
    var ts = Date.parse('01/01/2020 '+time);
    return (ts/10000);
}


