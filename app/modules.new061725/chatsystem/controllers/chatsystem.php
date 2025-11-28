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
class chatsystem extends MX_Controller {
    //put your code here
    //Global variable  
    
   public function __construct() {
        parent::__construct();
        //$this->load->library('form_validation');
        //$this->form_validation->CI =& $this;
        $this->load->model('chat_system_model');
        //$this->load->library('pagination');
    }
    
    function saveChatLog($name, $message)
    {
        
    }
    
    function getPChat($to, $message)
    {
        
            foreach ($message->result() as $msg) {
                if($msg->chat_from == $this->session->userdata('user_id')):
                    $class = 'alert alert-success pull-right col-lg-10';
                else:
                    $class = 'alert alert-info pull-left col-lg-10';
                endif;
                ?>
                <li class="<?php echo $class ?>" style="margin-bottom:5px; padding:2px">
                    <span class="chatboxmessagecontent"><?php echo $msg->message ?></span>
                </li>
        <?php
            }
    }
    
    function getPreviousChat()
    {
        $to = $this->input->post('to');
        $message = $this->chat_system_model->getPreviousChat($to,$this->session->userdata('user_id'));
        $last_id = $this->chat_system_model->getChats($this->session->userdata('user_id'));
       // print_r($this->session->userdata('user_id'));
        if(!$message):
            $body = '';
            $rel = '';
            $lid = 0;
            $hasMessage = FALSE;
        else:
            if($message->num_rows > 0):
            
                $body = Modules::run('chatsystem/getPChat', $to, $message);
                $lid = $last_id->row()->id;
                $rel = $message->row()->relation;
                $hasMessage = TRUE;
            else:
                $body = Modules::run('chatsystem/getPChat', $to, $message);
                $lid = $last_id->row()->id;
                $rel = $message->row()->relation;
                $hasMessage = FALSE;
            endif;
            
        endif;
        
        echo json_encode(array(
                  'last_id' => $lid,
                  'rel' => $rel,
                  'body' =>  $body,  
                  'hasMessage'=> $hasMessage
        ));
    }
    
    function showChatBox()
    {
        $message = $this->chat_system_model->checkForNewMessage($this->session->userdata('user_id'));
            foreach ($message->result() as $msg) {
                if($msg->chat_from == $this->session->userdata('user_id')):
                    $class = 'alert alert-success pull-right col-lg-10';
                else:
                    $class = 'alert alert-info pull-left col-lg-10';
                endif;
                ?>
                <li class="<?php echo $class ?>" style="margin-bottom:5px; padding:2px">
                    <span class="chatboxmessagecontent"><?php echo $msg->message ?></span>
                </li>
        <?php
            }
    }
    
    function getMultipleUserID($id)
    {
        $id = $this->chat_system_model->countNewMessage($id);
        $last_key = end(array_keys($id->result()));
        foreach ($id->result() as $key => $id)
        {
            $ids .= $id->chat_from;
            if ($key == $last_key) {
                // last element
            } else {
               $ids .= ',';
            }
            $names .= $id->firstname;
            if ($key == $last_key) {
                // last element
            } else {
               $names .= ',';
            }
            $rel .= $id->relation;
            if ($key == $last_key) {
                // last element
            } else {
               $rel .= ',';
            }
            $num_msg += 1;
            if ($key == $last_key) {
                // last element
            } else {
               $num_msg .= ',';
            }
        }
            
        
        return json_encode(array('ids'=> $ids, 'names' => $names, 'rel' => $rel, 'num_msg' => $num_msg));
    }
    
    function loadNewMessage()
    {          
        $last_id = $this->input->post('last_id');
        $to = $this->input->post('to');
        $pasttime = time();
        $message = $this->chat_system_model->getChats($this->session->userdata('user_id'));
        while((time()-$pasttime)<30):
            $message = $this->chat_system_model->getChats($this->session->userdata('user_id'));
            if($message->row()->id > $last_id):
                    if($message->num_rows>0):
                        $body = Modules::run('chatsystem/showChatBox');
                        $hasMessage = TRUE;
                    else:
                        $body = '';
                        $hasMessage = FALSE;
                    endif;
                    
                    echo json_encode(array(
                          'id' => 'chitchat_'.$to,
                          'last_id' => $message->row()->id,
                          'rel' => $message->row()->rel,
                          'num_msgs' => $message->num_rows-$last_id,
                          'body' =>  $body,
                          'hasMessage' => $hasMessage
                    ));
            break;
            else:
                sleep( 5 );
                continue;
            endif;
        endwhile;
        //print_r($message);
       if($message->row()->id==$last_id):
            echo json_encode(array(
                          'id' => 'chitchat_'.$to,
                          'last_id' => $message->row()->id,
                          'rel' => $message->row()->rel,
                          'num_msgs' => $message->num_rows-$last_id,
                          'body' =>  $body,
                          'hasMessage' => FALSE
                    ));
       endif;
        
    }
    
    function readMessage($pChat_id)
    {
        $details = array('recd' => 1);
        $this->chat_system_model->readMessage($details, $this->session->userdata('user_id'), $pChat_id);
        return;
    }
    
    function checkForNewMessage()
    {
          $message = $this->chat_system_model->getChats($this->session->userdata('user_id'));
          if($message->num_rows>0):
              $body = Modules::run('chatsystem/showChatBox');
              $hasMessage = TRUE;
          else:
              $body = '';
              $hasMessage = FALSE;
          endif;
          $namesID = json_decode($this->getMultipleUserID($this->session->userdata('user_id')));
          echo json_encode(array(
                'last_id' => $message->row()->id,
                'ids' => $namesID->ids ,
                'names' => $namesID->names,
                'rel' => $namesID->rel,
                'num_msgs' => $message->num_rows,
                'body' =>  $body,
                'hasMessage' => $hasMessage
          ));
    }
    
    
    function sendChat($name) {
        $from = $this->session->userdata('user_id');
        $to = $this->input->post('to');
        $message = $this->input->post('message');
        $pChat_id = $this->input->post('pChat_id');

        $_SESSION['openChatBoxes'][$_POST['to']] = date('Y-m-d H:i:s', time());

        $messagesan = $this->sanitize($message);

            $data = array(
                'chat_from' => $from,
                'chat_to' => $to,
                'message' => $messagesan,
                'sent' => date('Y-m-d H:i:s', time()),
            );

            $this->chat_system_model->saveChat($data, $from, $to, $pChat_id);

            echo json_encode(array('name'=>$name));

            //$sql = "insert into chat (chat.from,chat.to,message,sent) values ('".mysql_real_escape_string($from)."', '".mysql_real_escape_string($to)."','".mysql_real_escape_string($message)."',NOW())";
            //$query = mysql_query($sql);
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
                $this->sendChat($this->session->userdata('user_id'), $this->session->userdata('name'));
            break;
            case 'closechat':
                $this->closeChat();
            break;
            case 'chatheartbeat':
                $this->chatHeartbeat($this->session->userdata('username'));
            break;
        }

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