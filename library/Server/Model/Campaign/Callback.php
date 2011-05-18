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
class Server_Model_Campaign_Callback
{
    protected $id;
    protected $uid;
    protected $campaignId;
    protected $type;
    protected $wsdl;
    protected $action;
    protected $params;
    
    /**
     * @param $id the $id to set
     */
    public function setId( $id )
    {
        $this->id = $id;
    }

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }
    
	/**
     * @param $uid the $uid to set
     */
    public function setUid( $uid )
    {
        $this->uid = $uid;
    }

	/**
     * @return the $uid
     */
    public function getUid()
    {
        return $this->uid;
    }

    
	/**
     * @param $campaignId the $campaignId to set
     */
    public function setCampaignId( $campaignId )
    {
        $this->campaignId = $campaignId;
    }

	/**
     * @return the $campaignId
     */
    public function getCampaignId()
    {
        return $this->campaignId;
    }

    
	/**
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }
    
	/**
     * @param $type the $type to set
     */
    public function setType( $type )
    {
        $this->type = $type;
    }

	/**
     * @return the $wsdl
     */
    public function getWsdl()
    {
        return $this->wsdl;
    }

	/**
     * @param $wsdl the $wsdl to set
     */
    public function setWsdl( $wsdl )
    {
        $this->wsdl = $wsdl;
    }

	/**
     * @return the $action
     */
    public function getAction()
    {
        return $this->action;
    }

	/**
     * @param $action the $action to set
     */
    public function setAction( $action )
    {
        $this->action = $action;
    }

	/**
     * @return the $params
     */
    public function getParams()
    {
        return $this->params;
    }

	/**
     * @param $params the $params to set
     */
    public function setParams( $params )
    {
        $this->params = $params;
    }

    /** 
     * @param int $id
     * @return boolean
     */
    public function load( $id )
    {
        if ( null === $id ) throw new Exception('Incorrect callback id');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_campaignes__callbacks WHERE id = :id";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':id', $id);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ( $result ) {
            $this->setId($result[0]['id']);   
            $this->setUid($result[0]['uid']);
            $this->setCampaignId($result[0]['campaign_id']);
            $this->setType($result[0]['type']);
            $this->setAction($result[0]['action']);
            $this->setWsdl($result[0]['wsdl']);
            
            /* load params */
            $select_sql = "SELECT * FROM mail_campaignes__callbacks_params WHERE callback_id = :callback_id";
            $stmt = $db->prepare($select_sql);
            $stmt->bindParam(':callback_id', $this->getId());
            try { $stmt->execute(); } 
            catch ( PDOException $e ) {
                $db = NULL;
                throw $e;
            }     
            $this->params = array();  
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ( $result ) {
                foreach ( $result as $record ) {
                    $this->params[$record['name']] = $record['value'];
                }
            }
        }        
        
        $db = NULL;
        return $this;
    }
    
    /** 
     * @param string $uid
     * @return boolean
     */
    public function loadByUid( $uid )
    {
        if ( null === $uid ) throw new Exception('Incorrect callback uid');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_campaignes__callbacks WHERE uid = :uid";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':uid', $uid);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ( $result ) {
            $this->setId($result[0]['id']);   
            $this->setUid($result[0]['uid']);
            $this->setCampaignId($result[0]['campaign_id']);
            $this->setType($result[0]['type']);
            $this->setAction($result[0]['action']);
            $this->setWsdl($result[0]['wsdl']);

            /* load params */
            $select_sql = "SELECT * FROM mail_campaignes__callbacks_params WHERE callback_id = :callback_id";
            $stmt = $db->prepare($select_sql);
            $stmt->bindParam(':callback_id', $this->getId());
            try { $stmt->execute(); } 
            catch ( PDOException $e ) {
                $db = NULL;
                throw $e;
            }       
            $this->params = array();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ( $result ) {
                foreach ( $result as $record ) {
                    $this->params[$record['name']] = $record['value'];
                }
            }
        }        
        
        $db = NULL;
        return $this;
    }
    
    /** 
     * @param $campaignId
     * @return Server_Model_Campaign_Callback
     */
    static public function loadByCampaign( $campaignId, $type = null )
    {
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_campaignes__callbacks WHERE campaign_id = :campaign_id";
        if ( null !== $type ) $select_sql .= " AND type = :type";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':campaign_id', $campaignId);
        if ( null !== $type ) $stmt->bindParam(':type', $type);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $return = array();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ( $results && sizeof($results) ) {
            foreach ( $results as $result ) {
                $objCallback = new Server_Model_Campaign_Callback();
                $objCallback->setId($result['id']);
                $objCallback->setUid($result['uid']);
                $objCallback->setCampaignId($result['campaign_id']);
                $objCallback->setType($result['type']);
                $objCallback->setAction($result['action']);
                $objCallback->setWsdl($result['wsdl']);

                /* load params */
                $select_sql = "SELECT * FROM mail_campaignes__callbacks_params WHERE callback_id = :callback_id";
                $stmt = $db->prepare($select_sql);
                $stmt->bindParam(':callback_id', $objCallback->getId());
                try { $stmt->execute(); } 
                catch ( PDOException $e ) {
                    $db = NULL;
                    throw $e;
                }       
                $params = array();
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ( $res ) {                    
                    foreach ( $res as $record ) { $params[$record['name']] = $record['value']; }
                }
                $objCallback->setParams($params);
                $return[] = $objCallback;
            }
            return $return;
        }        
        
        $db = NULL;
        return $return;        
    }
    
    /** 
     * @param int $id
     * @return boolean
     */
    static public function exists( $id )
    {
        if ( null === $id ) throw new Exception('Incorrect calback id');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT count(id) as cnt FROM mail_campaignes__callbacks WHERE id = :id";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':id', $id);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);        
        
        $db = NULL;
        return (boolean) $result[0];
    }
    
    /** 
     * @param string $uid
     * @return boolean
     */
    static public function existsByUid( $uid )
    {
        if ( null === $uid ) throw new Exception('Incorrect calback uid');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT count(id) as cnt FROM mail_campaignes__callbacks WHERE uid = :uid";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':uid', $uid);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);        
        
        $db = NULL;
        return (boolean) $result[0];
    }
    
    /**
     * 
     * @return unknown_type
     */
    public function save()
    {
        if ( null !== $this->getId() ) throw new Exception('Couldn\'t save callback.');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $uid = md5(uniqid(mt_rand(), true));
        
        date_default_timezone_set('UTC');        
        $insert_sql = "INSERT INTO mail_campaignes__callbacks (uid, campaign_id, type, action, wsdl) VALUES (:uid, :campaign_id, :type, :action, :wsdl)";
        $stmt = $db->prepare($insert_sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':campaign_id', $this->getCampaignId());
        $stmt->bindParam(':type', $this->getType());
        $stmt->bindParam(':action', $this->getAction());
        $stmt->bindParam(':wsdl', $this->getWsdl());
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        $this->setId($db->lastInsertId());
        $this->setUid($uid);
        
        $db = NULL;
        return true; 
    }
    
    /**
     * @return boolean
     */
    public function saveParam($name, $value)
    {        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if ( !array_key_exists($name, $this->getParams()) ) {        
            $insert_sql = "INSERT INTO mail_campaignes__callbacks_params (callback_id, name, value) VALUES (:callback_id, :name, :value);";
            $stmt = $db->prepare($insert_sql);
            $stmt->bindParam(':callback_id', $this->getId());
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':value', $value);
            try { $stmt->execute(); } 
            catch ( PDOException $e ) {
                $db = NULL;
                throw $e;
            } 
        } elseif ( $this->params[$name] != $value ) {
            $update_sql = "UPDATE mail_campaignes__callbacks_params SET value = :value WHERE callback_id = :callback_id AND name = :name";
            $stmt = $db->prepare($update_sql);
            $stmt->bindParam(':callback_id', $this->getId());
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':value', $value);
            try { $stmt->execute(); } 
            catch ( PDOException $e ) {
                $db = NULL;
                throw $e;
            } 
        }
                
        $db = NULL;
        return true;
    }
    
}