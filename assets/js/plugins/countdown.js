function startCountDown(i, p, f,id, Option) {

// store parameters
    var pause = p;
    var fn = f;
    var timers;
    // make reference to div
    var countDownObj = document.getElementById(id);
    if (countDownObj == null) {
    // error
        alert("div not found, check your id");
    // bail
    return;
    }
    countDownObj.count = function(i) {
    // write out count
    countDownObj.innerHTML = i;
    if (i == 0) {
    // execute function
    fn();
    // stop
    return;
    }
    
    timers = setTimeout(function() {
    // repeat
        countDownObj.count(i - 1);
        },
        pause
        );
     if(Option == 0){
         clearTimeout(timers);
     }
    }
    // set it going
    countDownObj.count(i);
    
    
    
}

function startCount(i, p, f,id) {
// store parameters
    var pause = p;
    var fn = f;
    // make reference to div
    var countDownObj = document.getElementById(id);
    if (countDownObj == null) {
    // error
        alert("div not found, check your id");
    // bail
    return;
    }
    countDownObj.count = function(i) {
    // write out count
    countDownObj.innerHTML = i;
    if (i == 0) {
    // execute function
    fn();
    // stop
    return;
    }
    setTimeout(function() {
    // repeat
    countDownObj.count(i - 1);
    },
    pause
    );
    }
    // set it going
    countDownObj.count(i);
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