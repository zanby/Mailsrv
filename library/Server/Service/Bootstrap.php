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
require_once ENGINE_DIR.'/Server/Model/Log.php';

class Server_Service_Bootstrap
{
    /**
     * @param int $threads First int
     * @param int $iterations Second int
     * @param int $executionTime Third int
     * @return boolean
     */
	public function startBuilder($threads = 1, $iterations = 1, $executionTime = 0)
	{	
		date_default_timezone_set('UTC');
		$threads = ( $threads > BUILDER_MAX_THREADS ) ? BUILDER_MAX_THREADS : (int)$threads;
		$iterations = ( $iterations && $iterations > BUILDER_MAX_ITERATIONS ) ? BUILDER_MAX_ITERATIONS : (int)$iterations;
		$executionTime = ( $executionTime && $executionTime > BUILDER_MAX_EXECUTION_TIME ) ? BUILDER_MAX_EXECUTION_TIME : (int)$executionTime;
		
		Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] BUILDER START threads:'.$threads.' iterations:'.$iterations.' execution_time:'.$executionTime, 'builder.log');
	    for ( $i = 0; $i <  $threads; $i++ ) {
	        /*
    		$client = new Dklab_SoapClient(null, array(
    			'location' => SERVER_URL."/mail.server.builder.php",
    			'uri' => 'urn:myschema',
    			'timeout' => 2,
    		));
    		*/
	        require_once ENGINE_DIR . '/bootstrap_script.php';
            $client = new Server_Client_Dklab(SERVER_URL.'/wsdl.php?t=builder', array('timeout' => 60) );            
    		$client->setUsername(CREDENTIAL_USERNAME);
    		$client->setPassword(CREDENTIAL_PASSWORD);
    		
			Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] BUILDER START_THREAD:'.($i+1).' iterations:'.$iterations.' execution_time:'.$executionTime, 'builder.log');
            $request = $client->async->start($iterations, $executionTime);
            //$request->getResult();
	    }     
		Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] BUILDER RETURN', 'builder.log');
        //return true;
        return $request->getResult(); 
	}
	
    /**
     * @param int $threads First int
     * @param int $iterations Second int
     * @param int $executionTime Third int
     * @return boolean
     */
	public function startDeliver($threads = 1, $iterations = 1, $executionTime = 0)
	{
		date_default_timezone_set('UTC');
		$threads = ( $threads > DELIVER_MAX_THREADS ) ? DELIVER_MAX_THREADS : (int)$threads;
		$iterations = ( $iterations && $iterations > DELIVER_MAX_ITERATIONS ) ? DELIVER_MAX_ITERATIONS : (int)$iterations;
		$executionTime = ( $executionTime && $executionTime > DELIVER_MAX_EXECUTION_TIME ) ? DELIVER_MAX_EXECUTION_TIME : (int)$executionTime;
		
		Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] DELIVER START threads:'.$threads.' iterations:'.$iterations.' execution_time:'.$executionTime, 'deliver.log');
	    for ( $i = 0; $i <  $threads; $i++ ) {
	        /*
    		$client = new Dklab_SoapClient(null, array(
    			'location' => SERVER_URL."/mail.server.deliver.php",
    			'uri' => 'urn:myschema',
    			'timeout' => 2,
    		));
    		*/
            require_once ENGINE_DIR . '/bootstrap_script.php';
            $client = new Server_Client_Dklab(SERVER_URL.'/wsdl.php?t=deliver', array('timeout' => 60) );            
            $client->setUsername(CREDENTIAL_USERNAME);
            $client->setPassword(CREDENTIAL_PASSWORD);    		
    		
			Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] DELIVER START_THREAD:'.($i+1).' iterations:'.$iterations.' execution_time:'.$executionTime, 'deliver.log');
    		$request = $client->async->start($iterations, $executionTime);		
    		//$request->getResult();
	    }
		Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] DELIVER RETURN', 'deliver.log');
	    //return true;
	    return $request->getResult();
	}
	
}