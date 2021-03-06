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
require_once ENGINE_DIR.'/Dklab/SoapClient.php';
require_once ENGINE_DIR.'/Server/Client/Dklab.php';

class Server_Service_Deliver_Verifier
{
	static public function start()
	{
		date_default_timezone_set('UTC');
        set_time_limit(0);
        ini_set('memory_limit','512M');
	    
        try {           
            /*
            $client = new Dklab_SoapClient(null, array(
                'location' => SERVER_URL."/mail.server.deliver.php",
                'uri' => 'urn:myschema',
                'timeout' => 600,
            ));
            */
            require_once ENGINE_DIR . '/bootstrap_script.php';
            $client = new Server_Client_Dklab(SERVER_URL.'/wsdl.php?t=deliver', array('timeout' => 600) );            
            $client->setUsername(CREDENTIAL_USERNAME);
            $client->setPassword(CREDENTIAL_PASSWORD);            
        } catch (Exception $e) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        try {
            $request = $client->async->verify();
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }       

        return "OK";
	}
	
	static public function verify()
	{	    
		date_default_timezone_set('UTC');
		Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] DELIVER_VERIFIER START', 'deliver.log');
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $check_time = time() - DELIVER_VERIFY_TIME;
        $check_date = date('Y-m-d H:i:s', $check_time);
        $status = 'new';
        $old_status = 'in_progress';
        $null = null;
        
        $update_sql = "UPDATE mail_campaignes__recipients SET 
            status = :status, in_progress_date = :in_progress_date 
            WHERE status = :old_status AND in_progress_date <= :check_date LIMIT 100";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':in_progress_date', $null);
        $stmt->bindParam(':old_status', $old_status);
        $stmt->bindParam(':check_date', $check_date);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        } 
        
        $db = NULL;
		//Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] DELIVER_VERIFIER RETURN', 'deliver.log');
	    return true;
	}
}