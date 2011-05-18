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
require_once ENGINE_DIR.'/Server/Model/Log.php';
require_once ENGINE_DIR.'/Server/Model/Campaign.php';
require_once ENGINE_DIR.'/Server/Model/Campaign/Recipient.php';
require_once ENGINE_DIR.'/Server/Model/Campaign/Recipients.php';
require_once ENGINE_DIR.'/Server/Model/Campaign/Sender.php';
require_once ENGINE_DIR.'/Server/Model/Campaign/Image.php';
require_once ENGINE_DIR.'/Server/Model/Campaign/Callback.php';
require_once ENGINE_DIR.'/Server/Model/Campaign/Param.php';
require_once ENGINE_DIR.'/Server/Model/Campaign/Params.php';
require_once ENGINE_DIR.'/Server/Model/Campaign/Header.php';

class Callback extends Server_Model_Campaign_Callback {}
class Recipient extends Server_Model_Campaign_Recipient{}
class Recipients extends Server_Model_Campaign_Recipients {}
class Param extends Server_Model_Campaign_Param {}
class Params extends Server_Model_Campaign_Params {}

class Server_Service_Campaign
{
    /**
     * @return boolean
     */
    public function testCampaign()
    {
        return true;
    }

    /**
     * @return string
     */
    public function createCampaign()
    {
        $objCampaign = new Server_Model_Campaign();
        try { $result = $objCampaign->save(); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        return $objCampaign->getUid();
    }

    /**
     * @param string $uid First string
     * @param string $email Second string
     * @param string $name Third string
     * @return boolean
     */
    public function setSender( $uid, $email, $name = null )
    {
        try { $result = Server_Model_Campaign::existsByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');
        
        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');
        
        $objCampaign = new Server_Model_Campaign(); 
        try { 
            $objCampaign->loadByUid( $uid );
            if ( !$objSender = Server_Model_Campaign_Sender::loadByCampaign($objCampaign->getId()) ) {
                $objSender = new Server_Model_Campaign_Sender();
                $objSender->setCampaignId( $objCampaign->getId() );
            }            
            $objSender->setEmail($email);
            $objSender->setName($name);
            $objSender->save();
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        return $result;
    }

    /**
     * @param string $uid First string
     * @param Recipients $recipiens Second Recipients
     * @return boolean
     */
    public function addRecipients( $uid, $recipients )
    {
        //Server_Model_Log::log(var_export($recipients, true), 'recipients.log');
        
        try { $result = Server_Model_Campaign::existsByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');
        
        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');
        
        set_time_limit(0);
        ini_set('memory_limit','512M');
        
        $recipients = isset($recipients->recipients) && !empty($recipients->recipients) ? $recipients->recipients : array();
        $recipients = ( is_array($recipients) ) ? $recipients : array($recipients);
        
        if ( is_array($recipients) && sizeof($recipients) != 0 ) {
            $objCampaign = new Server_Model_Campaign();
            try { $objCampaign->loadByUid( $uid ); }
            catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
            foreach ( $recipients as $recipient ) {
                
                if ( !isset($recipient->email) || empty($recipient->email) ) throw new SoapFault("HTTP", 'Incorrect recipient email');
                $recipient->name = isset($recipient->name) && !empty($recipient->name) ? $recipient->name : null;
                $recipient->locale = isset($recipient->locale) && !empty($recipient->locale) ? $recipient->locale : null;
                $recipient->params = isset($recipient->params) && !empty($recipient->params) ? $recipient->params : array();
                $recipient->params = ( is_array($recipient->params) ) ? $recipient->params : array($recipient->params);
                
                $objRecipient = new Server_Model_Campaign_Recipient();
                $objRecipient->setCampaignId( $objCampaign->getId() );
                $objRecipient->setEmail( $recipient->email );
                $objRecipient->setName( $recipient->name );
                $objRecipient->setLocale( $recipient->locale );
                if ( isset($recipient->params) && is_array($recipient->params) && sizeof($recipient->params) ) {
                    foreach ( $recipient->params as $param ) {
                        if ( isset($param->key) && !empty($param->key) ) {
                            $param->value = isset($param->value) ? $param->value : '';
                            try { $objRecipient->addParam($param->key, $param->value); }
                            catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
                        }
                    }
                }
                
                try { $objCampaign->addRecipient($objRecipient); }
                catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }                
            }
            try { $objCampaign->saveRecipients(); } 
            catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        }
        
        /*
        if ( is_array($recipients) && sizeof($recipients) != 0 ) {
            $objCampaign = new Server_Model_Campaign();
            try { $objCampaign->loadByUid( $uid ); }
            catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
            foreach ( $recipients as $recipient ) {
                
                if ( !isset($recipient['email']) || empty($recipient['email']) ) throw new SoapFault("HTTP", 'Incorrect recipient email');
                //if ( !isset($recipient['name']) || empty($recipient['name']) ) throw new SoapFault("HTTP", 'Incorrect recipient name');
                $recipient['locale'] = isset($recipient['locale']) ? $recipient['locale'] : null;
                
                $objRecipient = new Server_Model_Campaign_Recipient();
                $objRecipient->setCampaignId( $objCampaign->getId() );
                $objRecipient->setEmail( $recipient['email'] );
                $objRecipient->setName( $recipient['name'] );
                $objRecipient->setLocale( $recipient['locale'] );
                if ( isset($recipient['params']) && is_array($recipient['params']) && sizeof($recipient['params']) ) {
                    foreach ( $recipient['params'] as $param_name => $param_value ) {
                        try { $objRecipient->addParam($param_name, $param_value); }
                        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
                    }
                }
                
                try { $objCampaign->addRecipient($objRecipient); }
                catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }                
            }
            try { $objCampaign->saveRecipients(); } 
            catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        }
        */
        
        return true;
    }

    /**
     * @param string $uid First string
     * @param Recipient $recipient Second Recipient
     * @return boolean
     */
    public function addRecipient( $uid, $recipient )
    {       
        //Server_Model_Log::log(var_export($recipient, true), 'recipient.log');

        try { $result = Server_Model_Campaign::existsByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');
        
        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');
        
        $objCampaign = new Server_Model_Campaign();
        try { $objCampaign->loadByUid( $uid ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        if ( !isset($recipient->email) || empty($recipient->email) ) throw new SoapFault("HTTP", 'Incorrect recipient email');
        $recipient->name = isset($recipient->name) && !empty($recipient->name) ? $recipient->name : null;
        $recipient->locale = isset($recipient->locale) && !empty($recipient->locale) ? $recipient->locale : null;
        $recipient->params = isset($recipient->params) && !empty($recipient->params) ? $recipient->params : array();
        $recipient->params = ( is_array($recipient->params) ) ? $recipient->params : array($recipient->params);
        
        $objRecipient = new Server_Model_Campaign_Recipient();
        $objRecipient->setCampaignId( $objCampaign->getId() );
        $objRecipient->setEmail( $recipient->email );
        $objRecipient->setName( $recipient->name );
        $objRecipient->setLocale( $recipient->locale );
        if ( isset($recipient->params) && is_array($recipient->params) && sizeof($recipient->params) ) {            
            foreach ( $recipient->params as $param ) {
                if ( isset($param->key) && !empty($param->key) ) {
                    $param->value = isset($param->value) ? $param->value : '';
                    try { $objRecipient->addParam($param->key, $param->value); }
                    catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
                }
            }
        }
        
        try { $objRecipient->save(); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        unset($objRecipient);
        
        /*
        if ( !isset($recipient['email']) || empty($recipient['email']) ) throw new SoapFault("HTTP", 'Incorrect recipient email');
        //if ( !isset($recipient['name']) || empty($recipient['name']) ) throw new SoapFault("HTTP", 'Incorrect recipient name');
        $recipient['locale'] = isset($recipient['locale']) ? $recipient['locale'] : null;
        
        $objRecipient = new Server_Model_Campaign_Recipient();
        $objRecipient->setCampaignId( $objCampaign->getId() );
        $objRecipient->setEmail( $recipient['email'] );
        $objRecipient->setName( $recipient['name'] );
        $objRecipient->setLocale( $recipient['locale'] );
        if ( isset($recipient['params']) && is_array($recipient['params']) && sizeof($recipient['params']) ) {
            foreach ( $recipient['params'] as $param_name => $param_value ) {
                try { $objRecipient->addParam($param_name, $param_value); }
                catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
            }
        }
        
        try { $objRecipient->save(); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        unset($objRecipient);
        */
        
        return true;
    } 

    /**
     * @param string $uid First string
     * @param string $subject Second string
     * @return boolean
     */
    public function setSubject( $uid, $subject )
    {
        try { $result = Server_Model_Campaign::existsByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');
        
        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');
        
        $objCampaign = new Server_Model_Campaign();
        try { $objCampaign->loadByUid( $uid ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        
        try { $objCampaign->saveSubject($subject); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        return true;      
    }

    /**
     * @param string $uid First string
     * @param string $html Second string
     * @return boolean
     */
    public function setHtml( $uid, $html )
    {
        try { $result = Server_Model_Campaign::existsByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');
        
        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');        
        
        $objCampaign = new Server_Model_Campaign();
        try { $objCampaign->loadByUid( $uid ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        

        try { $objCampaign->saveBodyHtml($html); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        return true;  
    }

    /**
     * @param string $uid First string
     * @param string $plain Second string
     * @return boolean
     */
    public function setPlain( $uid, $plain )
    {
        try { $result = Server_Model_Campaign::existsByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');

        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');
        
        $objCampaign = new Server_Model_Campaign();
        try { $objCampaign->loadByUid( $uid ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        

        try { $objCampaign->saveBodyPlain($plain); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        return true;
    }

    /**
     * @param string $uid First string
     * @param Params $params Second Params	   
     * @return boolean
     */
    public function addParams( $uid, $params )
    {
        //Server_Model_Log::log(var_export($params, true), 'params.log');
        
        try { $result = Server_Model_Campaign::existsByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');
        
        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');
        
        set_time_limit(0);
        ini_set('memory_limit','512M');
        
        $params = isset($params->params) && !empty($params->params) ? $params->params : array();
        $params = ( is_array($params) ) ? $params : array($params);
        
        if ( is_array($params) && sizeof($params) != 0 ) {
                    
            $objCampaign = new Server_Model_Campaign();
            try { $objCampaign->loadByUid( $uid ); }
            catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        

            foreach ( $params as $param ) {
                if ( isset($param->key) && !empty($param->key) ) {
                    $param->value = isset($param->value) ? $param->value : '';
                    try {
                        $objParam = new Server_Model_Campaign_Param();
                        $objParam->setCampaignId( $objCampaign->getId() );
                        $objParam->setName( $param->key );
                        $objParam->setValue( $param->value );
                    } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }                
                    
                    try { $objCampaign->addParam($objParam); }
                    catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
                }                
            }
            try { $objCampaign->saveParams(); } 
            catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }            
        }
        
        /*
        if ( is_array($paramsHash) && sizeof($paramsHash) ) {
        
            $objCampaign = new Server_Model_Campaign();
            try { $objCampaign->loadByUid( $uid ); }
            catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        

            foreach ( $paramsHash as $name => $value ) {
                try {
                    $objParam = new Server_Model_Campaign_Param();
                    $objParam->setCampaignId( $objCampaign->getId() );
                    $objParam->setName( $name );
                    $objParam->setValue( $value );
                } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }                
                
                try { $objCampaign->addParam($objParam); }
                catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }                
            }
            try { $objCampaign->saveParams(); } 
            catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }            
        }
        */
        
        return true;
    }

    /**
     * @param string $uid First string
     * @param string $name Second string
     * @param string $value Third string
     * @return boolean
     */
    public function addParam( $uid, $name, $value )
    {        
        try { $result = Server_Model_Campaign::existsByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');

        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');
        
        $objCampaign = new Server_Model_Campaign();
        try { $objCampaign->loadByUid( $uid ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
                
        try {
            $objParam = new Server_Model_Campaign_Param();
            $objParam->setCampaignId( $objCampaign->getId() );
            $objParam->setName( $name );
            $objParam->setValue( $value );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        try { $objCampaign->addParam($objParam); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
                        
        try { $objCampaign->saveParams(); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }            
        
		return true;
    }
    
    /**
     * @param string $uid First string
     * @param string $imageName Second string
     * @param base64Binary $imageSource Third base64Binary
     * @return boolean
     */
    public function addEmbededImage( $uid, $imageName, $imageSource )
    {
        try { $result = Server_Model_Campaign::existsByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');
        
        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');
        
        $objCampaign = new Server_Model_Campaign();
        try { $objCampaign->loadByUid( $uid ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
                
        $objImage = new Server_Model_Campaign_Image();
        $objImage->setCampaignId( $objCampaign->getId() );
        $objImage->setImageName( $imageName );
        $objImage->setImageSource( base64_encode($imageSource) );

        try { $objCampaign->addImage($objImage); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }

        try { $objCampaign->saveImages(); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); } 
        
		return true;
    }
    
    /**
     * @param string $uid
     * @param string $templateUid
     * @param string $instanceKey
     * @return boolean
     */
    public function setTemplate( $uid, $templateUid, $instanceKey )
    {
        require_once ENGINE_DIR.'/Server/Model/Template.php';
        
        try { $result = Server_Model_Campaign::existsByUid( $uid ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');        
        
        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');
        
        try { $result = Server_Model_Template::existsByUid( $templateUid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');
        
        $objCampaign = new Server_Model_Campaign();
        try { $objCampaign->loadByUid( $uid ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
                
        $objTemplate = new Server_Model_Template();
        try { $result = $objTemplate->loadByUid( $templateUid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }      
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');

        if ( $objTemplate->getStatus() != 'active' ) throw new SoapFault("HTTP", 'Can not load template. Template isn\'t active');
        try { $objTemplate->saveLastUsed(); }
		catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
		
		
        try { $result = $objCampaign->saveTempalteId( $objTemplate->getId() ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        return $result;
    }
    
    /**
     * @param string $uid First string
     * @param string $date Second string
	 * @param string $timezone Third string
     * @return boolean
     */
    public function setDeliveryDate( $uid, $date, $timezone = 'UTC' )
	{
		try { $tz = new DateTimeZone($timezone); }
		catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
		
		try { $objDate = new DateTime($date, $tz); }
		catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
	
        try { $result = Server_Model_Campaign::existsByUid( $uid ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');        
        
        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');
		
        $objCampaign = new Server_Model_Campaign();
        try { $objCampaign->loadByUid( $uid ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        
		/* convert date to UTC */
		$utctz = new DateTimeZone('UTC');
		$objDate->setTimezone($utctz);
		
        try { $result = $objCampaign->saveDeliveryDate( $objDate->format('Y-m-d H:i:s') ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        return $result;
	}
		
    /**
     * @param string $uid First string
     * @param Callback $callback Second Callback
     * @return string
     */
    public function addCallback( $uid, $callback )
    {
        if ( !($callback instanceof stdClass) ) throw new SoapFault("HTTP", 'Incorrect callback object');
        if ( empty($callback->type) ) throw new SoapFault("HTTP", 'Callback type hasn\'t been specified');
        $callback->type = strtolower($callback->type);
        if ( !in_array($callback->type, array('before', 'after', 'recipients')) ) throw new SoapFault("HTTP", 'Incorrect callback type');
        if ( empty($callback->wsdl) ) throw new SoapFault("HTTP", 'Callback wsdl hasn\'t been specified');
        if ( empty($callback->action) ) throw new SoapFault("HTTP", 'Callback action hasn\'t been specified');
        
        try { $result = Server_Model_Campaign::existsByUid( $uid ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');        
        
        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');
        
        $objCampaign = new Server_Model_Campaign();
        try { $objCampaign->loadByUid( $uid ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
                
        $objCallback = new Server_Model_Campaign_Callback();
        $objCallback->setCampaignId( $objCampaign->getId() );
        $objCallback->setType( $callback->type );
        $objCallback->setWsdl( $callback->wsdl );
        $objCallback->setAction( $callback->action );
        $objCallback->save();
        
        return $objCallback->getUid();
    }
    
    /**
     * @param string $callbackUID First string
     * @param string $name Second string
     * @param string $value Third string
     * @return boolean
     */
    public function addCallbackParam( $callbackUID, $name, $value )
    {
        if ( empty($name) ) throw new SoapFault("HTTP", 'Incorrect parameter name');
        
        try { $result = Server_Model_Campaign_Callback::existsByUid( $callbackUID ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect callback uid');        
                
        $objCallback = new Server_Model_Campaign_Callback();
        try { $objCallback->loadByUid( $callbackUID ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
                
        try { $objCallback->saveParam($name, $value); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        return true;
    }
	
    /**
     * @param string $uid First string
     * @param string $name Second string
     * @param string $value Third string
     * @return boolean
     */
    public function addHeader( $uid, $name, $value )
    {        
        try { $result = Server_Model_Campaign::existsByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');

        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');
        
        $objCampaign = new Server_Model_Campaign();
        try { $objCampaign->loadByUid( $uid ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
                
        try {
            $objHeader = new Server_Model_Campaign_Header();
            $objHeader->setCampaignId( $objCampaign->getId() );
            $objHeader->setName( $name );
            $objHeader->setValue( $value );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        try { $objCampaign->addHeader($objHeader); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
                        
        try { $objCampaign->saveHeaders(); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }            
        
        return true;
    }
    
    /**
     * @param string $uid First string
     * @param string $subject Second string
     * @param string $message Third string
     * @return boolean
     */
    public function addPMBMessage( $uid, $subject, $message )
    {
        try { $result = Server_Model_Campaign::existsByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');

        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');
        
        $objCampaign = new Server_Model_Campaign();
        try { $objCampaign->loadByUid( $uid ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        try { $objCampaign->savePMBMessage($subject, $message); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); } 
        return true;
    }

    /**
     * @param string $uid First string
     * @param string $subject Second string
     * @return boolean
     */
    public function addPMBSubject( $uid, $subject )
    {
        try { $result = Server_Model_Campaign::existsByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');

        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');

        $objCampaign = new Server_Model_Campaign();
        try { $objCampaign->loadByUid( $uid ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }

        try { $objCampaign->savePMBSubject($subject); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        return true;
    }

    /**
     * @param string $uid First string
     * @param string $body Second string
     * @return boolean
     */
    public function addPMBBody( $uid, $body )
    {
        try { $result = Server_Model_Campaign::existsByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');

        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started. Cannot modify started compaign');

        $objCampaign = new Server_Model_Campaign();
        try { $objCampaign->loadByUid( $uid ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }

        try { $objCampaign->savePMBBody($body); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        return true;
    }

    /**
     * @param string $uid First string
     * @return boolean
     */
    public function startCampaign( $uid )
    {
        try { $result = Server_Model_Campaign::existsByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');
        
        try { $result = Server_Model_Campaign::isNotStartedByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'The campaign is already started.');
        
        $objCampaign = new Server_Model_Campaign();
        try { $objCampaign->loadByUid( $uid ); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        
        try {
			date_default_timezone_set('UTC');
			$objDateNow = new DateTime();
			$objDate = new DateTime($objCampaign->getDeliveryDate());
			if ( strcmp($objDateNow->format('Y-m-d H:i:s'), $objDate->format('Y-m-d H:i:s')) < 0 ) {
				$result = $objCampaign->saveStatus('wait');
			} else {
				$result = $objCampaign->start();
			}
			
            
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }

        return $result;
    }
    
    /**
     * @param string $uid First string
     * @return boolean
     */
    public function removeCampaign( $uid )
    {
        try { $result = Server_Model_Campaign::existsByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect campaign id');
        
        try { $result = Server_Model_Campaign::canRemoveByUid( $uid );
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) return false;
        
        $objCampaign = new Server_Model_Campaign();
        try { 
            $objCampaign->loadByUid( $uid );
            $objCampaign->remove(); 
        }catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        
        return true;
    }
    
}