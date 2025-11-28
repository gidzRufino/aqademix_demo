<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of chat_system
 *
 * @author genesis
 */
class Chat_system extends MX_Controller {
    //put your code here
    //Global variable  
    
   public function __construct() {
        parent::__construct();
        //$this->load->library('form_validation');
        //$this->form_validation->CI =& $this;
        $this->load->model('chat_system_model');
        //$this->load->library('pagination');
    }
    
    function onlineUsers()
    {
       $data['onlineUsers'] = Modules::run('users/getUsers');
       $this->load->view('userlist', $data);
    }
        
        
    function chat($action) 
    {
        switch ($action){
            case 'startchatsession':
                $this->startChatSession($this->session->userdata('name'));
            break;
            case 'sendchat':
                $this->sendChat($this->session->userdata('username'));
            break;
            case 'closechat':
                $this->closeChat();
            break;
            case 'chatheartbeat':
                $this->chatHeartbeat($this->session->userdata('username'));
            break;
        }
//            if ($_GET['action'] == "chatheartbeat") { chatHeartbeat(); } 
//            if ($_GET['action'] == "sendchat") { sendChat(); } 
//            if ($_GET['action'] == "closechat") { closeChat(); } 
//            if ($_GET['action'] == "startchatsession") { startChatSession(); } 

            if (!isset($_SESSION['chatHistory'])) {
                    $_SESSION['chatHistory'] = array();	
            }

            if (!isset($_SESSION['openChatBoxes'])) {
                    $_SESSION['openChatBoxes'] = array();	
            }
    }
    
    function startChatSession($username) {
                $items = '';
                if (!empty($_SESSION['openChatBoxes'])) {
                        foreach ($_SESSION['openChatBoxes'] as $chatbox => $void) {
                                $items .= chatBoxSession($chatbox);
                        }
                }


                if ($items != '') {
                        $items = substr($items, 0, -1);
                }
                echo json_encode(array('username' => $username, 'items' => $items));


                exit(0);
        }

function sendChat($from) {
    //$from = $_SESSION['username'];
    $to = $_POST['to'];
    $message = $_POST['message'];

    $_SESSION['openChatBoxes'][$_POST['to']] = date('Y-m-d H:i:s', time());

    $messagesan = $this->sanitize($message);

    if (!isset($_SESSION['chatHistory'][$_POST['to']])) {
            $_SESSION['chatHistory'][$_POST['to']] = '';
    }

$_SESSION['chatHistory'][$_POST['to']] .= <<<EOD
                                   {
                "s": "1",
                "f": "{$to}",
                "m": "{$messagesan}"
   },
EOD;


	unset($_SESSION['tsChatBoxes'][$_POST['to']]);
        
        $data = array(
            'from' => $from,
            'to' => $to,
            'message' => $message,
            'sent' => date('Y-m-d H:i:s', time()),
        );
        
        $this->chat_system_model->saveChat($data);
        
	//$sql = "insert into chat (chat.from,chat.to,message,sent) values ('".mysql_real_escape_string($from)."', '".mysql_real_escape_string($to)."','".mysql_real_escape_string($message)."',NOW())";
	//$query = mysql_query($sql);
	echo "1";
	exit(0);
}

function chatHeartbeat($username) {
         $history = '';
	
//	$sql = "select * from chat where (chat.to = '".mysql_real_escape_string($_SESSION['username'])."' AND recd = 0) order by id ASC";
//	$query = mysql_query($sql);
        
        $messages = $this->chat_system_model->getChats($username);
	$items = '';

	$chatBoxes = array();
        
        foreach ($messages->result() as $ch){
            		if (!isset($_SESSION['openChatBoxes'][$ch->from]) && isset($_SESSION['chatHistory'][$ch->from])) {
			$items = $_SESSION['chatHistory'][$ch->from];
		}

		$chatMessage = $this->sanitize($ch->message);
                


//		$items .= <<<EOD
//			{
//			"s": "0",
//			"f": "{$ch->from}",
//			"m": "{$chatMessage}"
//	   },
//EOD;

	if (!isset($_SESSION['chatHistory'][$ch->from])) {
		$_SESSION['chatHistory'][$ch->from] = '';
	}

	$_SESSION['chatHistory'][$ch->from] .= <<<EOD
						   {
			"s": "0",
			"f": "{$ch->from}",
			"m": "{$ch->from}"
	   },
EOD;
		
		unset($_SESSION['tsChatBoxes'][$ch->from]);
		$_SESSION['openChatBoxes'][$ch->from] = $ch->sent;
        }

//	while ($chat = mysql_fetch_array($query)) {
//
//
//	}

	if (!empty($_SESSION['openChatBoxes'])) {
            foreach ($_SESSION['openChatBoxes'] as $chatbox => $time) {
                    if (!isset($_SESSION['tsChatBoxes'][$chatbox])) {
                            $now = time()-strtotime($time);
                            $time = date('g:iA M dS', strtotime($time));

                            $message = "Sent at $time";
                            if ($now > 180) {
                              $history = array(
                                    's'=>"2",
                                    'f'=>$chatbox,
                                    'm'=>$message
                             );

            if (!isset($_SESSION['chatHistory'][$chatbox])) {
                    $_SESSION['chatHistory'][$chatbox] = '';
            }
                $history = array(
                        's'=>"2",
                        'f'=>$chatbox,
                        'm'=>$message
                 );
                            $_SESSION['tsChatBoxes'][$chatbox] = 1;
                    }
                    }
            }
                $items = array(
                        's'=>"0",
                        'f'=>$ch->from,
                        'username' => $ch->firstname,
                        'm'=>$chatMessage,
                        'sent' => $message
                 );
}


//	$sql = "update chat set recd = 1 where chat.to = '".mysql_real_escape_string($_SESSION['username'])."' and recd = 0";
//	$query = mysql_query($sql);

        $updateChat = array(
            'recd' => 1,
        );
        $this->chat_system_model->updateChat($username, $updateChat);
        
        if($history==NULL):
            $history = '';
        endif;
        
         echo json_encode(array('username' => $username, 'items'=>[$items]));

	 exit(0);
    }

function chatBoxSession($chatbox) {
	
	$items = '';
	
	if (isset($_SESSION['chatHistory'][$chatbox])) {
		$items = $_SESSION['chatHistory'][$chatbox];
	}

	return $items;
}



function sanitize($text) {
        $text = htmlspecialchars($text, ENT_QUOTES);
        $text = str_replace("\n\r","\n",$text);
        $text = str_replace("\r\n","\n",$text);
        $text = str_replace("\n","<br>",$text);
        return $text;
}




function closeChat() {

	//unset($_SESSION['openChatBoxes'][$_POST['chatbox']]);
	
	echo "1";
	exit(0);
}


        //end of chat application
    
}

?>
