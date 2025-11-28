/*

Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)

This script may be used for non-commercial purposes only. For any
commercial purposes, please contact the author at 
anant.garg@inscripts.com

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

*/

var windowFocus 		= true;
var username;
var chatHeartbeatCount 	= 0;
var minChatHeartbeat 	= 1000;
var maxChatHeartbeat 	= 33000;
var chatHeartbeatTime 	= minChatHeartbeat;
var originalTitle;
var blinkOrder 			= 0;
var user_id;

var chatboxFocus 		= new Array();
var newMessages 		= new Array();
var newMessagesWin 		= new Array();
var chatBoxes 			= new Array(); 
var chat_url            = $('#chat_url').val();
var chatuser;


//$.noConflict();

$(document).ready(function(){
	originalTitle = document.title;
	//startChatSession();

	$([window, document]).blur(function(){
		windowFocus = false;
	}).focus(function(){
		windowFocus = true;
		document.title = originalTitle;
	});
});



function chatWith(chatuser, user_id) {
	createChatBox(user_id,1,chatuser);
	$("#chatbox_"+user_id+" .chatboxtextarea").focus();
}

//**********************************************************************************************************
	// createChatBox
//**********************************************************************************************************


function createChatBox(user_id,minimizeChatBox,chatuser) {
	if ($("#chatbox_"+user_id).length > 0) {
		if ($("#chatbox_"+user_id).css('display') == 'none') {
			$("#chatbox_"+user_id).css('display','block');
			restructureChatBoxes();
		}
		$("#chatbox_"+user_id+" .chatboxtextarea").focus();
		return;
	}

	$(" <div />" ).attr("id","chatbox_"+user_id)
	.addClass("chatbox panel panel-green")
	.html('<div class="chatboxhead"><div class="panel-heading ">'+chatuser+' <div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\''+user_id+'\')"><i class="fa fa-minus-square"></i></a> <a href="javascript:void(0)" onclick="javascript:closeChatBox(\''+user_id+'\')"><i class="fa fa-close"></i></a></div></div></div><div class="panel-body" style="padding:0 15px;"><ul class="chatboxcontent chat" style="padding:0;"></ul></div><div class="chatboxinput panel-footer"><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+user_id+'\');"></textarea></div>')
	.appendTo($( "body" ));
			   
	$("#chatbox_"+user_id).css('bottom', '0px');
	$("#chatbox_"+user_id).css('margin-bottom', '0');
	
	chatBoxeslength = 0;

	for (x in chatBoxes) {
		if ($("#chatbox_"+chatBoxes[x]).css('display') != 'none') {
			chatBoxeslength++;
		}
	}

	if (chatBoxeslength == 0) {
		$("#chatbox_"+user_id).css('right', '20px');
	} else {
		width = (chatBoxeslength)*(225+7)+20;
		$("#chatbox_"+user_id).css('right', width+'px');
	}
	
	chatBoxes.push(user_id);

	if (minimizeChatBox == 1) {
		minimizedChatBoxes = new Array();

		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}
		minimize = 0;
		for (j=0;j<minimizedChatBoxes.length;j++) {
			if (minimizedChatBoxes[j] == user_id) {
				minimize = 1;
			}
		}

		if (minimize == 1) {
			$('#chatbox_'+user_id+' .chatboxcontent').css('display','none');
			$('#chatbox_'+user_id+' .chatboxinput').css('display','none');
		}
	}

	chatboxFocus[user_id] = false;

	$("#chatbox_"+user_id+" .chatboxtextarea").blur(function(){
		chatboxFocus[user_id] = false;
		$("#chatbox_"+user_id+" .chatboxtextarea").removeClass('chatboxtextareaselected');
	}).focus(function(){
		chatboxFocus[user_id] = true;
		newMessages[user_id] = false;
		$('#chatbox_'+user_id+' .chatboxhead').removeClass('chatboxblink');
		$("#chatbox_"+user_id+" .chatboxtextarea").addClass('chatboxtextareaselected');
	});

	$("#chatbox_"+user_id).click(function() {
		if ($('#chatbox_'+user_id+' .chatboxcontent').css('display') != 'none') {
			$("#chatbox_"+user_id+" .chatboxtextarea").focus();
		}
	});

	$("#chatbox_"+user_id).show();
	///////////////
	//$("#chatbox_"+user_id).draggable();
	//$(".chatbox_").draggable();
	///////////
}

//**********************************************************************************************************
	// checkChatBoxInputKey
//**********************************************************************************************************

function checkChatBoxInputKey(event,chatboxtextarea,user_id) {
	 
	if(event.keyCode == 13 && event.shiftKey == 0)  {
		message = $(chatboxtextarea).val();
		message = message.replace(/^\s+|\s+$/g,"");

		$(chatboxtextarea).val('');
		$(chatboxtextarea).focus();
		$(chatboxtextarea).css('height','44px');
		if (message != '') {
			//$.post("http://localhost/CodeIgniter/application/views/chat/chat.php?action=sendchat", {to: user_id, message: message} , function(data){
                    $.ajax({
                       type: "POST",
                       dataType: 'json',
                       url:chat_url+"sendchat",
                       data: 'csrf_test_name='+$.cookie('csrf_cookie_name')+'&to='+user_id+'& message='+message, // serializes the form's elements.
                       success: function(data)
                       {
                            message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
                            $("#chatbox_"+user_id+" .chatboxcontent").append('<li class="chatboxmessage"><span class="chatboxmessagefrom right clearfix">'+data.name+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+message+'</span></li>');
                            $("#chatbox_"+user_id+" .chatboxcontent").scrollTop($("#chatbox_"+user_id+" .chatboxcontent")[0].scrollHeight);
                          
                       }    
                     });

                    return false;
		}

		return false;
	}

	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

	if (maxHeight > adjustedHeight) {
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			$(chatboxtextarea).css('height',adjustedHeight+8 +'px');
	} else {
		$(chatboxtextarea).css('overflow','auto');
	}
	 
}

//**********************************************************************************************************
	// restructureChatBoxes
//**********************************************************************************************************


function restructureChatBoxes() {
	align = 0;
	for (x in chatBoxes) {
		user_id = chatBoxes[x];

		if ($("#chatbox_"+user_id).css('display') != 'none') {
			if (align == 0) {
				$("#chatbox_"+user_id).css('right', '20px');
			} else {
				width = (align)*(225+7)+20;
				$("#chatbox_"+user_id).css('right', width+'px');
			}
			align++;
		}
	}
}




//**********************************************************************************************************
	// startChatSession
//**********************************************************************************************************

function startChatSession(){  
	$.ajax({
	  //url: "http://localhost/CodeIgniter/application/views/chat/chat.php?action=startchatsession",
	  url: chat_url+"startchatsession",
	  cache: false,
	  dataType: "json",
	  success: function(data) {
 
                //alert(data.username)
		username = data.username;

		$.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug

				user_id = item.f;

				if ($("#chatbox_"+user_id).length <= 0) {
					createChatBox(user_id,1);
				}
				
				if (item.s == 1) {
					item.f = username;
				}

				if (item.s == 2) {
					$("#chatbox_"+user_id+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
					$("#chatbox_"+user_id+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+item.f+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
				}
			}
		});
		
		for (i=0;i<chatBoxes.length;i++) {
			user_id = chatBoxes[i];
			$("#chatbox_"+user_id+" .chatboxcontent").scrollTop($("#chatbox_"+user_id+" .chatboxcontent")[0].scrollHeight);
			setTimeout('$("#chatbox_"+user_id+" .chatboxcontent").scrollTop($("#chatbox_"+user_id+" .chatboxcontent")[0].scrollHeight);', 100); // yet another strange ie bug
		}
	// smith
		//$("#chatbox_"+user_id).draggable();
		//$(".chatbox_").draggable();
	////////////////
	setTimeout('chatHeartbeat();',chatHeartbeatTime);
	
	}});
}





//**********************************************************************************************************
	// chatHeartbeat
//**********************************************************************************************************



//**********************************************************************************************************
	// closeChatBox
//**********************************************************************************************************

function closeChatBox(user_id) {
	$('#chatbox_'+user_id).css('display','none');
	restructureChatBoxes();

//	$.post("http://localhost/CodeIgniter/application/views/chat/chat.php?action=closechat", { chatbox: user_id} , function(data){	
	$.post(chat_url+"?action=closechat", { chatbox: user_id} , function(data){	
	});

}


//**********************************************************************************************************
	// toggleChatBoxGrowth
//**********************************************************************************************************

function toggleChatBoxGrowth(user_id) {
	if ($('#chatbox_'+user_id+' .chatboxcontent').css('display') == 'none') {  
		
		var minimizedChatBoxes = new Array();
		
		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}

		var newCookie = '';

		for (i=0;i<minimizedChatBoxes.length;i++) {
			if (minimizedChatBoxes[i] != user_id) {
				newCookie += user_id+'|';
			}
		}

		newCookie = newCookie.slice(0, -1)


		$.cookie('chatbox_minimized', newCookie);
		$('#chatbox_'+user_id+' .chatboxcontent').css('display','block');
		$('#chatbox_'+user_id+' .chatboxinput').css('display','block');
		$("#chatbox_"+user_id+" .chatboxcontent").scrollTop($("#chatbox_"+user_id+" .chatboxcontent")[0].scrollHeight);
	} else {
		
		var newCookie = user_id;

		if ($.cookie('chatbox_minimized')) {
			newCookie += '|'+$.cookie('chatbox_minimized');
		}


		$.cookie('chatbox_minimized',newCookie);
		$('#chatbox_'+user_id+' .chatboxcontent').css('display','none');
		$('#chatbox_'+user_id+' .chatboxinput').css('display','none');
	}
	
}





/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

$.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = $.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};










