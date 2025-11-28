<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Eskwela extends MX_Controller {
    
    public function db($year=NULL)
    {
        if($year==NULL):
            $year = $this->session->userdata('school_year');
        endif;
        $settings = $this->getSet();
            
        $db = strtolower('eskwela_'.$settings->short_name.'_'.$year);
        $db_config = array(
            'dsn'       =>  '',
            'hostname'  =>  'localhost',
        	'username' => 'root',
        	'password' => 'Jesussaves@143',
            'database'  =>  $db,
            'dbprefix'  =>  'esk_',
            'dbdriver'  =>  'mysqli',
            'pconnect' => FALSE,
            'db_debug' => (ENVIRONMENT !== 'production'),
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => TRUE
        );
        
        $db_details = $this->load->database($db_config, TRUE);
        
        return $db_details;
    }
    
    
    function generateRandNum() 
    {
        if($_SERVER['HTTP_HOST']=='localhost'):
            $preString = '1';
        else:
            $preString = '2';
        endif;
        
        $length = '5';
        $characters = '0123456789';
        $string = '';    

        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters)-1)];
        }

        return $preString.$string;
    }
    
    function code() 
    {
        if($_SERVER['HTTP_HOST']=='localhost'):
            $preString = '1';
        else:
            $preString = '2';
        endif;
        
        $length = '5';
        $characters = '0123456789';
        $string = '';    

        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters)-1)];
        }

        return $preString.$string;
    }
    
    function codeCheck($table, $column, $code){
        $result = $this->db->where($column, $code)
                ->get($table);
        if($result->num_rows() != 0):
            return $code;
        else:
            $code = $this->code();
            return $this->codeCheck($table, $column, $code);
        endif;
    }
    
    public function dbInstall($uname, $pass, $name_of_school, $year)
    {
        $db = strtolower('eskwela_'.$name_of_school.'_'.$year);
        $db_config = array(
            'dsn'       =>  '',
            'hostname'  =>  'localhost',
            'username'  =>  $uname,
            'password'  =>  $pass,
            'database'  =>  $db,
            'dbprefix'  =>  'esk_',
            'dbdriver'  =>  'mysqli',
            
        );
        
        $db_details = $this->load->database($db_config, TRUE);
        
        return $db_details;
    }
    
    public function getSet()
    {
        $query = $this->db->get('settings');
        return $query->row();
    }
    
    public function itexmo($number,$message,$apicode,$passwd){
        $ch = curl_init();
        $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
        curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
        curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS, 
                  http_build_query($itexmo));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec ($ch);
        curl_close ($ch);
    } 
    
    function numberTowords($num)
    { 
        $ones = array(
            0 =>"ZERO", 
            1 => "ONE", 
            2 => "TWO", 
            3 => "THREE", 
            4 => "FOUR", 
            5 => "FIVE", 
            6 => "SIX", 
            7 => "SEVEN", 
            8 => "EIGHT", 
            9 => "NINE", 
            10 => "TEN", 
            11 => "ELEVEN", 
            12 => "TWELVE", 
            13 => "THIRTEEN", 
            14 => "FOURTEEN", 
            15 => "FIFTEEN", 
            16 => "SIXTEEN", 
            17 => "SEVENTEEN", 
            18 => "EIGHTEEN", 
            19 => "NINETEEN",
            "014" => "FOURTEEN" 
        ); 
        $tens = array( 
            0 => "ZERO",
            1 => "TEN",
            2 => "TWENTY", 
            3 => "THIRTY", 
            4 => "FORTY", 
            5 => "FIFTY", 
            6 => "SIXTY", 
            7 => "SEVENTY", 
            8 => "EIGHTY", 
            9 => "NINETY" 
        ); 
        $hundreds = array( 
            "HUNDRED", 
            "THOUSAND", 
            "MILLION", 
            "BILLION", 
            "TRILLION", 
            "QUARDRILLION" 
        ); //limit t quadrillion 
        
        $num = number_format($num,2,".",","); 
        
        $num_arr = explode(".",$num); 
        $wholenum = $num_arr[0]; 
        $decnum = $num_arr[1]; 
        $whole_arr = array_reverse(explode(",",$wholenum)); 
        krsort($whole_arr,1); 
        
        $rettxt = ""; 
        foreach($whole_arr as $key => $i){
            while(substr($i,0,1)=="0")
            $i=substr($i,1,5);
            if($i < 20){ 
                //echo "getting:".$i;
                $rettxt .= $ones[$i]; 
            }elseif($i < 100){ 
                if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
                if(substr($i,1,1)!="0") $rettxt .= " - ".$ones[substr($i,1,1)]; 
            }else{ 
                if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
                if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
                if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
            } 
            if($key > 0){ 
                $rettxt .= " ".$hundreds[$key]." "; 
            } 
        } 
        if($decnum > 0){ 
            $rettxt .= " and "; 
            if($decnum < 20){ 
                $rettxt .= $ones[$decnum]; 
            }elseif($decnum < 100){ 
                $rettxt .= $tens[substr($decnum,0,1)]; 
                $rettxt .= " ".$ones[substr($decnum,1,1)]; 
            } 
        } 
        return $rettxt; 
    } 
    
    
    
}
