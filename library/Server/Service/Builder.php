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
require_once ENGINE_DIR.'/Server/Model/Campaign.php';
require_once ENGINE_DIR.'/Server/Model/Campaign/Recipient.php';
require_once ENGINE_DIR.'/Server/Model/Campaign/Sender.php';
require_once ENGINE_DIR.'/Server/Model/Campaign/Param.php';
require_once ENGINE_DIR.'/Server/Model/Campaign/Image.php';
require_once ENGINE_DIR.'/Server/Model/Campaign/Callback.php';
require_once ENGINE_DIR.'/Server/Model/Campaign/Header.php';
require_once ENGINE_DIR.'/Server/Service/Builder/Verifier.php';

class Server_Service_Builder
{
    /**
     * @param int $iterations First int
     * @param int $executionTime Second int
     * @return boolean
     */
    public function start($iterations = 1, $execution_time = 0)
    {                     
        date_default_timezone_set('UTC');
        $start_time = time();
        set_time_limit(0);
        ini_set('memory_limit','512M');

        if ( $execution_time ) {
            $stop_time = $start_time + $execution_time;
            while ( $stop_time >= $start_time ) {
                try { $records = Server_Model_Campaign::getRowsWithLock(); }
                catch (Exception $e) { 
					Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] BUILDER '.$e->getMessage(), 'builder_error.log');
					throw new SoapFault("HTTP", $e->getMessage()); 
				}
    
                if ( $records && sizeof($records) ) {
					Server_Service_Builder_Verifier::start();
                    try {           
                        /*
                        $client = new Dklab_SoapClient(null, array(
                            'location' => SERVER_URL."/mail.server.builder.php",
                            'uri' => 'urn:myschema',
                            'timeout' => 600,
                        ));
                        */
                        require_once ENGINE_DIR . '/bootstrap_script.php';
                        $client = new Server_Client_Dklab(SERVER_URL.'/wsdl.php?t=builder', array('timeout' => 600) );            
                        $client->setUsername(CREDENTIAL_USERNAME);
                        $client->setPassword(CREDENTIAL_PASSWORD);
                    } catch (Exception $e) { 
						Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] BUILDER '.$e->getMessage(), 'builder_error.log');
						throw new SoapFault("HTTP", $e->getMessage()); 
					}
                    
                    try { $request = $client->async->build($records); } 
                    catch ( Exception $e ) { 
						Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] BUILDER '.$e->getMessage(), 'builder_error.log');
						throw new SoapFault("HTTP", $e->getMessage()); 
					}

                    try { $request->getResult(); } 
                    catch ( Exception $e ) { 
						Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] BUILDER '.$e->getMessage(), 'builder_error.log');
						throw new SoapFault("HTTP", $e->getMessage()); 
					}					
                } else {
                    Server_Service_Builder_Verifier::start();
                    usleep(1000000);
                }                                
                $start_time = time();                
            }
            return true;
        } else {        
            for ( $i = 0; $i < $iterations; $i++ ) {
                try { $records = Server_Model_Campaign::getRowsWithLock(); }
                catch (Exception $e) { 
					Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] BUILDER '.$e->getMessage(), 'builder_error.log');
					throw new SoapFault("HTTP", $e->getMessage()); 
				}
    
                if ( $records && sizeof($records) ) {
                    Server_Service_Builder_Verifier::start();
                    try {           
                        /*
                        $client = new Dklab_SoapClient(null, array(
                            'location' => SERVER_URL."/mail.server.builder.php",
                            'uri' => 'urn:myschema',
                            'timeout' => 600,
                        ));
                        */
                        require_once ENGINE_DIR . '/bootstrap_script.php';
                        $client = new Server_Client_Dklab(SERVER_URL.'/wsdl.php?t=builder', array('timeout' => 600) );            
                        $client->setUsername(CREDENTIAL_USERNAME);
                        $client->setPassword(CREDENTIAL_PASSWORD);                        
                    } catch (Exception $e) { 
						Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] BUILDER '.$e->getMessage(), 'builder_error.log');
						throw new SoapFault("HTTP", $e->getMessage()); 
					}
                    
                    try { $request = $client->async->build($records); } 
                    catch ( Exception $e ) { 
						Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] BUILDER '.$e->getMessage(), 'builder_error.log');
						throw new SoapFault("HTTP", $e->getMessage()); 
					}

                    try { $request->getResult(); } 
                    catch ( Exception $e ) { 
						Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] BUILDER '.$e->getMessage(), 'builder_error.log');
						throw new SoapFault("HTTP", $e->getMessage()); 
					}                    
                } else {
                    Server_Service_Builder_Verifier::start();
                    usleep(1000000);
                }
                $start_time = time();
            }
            //return $request->getResult();
            return true;                    
        }        
    }
    
    /**
     * @param int[] $records First int[]
     * @return boolean
     */
    public function build( $records )
    {        
        set_time_limit(0);
        ini_set('memory_limit','512M');
        
        if ( is_array($records) && sizeof($records) != 0 ) {
            try {
                require_once ENGINE_DIR . '/bootstrap_script.php';
                $client = new Server_Client_Dklab(SERVER_URL.'/wsdl.php?t=builder', array(
                    'timeout' => 600, 
                    'response_validator' => 'Server_Model_Campaign::responseValidator'
                ) );            
                $client->setUsername(CREDENTIAL_USERNAME);
                $client->setPassword(CREDENTIAL_PASSWORD);
                
            } catch (Exception $e) {
                foreach ( $records as $record ) Server_Model_Campaign::rollbackStatus($record);
				throw new SoapFault("HTTP", $e->getMessage());
            }
            
            $requests = array();
            $iteration = 0;
            $max_p = 10;
            $max_p = ( sizeof($records) > $max_p ) ? $max_p : sizeof($records);
            $cur_p = 0;
            $Rcount = sizeof($records);

            foreach ($records as $index => $record) {
                $cur_p++;                
                try { $requests[] = $client->async->buildCampaign( $record ); } 
                catch ( Exception $e ) {
                    Server_Model_Campaign::rollbackStatus($record);
                    //throw $e;
					//throw new SoapFault("HTTP", $e->getMessage());
                }
                if ( $cur_p >= $max_p || $index == $Rcount - 1 ) {
                    foreach ( $requests as $request ) {
                        try { $result = $request->getResult(); } 
                        catch ( Exception $e ) {
                            /**
                             * Здесь возмона ситуация когда по таймоуту мы отвалились, но т.к. реквест асинхронный,
                             * то он может вывалиться. т.е. максимум мы можес сказать, что мы не дождались результата,
                             * а какой результат мы не знаем. Это ислючение возникнет, если мы выставили timeout для клиента
                             * в значение меньшее, чем может выполняться функция sendEmail().
                             * Однако, исключение может возникнуть не только по таймоуту.
                             */
                            $_request = $e->request;
                            $_mail_id = $_request[1][0]['id'];                            
                            Server_Model_Campaign::rollbackStatus($_mail_id);                            
                            //throw $e;
							//throw new SoapFault("HTTP", $e->getMessage());
                        }
                    }
                    $cur_p = 0; $requests = array();
                }
            }
            unset($client,$requests,$iteration,$max_p,$cur_p,$Rcount,$record,$result,$_mail_id);
        
        }
        
        return true;
    }
    
    /**
     * @param int $records First int
     * @return boolean
     */
    public function buildCampaign( $record )
    {
        $objCampaign = new Server_Model_Campaign();
        $objCampaign->load($record);
        if ( !$objCampaign || !$objCampaign->getId() ) throw new SoapFault("HTTP", 'Incorrect campaign id');

        try { $result = $objCampaign->build(); }
        catch ( Exception $e ) {
            Server_Model_Campaign::rollbackStatus($record);
            throw new SoapFault("HTTP", $e->getMessage());        
        }
        return $result;
    }
    
    /**
     * @return boolean
     */
    public function verify()
    {
        try { Server_Service_Builder_Verifier::verify(); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        return true;
    }
	
    /**
     * @return boolean
     */
    public function verifyDeliveryDate()
    {
        try { Server_Service_Builder_Verifier::verifyDeliveryDate(); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        return true;
    }
    
    /**
     * @return boolean
     */
    public function closeProcessedCampaigns()
    {
        try { Server_Service_Builder_Verifier::closeProcessedCampaigns(); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        return true;
    }
}