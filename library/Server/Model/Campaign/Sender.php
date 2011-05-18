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
class Server_Model_Campaign_Sender
{
    protected $id;
    protected $campaignId;
    protected $email;
    protected $name;
	
	/**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @param $id the $id to set
     */
    public function setId( $id )
    {
        $this->id = $id;
        return $this;
    }

	/**
     * @return the $campaignId
     */
    public function getCampaignId()
    {
        return $this->campaignId;
    }

	/**
     * @param $campaignId the $campaignId to set
     */
    public function setCampaignId( $campaignId )
    {
        $this->campaignId = $campaignId;
        return $this;
    }

	/**
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }

	/**
     * @param $email the $email to set
     */
    public function setEmail( $email )
    {
        $this->email = $email;
        return $this;
    }

	/**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * @param $name the $name to set
     */
    public function setName( $name )
    {
        $this->name = $name;
        return $this;
    }

    public function save()
    {
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ( null === $this->getId() ) {
            $emptyStr = '';
            $insert_sql = "INSERT INTO mail_campaignes__senders (campaign_id, email, name) VALUES (:campaign_id, :email, :name)";
            $stmt = $db->prepare($insert_sql);
            $stmt->bindParam(':campaign_id', $this->getCampaignId());
            $stmt->bindParam(':email', $this->getEmail());
            $stmt->bindParam(':name', $this->getName());
            try { $stmt->execute(); } 
            catch ( PDOException $e ) {
                $db = NULL;
                throw $e;
            }       
            $this->setId($db->lastInsertId());
        } else {
            $update_sql = "UPDATE mail_campaignes__senders SET campaign_id = :campaign_id, email = :email, name = :name";
            $stmt = $db->prepare($update_sql);
            $stmt->bindParam(':campaign_id', $this->getCampaignId());
            $stmt->bindParam(':email', $this->getEmail());
            $stmt->bindParam(':name', $this->getName());
            try { $stmt->execute(); } 
            catch ( PDOException $e ) {
                $db = NULL;
                throw $e;
            }       
        }
        
        $db = NULL;
        return true; 
    }
    
    static public function loadByCampaign( $campaignId )
    {
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_campaignes__senders WHERE campaign_id = :campaign_id";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':campaign_id', $campaignId);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ( $result ) {
            $objSender = new Server_Model_Campaign_Sender();
            $objSender->setId($result[0]['id']);
            $objSender->setCampaignId($result[0]['campaign_id']);
            $objSender->setEmail($result[0]['email']);
            $objSender->setName($result[0]['name']);
            return $objSender;
        }        
        
        $db = NULL;
        return null;        
    }
    
    
}