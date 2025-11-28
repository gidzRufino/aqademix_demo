<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of attendance
 *
 * @author genesis
 */
define('ENCRYPTION_KEY', 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282');
class web_sync extends MX_Controller{
    function __construct() {
          // uncomment the script below for live return
//        header('Access-Control-Allow-Origin: *');
//        header("Access-Control-Allow-Headers: x-requested-with, Content-Type, origin, authorization, accept, client-security-token");
//        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
//        //header("Content-Type: application/json");
//        $method = $_SERVER['REQUEST_METHOD'];
//        if($method == "OPTIONS") {
//            die();
//        }
        
        parent::__construct();
        $this->load->model('web_sync_model');
        $this->load->library('encrypted');
    }
    private function encrypt($data)
    {
        $encrypt = new encrypted();
        $dataEncrypted = $encrypt->mc_encrypt($data, ENCRYPTION_KEY);
        $dataEncrypted = base64_encode($dataEncrypted);
        return $dataEncrypted;
    }
    
    private function decrypt($data)
    {
        $decrypted = new encrypted();
        $decrypt = base64_decode($data);
        $dataDecrypted = $decrypted->mc_decrypt($decrypt, ENCRYPTION_KEY);
        return $dataDecrypted;
    }
    
    function contains($needle, $haystack)
    {
        return strpos($haystack, $needle) !== false;
    }
    
    function saveRunScript($query, $school_year = NULL)
    {
        if($school_year==NULL):
            $settings = Modules::run('main/getSet');
            $school_year = $settings->school_year;
        endif;
        $this->db = ($this->eskwela->db($school_year));
        $this->db->insert('websync_controller',array('run_script' => $this->encrypt($query), 'id' => $this->eskwela->codeCheck('websync_controller', 'id', $this->eskwela->code())) );
        return;
    }
    
    function saveOnlineData($data=NULL)
    {
        if($data==NULL):
            $data = $this->input->post('updates');
        endif;
        
        $decode1 = base64_decode($data);
        $decode2 = $this->decrypt($decode1);
        $object = json_decode($decode2);
        //print_r($object);
        //echo $settings->school_id.' | '.$object->school_id;
        $dataMessage = $object->data->run_script;
        
//
        $inserted = $this->web_sync_model->insertDataSync($this->decrypt($dataMessage));

        if($inserted):
            echo json_encode(array('status' => TRUE, 'id' => $object->update_id, 'msg' => 'successfully Saved'));
        else:
            echo json_encode(array('status' => FALSE, 'id' => $object->update_id, 'msg' => ' Error in Syncing - '.$object->data->id));
        endif;
    }
    
    
    public function checkOnlineData()
    {
        $settings = Modules::run('main/getSet');
        $data = $this->web_sync_model->getData();
        if($data->num_rows()>0)
        {
            $i = 0;
            
            foreach($data->result() as $d)
            {
                $i++;
                $inData =  $d;
                $dataWtCreds = array('data'=>$inData, 'school_id'=>$settings->school_id, 'update_id' => $d->id);
                $inData = json_encode($dataWtCreds);
                $inData = $this->encrypt($inData);
                $updates .= base64_encode($inData).';';
                $this->resetOnlineData($d->id);
            }
            echo $updates;
            
        }else{
            
        }
    }
    
    
    public function sendToWeb($data=NULL)
    {
        $settings = Modules::run('main/getSet');
        if($data==NULL):
            $data = $this->input->post('updates');
        endif;
        
        $decode1 = base64_decode($data);
        $decode2 = $this->decrypt($decode1);
        $object = json_decode($decode2);
        //print_r($object);
        //echo $settings->school_id.' | '.$object->school_id;
        if($settings->school_id==$object->school_id):
            $dataMessage = $object->data->run_script;
            
            $inserted = $this->web_sync_model->insertDataSync($this->decrypt($dataMessage));
           
            if($inserted):
                echo json_encode(array('status' => TRUE, 'id' => $object->update_id, 'msg' => 'successfully synced'));
            else:
                echo json_encode(array('status' => FALSE, 'id' => $object->update_id, 'msg' => ' Error in Syncing - '.$object->data->id));
            endif;
        else:
            echo json_encode(array('status' => FALSE, 'id' => $object->school_id, 'msg' => 'Identification Denied'));
        endif;
        
    }
    
    function checkData()
    {
        $settings = Modules::run('main/getSet');
        $data = $this->web_sync_model->getData();
        if($data->num_rows()>0)
        {
            $i = 0;
            
            foreach($data->result() as $d)
            {
                $i++;
                $inData =  $d;
                $dataWtCreds = array('data'=>$inData, 'school_id'=>$settings->school_id, 'update_id' => $d->id);
                $inData = json_encode($dataWtCreds);
                $inData = $this->encrypt($inData);
                $updates .= base64_encode($inData).';';
            }
            echo $updates;
            
        }else{
            
        }
    }
    
    
        
    function getInitialUpdates($row=Null)
    {
        $this->load->helper('file');
        $settings = Modules::run('main/getSet');
        $profile = $this->web_sync_model->getInitialUpdates('profile');
        $dataWtCreds = array('data'=>$profile->result(), 'school_id'=>$settings->school_id, 'action'=>'create', 'table' => 'profile');
        foreach ($profile->result() as $p):
            $dataWtCreds = array('data'=>$p, 'school_id'=>$settings->school_id, 'action'=>'create', 'table' => 'profile');
            $inData = json_encode($dataWtCreds);
            $inData = $this->encrypt($inData);
            $updates .= base64_encode($inData).';';
        endforeach;

        echo json_encode(array('updates' => $updates, 'num_of_updates' => $profile->num_rows));
    }
    
    function downloadInitialUpdates()
    {
        
        $this->load->helper('file');
        $settings = Modules::run('main/getSet');
        $details = $this->web_sync_model->getContactUpdates();
        $data2WtCreds = array('data'=>$details->result(), 'school_id'=>$settings->school_id, 'action'=>'create', 'table' => 'none');
        $inData2 = json_encode($data2WtCreds);
        $inData2 = $this->encrypt($inData2);
        $update2 = base64_encode($inData2).';';
        foreach ($details->result() as $m):
            $motherInfo = Modules::run('registrar/getMother', $m->mother_id);
            $mama = array('data'=>$motherInfo, 'school_id'=>$settings->school_id, 'action'=>'create', 'table' => 'none');
            $mommy = json_encode($mama);
            $mommy = $this->encrypt($mommy);
            $motherData .= base64_encode($mommy).';';
        endforeach;
            $motherData = $update2.$motherData;
            
        $this->load->helper('download');
        force_download('e-sKwela_initial_Updates.txt', $motherData);
    }
    
    //Save Data to USB
    
    
    function saveToUSB()
    {
        $this->load->helper('file');
        $data = $this->web_sync_model->checkUpdates();
        $settings = Modules::run('main/getSet');
        if($data->num_rows()>0)
        {
            foreach ($data->result() as $d):
                switch ($d->action):
                    case 'create':
                      $inData =  $this->web_sync_model->getCreatedData($d->table_name, $d->primary_key, $d->primary_key_value);
                      $dataWtCreds = array('data'=>$inData, 'school_id'=>$settings->school_id, 'action'=>'create', 'table' => $d->table_name, 'pk' => $d->primary_key, 'pk_value' => $d->primary_key_value);
                      //$inData = json_encode($dataWtCreds);
                      $inData = $this->encrypt($dataWtCreds);
                      $updates .= base64_encode($inData).';';
                    break;
                    case 'update':
                        $inData =  $this->web_sync_model->getCreatedData($d->table_name, $d->primary_key, $d->primary_key_value);
                        $dataWtCreds = array('data'=>$inData, 'school_id'=>$settings->school_id, 'action'=>'create', 'table' => $d->table_name, 'pk' => $d->primary_key, 'pk_value' => $d->primary_key_value);
                        $inData = $this->encrypt($dataWtCreds);
                        $updates .= base64_encode($inData).';';
                       // echo $updates.'<br />';
                    break;    
                    
                endswitch;
            endforeach;
                    write_file('db_backup/e-sKwela_Updates.txt', $updates);
                    $this->load->helper('download');
                    chmod("db_backup/sKwela_Updates.txt", 0444);
                    force_download('sKwela_Updates.txt', $updates);
            
                  
        }
        
    }


    // Local Server Request
    
    function updateSyncController($table, $pk, $pk_value, $action, $type=NULL)
    {
        $details = array(
            'id'                => $this->eskwela->code(),
            'table_name'        => $table,
            'primary_key'       => $pk,
            'primary_key_value' => $pk_value,
            'action'            => $action,
            'type'              => $type
        );
        
        $this->web_sync_model->insertTables($details);
        
        $update_type = $this->web_sync_model->checkUpdateType($type);
        
        $num_of_updates = array(
            'num_of_updates'    => $update_type->num_of_updates + 1,
        );
        
        $this->web_sync_model->updateNumType($num_of_updates, $type);
        
        return;
    }
    
    function getNumData()
    {
        $data = $this->web_sync_model->checkUpdates();
        if($data->num_rows()>0):
            echo $data->num_rows();
        else:
            echo $data->num_rows();
        endif;
    }
    
    
    function getData($data)
    {
        $decode1 = base64_decode($data);
        $tableFields=json_decode($decode1);
        $this->getIndividualData($tableFields->id, $tableFields->run_script);
    }
    
    function getIndividualData($id, $run_script)
    {
        $getUpdates = $this->web_sync_model->getCreatedData($table, $primary_key, $pk_value);
        $jsonString = json_encode($getUpdates);
        $getUpdates = base64_encode($jsonString);
        //$getUpdates = base64_encode($getUpdates);
        echo json_encode(array('id'=>$id, 'updates' => $getUpdates, 'action' => $action, 'table' =>$table, 'pk' => $primary_key, 'pk_value'=>$pk_value));
        
    }
    
    
    // Portal catches the data
    
    function send($data)
    {
        $decode1 = base64_decode($data);
        $decode2 = $this->decrypt($decode1);
        $object = json_decode($decode2);
        print_r($object);
    }
//    
    function resetOnlineData($id)
    {
        if($this->web_sync_model->emptyTable($id)):
            //echo json_encode(array('status' => TRUE));
        endif;
    }
    
    
    function emptyTable($id)
    {
        $this->web_sync_model->emptyTable($id);
        $details = 'Data was Successfully Sync to Live';
        Modules::run('main/writeLog', 'system', $details);
        
    }
    
       
    public function getOnlineDataCurl()
    {
        $settings = Modules::run('main/getSet');
        $handle = curl_init();
 
        $url = "https://".$settings->web_address."/web_sync/checkOnlineData/";
 

        // Set the url
        curl_setopt($handle, CURLOPT_URL, $url);
        // Set the result output to be a string.
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        $returnedData = curl_exec($handle);

        curl_close($handle);
        
        $dataItems = explode(';', $returnedData);
        $limit = count($dataItems);
        
        for($i=0;$i<$limit;$i++):
            echo $this->saveOnlineData($dataItems[$i]);
        endfor;
        echo '\n';
       
    }
    
    function sendDataCurlOnline()
    {
        $settings = Modules::run('main/getSet');
        $data = $this->web_sync_model->getData();
        if($data->num_rows()>0)
        {
            $i = 0;
            
            foreach($data->result() as $d)
            {
                $i++;
                $inData =  $d;
                $dataWtCreds = array('data'=>$inData, 'school_id'=>$settings->school_id, 'update_id' => $d->id);
                $inData = json_encode($dataWtCreds);
                $inData = $this->encrypt($inData);
                $updates = base64_encode($inData);
                $this->sendDataCurl($updates);
            }
            
        }else{
            
        }
    }
    
    function sendDataCurl($data)
    {
        $settings = Modules::run('main/getSet');
        $handle = curl_init();
 
        $url = "https://".$settings->web_address."/web_sync/sendToWeb/";

        $postData = array(
          'status'      => 1,
          'updates'     => $data,
        );

        curl_setopt_array($handle,
        array(
             CURLOPT_URL => $url,
             // Enable the post response.
            CURLOPT_POST       => true,
            // The data to transfer with the response.
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_RETURNTRANSFER     => true,
          )
        );

        $details = curl_exec($handle);

        curl_close($handle);

        $result = json_decode($details);
        
        if($result->status):
            $this->emptyTable($result->id);
            echo $result->msg;
        else:
            echo $result->msg;
        endif;
                
                
        
    }

}