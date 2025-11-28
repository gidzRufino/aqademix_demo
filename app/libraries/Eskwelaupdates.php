<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Eskwelaupdates extends MX_Controller {
    
    public function checkVersion()
    {
        $q = $this->db->get('system_settings');
        return $q->row();
    }
    
    function getFileInfo($url){
        $ch = curl_init($url);
        curl_setopt( $ch, CURLOPT_NOBODY, true );
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_MAXREDIRS, 3 );
        curl_exec( $ch );

        $headerInfo = curl_getinfo( $ch );
        curl_close( $ch );

        return $headerInfo;
      }
      
      function getFiles($version)
    {
        $url = "http://www.eskwelacampus.com/updates/".$version.'/';
        $file_path = APPPATH."updates/".$version.'/';
        if(!file_exists($file_path)):
            mkdir($file_path);
        endif;
        do{
            $raw = file_get_contents($url);
            $head = $this->parseHeaders($http_response_header);
        }while($head!='200');
        //echo $raw;
        
        
        //int_r($raw);
       //file_put_contents($file_path, $raw);
       $lines = explode("\n", $raw);
       $i = 1;         
        foreach($lines as $line) {
            $line = preg_replace('/<[^<]+?>/', '', $line); // removes tags, courtesy of http://stackoverflow.com/users/154877/marcel
            $ext = explode('.', trim($line));
            if($i++ > 8 && trim($line)!=""):
                if(count($ext)>1):
                    if($ext[1]=='php'):
                        $data[]= trim($line);
                    endif;
                else:
                    //echo 'Directory: '.trim($line).'<br />';
                endif;

            endif;
                //file_put_contents($file_path.trim($line), $raw);
        }
        return json_encode(array('file_path'=> $file_path, 'data' => $data, 'raw'=> $url));
       
        if($this->eskwelaupdates->fileDownload($url, $file_path)){
                echo "File dowloaded.";
        } 
    }
    
    public function parseHeaders( $headers )
    {
        $head = array();
        foreach( $headers as $k=>$v )
        {
            $t = explode( ':', $v, 2 );
            if( isset( $t[1] ) )
                $head[ trim($t[0]) ] = trim( $t[1] );
            else
            {
                $head[] = $v;
                if( preg_match( "#HTTP/[0-9\.]+\s+([0-9]+)#",$v, $out ) )
                    $head['reponse_code'] = intval($out[1]);
            }
        }
        foreach ($head as $h=>$k):
            if($h=="reponse_code" && $h!='0'):
                return $k;
            endif;
        endforeach;
    }
    
    
    
    
}