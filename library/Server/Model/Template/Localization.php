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
class Server_Model_Template_Localization
{
	private $id;
	private $templateId;
	private $locale;
	private $subject;
	private $bodyHtml;
	private $bodyPlain;
	private $pmbSubject;
	private $pmbMessage;
	private $isDefault;		
	private $images;
	
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param $id the $id to set
     * @return Server_Model_Template_Localization
     */
    public function setId( $id )
    {
        $this->id = $id;
        return $this;
    }
    

    /**
     * @return the $templateId
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }
    
    /**
     * @param $templateId the $templateId to set
     * @return Server_Model_Template_Localization
     */
    public function setTemplateId( $templateId )
    {
        $this->templateId = $templateId;
        return $this;
    }
	
	/**
     * @param $locale the $locale to set
     */
    public function setLocale( $locale )
    {
        $this->locale = $locale;
    }

	/**
     * @return the $locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

	/**
     * @return the $subject
     */
    public function getSubject()
    {
        if ( null == $this->subject ) $this->initSubject();
        return $this->subject;
    }

	/**
     * @param $subject the $subject to set
     * @return Server_Model_Template_Localization
     */
    public function setSubject( $subject )
    {
        $this->subject = $subject;
        return $this;
    }

    /** 
     * @return Server_Model_Template_Localization
     */
    public function initSubject()
    {
        $this->subject = "Message Subject";
        return $this;
    }

	/**
     * @return the $bodyHtml
     */
    public function getBodyHtml()
    {
        if ( null == $this->bodyHtml ) $this->initBodyHtml();
        return $this->bodyHtml;
    }

	/**
     * @param $bodyHtml the $bodyHtml to set
     * @return Server_Model_Template_Localization
     */
    public function setBodyHtml( $bodyHtml )
    {
        $this->bodyHtml = $bodyHtml;
        return $this;
    }

    /** 
     * @return Server_Model_Template_Localization
     */
    public function initBodyHtml()
    {
		$this->bodyHtml = '';
        return $this;
    }
    
	/**
     * @return the $bodyPlain
     */
    public function getBodyPlain()
    {
        if ( null == $this->bodyPlain ) $this->initBodyPlain();
        return $this->bodyPlain;
    }

	/**
     * @param $bodyPlain the $bodyPlain to set
     * @return Server_Model_Template_Localization
     */
    public function setBodyPlain( $bodyPlain )
    {
        $this->bodyPlain = $bodyPlain;
        return $this;
    }

    /** 
     * @return Server_Model_Template_Localization
     */
    public function initBodyPlain()
    {
		$this->bodyPlain = '';
        return $this;
    }
	
    /**
     * 
     * @return unknown_type
     */
    public function getPmbSubject()
    {
        return $this->pmbSubject;
    }
    
    /**
     * 
     * @param $subject
     * @return unknown_type
     */
    public function setPmbSubject( $subject )
    {
        $this->pmbSubject = $subject;
        return $this;
    }

    /**
     * 
     * @return unknown_type
     */
    public function getPmbMesage()
    {
        return $this->pmbMessage;
    }
    
    /**
     * 
     * @param $message
     * @return unknown_type
     */
    public function setPmbMesage( $message )
    {
        $this->pmbMessage = $message;
        return $this;
    }
        
    /**
     * @return the $isDefult
     */
    public function getIsDefault()
    {
        return $this->isDefult;
    }
    
    /**
     * @param $isDefult the $isDefult to set
     * @return Server_Model_Template_Localization
     */
    public function setIsDefault( $isDefult )
    {
        $this->isDefult = $isDefult;
        return $this;
    }
	
    /**
     * @return array $images
     */
    public function getImages()
    {
        if ( null === $this->images ) {
            try { $this->images = Server_Model_Template_Localization_Image::loadByLocalization($this->getId()); }
            catch ( Exception $e ) { throw $e; }
        }
        return $this->images;
    }

    /**
     * @param array $images
     * @return Server_Model_Template_Localization
     */
    public function setImages( $images )
    {
        $this->images = $images;
        return $this;
    }
    
    /**
     * 
     * @param Server_Model_Template_Localization_Image $image
     * @return Server_Model_Template_Localization
     */
    public function addImage(Server_Model_Template_Localization_Image $image )
    {
        $this->images[] = $image;
        return $this;
    }
    
    /** 
     * @param int $id
     * @return boolean
     * @return Server_Model_Template_Localization
     */
    public function load( $id )
    {
        if ( null === $id ) throw new Exception('Incorrect localization id');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_templates__localizations WHERE id = :id";
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
			$this->setTemplateId($result[0]['template_id']);
			$this->setLocale($result[0]['locale']);
            $this->setSubject($result[0]['subject']);
            $this->setBodyHtml($result[0]['body_html']);
            $this->setBodyPlain($result[0]['body_plain']);
            $this->setPmbSubject($result[0]['pmb_subject']);
            $this->setPmbMesage($result[0]['pmb_message']);
			$this->setIsDefault($result[0]['is_default']);
        }        
        
        $db = NULL;
        return $this;
    }
    
    /**
     * 
     * @param int $templateId
     * @param string $locale
     * @return Server_Model_Template_Localization
     */
    public function loadByTempateAndLocale( $templateId, $locale )
    {
        if ( null === $templateId ) throw new Exception('Incorrect template id');
        if ( null === $locale ) throw new Exception('Incorrect template locale');        

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_templates__localizations WHERE template_id = :template_id AND locale = :locale";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':template_id', $templateId);
        $stmt->bindParam(':locale', $locale);        
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ( $result ) {
            $this->setId($result[0]['id']);            
            $this->setTemplateId($result[0]['template_id']);
            $this->setLocale($result[0]['locale']);
            $this->setSubject($result[0]['subject']);
            $this->setBodyHtml($result[0]['body_html']);
            $this->setBodyPlain($result[0]['body_plain']);
            $this->setPmbSubject($result[0]['pmb_subject']);
            $this->setPmbMesage($result[0]['pmb_message']);            
            $this->setIsDefault($result[0]['is_default']);
        }        
        
        $db = NULL;
        return $this;
    }
    
    /**
     * 
     * @param int $templateId
     * @param string $locale
     * @return array
     */
    public function loadByTempateAndLocaleAsArray( $templateId, $locale )
    {
        if ( null === $templateId ) throw new Exception('Incorrect template id');
        if ( null === $locale ) throw new Exception('Incorrect template locale');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_templates__localizations WHERE template_id = :template_id AND locale = :locale";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':template_id', $templateId);
        $stmt->bindParam(':locale', $locale);        
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
     * @param string $templateUid
     * @param string $instanceKey
     * @param string $locale
     * @return Server_Model_Template_Localization
     */
    public function loadByTempateUidAndLocale( $templateUid, $instanceKey, $locale )
    {
        if ( null === $templateUid ) throw new Exception('Incorrect template uid');
        if ( null === $instanceKey ) throw new Exception('Incorrect instanceKey');
        if ( null === $locale ) throw new Exception('Incorrect template locale');        

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "
            SELECT tl.* 
            FROM mail_templates__localizations as tl
            INNER JOIN mail_templates as t ON t.id = tl.template_id             
            WHERE t.uid = :templateUid AND tl.locale = :locale AND t.instanceKey = :instanceKey";        
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':templateUid', $templateUid);     
        $stmt->bindParam(':instanceKey', $instanceKey);   
        $stmt->bindParam(':locale', $locale);        
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ( $result ) {
            $this->setId($result[0]['id']);            
            $this->setTemplateId($result[0]['template_id']);
            $this->setLocale($result[0]['locale']);
            $this->setSubject($result[0]['subject']);
            $this->setBodyHtml($result[0]['body_html']);
            $this->setBodyPlain($result[0]['body_plain']);
            $this->setPmbSubject($result[0]['pmb_subject']);
            $this->setPmbMesage($result[0]['pmb_message']);            
            $this->setIsDefault($result[0]['is_default']);
        }        
        
        $db = NULL;
        return $this;
    }
    
    /**
     * 
     * @param strin $templateUid
     * @param string $instanceKey
     * @param string $locale
     * @return array
     */
    public function loadByTempateUidAndLocaleAsArray( $templateUid, $instanceKey, $locale )
    {
        if ( null === $templateUid ) throw new Exception('Incorrect template uid');
        if ( null === $instanceKey ) throw new Exception('Incorrect instanceKey');
        if ( null === $locale ) throw new Exception('Incorrect template locale');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "
            SELECT tl.* 
            FROM mail_templates__localizations as tl
            INNER JOIN mail_templates as t ON t.id = tl.template_id             
            WHERE t.uid = :templateUid AND tl.locale = :locale AND t.instanceKey = :instanceKey";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':templateUid', $templateUid);
        $stmt->bindParam(':instanceKey', $instanceKey);
        $stmt->bindParam(':locale', $locale);        
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
     * @param int $templateId
     * @param string $locale
     * @return Server_Model_Template_Localization
     */
    static public function loadDefaultByTempate( $templateId )
    {
        if ( null === $templateId ) throw new Exception('Incorrect template id');        

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT id FROM mail_templates__localizations WHERE template_id = :template_id AND is_default = 1";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':template_id', $templateId);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = NULL;
        
        if ( !$result ) throw new Exception('Can not load default localization for template');

        $objLocalization = new Server_Model_Template_Localization();
        $objLocalization->setId($result[0]['id']);            
        $objLocalization->setTemplateId($result[0]['template_id']);
        $objLocalization->setLocale($result[0]['locale']);
        $objLocalization->setSubject($result[0]['subject']);
        $objLocalization->setBodyHtml($result[0]['body_html']);
        $objLocalization->setBodyPlain($result[0]['body_plain']);
        $objLocalization->setPmbSubject($result[0]['pmb_subject']);
        $objLocalization->setPmbMesage($result[0]['pmb_message']);        
        $objLocalization->setIsDefault($result[0]['is_default']);
        return $objLocalization;
    }
    
    /**
     * 
     * @param int $templateId
     * @return array<Server_Model_Template_Localization>
     */
    static public function loadListByTempate( $templateId )
    {
        if ( null === $templateId ) throw new Exception('Incorrect template id');        

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_templates__localizations WHERE template_id = :template_id";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':template_id', $templateId);        
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $results = $stmt->fetchAll();
        $return = array();
        
        if ( $results ) {
            foreach ( $results as $result ) {
                $objLocalization = new Server_Model_Template_Localization();
                $objLocalization->setId($result['id']);            
                $objLocalization->setTemplateId($result['template_id']);
                $objLocalization->setLocale($result['locale']);
                $objLocalization->setSubject($result['subject']);
                $objLocalization->setBodyHtml($result['body_html']);
                $objLocalization->setBodyPlain($result['body_plain']);
                $objLocalization->setPmbSubject($result['pmb_subject']);
                $objLocalization->setPmbMesage($result['pmb_message']);                
                $objLocalization->setIsDefault($result['is_default']);
                $return[] = $objLocalization;
            }
        }        
        
        $db = NULL;
        return $return;
    }
    
    static public function deleteAllByTempate( $templateId )
    {
        if ( null === $templateId ) throw new Exception('Incorrect template id');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $delete_sql = "DELETE FROM mail_templates__localizations WHERE template_id = :template_id";
        $stmt = $db->prepare($delete_sql);
        $stmt->bindParam(':template_id', $templateId);        
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        return true;
    }
    
    
    /**
     * Remove locale item by templateId and locale name.
     * @param string $templateId
     * @param string $locale
     * @throws Exception
     * @return boolean
     */
    static public function deleteByLocale( $templateId, $locale )
    {
        if ( null === $templateId ) throw new Exception('Incorrect template id');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $delete_sql = "DELETE FROM mail_templates__localizations WHERE template_id = :template_id AND locale = :locale";
        $stmt = $db->prepare($delete_sql);
        $stmt->bindParam(':template_id', $templateId);
        $stmt->bindParam(':locale', $locale);    
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        return true;
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function save()
    {        
        if ( null !== $this->getId() ) return $this->update();

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        date_default_timezone_set('UTC');        
        $created_date = date('Y-m-d H:i:s');
        
        $emptyStr = '';
		
        $insert_sql = "INSERT INTO mail_templates__localizations (template_id, locale, subject, body_html, body_plain, is_default) VALUES (:template_id, :locale, :subject, :body_html, :body_plain, :is_default)";
        $stmt = $db->prepare($insert_sql);
        $stmt->bindParam(':template_id', $this->getTemplateId());
        $stmt->bindParam(':locale', $this->getLocale());
		$stmt->bindParam(':subject', $this->getSubject() );
		$stmt->bindParam(':body_html', $this->getBodyHtml());
		$stmt->bindParam(':body_plain', $this->getBodyPlain());
		$stmt->bindParam(':is_default', $this->getIsDefault());
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        $this->setId($db->lastInsertId());
        
        $db = NULL;
        return true;        
    }
    
    /** 
     * @param string $subject
     * @param string $message
     * @return boolean
     */
    public function savePMBMessage( $subject, $message )
    {
        if ( null === $this->getId() ) throw new Exception('Cannot save campaign PMB message.');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $update_sql = "UPDATE mail_templates__localizations SET pmb_subject = :pmb_subject, pmb_message = :pmb_message WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':pmb_subject', trim($subject));
        $stmt->bindParam(':pmb_message', trim($message));
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
     * update localization
     * @return bolean
     */
    public function update()
    {
        if ( null === $this->getId() ) return $this->save();
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        date_default_timezone_set('UTC');        
        $created_date = date('Y-m-d H:i:s');
        
        $emptyStr = '';
        
        $update_sql = "UPDATE mail_templates__localizations SET template_id = :template_id, locale = :locale, subject = :subject, body_html = :body_html, body_plain = :body_plain, is_default = :is_default WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':template_id', $this->getTemplateId());
        $stmt->bindParam(':locale', $this->getLocale());
        $stmt->bindParam(':subject', $this->getSubject() );
        $stmt->bindParam(':body_html', $this->getBodyHtml());
        $stmt->bindParam(':body_plain', $this->getBodyPlain());
        $stmt->bindParam(':is_default', $this->getIsDefault());
        $stmt->bindParam(':id', $this->getId());
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        $this->setId($db->lastInsertId());
        
        $db = NULL;
        return true;        
    }
	
    /**
     * @return unknown_type
     */
    public function saveImages()
    {        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if ( sizeof($this->images) ) {
            $insert_sql = "INSERT INTO mail_templates__localizations_images (localization_id, image_name, image_source, image_content_type) VALUES ";
            foreach ( $this->images as $i ) $image[] = "(?, ?, ?, ?)";
            $insert_sql = $insert_sql . join(',', $image);

            $stmt = $db->prepare($insert_sql);
            
            $paramIndex = 1;
            $emptyStr = '';
            foreach ( $this->images as $i => $im ) {
                $stmt->bindParam($paramIndex, $this->getId());                
                $stmt->bindParam($paramIndex + 1, $im->getImageName());
                $stmt->bindParam($paramIndex + 2, $im->getImageSource());
                $stmt->bindParam($paramIndex + 3, $im->getImageContentType());
                $paramIndex = $paramIndex + 4;
            }
            
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
     * @param int $templateId
     * @return boolean
     */
    static public function exists( $templateId, $locale )
    {
        if ( null === $templateId ) throw new Exception('Incorrect template id');
		if ( null === $locale ) throw new Exception('Incorrect locale');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT count(id) as cnt FROM mail_templates__localizations WHERE template_id = :template_id AND locale = :locale";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':template_id', $templateId);
		$stmt->bindParam(':locale', $locale);
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
     * @param string $templateUid
     * @param string $instanceKey
     * @param string $locale
     * @return boolean
     */
    static public function existsByUid( $templateUid, $instanceKey, $locale )
    {
        if ( null === $templateUid ) throw new Exception('Incorrect template uid');
        if ( null === $instanceKey ) throw new Exception('Incorrect instanceKey');
        if ( null === $locale ) throw new Exception('Incorrect locale');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "
            SELECT count(tl.id) as cnt 
            FROM mail_templates__localizations as tl
            INNER JOIN mail_templates as t ON t.id = tl.template_id              
            WHERE t.uid = :templateUid AND tl.locale = :locale AND t.instanceKey = :instanceKey";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':templateUid', $templateUid);
        $stmt->bindParam(':locale', $locale);
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
}
