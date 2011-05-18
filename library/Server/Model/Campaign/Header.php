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
class Server_Model_Campaign_Header
{
    protected $id;
    protected $campaignId;
    protected $name;
    protected $value;
    
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
    }

    /**
     * @return the $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value the $value to set
     */
    public function setValue( $value )
    {
        if ( is_object($value) ) throw new Exception("Value of header can not be an object");
        if ( is_array($value) ) throw new Exception("Value of header can not be an array");
        
        $this->value = $value;
    }

    static public function loadByCampaign( $campaignId )
    {
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_campaignes__headers WHERE campaign_id = :campaign_id";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':campaign_id', $campaignId);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $return = array();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ( $results && sizeof($results) ) {
            foreach ( $results as $result ) {
                $objHeader = new Server_Model_Campaign_Header();
                $objHeader->setId($result['id']);
                $objHeader->setCampaignId($result['campaign_id']);            
                $objHeader->setName($result['name']);
                $objHeader->setValue($result['value']);
                $return[] = $objHeader;
            }
            return $return;
        }        
        
        $db = NULL;
        return $return;        
    }
    
    static public function loadByCampaignForSearch( $campaignId )
    {
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_campaignes__headers WHERE campaign_id = :campaign_id";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':campaign_id', $campaignId);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $return = array();
        $return['search'] = array();
        $return['replace'] = array();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ( $results && sizeof($results) ) {
            foreach ( $results as $result ) {
                $return['search'][] = '{*'.$result['name'].'*}';
                $return['replace'][] = $result['value'];
            }
            return $return;
        }        
        
        $db = NULL;
        return $return;        
    }
    
}