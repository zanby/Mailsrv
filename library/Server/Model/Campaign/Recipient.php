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
class Server_Model_Campaign_Recipient
{
    protected $id;
    protected $campaignId;
    protected $email;
    protected $name;
    protected $locale;
    protected $params;
    protected $createDate;
    protected $status;
    
    /**
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id to set
     * @return Server_Model_Campaign_Recipient
     */
    public function setId( $id )
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int $campaignId
     */
    public function getCampaignId()
    {
        return $this->campaignId;
    }

    /**
     * @param int $campaignId to set
     * @return Server_Model_Campaign_Recipient
     */
    public function setCampaignId( $campaignId )
    {
        $this->campaignId = $campaignId;
        return $this;
    }

    /**
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email to set
     * @return Server_Model_Campaign_Recipient
     */
    public function setEmail( $email )
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name to set
     * @return Server_Model_Campaign_Recipient
     */
    public function setName( $name )
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * @return string $locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     * @return Server_Model_Campaign_Recipient
     */
    public function setLocale( $locale )
    {
        $this->locale = $locale;
        return $this;
    }
    
    /**
     * @param array $params to set
     * @return Server_Model_Campaign_Recipient
     */
    public function setParams( $params )
    {
        $this->params = $params;
        return $this;
    }

    
    /**
     * @return array $params
     */
    public function getParams()
    {
        return $this->params;
    }
    
    /** 
     * @param string $name
     * @param string $value
     * @return @return Server_Model_Campaign_Recipient
     */
    public function addParam($name, $value)
    {
        if ( is_object($value) ) throw new Exception("You can not use objects as params");
        $this->params[$name] = $value;
        return $this;
    }
    
    /**
     * @param string $status to set
     * @return Server_Model_Campaign_Recipient
     */
    public function setStatus( $status )
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $createDate to set
     * @return Server_Model_Campaign_Recipient
     */
    public function setCreateDate( $createDate )
    {
        $this->createDate = $createDate;
        return $this;
    }

    /**
     * @return string $createDate
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }
   
    /**
     * 
     * @return boolean
     */
    public function save()
    {
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        date_default_timezone_set('UTC');        
        $created_date = date('Y-m-d H:i:s');
        $statusNew = 'new';
        
        if ( null === $this->getId() ) {
            $emptyStr = '';
            $insert_sql = "INSERT INTO mail_campaignes__recipients 
                (campaign_id, email, name, locale, params, create_date, status) VALUES 
                (:campaign_id, :email, :name, :locale, :params, :create_date, :status)";
            $stmt = $db->prepare($insert_sql);
            $stmt->bindParam(':campaign_id', $this->getCampaignId());
            $stmt->bindParam(':email', $this->getEmail());
            $stmt->bindParam(':name', $this->getName());
            $stmt->bindParam(':locale', $this->getLocale());
            $stmt->bindParam(':params', serialize($this->getParams()));
            $stmt->bindParam(':create_date', $created_date);
            $stmt->bindParam(':status', $statusNew);
            try { $stmt->execute(); } 
            catch ( PDOException $e ) {
                $db = NULL;
                throw $e;
            }       
            $this->setId($db->lastInsertId());
        } else {
            $update_sql = "UPDATE mail_campaignes__recipients SET 
                campaign_id = :campaign_id, email = :email, name = :name, locale = :locale, params = :params, status = :status";
            $stmt = $db->prepare($update_sql);
            $stmt->bindParam(':campaign_id', $this->getCampaignId());
            $stmt->bindParam(':email', $this->getEmail());
            $stmt->bindParam(':name', $this->getName());
            $stmt->bindParam(':locale', $this->getLocale());
            $stmt->bindParam(':params', serialize($this->getParams()));
            $stmt->bindParam(':status', $this->getStatus());
            try { $stmt->execute(); } 
            catch ( PDOException $e ) {
                $db = NULL;
                throw $e;
            }       
        }
        
        $db = NULL;
        return true; 
    }
    
    /**
     * 
     * @param int $id
     * @return array
     */
    static public function loadAsArrray( $id )
    {
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_campaignes__recipients WHERE id = :id";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':id', $id);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }               
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ( !$result || !sizeof($result) ) throw new Exception('Incorrect id of recipient');
        
        return $result[0];                
    }        
    
    /**
     * 
     * @param int $rows_count
     * @return array
     */
    static public function getRowsWithLock($rows_count = 100)
    {       
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
        $records_to_process = array();
        $isDeadlock = true;
        $max_deadlock_iteration = 10;
        $deadlock_iteration = 0;                
        date_default_timezone_set('UTC');
        
        while ( $isDeadlock && $deadlock_iteration <= $max_deadlock_iteration ) {
            $deadlock_iteration++;
            $delivery_date = date('Y-m-d H:i:s');
            $in_progress_date = date('Y-m-d H:i:s');
        
            $db->beginTransaction();
            //$select_sql = "SELECT id FROM mail_campaignes__recipients WHERE status = 'started' AND delivery_date <= :delivery_date ORDER BY delivery_date ASC LIMIT 0, ".$rows_count." FOR UPDATE";
            
            $select_sql = "SELECT mcr.id 
                FROM mail_campaignes__recipients mcr 
                INNER JOIN `mail_campaignes` mc ON mcr.campaign_id = mc.id 
                WHERE mc.status = 'processed' AND mc.delivery_date <= :delivery_date AND mcr.status = 'new'
                ORDER BY mc.delivery_date ASC LIMIT 0,".$rows_count." FOR UPDATE";

            $stmt = $db->prepare($select_sql);
            $stmt->bindParam(':delivery_date', $delivery_date);
            //  Deadlock
            try { $stmt->execute(); } 
            catch ( PDOException $e ) {
                $db->rollBack();
                unset($select_sql,$stmt); 
                continue;
            }       
            $records_to_process = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            if ( $records_to_process && sizeof($records_to_process) != 0 ) {
                $update_sql = "UPDATE mail_campaignes__recipients SET status = 'in_progress', in_progress_date = '".$in_progress_date."' WHERE id IN (" .join(',', $records_to_process). ")";
                //  Deadlock
                try { $stmt = $db->query($update_sql); } 
                catch (PDOException $e) {
                    $db->rollBack();
                    unset($update_sql,$stmt); 
                    continue;
                } 
                $db->commit();
                $isDeadlock = false;
            } else {
                $db->rollBack();
                $isDeadlock = false;
            }
        }
        
        unset($delivery_date,$in_progress_date,$select_sql,$update_sql,$stmt);
        
        $db = NULL;
        return $records_to_process;
    }
    
    /**
     * 
     * @param int $id
     * @param string $status
     * @return boolean
     */
    static public function rollbackStatus($id, $status = 'new', $incAttempt = null)
    {
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $status = ( null === $status ) ? 'new' : $status;

        if ( $status == 'processed' ) {
            date_default_timezone_set('UTC');
            $processed_date = date('Y-m-d H:i:s');
            
            $update_sql = "UPDATE mail_campaignes__recipients SET status = 'processed', processed_date = '".$processed_date."'  WHERE id = '".$id."'";
            try { $stmt = $db->query($update_sql); } 
            catch ( PDO_Exception $e ) { 
                $db = NULL; 
                throw $e;
            }       
        } else {
            if ( true === $incAttempt ) {
                $update_sql = "UPDATE mail_campaignes__recipients SET status = '".$status."', attempt = attempt + 1 WHERE id = '".$id."'";
            } else {
                $update_sql = "UPDATE mail_campaignes__recipients SET status = '".$status."' WHERE id = '".$id."'";
            }            
            try { $stmt = $db->query($update_sql); } 
            catch ( PDO_Exception $e ) { 
                $db = NULL; 
                throw $e;
            }       
        } 
        unset($update_sql, $stmt);
        $db = NULL;
        
        return true;
    }
    
    /**
     * Must return true if the response is valid, false if not and we need 
     * to reconnect, or throw an exception if attemts limit is reached. 
     * @return boolean
     */
    static public function responseValidator($response, $numberOfAttempt, $callArgs)
    {        
        if ($response['http_code'] != 200 || !strlen($response['body'])) {
            $strCallArgs = ''; Server_Model_Log::array2str( $strCallArgs, $callArgs );
            Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] HTTP_CODE:'.$response['http_code'].' ATTEMPT:'.$numberOfAttempt.' CALLARGS:'.$strCallArgs, 'deliver_responseValidator.log');            
            if ( $numberOfAttempt < 5 ) {                
                //sleep(60*$numberOfAttempt);
                sleep(10);
                return false;
            } else {
                try {
                    throw new SoapFault("Client", date("r") . ": Exception: failed after $numberOfAttempt attempts!");
                } catch (Exception $e) {
                    $e->request = $callArgs;
                    $e->response = $response;
                    throw $e; 
                }                
            }
        }
        return true;
    }
    
    /**
     * 
     * @param array|string $to
     * @param string $from
     * @param string $message
     * @param int $campaign_id
     * @return boolean
     */
    static public function sendSMTP($to, $from, $message, $campaign_id)
    {        
        global $_RESULT;
              
		Server_Model_Log::logRaw($message, $campaign_id, $to);		
        if ( !SMTP ) return true;

        $to = ( !is_array($to) ) ? array($to) : $to;
		
        define('DISPLAY_XPM4_ERRORS', true);
        $arr = array( 'type' => 3, 'destination' => Server_Model_Log::getXPM4LogFile() );
        define('LOG_XPM4_ERRORS', serialize($arr));        
        require_once(ENGINE_DIR.'/XPertMailer/FUNC5.php');
        require_once(ENGINE_DIR.'/XPertMailer/MIME5.php');
        require_once(ENGINE_DIR.'/XPertMailer/SMTP5.php');

        try { $conn = SMTP5::connect(SMTP_HOST, SMTP_PORT); } 
		catch ( Exception $e ) { throw new Exception_SMTP_Connection("Could not connect to SMTP server. Error: ".$e->getMessage()); }       		
        if ( !$conn ) { throw new Exception_SMTP_Connection("Could not connect to SMTP server."); }
        
        try { 
            $status = SMTP5::send($conn, $to, $message, $from);
            $smtpResult = $_RESULT; 
        } catch ( Exception $e ) {   
            SMTP5::disconnect($conn);                               
            throw new Exception_SMTP_Status($e->getMessage());
        }
        
        /* 
         * some unknown error has been detected from smtp server
         * in this case we cannot sent this email and we must mark it as CANCELED 
         */        
        if ( $status === false ) {
            $result_mess = '';
            if ( isset($smtpResult) ) {
                Server_Model_Log::array2str( $result_mess, $smtpResult );
                Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] STATUS:'. ( $status === false ? 'CANCELED' : 'OK' ) .' RESULT:'.$result_mess, "result_smtp.log");
            }

            SMTP5::disconnect($conn);
            
            /* from */
            if ( !empty($smtpResult[320]) || !empty($smtpResult[321]) )
                throw new Exception_SMTP_Status_From('SMTP Server Error:'.$result_mess);
            /* to */
            elseif ( !empty($smtpResult[323]) || !empty($smtpResult[324]) ){
                throw new Exception_SMTP_Status_To('SMTP Server Error:'.$result_mess);
            /* data */
            }elseif ( !empty($smtpResult[326]) || !empty($smtpResult[327]) || !empty($smtpResult[328]) || !empty($smtpResult[329]) || !empty($smtpResult[330]) )
                throw new Exception_SMTP_Status_Data('SMTP Server Error:'.$result_mess);
            /* rset */
            elseif ( !empty($smtpResult[332]) || !empty($smtpResult[333]) )
                throw new Exception_SMTP_Status_Rset('SMTP Server Error:'.$result_mess);
            /* unknown */
            else {                       
                Server_Model_Log::log(var_export($smtpResult, true),'kkkkk.log');
                throw new Exception_SMTP_Status('SMTP Server Error:'.$result_mess);
            }
		} 

        SMTP5::disconnect($conn);        
        return true;
    }
    
    /**
     * 
     * @param string $str
     * @return string
     */
    static public function arrayWalk($str)
    {
        return '{*'.$str.'*}';
    }
}