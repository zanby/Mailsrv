<?php
/**
*   Zanby Enterprise Group Family System
*
*    Copyright (C) 2005-2011 Zanby LLC. (http://www.zanby.com)
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
*    To contact Zanby LLC, send email to info@zanby.com.  Our mailing 
*    address is:
*
*            Zanby LLC
*            3611 Farmington Road
*            Minnetonka, MN 55305
*
* @category   Zanby
* @package    Mailsrv
* @copyright  Copyright (c) 2005-2011 Zanby LLC. (http://www.zanby.com)
* @license    http://zanby.com/license/     GPL License
* @version    <this will be auto generated>
*/
class Server_Model_Log
{
    static public function log($message, $logfile)
    {		
        $dir = ENGINE_DIR . '/../logs';
        $fname = $dir."/".$logfile;
        $fp = fopen($fname, 'a');
        fwrite($fp, $message."\n");
        fclose($fp);
        chmod($fname, 0777);        
    }
	
    static public function logRaw($message, $campaign_id, $to)
    {		
		if ( LOG_RAW_MESSAGES ) {
			$to = ( !is_array($to) ) ? array($to) : $to;
			$strTo = join('_', $to);

			$campaign_log_dir = '/raw_messages/campaign_'.$campaign_id;		
			if ( !file_exists(ENGINE_DIR.'/../logs'.$campaign_log_dir) ) mkdir(ENGINE_DIR.'/../logs'.$campaign_log_dir, 0777);
			chmod(ENGINE_DIR.'/../logs'.$campaign_log_dir, 0777);
			
			$log_dir = $campaign_log_dir.'/'.date('Y-m-d');
			if ( !file_exists(ENGINE_DIR.'/../logs'.$log_dir) ) mkdir(ENGINE_DIR.'/../logs'.$log_dir, 0777);
			chmod(ENGINE_DIR.'/../logs'.$log_dir, 0777);
					
			Server_Model_Log::log($message, $log_dir.'/'.$strTo.'_'.Server_Model_Log::getmicrotime().'.log');
		}
		//exec('chmod -R 777 '.ENGINE_DIR.'/../logs/raw_messages/');
    }
	
    static public function getXPM4LogFile()
    {
        $dir = ENGINE_DIR . '/../logs';
        $fname = $dir."/XPM4.log";
        if ( !file_exists( $fname ) ) {
            $fp = fopen($fname, 'w');
            fclose($fp);
            chmod($fname, 0777);            
        }
        return $fname;
    }
    
	static public function getmicrotime() 
	{ 
		list($usec, $sec) = explode(" ", microtime()); 
		return ((float)$usec + (float)$sec); 
	}
	
    static public function array2str( &$str, $array )
    {
        if ( is_array($array) && sizeof($array) != 0 ) {
            foreach ( $array as $key => $arrItem ) {
                if ( $str == '' ) $str .= $key.'=>{';
                else $str .= $key.'=>{';                                
                Server_Model_Log::array2str( $str, $arrItem, null  );
                $str .= '}';
            }
        } elseif ( is_scalar($array) ) {
            $str .= '"'.$array.'"';
        }
        $str = str_replace(array("\n","\r"), '', $str);
    }
}
