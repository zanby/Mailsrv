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
class Server_Model_Campaign
{
    protected $id;
    protected $uid;
    protected $templateId; 
    protected $sender;
    protected $subject;
    protected $bodyHtml;
    protected $bodyPlain;
    protected $pmbSubject;
    protected $pmbMessage;    
    protected $deliveryDate;
    protected $createDate;
    protected $status;
    protected $startDate;
    protected $inProgressDate;
    protected $processedDate;
    
    protected $recipients;
    protected $images;
    protected $attachments;
    protected $headers;
    protected $params;
    
    static protected $loadCached;
   
    /**
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     * @return Server_Model_Campaign
     */
    public function setId( $id )
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return string $uid
     */
    public function getUid()
    {
        return $this->uid;
    }
        
	/**
     * @param string $uid
     * @return Server_Model_Campaign
     */
    public function setUid( $uid )
    {
        $this->uid = $uid;
    }
    
    /**
     * @return int $templateId
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }
    
    /**
     * @param int $templateId
     * @return Server_Model_Campaign
     */
    public function setTemplateId( $templateId )
    {
        $this->templateId = $templateId;
        return $this;
    }
    
	/**
     * @return Server_Model_Campaign_Sender $sender 
     */
    public function getSender()
    {
        if ( null === $this->sender ) {
            try { $this->sender = Server_Model_Campaign_Sender::loadByCampaign($this->getId()); }
            catch ( Exception $e ) { throw $e; }
        }
        return $this->sender;
    }

	/**
     * @param $sender the $sender to set
     * @return Server_Model_Campaign
     */
    public function setSender( Server_Model_Campaign_Sender $sender )
    {
        $this->sender = $sender;
        return $this;
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
     * @return Server_Model_Campaign
     */
    public function setSubject( $subject )
    {
        $this->subject = $subject;
        return $this;
    }
    
    /** 
     * @return Server_Model_Campaign
     */
    public function initSubject()
    {
        $this->subject = '';
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
     * @return Server_Model_Campaign
     */
    public function setBodyHtml( $bodyHtml )
    {
        $this->bodyHtml = $bodyHtml;
        return $this;
    }

    /** 
     * @return Server_Model_Campaign
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
     * @return Server_Model_Campaign
     */
    public function setBodyPlain( $bodyPlain )
    {
        $this->bodyPlain = $bodyPlain;
        return $this;
    }

    /** 
     * @return Server_Model_Campaign
     */
    public function initBodyPlain()
    {
		$this->bodyPlain = '';
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getPmbSubject()
    {
        return $this->pmbSubject;
    }
    
    /**
     * 
     * @param string $subject
     * @return Server_Model_Campaign
     */
    public function setPmbSubject( $subject )
    {
        $this->pmbSubject = $subject;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getPmbMesage()
    {
        return $this->pmbMessage;
    }
    
    /**
     * 
     * @param string $message
     * @return Server_Model_Campaign
     */
    public function setPmbMesage( $message )
    {
        $this->pmbMessage = $message;
        return $this;
    }
    
	/**
     * @return the $recipients
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

	/**
     * @param $recipients the $recipients to set
     * @return Server_Model_Campaign
     */
    public function setRecipients( $recipients )
    {
        $this->recipients = $recipients;
        return $this;
    }

    /** 
     * @param Server_Model_Campaign_Recipient $recipient
     * @return Server_Model_Campaign
     */
    public function addRecipient( Server_Model_Campaign_Recipient $recipient )
    {
        $this->recipients[] = $recipient;
        return $this;
    }
    
	/**
     * @return the $images
     */
    public function getImages()
    {
        if ( null === $this->images ) {
            try { $this->images = Server_Model_Campaign_Image::loadByCampaign($this->getId()); }
            catch ( Exception $e ) { throw $e; }
        }
        return $this->images;
    }

	/**
     * @param $images the $images to set
     * @return Server_Model_Campaign
     */
    public function setImages( $images )
    {
        $this->images = $images;
        return $this;
    }
    
    /**
     * 
     * @param $image
     * @return Server_Model_Campaign
     */
    public function addImage(Server_Model_Campaign_Image $image )
    {
        $this->images[] = $image;
        return $this;
    }

	/**
     * @return the $attachments
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

	/**
     * @param $attachments the $attachments to set
     * @return Server_Model_Campaign
     */
    public function setAttachments( $attachments )
    {
        $this->attachments = $attachments;
        return $this;
    }
    
    /** 
     * @param $attachment
     * @return Server_Model_Campaign
     */
    public function addAttachment( $attachment )
    {
        $this->attachment[] = $attachment;
        return $this;
    }

	/**
     * @return the $headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }

	/**
     * @param $headers the $headers to set
     * @return Server_Model_Campaign
     */
    public function setHeaders( $headers )
    {
        $this->headers = $headers;
        return $this;
    }

    /** 
     * @param $header
     * @return unknown_type
     */
    public function addHeader( $header )
    {
        $this->headers[] = $header;
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
     * @param $params the $params to set
     */
    public function setParams( $params )
    {
        $this->params = $params;
    }

	/**
     * @return the $params
     */
    public function getParams()
    {
        return $this->params;
    }

    /** 
     * @param $name
     * @param $value
     * @return unknown_type
     */
    public function addParam(Server_Model_Campaign_Param $param)
    {
        $this->params[] = $param;
        return $this;
    }
	
	/**
     * @param $processedDate the $processedDate to set
     */
    public function setProcessedDate( $processedDate )
    {
        $this->processedDate = $processedDate;
    }

	/**
     * @return the $processedDate
     */
    public function getProcessedDate()
    {
        return $this->processedDate;
    }

	/**
     * @param $inProgressDate the $inProgressDate to set
     */
    public function setInProgressDate( $inProgressDate )
    {
        $this->inProgressDate = $inProgressDate;
    }

	/**
     * @return the $inProgressDate
     */
    public function getInProgressDate()
    {
        return $this->inProgressDate;
    }

	/**
     * @param $startDate the $startDate to set
     */
    public function setStartDate( $startDate )
    {
        $this->startDate = $startDate;
    }

	/**
     * @return the $startDate
     */
    public function getStartDate()
    {
        return $this->startDate;
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
     * @param $deliveryDate the $deliveryDate to set
     */
    public function setDeliveryDate( $deliveryDate )
    {
        $this->deliveryDate = $deliveryDate;
    }

	/**
     * @return the $deliveryDate
     */
    public function getDeliveryDate()
    {
        return $this->deliveryDate;
    }
    
    /** 
     * @param int $id
     * @return boolean
     */
    public function load( $id )
    {
        if ( null === $id ) throw new Exception('Incorrect campaign id');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_campaignes WHERE id = :id";
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
            $this->setTemplateId($result[0]['template_id']);         
            $this->setSubject($result[0]['subject']);
            $this->setBodyHtml($result[0]['body_html']);
            $this->setBodyPlain($result[0]['body_plain']);
            $this->setPmbSubject($result[0]['pmb_subject']);
            $this->setPmbMesage($result[0]['pmb_message']);            
            $this->setDeliveryDate($result[0]['delivery_date']);
            $this->setCreateDate($result[0]['create_date']);
            $this->setStatus($result[0]['status']);
            $this->setStartDate($result[0]['start_date']);
            $this->setInProgressDate($result[0]['in_progress_date']);
            $this->setProcessedDate($result[0]['processed_date']);
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
        if ( null === $uid ) throw new Exception('Incorrect campaign uid');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_campaignes WHERE uid = :uid";
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
            $this->setTemplateId($result[0]['template_id']);         
            $this->setSubject($result[0]['subject']);
            $this->setBodyHtml($result[0]['body_html']);
            $this->setBodyPlain($result[0]['body_plain']);
            $this->setPmbSubject($result[0]['pmb_subject']);
            $this->setPmbMesage($result[0]['pmb_message']);            
            $this->setDeliveryDate($result[0]['delivery_date']);
            $this->setCreateDate($result[0]['create_date']);
            $this->setStatus($result[0]['status']);
            $this->setStartDate($result[0]['start_date']);
            $this->setInProgressDate($result[0]['in_progress_date']);
            $this->setProcessedDate($result[0]['processed_date']);
        }        
        
        $db = NULL;
        return $this;
    }
    
    /**
     * 
     * @return boolean
     */
    public function save()
    {        
        if ( null !== $this->getId() ) throw new Exception('Cannot save campaign.');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        date_default_timezone_set('UTC');        
        $delivery_date = date('Y-m-d H:i:s');
        $created_date = date('Y-m-d H:i:s');
        $uid = md5(uniqid(mt_rand(), true));
        
        $emptyStr = '';
        $statusNew = 'new';
        $insert_sql = "INSERT INTO mail_campaignes (uid, delivery_date, create_date, status) VALUES (:uid, :delivery_date, :create_date, :status)";
        $stmt = $db->prepare($insert_sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':delivery_date', $delivery_date);
        $stmt->bindParam(':create_date', $created_date);
        $stmt->bindParam(':status', $statusNew);
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
     * @return unknown_type
     */
    public function saveStatus( $status )
    {
        if ( null === $this->getId() ) throw new Exception('Cannot save campaign status.');
        
		$status = strtolower($status);
		if ( !in_array($status, array('new','wait','started','in_progress','processed','sended')) ) return false;
		
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        date_default_timezone_set('UTC');
        $started_date = date('Y-m-d H:i:s');
        
        $update_sql = "UPDATE mail_campaignes SET status = :status WHERE id = :id";
        $stmt = $db->prepare($update_sql);
		$stmt->bindParam(':status', $status);
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
     * @return boolean
     */
    public function saveRecipients()
    {        
        if ( null === $this->getId() ) throw new Exception('Cannot save campaign recipients.');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        date_default_timezone_set('UTC');        
        $created_date = date('Y-m-d H:i:s');
        
        if ( sizeof($this->recipients) ) {
            $insert_sql = "INSERT INTO mail_campaignes__recipients (campaign_id, email, name, params, create_date) VALUES ";
            foreach ( $this->recipients as $r ) $recipient[] = "(?, ?, ?, ?, ?)";
            $insert_sql = $insert_sql . join(',', $recipient);

            $stmt = $db->prepare($insert_sql);
            
            $paramIndex = 1;
            $emptyStr = '';
            foreach ( $this->recipients as $i => $r ) {
                $stmt->bindParam($paramIndex, $this->getId());                
                $stmt->bindParam($paramIndex + 1, $r->getEmail());
                $stmt->bindParam($paramIndex + 2, $r->getName());
                $stmt->bindParam($paramIndex + 3, serialize($r->getParams()));
                $stmt->bindParam($paramIndex + 4, $created_date);
                $paramIndex = $paramIndex + 5;
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
     * @return boolean
     */
    public function saveParams()
    {        
        if ( null === $this->getId() ) throw new Exception('Cannot save campaign params.');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if ( sizeof($this->params) ) {
            $insert_sql = "INSERT INTO mail_campaignes__params (campaign_id, name, value) VALUES ";
            foreach ( $this->params as $p ) $param[] = "(?, ?, ?)";
            $insert_sql = $insert_sql . join(',', $param);

            $stmt = $db->prepare($insert_sql);
            
            $paramIndex = 1;
            $emptyStr = '';
            foreach ( $this->params as $i => $p ) {
                $stmt->bindParam($paramIndex, $this->getId());                
                $stmt->bindParam($paramIndex + 1, $p->getName());
                $stmt->bindParam($paramIndex + 2, $p->getValue());
                $paramIndex = $paramIndex + 3;
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
     * @return boolean
     */
    public function saveImages()
    {        
        if ( null === $this->getId() ) throw new Exception('Cannot save campaign images.');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if ( sizeof($this->images) ) {
            $insert_sql = "INSERT INTO mail_campaignes__images (campaign_id, image_name, image_source, image_content_type) VALUES ";
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
     * @param string $value
     * @return boolean
     */
    public function saveSubject( $value )
    {
        if ( null === $this->getId() ) throw new Exception('Cannot save campaign subject.');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $update_sql = "UPDATE mail_campaignes SET subject = :subject WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':subject', trim($value));
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
     * @param string $value
     * @return boolean
     */
    public function saveBodyHtml( $value )
    {
        if ( null === $this->getId() ) throw new Exception('Cannot save campaign body.');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $update_sql = "UPDATE mail_campaignes SET body_html = :body_html WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':body_html', trim($value));
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
     * @param string $value
     * @return boolean
     */
    public function saveBodyPlain( $value )
    {
        if ( null === $this->getId() ) throw new Exception('Cannot save campaign body.');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $update_sql = "UPDATE mail_campaignes SET body_plain = :body_plain WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':body_plain', trim($value));
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
     * @param int $templateId
     * @return boolean
     */
    public function saveTempalteId( $templateId )
    {
        if ( null === $this->getId() ) throw new Exception('Cannot save campaign template.');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $update_sql = "UPDATE mail_campaignes SET template_id = :template_id WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':template_id', $templateId);
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
     * @param string $date
     * @return boolean
     */
    public function saveDeliveryDate( $date )
    {
        if ( null === $this->getId() ) throw new Exception('Cannot save campaign delivery date.');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $update_sql = "UPDATE mail_campaignes SET delivery_date = :delivery_date WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':delivery_date', $date);
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
     * @return boolean
     */
    public function saveHeaders()
    {        
        if ( null === $this->getId() ) throw new Exception('Cannot save campaign params.');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if ( sizeof($this->headers) ) {
            $insert_sql = "INSERT INTO mail_campaignes__headers (campaign_id, name, value) VALUES ";
            foreach ( $this->headers as $h ) $header[] = "(?, ?, ?)";
            $insert_sql = $insert_sql . join(',', $header);

            $stmt = $db->prepare($insert_sql);
            
            $paramIndex = 1;
            $emptyStr = '';
            foreach ( $this->headers as $i => $h ) {
                $stmt->bindParam($paramIndex, $this->getId());                
                $stmt->bindParam($paramIndex + 1, $h->getName());
                $stmt->bindParam($paramIndex + 2, $h->getValue());
                $paramIndex = $paramIndex + 3;
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
        $update_sql = "UPDATE mail_campaignes SET pmb_subject = :pmb_subject, pmb_message = :pmb_message WHERE id = :id";
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
     * @param string $subject
     * @return boolean
     */
    public function savePMBSubject( $subject )
    {
        if ( null === $this->getId() ) throw new Exception('Cannot save campaign PMB message.');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); }
        catch ( PDO_Exception $e ) {
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $update_sql = "UPDATE mail_campaignes SET pmb_subject = :pmb_subject WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':pmb_subject', trim($subject));
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
     * @param string $body
     * @return boolean
     */
    public function savePMBBody( $body )
    {
        if ( null === $this->getId() ) throw new Exception('Cannot save campaign PMB message.');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); }
        catch ( PDO_Exception $e ) {
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $update_sql = "UPDATE mail_campaignes SET pmb_message = :pmb_message WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':pmb_message', trim($body));
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
     * @param string $subject
     * @param string $html
     * @param string $plain
     * @param string $raw
     * @return boolean
     */
    public function saveRaw($subject, $html, $plain, $raw, $pmb_subject = null, $pmb_message = null, $locale = null, $isDefaultLocale = null)
    {
        if ( null === $this->getId() ) throw new Exception('Cannot save campaign raw.');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
                
        date_default_timezone_set('UTC');
        $processed_date = date('Y-m-d H:i:s');
        $statusProcessed = 'processed';
        $statusStarted = 'started';
        
        $delete_sql = "DELETE FROM mail_campaignes__raw WHERE campaign_id = :campaign_id AND locale = :locale";
        $stmt = $db->prepare($delete_sql);
        $stmt->bindParam(':campaign_id', $this->getId());
        $stmt->bindParam(':locale', $locale);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        } 
        
        $insert_sql = "INSERT INTO mail_campaignes__raw 
            (campaign_id, locale, is_default_locale, subject, body_html, body_plain, pmb_subject, pmb_message, message) VALUES 
            (:campaign_id, :locale, :is_default_locale, :subject, :body_html, :body_plain, :pmb_subject, :pmb_message, :message)";
        $stmt = $db->prepare($insert_sql);
        $stmt->bindParam(':campaign_id', $this->getId());
        $stmt->bindParam(':locale', $locale);
        $stmt->bindParam(':is_default_locale', $isDefaultLocale);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':body_html', $html);
        $stmt->bindParam(':body_plain', $plain);
        $stmt->bindParam(':pmb_subject', $pmb_subject);
        $stmt->bindParam(':pmb_message', $pmb_message);
        $stmt->bindParam(':message', $raw);        
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        } 
                
        $db = NULL;
        return true;
    }
    
    /** 
     * @return boolean
     */
    public function saveAsProcessed()
    {
        if ( null === $this->getId() ) throw new Exception('Cannot save as processed.');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
                
        date_default_timezone_set('UTC');
        $processed_date = date('Y-m-d H:i:s');
        $statusProcessed = 'processed';

        $update_sql = "UPDATE mail_campaignes SET status = :status, processed_date = :processed_date WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':status', $statusProcessed);
        $stmt->bindParam(':processed_date', $processed_date);
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
     * @return boolean
     */
    public function saveAsCanceled()
    {
        if ( null === $this->getId() ) throw new Exception('Cannot save as canceled.');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
                
        date_default_timezone_set('UTC');
        $processed_date = date('Y-m-d H:i:s');
        $statusProcessed = 'canceled';

        $update_sql = "UPDATE mail_campaignes SET status = :status, processed_date = :processed_date WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':status', $statusProcessed);
        $stmt->bindParam(':processed_date', $processed_date);
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
     * remove campaign if it isn't processed already
     * to remove processed campaign use delete method
     * @return boolean
     */
    public function remove()
    {
        if ( null === $this->getId() ) throw new Exception('Cannot remove campaign.');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $delete_sql = "DELETE FROM mail_campaignes WHERE id = :id AND status IN ('new', 'wait', 'started')";
        $stmt = $db->prepare($delete_sql);
        $stmt->bindParam(':id', $this->getId());
        try { $stmt->execute(); } 
        catch ( PDOException $e ) { $db = NULL; throw $e; }
        
        return true;
    }
    
    /**
     * 
     * @return array
     */
    
    public function loadRaw( $locale = null )
    {
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if ( $locale === null ) {
            /* try to load default locale */
            $select_sql = "SELECT * FROM mail_campaignes__raw WHERE campaign_id = :campaign_id AND is_default_locale = '1'";
            $stmt = $db->prepare($select_sql);
            $stmt->bindParam(':campaign_id', $this->getId());
            try { $stmt->execute(); } 
            catch ( PDOException $e ) { $db = NULL; throw $e; }
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);                   
        } else {
            /* try to load raw message by locale */
            $select_sql = "SELECT * FROM mail_campaignes__raw WHERE campaign_id = :campaign_id AND locale = :locale";
            $stmt = $db->prepare($select_sql);
            $stmt->bindParam(':campaign_id', $this->getId());
            $stmt->bindParam(':locale', $locale);
            try { $stmt->execute(); } 
            catch ( PDOException $e ) { $db = NULL; throw $e; }                   
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            /* try to load default locale */
            if ( !$result ) {
                $select_sql = "SELECT * FROM mail_campaignes__raw WHERE campaign_id = :campaign_id AND is_default_locale = '1'";
                $stmt = $db->prepare($select_sql);
                $stmt->bindParam(':campaign_id', $this->getId());
                try { $stmt->execute(); } 
                catch ( PDOException $e ) { $db = NULL; throw $e; }
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        if ( !$result ) throw new Exception('Can not load raw content for campaign');
        
        return $result[0];        
    }
    
    /**
     * @return unknown_type
     */
    public function start()
    {
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if ( $this->getStatus() != 'new' ) return false;
        
        date_default_timezone_set('UTC');
        $started_date = date('Y-m-d H:i:s');
        
        $update_sql = "UPDATE mail_campaignes SET status = 'started', start_date = :start_date WHERE id = :id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindParam(':start_date', $started_date);
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
     * @return boolean
     */
    public function build()
    {
        if ( !$this->getId() ) throw new Exception('Incorrect campaign id');

        date_default_timezone_set('UTC');
        $lstCallbacks = Server_Model_Campaign_Callback::loadByCampaign( $this->getId(), 'before' );
        if ( sizeof($lstCallbacks) != 0 ) {
            foreach ( $lstCallbacks as $objCallback ) {
                $result = false;
                try {
                    //TODO: need coorect timout
                    $client = new SoapClient( $objCallback->getWsdl(), array('timeout' => 600) );
                    $action = $objCallback->getAction();
                    $result = $client->$action($this->getUid(), $objCallback->getParams());
                } catch ( Exception $e ) {                    
                    Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] '.$e->getMessage().' CAMPAIGN:'.$this->getId().' CALLBACK:'.$objCallback->getWsdl().':'.$objCallback->getAction(), 'error_callback.log');
                }
                Server_Model_Log::log('['.date('j/M/Y:H:i:s O').'] STATUS:'. ($result?'OK':'CANCELED') .' CALLBACK:BEFORE CAMPAIGN:'.$this->getId().' CALLBACK:'.$objCallback->getWsdl().':'.$objCallback->getAction(), 'callback.log');
                
                /**
                 * if result from callback function is FALSE, doesn't need to process this campaign
                 * if we have any exception in calback function - we cannot process campaign
                 * - mark campaign as 'canceled' and write status to log file
                 */
                if ( !$result ) {
                    try { $this->saveAsCanceled(); }
                    catch ( Exception $e ) { throw $e; }
                    return false;
                }
            }
        }
        
        try {
            if ( $this->getTemplateId() ) { $return = $this->_buildTemplates(); } 
            else { $return = $this->_build(); }
        } catch ( Exception $e ) { throw $e; } 
        
        try { $return = $this->saveAsProcessed(); }
        catch ( Exception $e ) { throw $e; }
        
        return $return;
    }
    
    /** 
     * @return boolean
     */
    protected function _build()
    {        
        $sender = $this->getSender();
        if ( null !== $sender ) {
            $sender = ( $sender->getName() ) ? $sender->getName().' <'.$sender->getEmail().'>' : $sender->getEmail();
        } else $sender = 'postmaster@localhost';

        $subject = $this->getSubject();
        $html = $this->getBodyHtml();
        $plain = $this->getBodyPlain();        
        $pmb_subject = $this->getPmbSubject();
        $pmb_message = $this->getPmbMesage();
        
		$use_html = !empty($html) ? true : false;
		$use_plain = !empty($plain) ? true : false;
		$use_pmb = !empty($pmb_subject) && !empty($pmb_message) ? true : false;
		
        $params = Server_Model_Campaign_Param::loadByCampaignForSearch( $this->getId() );
        $subject = str_replace($params['search'], $params['replace'], $subject);
        $use_html && $html = str_replace($params['search'], $params['replace'], $html);
        $use_plain && $plain = str_replace($params['search'], $params['replace'], $plain);        
        $use_pmb && $pmb_subject = str_replace($params['search'], $params['replace'], $pmb_subject);
        $use_pmb && $pmb_message = str_replace($params['search'], $params['replace'], $pmb_message);
                
        require_once(ENGINE_DIR.'/htmlMimeMail5/htmlMimeMail5.php');
        $mail = new htmlMimeMail5();
        $mail->setTextCharset("UTF-8");
        $mail->setHTMLCharset("UTF-8");
        $mail->setHeadCharset("UTF-8");
        $mail->setFrom($sender);
        
        $mail->setSubject('{#*--SUBJECT--*#}');
        $mail->setHeader('Date', '{#*--MAIL_DATE--*#}');	

        /* add custom headers */
        $overrided_to = null;
        $headers = Server_Model_Campaign_Header::loadByCampaign( $this->getId() );
        if ( sizeof($headers) != 0 ) {
            foreach ( $headers as $header ) {
                if ( strtolower($header->getName()) != 'to' ) $mail->setHeader($header->getName(), $header->getValue());
                else $overrided_to = $header->getValue();
            }
        }        

		/* if part doesn't contain content, don't send this part */		
		$use_plain && $mail->setText('{#*--TEXT--*#}');
		$use_html && $mail->setHTML('{#*--HTML--*#}'); 		
        
        if ( $use_html && sizeof($this->getImages()) ) {
            foreach ( $this->getImages() as $objImage ) {
                $source = base64_decode($objImage->getImageSource());
                $mail->addEmbeddedImage(new stringEmbeddedImage($source, $objImage->getImageName(), $objImage->getImageContentType(), null, $objImage->getCid()));
                
                $quoted = preg_quote($objImage->getImageName());
                $cid    = preg_quote($objImage->getCid());
                $html = preg_replace("#src=\"$quoted\"|src='$quoted'#", "src=\"cid:$cid\"", $html);
                $html = preg_replace("#background=\"$quoted\"|background='$quoted'#", "background=\"cid:$cid\"", $html);
                $html = preg_replace("#background:url\('$quoted'\)#", "background:url('cid:$cid')", $html);
                
            }
        }

        /**
         * to override to address in mail body (not recipient address)
         * set up header TO to needed email address
         * @author Artem Sukharev
         */
        if ( $overrided_to ) $raw = $mail->getRFC822(array($overrided_to), 'smtp', true);
        else $raw = $mail->getRFC822(array('{#*--TO--*#}'), 'smtp', true);
        
        try { $this->saveRaw($subject, $html, $plain, $raw, $pmb_subject, $pmb_message, null, 1); }
        catch ( Exception $e ) { throw $e; }
        
        return true;
    }
    
    /**
     * 
     * @return unknown_type
     */
    protected function _buildTemplates()
    {
        require_once ENGINE_DIR.'/Server/Model/Template.php';
        require_once ENGINE_DIR.'/Server/Model/Template/Localization.php';
        require_once ENGINE_DIR.'/Server/Model/Template/Localization/Image.php';
        
        $sender = $this->getSender();
        if ( null !== $sender ) {
            $sender = ( $sender->getName() ) ? $sender->getName().' <'.$sender->getEmail().'>' : $sender->getEmail();
        } else $sender = 'postmaster@localhost';

        $objTemplate = new Server_Model_Template();
        try { $objTemplate->load( $this->getTemplateId() ); }
        catch ( Exception $e ) { throw $e; }        
        if ( !$objTemplate ) throw new Exception('Incorrect template id');
        
        try { $lstLocalizations = Server_Model_Template_Localization::loadListByTempate( $objTemplate->getId() ); }
        catch ( Exception $e ) { throw $e; }
        
        if ( sizeof($lstLocalizations) == 0 ) throw new Exception('There isn\'t localization for template');
        
        foreach ( $lstLocalizations as $objLocalizations ) {
            /**
             * overload subject from campaign if it exists
             * it needs if subject can be custom
             */
            $subject = $this->getSubject() ? $this->getSubject() : $objLocalizations->getSubject();
            $html = $objLocalizations->getBodyHtml();
            $plain = $objLocalizations->getBodyPlain();
            /**
             * @TODO: overload pmb subject & message from campaign if it exists
             * it needs if pmb subject & message can be custom
             */
            $pmb_subject = $this->getPmbSubject() ? $this->getPmbSubject() : $objLocalizations->getPmbSubject();
            $pmb_message = $this->getPmbMesage() ? $this->getPmbMesage() : $objLocalizations->getPmbMesage();
            			
            $use_html = !empty($html) ? true : false;
			$use_plain = !empty($plain) ? true : false;
			$use_pmb = !empty($pmb_subject) && !empty($pmb_message) ? true : false;
			
            $params = Server_Model_Campaign_Param::loadByCampaignForSearch( $this->getId() );
            $subject = str_replace($params['search'], $params['replace'], $subject);
            $use_html && $html = str_replace($params['search'], $params['replace'], $html);
            $use_plain && $plain = str_replace($params['search'], $params['replace'], $plain);	
            $use_pmb && $pmb_subject = str_replace($params['search'], $params['replace'], $pmb_subject);
            $use_pmb && $pmb_message = str_replace($params['search'], $params['replace'], $pmb_message);            
                    
            require_once(ENGINE_DIR.'/htmlMimeMail5/htmlMimeMail5.php');
            $mail = new htmlMimeMail5();
            $mail->setTextCharset("UTF-8");
            $mail->setHTMLCharset("UTF-8");
            $mail->setHeadCharset("UTF-8");
            $mail->setFrom($sender);
            
            $mail->setSubject('{#*--SUBJECT--*#}');
			$mail->setHeader('Date', '{#*--MAIL_DATE--*#}');
			
            /* add custom headers */
            $overrided_to = null;
            $headers = Server_Model_Campaign_Header::loadByCampaign( $this->getId() );
            if ( sizeof($headers) != 0 ) {
                foreach ( $headers as $header ) {
                    if ( strtolower($header->getName()) != 'to' ) $mail->setHeader($header->getName(), $header->getValue());
                    else $overrided_to = $header->getValue();
                }
            }        			
            			
			/* if part doesn't contain content, don't send this part */
			$use_plain && $mail->setText('{#*--TEXT--*#}');
			$use_html && $mail->setHTML('{#*--HTML--*#}'); 		

            
            $imagesUsed = array();
            /* add embeded images from campaign */
            if ( $use_html && sizeof($this->getImages()) ) {
                foreach ( $this->getImages() as $objImage ) {
                    $source = base64_decode($objImage->getImageSource());
                    $mail->addEmbeddedImage(new stringEmbeddedImage($source, $objImage->getImageName(), $objImage->getImageContentType(), null, $objImage->getCid()));
                    
                    $quoted = preg_quote($objImage->getImageName());
                    $cid    = preg_quote($objImage->getCid());
                    $html = preg_replace("#src=\"$quoted\"|src='$quoted'#", "src=\"cid:$cid\"", $html);
                    $html = preg_replace("#background=\"$quoted\"|background='$quoted'#", "background=\"cid:$cid\"", $html);
                    $html = preg_replace("#background:url\('$quoted'\)#", "background:url('cid:$cid')", $html);
                    
                    $imagesUsed[] = $objImage->getImageName();
                }
            } 
            /* add embeded images from template 
             * if some image (by name) has been used in campaign
             * don't add this image */
            try { 
                if ( $use_html &&  sizeof( $objLocalizations->getImages() ) ) {
                    foreach ( $objLocalizations->getImages() as $objImage ) {
                        if ( !in_array($objImage->getImageName(), $imagesUsed) ) {
                            $source = base64_decode($objImage->getImageSource());
                            $mail->addEmbeddedImage(new stringEmbeddedImage($source, $objImage->getImageName(), $objImage->getImageContentType(), null, $objImage->getCid()));
                            
                            $quoted = preg_quote($objImage->getImageName());
                            $cid    = preg_quote($objImage->getCid());
                            $html = preg_replace("#src=\"$quoted\"|src='$quoted'#", "src=\"cid:$cid\"", $html);
                            $html = preg_replace("#background=\"$quoted\"|background='$quoted'#", "background=\"cid:$cid\"", $html);
                            $html = preg_replace("#background:url\('$quoted'\)#", "background:url('cid:$cid')", $html);
                        }
                    }
                } 
            } catch ( Exception $e ) { throw $e; }

            /**
             * to override to address in mail body (not recipient address)
             * set up header TO to needed email address
             * @author Artem Sukharev
             */
            if ( $overrided_to ) $raw = $mail->getRFC822(array($overrided_to), 'smtp', true);
            else $raw = $mail->getRFC822(array('{#*--TO--*#}'), 'smtp', true);

            
            try { $this->saveRaw($subject, $html, $plain, $raw, $pmb_subject, $pmb_message, $objLocalizations->getLocale(), $objLocalizations->getIsDefault()); }
            catch ( Exception $e ) { throw $e; }
        }
        
        return true;
    }

    /** 
     * @param int $id
     * @return Server_Model_Campaign
     */
    static public function loadCached( $id, $load_raw = false )
    {
        if ( isset( self::$loadCached[$id] ) ) return self::$loadCached[$id];
        
        self::$loadCached[$id] = new Server_Model_Campaign();
        
        try { self::$loadCached[$id]->load( $id ); }
        catch ( Exception $e ) { throw $e; }
        
        self::$loadCached[$id]->getSender();
        self::$loadCached[$id]->getImages();
        
        if ( $load_raw ) {
            try { self::$loadCached[$id]->raw = self::$loadCached[$id]->loadRaw(); }
            catch ( Exception $e ) { throw $e; }
        }
        
        return self::$loadCached[$id];
    }
    
    /** 
     * @param int $id
     * @return boolean
     */
    static public function exists( $id )
    {
        if ( null === $id ) throw new Exception('Incorrect campaign id');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT count(id) as cnt FROM mail_campaignes WHERE id = :id";
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
        if ( null === $uid ) throw new Exception('Incorrect campaign uid');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT count(id) as cnt FROM mail_campaignes WHERE uid = :uid";
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
     * @param int $id
     * @return boolean
     */
    static public function isNotStarted( $id )
    {
        if ( null === $id ) throw new Exception('Incorrect campaign id');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT status FROM mail_campaignes WHERE id = :id";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':id', $id);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);        

        $db = NULL;
        return $result[0] == 'new' || $result[0] == 'wait' || $result[0] == 'in_progress' ? true : false;
    }
    
    /** 
     * @param string $uid
     * @return boolean
     */
    static public function isNotStartedByUid( $uid )
    {
        if ( null === $uid ) throw new Exception('Incorrect campaign uid');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT status FROM mail_campaignes WHERE uid = :uid";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':uid', $uid);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);        

        $db = NULL;
        return $result[0] == 'new' || $result[0] == 'wait' || $result[0] == 'in_progress' ? true : false;
    }
    
    /** 
     * @param string $uid
     * @return boolean
     */
    static public function canRemoveByUid( $uid )
    {
        if ( null === $uid ) throw new Exception('Incorrect campaign uid');

        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT status FROM mail_campaignes WHERE uid = :uid";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':uid', $uid);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);        

        $db = NULL;
        return $result[0] == 'new' || $result[0] == 'wait' || $result[0] == 'started' ? true : false;
    }
    
    /** 
     * @param $rows_count
     * @return unknown_type
     */
    static public function getRowsWithLock($rows_count = 40)
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
            $in_progress_date = date('Y-m-d H:i:s');
        
            $db->beginTransaction();
            $select_sql = "SELECT id FROM mail_campaignes WHERE status = 'started' ORDER BY delivery_date ASC LIMIT 0, ".$rows_count." FOR UPDATE";
            $stmt = $db->prepare($select_sql);
            //  Deadlock
            try { $stmt->execute(); } 
            catch ( PDOException $e ) {
                $db->rollBack();
                unset($select_sql,$stmt); 
                continue;
            }       
            $records_to_process = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            if ( $records_to_process && sizeof($records_to_process) != 0 ) {
                $update_sql = "UPDATE mail_campaignes SET status = 'in_progress', in_progress_date = '".$in_progress_date."' WHERE id IN (" .join(',', $records_to_process). ")";
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
        
        unset($in_progress_date,$select_sql,$update_sql,$stmt);
        
        $db = NULL;
        return $records_to_process;
    }
    
    /** 
     * @param $id
     * @param $status
     * @return unknown_type
     */
    static public function rollbackStatus($id, $status = 'started')
    {
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $update_sql = "UPDATE mail_campaignes SET status = '".$status."' WHERE id = '".$id."'";
        try { $stmt = $db->query($update_sql); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL; 
            throw $e;
        }        
        unset($update_sql, $stmt);
        $db = NULL;
    }
    
    /**
     * Must return true if the response is valid, false if not and we need 
     * to reconnect, or throw an exception if attemts limit is reached.
     */
    static public function responseValidator($response, $numberOfAttempt, $callArgs)
    {
        if ($response['http_code'] != 200 || !strlen($response['body'])) {
            if ($numberOfAttempt < 3) {
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
}