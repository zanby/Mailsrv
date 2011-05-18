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
class Server_Model_Campaign_Image
{
    protected $id;
    protected $cid;
    protected $campaignId;
    protected $imageName;
    protected $imageSource;
    protected $imageContentType;    
    
    private $imageTypes = array(
        'gif'  => 'image/gif',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpe'  => 'image/jpeg',
        'bmp'  => 'image/bmp',
        'png'  => 'image/png',
        'tif'  => 'image/tiff',
        'tiff' => 'image/tiff',
        'swf'  => 'application/x-shockwave-flash');
    
	/**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @param $id the $id to set
     * @return Server_Model_Campaign_Image
     */
    public function setId( $id )
    {
        $this->id = $id;
        return $this;
    }
	
	/**
     * @param $cid the $cid to set
     * @return Server_Model_Campaign_Image
     */
    public function setCid( $cid )
    {
        $this->cid = $cid;
        return $this;
    }

	/**
     * @return the $cid
     */
    public function getCid()
    {
        if ( null === $this->cid ) $this->cid = md5($this->getId().$this->getCampaignId().$this->getImageName());
        return $this->cid;
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
     * @return Server_Model_Campaign_Image
     */
    public function setCampaignId( $campaignId )
    {
        $this->campaignId = $campaignId;
        return $this;
    }

	/**
     * @return the $imageName
     */
    public function getImageName()
    {
        return $this->imageName;
    }

	/**
     * @param $imageName the $imageName to set
     * @return Server_Model_Campaign_Image
     */
    public function setImageName( $imageName )
    {
        $this->imageName = $imageName;
        $ext = preg_replace('#^.*\.(\w{3,4})$#e', 'strtolower("$1")', $this->imageName);
        $content_type = isset($this->imageTypes[$ext]) ? $this->imageTypes[$ext] : 'image/jpeg';
        $this->setImageContentType($content_type);
        return $this;
    }

	/**
     * @return the $imageSource
     */
    public function getImageSource()
    {
        return $this->imageSource;
    }

	/**
     * @param $imageSource the $imageSource to set
     * @return Server_Model_Campaign_Image
     */
    public function setImageSource( $imageSource )
    {
        $this->imageSource = $imageSource;
        return $this;
    }

	/**
     * @return the $imageContentType
     */
    public function getImageContentType()
    {
        return $this->imageContentType;
    }

	/**
     * @param $imageContentType the $imageContentType to set
     * @return Server_Model_Campaign_Image
     */
    public function setImageContentType( $imageContentType )
    {
        $this->imageContentType = $imageContentType;
        return $this;
    }

    /** 
     * @param $campaignId
     * @return Server_Model_Campaign_Image
     */
    static public function loadByCampaign( $campaignId )
    {
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_campaignes__images WHERE campaign_id = :campaign_id";
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
                $objImage = new Server_Model_Campaign_Image();
                $objImage->setId($result['id']);
                $objImage->setCampaignId($result['campaign_id']);            
                $objImage->setImageName($result['image_name']);
                $objImage->setImageSource($result['image_source']);
                $objImage->setImageContentType($result['image_content_type']);
                $return[] = $objImage;
            }
            return $return;
        }        
        
        $db = NULL;
        return $return;        
    }
    
}