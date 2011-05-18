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
require_once ENGINE_DIR.'/Server/Model/Campaign/Callback.php';
require_once ENGINE_DIR.'/Server/Service/Deliver/Verifier.php';
require_once ENGINE_DIR.'/Exception/SMTP/Connection.php';
require_once ENGINE_DIR.'/Exception/SMTP/Status.php';
require_once ENGINE_DIR.'/Exception/SMTP/Status/From.php';
require_once ENGINE_DIR.'/Exception/SMTP/Status/To.php';
require_once ENGINE_DIR.'/Exception/SMTP/Status/Data.php';
require_once ENGINE_DIR.'/Exception/SMTP/Status/Rset.php';

class Server_Service_Deliver
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
                try { $records = Server_Model_Campaign_Recipient::getRowsWithLock(); }
                catch (Exception $e) { 
					Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] DELIVER '.$e->getMessage(), 'deliver_error.log');
					throw new SoapFault("HTTP", $e->getMessage()); 
				}
                
                if ( $records && sizeof($records) ) {
                    try {           
                        require_once ENGINE_DIR . '/bootstrap_script.php';
                        $client = new Server_Client_Dklab(SERVER_URL.'/wsdl.php?t=deliver', array('timeout' => 600) );            
                        $client->setUsername(CREDENTIAL_USERNAME);
                        $client->setPassword(CREDENTIAL_PASSWORD);                        
                    } catch (Exception $e) { 
						Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] DELIVER '.$e->getMessage(), 'deliver_error.log');
						throw new SoapFault("HTTP", $e->getMessage()); 
					}
                    
                    try { $request = $client->async->send($records); } 
                    catch ( Exception $e ) { 
						Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] DELIVER '.$e->getMessage(), 'deliver_error.log');
						throw new SoapFault("HTTP", $e->getMessage()); 
					}
                    
                    try { $request->getResult(); } 
                    catch ( Exception $e ) { 
						Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] DELIVER '.$e->getMessage(), 'deliver_error.log');
						throw new SoapFault("HTTP", $e->getMessage()); 
					}
                } else {
                    Server_Service_Deliver_Verifier::start();                    
                    usleep(1000000);
                }
                $start_time = time();
            }
		} else {				
    		for ( $i = 0; $i < $iterations; $i++ ) {
    			try { $records = Server_Model_Campaign_Recipient::getRowsWithLock(); }
    			catch (Exception $e) { 
					Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] DELIVER '.$e->getMessage(), 'deliver_error.log');
					throw new SoapFault("HTTP", $e->getMessage()); 
				}
        			
    			if ( $records && sizeof($records) ) {
        			try {
                        require_once ENGINE_DIR . '/bootstrap_script.php';
                        $client = new Server_Client_Dklab(SERVER_URL.'/wsdl.php?t=deliver', array('timeout' => 600) );            
                        $client->setUsername(CREDENTIAL_USERNAME);
                        $client->setPassword(CREDENTIAL_PASSWORD);        				
        			} catch (Exception $e) { 
						Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] DELIVER '.$e->getMessage(), 'deliver_error.log');
						throw new SoapFault("HTTP", $e->getMessage()); 
					}
        			
        			try { $request = $client->async->send($records); } 
        			catch ( Exception $e ) { 
						Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] DELIVER '.$e->getMessage(), 'deliver_error.log');
						throw new SoapFault("HTTP", $e->getMessage()); 
					}
        			
        			try { $request->getResult(); }
    			    catch ( Exception $e ) { 
						Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] DELIVER '.$e->getMessage(), 'deliver_error.log');
						throw new SoapFault("HTTP", $e->getMessage()); 
					}
    			} else {
                    Server_Service_Deliver_Verifier::start();                    
    			    usleep(1000000);
    			}
    			$start_time = time();
    		}                      		
		}		
		return true;
	}
	
    /**
     * @param int[] $records First int[]
     * @return boolean
     */
	public function send($records)
	{
        set_time_limit(0);
        ini_set('memory_limit','512M');
		
		if ( is_array($records) && sizeof($records) != 0 ) {
			try {			
                require_once ENGINE_DIR . '/bootstrap_script.php';
                $client = new Server_Client_Dklab(SERVER_URL.'/wsdl.php?t=deliver', array(
                    'timeout' => 60, 
                    'response_validator' => 'Server_Model_Campaign_Recipient::responseValidator'
                ) );            
                $client->setUsername(CREDENTIAL_USERNAME);
                $client->setPassword(CREDENTIAL_PASSWORD);                
			} catch (Exception $e) {
				foreach ( $records as $record ) Server_Model_Campaign_Recipient::rollbackStatus($record);
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
                try { $requests[] = $client->async->sendRaw($record); } 
                catch ( Exception $e ) {
                    Server_Model_Campaign_Recipient::rollbackStatus($record);
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
                             * в значение меньшее, чем может выполняться функция sendRaw().
                             * Однако, исключение может возникнуть не только по таймоуту.
                             */
                            $_request = $e->request;
                            $_mail_id = $_request[1][0]['id'];   
                            if ( !empty($_mail_id) ) Server_Model_Campaign_Recipient::rollbackStatus($_mail_id);	
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
	public function sendRaw($record)
	{
	    date_default_timezone_set('UTC');
        set_time_limit(0);
        ini_set('memory_limit','512M');
        
        $recordID = $record;
        
        /* init memcache object */
        $memcache = ( MEMCACHE ) ? new Memcache : null;
	$conn = null;
        try { $memcache && $conn = $memcache->connect(MEMCACHE_HOST, MEMCACHE_PORT); }
        catch ( Exception $e ) {
            Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] Cannot connect to memcahce server. Error: '.$e->getMessage(), 'error_memcache.log');
            Server_Model_Campaign_Recipient::rollbackStatus($recordID); 
            throw new SoapFault('Client', $e->getMessage());             
        }     
        if ( !$conn ) $memcache = null;
        
        /* load recipient information */
        try { $record = Server_Model_Campaign_Recipient::loadAsArrray($record); }
        catch ( Exception $e ) {
            Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] Error: '.$e->getMessage(), 'error_db.log');
            Server_Model_Campaign_Recipient::rollbackStatus($recordID); 
            throw new SoapFault('Client', $e->getMessage());
        }                
        
        /* init campaign object */
        $objCampaign = new Server_Model_Campaign();
        $objCampaign->setId($record['campaign_id']);

        /* load sender information */
        if ( !$memcache || !$sender = $memcache->get('sender_'.$objCampaign->getId()) ) {
            $sender = ( $objCampaign->getSender() ) ? $objCampaign->getSender()->getEmail() : 'postmaster@localhost';
            $memcache && $memcache->set('sender_'.$objCampaign->getId(), $sender, MEMCACHE_COMPRESSED, MEMCACHE_CACHE_TIME);
        }            
        $to = ( !empty($record['name']) ) ? $record['name'].' <'.$record['email'].'>' : $record['email'];
        
        /* load raw message */
        $locale = isset($record['locale']) ? $record['locale'] : null;
        try {            
            if ( !$memcache || !$raw = $memcache->get('raw_'.$locale.'_'.$objCampaign->getId()) ) {
                $raw = $objCampaign->loadRaw( $locale );
                $memcache && $memcache->set('raw_'.$locale.'_'.$objCampaign->getId(), $raw, MEMCACHE_COMPRESSED, MEMCACHE_CACHE_TIME);
            }            
        } catch ( Exception $e ) {  
            Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] Error: '.$e->getMessage(), 'error_db.log');
            Server_Model_Campaign_Recipient::rollbackStatus($recordID); 
            throw new SoapFault('Client', $e->getMessage());
        }
        
        /* load recipients callbacks */
        $lstCallbacks = null;
        try {
            if ( !$memcache || !$lstCallbacks = $memcache->get('lstCallbacks_recipient_'.$objCampaign->getId()) ) {
                $lstCallbacks = Server_Model_Campaign_Callback::loadByCampaign( $objCampaign->getId(), 'recipients' );
                $memcache && $memcache->set('lstCallbacks_recipient_'.$objCampaign->getId(), $lstCallbacks, MEMCACHE_COMPRESSED, MEMCACHE_CACHE_TIME);
            }            
        } catch ( Exception $e ) {
            Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] Error: '.$e->getMessage(), 'error_callback.log');
        }        
        
        $email_message  = $raw['message'];
        $subject        = $raw['subject'];
        $html           = $raw['body_html'];
        $plain          = $raw['body_plain'];
        $pmb_subject    = $raw['pmb_subject'];
        $pmb_message    = $raw['pmb_message'];
        
        /* setup recipient depended parameters */
        $params = unserialize($record['params']);
        if ( is_array($params) && sizeof($params) ) {
            $search = array_keys($params);
            $replace = array_values($params);
            $search = array_map('Server_Model_Campaign_Recipient::arrayWalk', $search);
            $subject = str_replace($search, $replace, $subject);
            $html = str_replace($search, $replace, $html);
            $plain = str_replace($search, $replace, $plain);            
            $pmb_subject && $pmb_subject = str_replace($search, $replace, $pmb_subject);
            $pmb_message && $pmb_message = str_replace($search, $replace, $pmb_message);
        }
        
        /* remove \n from html part */
        $html = str_replace("\n", "", $html);
        $html = str_replace("\r", "", $html);        
        
        /**
         * the \r\n.\r\n is end of data section for SMTP protocal
         * replace this line to .\r\n in plain content
         * @autor Artem Sukharev
         */
        $plain = str_replace("\r\n.\r\n", ".\r\n", $plain);
        $plain = str_replace("\n.\n", ".\n", $plain);
        $plain = preg_replace("/\n{1,}\./mi", ".", $plain);
        
        require_once(ENGINE_DIR.'/htmlMimeMail5/mimePart.php');
        $params['content_type'] = 'text/plain';
        $params['encoding']     = '7bit';
        $params['charset']      = 'UTF-8';
        $message = new Mail_mimePart($plain, $params);
        $encoded_plain = $message->encode();
        
        $params['content_type'] = 'text/html';
        $params['encoding']     = 'quoted-printable';
        $params['charset']      = 'UTF-8';
        $message = new Mail_mimePart($html, $params);
        $encoded_html = $message->encode();        
        
        $email_message = str_replace("{#*--SUBJECT--*#}", $subject, $email_message);
        $email_message = str_replace("{#*--TEXT--*#}", $encoded_plain['body'], $email_message);
        $email_message = str_replace("{#*--HTML--*#}", $encoded_html['body'], $email_message);        
        $email_message = str_replace("{#*--TO--*#}", $to, $email_message);
        $email_message = str_replace("{#*--MAIL_DATE--*#}", date('D, d M y H:i:s O'), $email_message);
        
        $email_message = preg_replace("/{\*(?:.*?)\*}/im", "", $email_message);

        /* do callbacks */
        if ( null !== $lstCallbacks && sizeof($lstCallbacks) != 0 ) {
            foreach ( $lstCallbacks as $objCallback ) {
                $result = false;
                try {
                    //TODO: need coorect timout
                    $client = new SoapClient( $objCallback->getWsdl(), array('timeout' => 600) );
                    $action = $objCallback->getAction();
                    
                    /* prepare params */
                    $params = $objCallback->getParams();
                    $params['mailsrv:recipient_email'] = $record['email'];
                    if ( array_key_exists('mailsrv:pmb_subject', $params) ) $params['mailsrv:pmb_subject'] = $pmb_subject ? $pmb_subject : $subject;
                    if ( array_key_exists('mailsrv:pmb_message', $params) ) $params['mailsrv:pmb_message'] = $pmb_message ? $pmb_message : $html;
                    
                    $result = $client->$action($objCallback->getUid(), $params);
                } catch ( Exception $e ) {                    
                    Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] '.$e->getMessage().' CAMPAIGN:'.$objCampaign->getId().' CALLBACK:'.$objCallback->getWsdl().':'.$objCallback->getAction(), 'error_callback.log');
                }
                Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] STATUS:'. ($result?'OK':'CANCELED') .' CALLBACK:RECIPIENTS CAMPAIGN:'.$objCampaign->getId().' CALLBACK:'.$objCallback->getWsdl().':'.$objCallback->getAction(), 'callback.log');
                
                /**
                 * if result from callback function is FALSE, doesn't need to process this campaign
                 * if we have any exception in calback function - we cannot process campaign
                 * - mark campaign as 'canceled' and write status to log file
                 */
                if ( !$result ) {
                    Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] MESSAGE SEND recipient:'.$record['id'].':'.$record['email'].' campaign:'.$record['campaign_id'].' CANCELED:Aborted by callback', 'messages.log');
                    Server_Model_Campaign_Recipient::rollbackStatus($recordID, 'canceled');                        
                    return false;
                }
            }
        }
        
        unset($message, $encoded_plain, $encoded_html);
        
        /**
         * SEND MESSAGE
         * log SMTP status and ROLLBACK status
         */
        
        try { 
            $status = Server_Model_Campaign_Recipient::sendSMTP($record['email'], $sender, $email_message, $record['campaign_id']); 
        }catch ( Exception_SMTP_Connection $e ) {
            Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] '.$e->getMessage(), "error_smtp.log");
            Server_Model_Campaign_Recipient::rollbackStatus($recordID);           
            throw new SoapFault('Client', $e->getMessage());
        } catch ( Exception_SMTP_Status_From $e ) {
            Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] '.$e->getMessage(), "error_smtp.log");
            Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] MESSAGE SEND recipient:'.$record['id'].':'.$record['email'].' campaign:'.$record['campaign_id'].' CANCELED:'.$e->getMessage(), 'messages.log');
            Server_Model_Campaign_Recipient::rollbackStatus($recordID, 'canceled');
            return true;
        } catch ( Exception_SMTP_Status_To $e ) {
            Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] '.$e->getMessage(), "error_smtp.log");
            Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] MESSAGE SEND recipient:'.$record['id'].':'.$record['email'].' campaign:'.$record['campaign_id'].' CANCELED:'.$e->getMessage(), 'messages.log');
            Server_Model_Campaign_Recipient::rollbackStatus($recordID, 'canceled');                        
            return true;
        } catch ( Exception_SMTP_Status_Data $e ) {
            Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] '.$e->getMessage(), "error_smtp.log");
            if ( $record['attempt'] < 5 ) {
                Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] MESSAGE SEND recipient:'.$record['id'].':'.$record['email'].' campaign:'.$record['campaign_id'].' ATTEMPT:'.($record['attempt'] + 1).' DEFERRED:'.$e->getMessage(), 'messages.log');
                Server_Model_Campaign_Recipient::rollbackStatus($recordID, 'in_progress', true);                           
                return false; 
                //throw new SoapFault('Client', $e->getMessage());
            } else {
                Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] MESSAGE SEND recipient:'.$record['id'].':'.$record['email'].' campaign:'.$record['campaign_id'].' CANCELED_AFTER_'.$record['attempt'].'_ATTEMPTS:'.$e->getMessage(), 'messages.log');
                Server_Model_Campaign_Recipient::rollbackStatus($recordID, 'canceled');                            
                return true;                
            }                     
        } catch ( Exception_SMTP_Status_Rset $e ) {
            Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] '.$e->getMessage(), "error_smtp.log");
            if ( $record['attempt'] < 5 ) {
                Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] MESSAGE SEND recipient:'.$record['id'].':'.$record['email'].' campaign:'.$record['campaign_id'].' ATTEMPT:'.($record['attempt'] + 1).' DEFERRED:'.$e->getMessage(), 'messages.log');
                Server_Model_Campaign_Recipient::rollbackStatus($recordID, 'in_progress', true);    
                return false;                       
                //throw new SoapFault('Client', $e->getMessage());
            } else {
                Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] MESSAGE SEND recipient:'.$record['id'].':'.$record['email'].' campaign:'.$record['campaign_id'].' CANCELED_AFTER_'.$record['attempt'].'_ATTEMPTS:'.$e->getMessage(), 'messages.log');
                Server_Model_Campaign_Recipient::rollbackStatus($recordID, 'canceled');                            
                return true;                
            }                     
	    } catch ( Exception_SMTP_Status $e ) {
	        Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] '.$e->getMessage(), "error_smtp.log");
	        Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] MESSAGE SEND recipient:'.$record['id'].':'.$record['email'].' campaign:'.$record['campaign_id'].' CANCELED:'.$e->getMessage(), 'messages.log');
            Server_Model_Campaign_Recipient::rollbackStatus($recordID, 'canceled');            
	        return true;
	    } catch ( Exception $e ) {
	        Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] '.$e->getMessage(), "error_smtp.log");
            Server_Model_Campaign_Recipient::rollbackStatus($recordID);			
            throw new SoapFault('Client', $e->getMessage());         
        }     

        Server_Model_Campaign_Recipient::rollbackStatus($recordID, 'processed'); 
        Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] MESSAGE SEND recipient:'.$record['id'].':'.$record['email'].' campaign:'.$record['campaign_id'].' SUCCESS', 'messages.log');
        return true;        
	}
	
    /**
     * @return boolean
     */
	public function verify()
	{
	    try { Server_Service_Deliver_Verifier::verify(); }
	    catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
	    
	    return true;
	}
	
    /**
     * @return boolean
     */
    public function log()
    {
        //try { Server_Service_Deliver_Logger::log(); }
        //catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        return true;
    }
}
