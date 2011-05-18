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
class Server_Model_Template
{
    protected $id;
    protected $uid; 
    protected $description;
    protected $createDate;
    private $_lastUsedDate;
    protected $status;
	private $_instanceKey;
    protected $defaultLocalization;
    

    /**
     * @return the $_lastUsedDate
     */
    public function getLastUsedDate()
    {
        return $this->_lastUsedDate;
    }

    
	/**
     * @param field_type $_lastUsedDate
     */
    public function setLastUsedDate($_lastUsedDate)
    {
        $this->_lastUsedDate = $_lastUsedDate;
    }

    
	/**
     * @return int $id
     */
	public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param int $id to set
     * @return Server_Model_Template
     */
    public function setId( $id )
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return the $uid
     */
    public function getUid()
    {
        return $this->uid;
    }
        
	/**
     * @param $uid the $uid to set
     * @return Server_Model_Template
     */
    public function setUid( $uid )
    {
        $this->uid = $uid;
    }
       
    
    
    /**
     * Setter for instanceKey
     * @param string $instanceKey
     * @author Alex Che
     */
    public function setInstanceKey($instanceKey)
    {
        $this->_instanceKey = $instanceKey;
    }
    

    /**
     * Getter for instanceKey
     * @return string
     * @author Alex Che
     */
    public function getInstanceKey()
    {
        return $this->_instanceKey;
    }
    
    
    /**
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * @param string $description to set
     * @return Server_Model_Template
     */
    public function setDescription( $description )
    {
        $this->description = $description;
        return $this;
    }
    
	/**
     * @param $status the $status to set
     */
    public function setStatus( $status )
    {
        $this->status = $status;
    }

	/**
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }
	
	/**
     * @param $createDate the $createDate to set
     */
    public function setCreateDate( $createDate )
    {
        $this->createDate = $createDate;
    }

	/**
     * @return the $createDate
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    
    /** 
     * @return Server_Model_Template_Localization
     */
    public function getDefaultLocalization()
    {
        if ( null === $this->defaultLocalization ) {
            try { $this->defaultLocalization = Server_Model_Template_Localization::loadDefaultByTempate($this->getId());
            } catch ( PDO_Exception $e ) { 
                throw $e;
            }
        }
        return $this->defaultLocalization;
    }
    
    /** 
     * @param int $id
     * @return Server_Model_Template
     */
    public function load( $id )
    {
        if ( null === $id ) throw new Exception('Incorrect template id');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_templates WHERE id = :id";
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
            $this->setCreateDate($result[0]['create_date']);
            $this->setStatus($result[0]['status']);
        }        
        
        $db = NULL;
        return $this;
    }
    
    /** 
     * @param string $uid
     * @param string $instanceKey
     * @return Server_Model_Template
     */
    public function loadByUid( $uid, $instanceKey )
    {
        if ( null === $uid ) throw new Exception('Incorrect template uid');
        if ( null === $instanceKey ) throw new Exception('Incorrect instanceKey');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_templates WHERE uid = :uid AND instanceKey = :instanceKey";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':instanceKey', $instanceKey);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ( $result ) {
            $this->setId($result[0]['id']);     
            $this->setUid($result[0]['uid']);
            $this->setCreateDate($result[0]['create_date']);
            $this->setStatus($result[0]['status']);
        }        
        
        $db = NULL;
        return $this;
    }
    
    
    /** 
     * @param string $uid
     * @return Server_Model_Template
     */
    public function loadByUidOnly( $uid )
    {
        if ( null === $uid ) throw new Exception('Incorrect template uid');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_templates WHERE uid = :uid";
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
            $this->setCreateDate($result[0]['create_date']);
            $this->setStatus($result[0]['status']);
        }        
        
        $db = NULL;
        return $this;
    }
    
    
    /** 
     * @param string $uid
     * @param string $instanceKey
     * @return array
     */
    public function loadByUidAsArray( $uid, $instanceKey )
    {
        if ( null === $uid ) throw new Exception('Incorrect template uid');
        if ( null === $instanceKey ) throw new Exception('Incorrect instanceKey');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_templates WHERE uid = :uid AND instanceKey = :instanceKey";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':instanceKey', $instanceKey);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = NULL;
        
        if ( $result ) { return $result[0]; }               
        
        return null;
    }
        
    /**
     * 
     * @return boolean
     */
    public function save()
    {        
        if ( null !== $this->getId() ) throw new Exception('Couldn\'t save template.');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        date_default_timezone_set('UTC');        
        $created_date = date('Y-m-d H:i:s');
        
        $emptyStr = '';
        $status = 'pending';
        
        
        $uid = $this->getUid() ? $this->getUid() : md5(uniqid(mt_rand(), true));
        
        $insert_sql = "INSERT INTO mail_templates (uid, instanceKey, create_date, status) VALUES (:uid, :instanceKey, :create_date, :status)";
        $stmt = $db->prepare($insert_sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':instanceKey', $this->getInstanceKey());
        $stmt->bindParam(':create_date', $created_date);
        $stmt->bindParam(':status', $status);
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
     * 
     * @return boolean
     */
    public function saveDescription()
    {        
        if ( null === $this->getId() ) throw new Exception('Couldn\'t save template.');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $update_sql = "UPDATE mail_templates SET description = :description WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':id', $this->getId());
        $stmt->bindParam(':description', $this->getDescription());
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $db = NULL;
        return true;        
    }
    
    
    /**
     * Save Instance key for template
     * 
     * @return boolean
     */
    public function saveInstanceKey()
    {        
        if ( null === $this->getId() ) throw new Exception('Couldn\'t save template.');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $update_sql = "UPDATE mail_templates SET instanceKey = :instanceKey, uid = :uid WHERE id = :id AND (instanceKey = '' OR instanceKey IS NULL)";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':id', $this->getId());
        $stmt->bindParam(':uid', $this->getUid() );
        $stmt->bindParam(':instanceKey', $this->getInstanceKey() );
        
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $db = NULL;
        return true;        
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function saveLastUsed()
    {        
        if ( null === $this->getId() ) throw new Exception('Couldn\'t save template.');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        date_default_timezone_set('UTC');        
        $last_used = date('Y-m-d H:i:s');
		
        $update_sql = "UPDATE mail_templates SET last_used = :last_used WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':id', $this->getId());
        $stmt->bindParam(':last_used', $last_used);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $db = NULL;
        return true;        
    }
	
    /**
     * @return bool
     */
    public function activate()
    {
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if ( $this->getStatus() != 'pending' ) return false;
        
        $update_sql = "UPDATE mail_templates SET status = 'active' WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':id', $this->getId());
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        } 
                
        $db = NULL;
        return true;
    }
    
    /**
     * @return unknown_type
     */
    public function deactivate()
    {
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if ( $this->getStatus() != 'active' ) return false;
        
        $update_sql = "UPDATE mail_templates SET status = 'pending' WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':id', $this->getId());
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        } 
                
        $db = NULL;
        return true;
    }
    
    /**
     * 
     * @return boolean
     */
    public function delete()
    {        
        if ( null === $this->getId() ) throw new Exception('Couldn\'t delete template.');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        date_default_timezone_set('UTC');        
        $created_date = date('Y-m-d H:i:s');
        
        $delete_sql = "DELETE FROM mail_templates WHERE id = :id";
        $stmt = $db->prepare($delete_sql);
        $stmt->bindParam(':id', $this->getId());
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $db = NULL;
        return true;        
    }
    
    /**
     * 
     * @return boolean
     */
    public function deleteByUid()
    {        
        if ( null === $this->getUid() ) throw new Exception('Couldn\'t delete template.');
        if ( null === $this->getInstanceKey() ) throw new Exception('Couldn\'t delete template.');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        date_default_timezone_set('UTC');        
        $created_date = date('Y-m-d H:i:s');
        
        $delete_sql = "DELETE FROM mail_templates WHERE uid = :uid AND instanceKey = :instanceKey";
        $stmt = $db->prepare($delete_sql);
        $stmt->bindParam(':uid', $this->getUid());
        $stmt->bindParam(':instanceKey', $this->getInstanceKey() );
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $db = NULL;
        return true;        
    }
    
    /** 
     * @param int $id
     * @return boolean
     */
    static public function exists( $id )
    {
        if ( null === $id ) throw new Exception('Incorrect template id');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT count(id) as cnt FROM mail_templates WHERE id = :id";
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
     * @param string $instanceKey
     * @return boolean
     */
    static public function existsByUid( $uid, $instanceKey )
    {
        if ( null === $uid ) throw new Exception('Incorrect template uid');
        if ( null === $instanceKey ) throw new Exception('Incorrect template instanceKey');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT count(id) as cnt FROM mail_templates WHERE uid = :uid AND instanceKey = :instanceKey";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':instanceKey', $instanceKey);
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
     * generate UID by tempalte name and instance key
     * used for Zanby-like implementations
     * @param striung $tplName
     * @param striung $instanceKey
     * @return striung
     */
    static public function generateTemplateUID($tplName, $instanceKey)
    {
        $uid = md5($tplName."::".$instanceKey);
        return $uid;        
    }
    
    
    /**
     * 
     * @param strin $templateUid
     * @param string $locale
     * @return array
     */
    static public function getTemapltesListByInstance( $instanceKey)
    {
        if ( null === $instanceKey ) throw new Exception('Incorrect instance key');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "
            SELECT id, uid, instanceKey, description, create_date, last_used, status  
            FROM mail_templates
            WHERE instanceKey = :instanceKey";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':instanceKey', $instanceKey);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = NULL;

        $return = array();
        if ( is_array($result) ) { 
            foreach ($result as $res) {
                $objTemplate = new Server_Model_Template();
                $objTemplate->setId($res['id']);
                $objTemplate->setUid($res['uid']);
                $objTemplate->setInstanceKey($res['instanceKey']);
                $objTemplate->setDescription($res['description']);
                $objTemplate->setCreateDate($res['create_date']);
                $objTemplate->setLastUsedDate($res['last_used']);
                $objTemplate->setStatus($res['status']);
                $return[] = $objTemplate;
            }
        }               

        return $return;
    }
}