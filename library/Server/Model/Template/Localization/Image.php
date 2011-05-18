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
class Server_Model_Template_Localization_Image
{
    protected $id;
    protected $cid;
    protected $localizationId;
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
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @param int $id
     * @return Server_Model_Template_Localization_Image
     */
    public function setId( $id )
    {
        $this->id = $id;
        return $this;
    }
	
	/**
     * @param int $cid
     * @return Server_Model_Template_Localization_Image
     */
    public function setCid( $cid )
    {
        $this->cid = $cid;
        return $this;
    }

	/**
     * @return int $cid
     */
    public function getCid()
    {
        if ( null === $this->cid ) $this->cid = md5($this->getId().$this->getLocalizationId().$this->getImageName());
        return $this->cid;
    }

	/**
     * @return int $localizationId
     */
    public function getLocalizationId()
    {
        return $this->localizationId;
    }

	/**
     * @param int $localizationId
     * @return Server_Model_Template_Localization_Image
     */
    public function setLocalizationId( $localizationId )
    {
        $this->localizationId = $localizationId;
        return $this;
    }

	/**
     * @return string $imageName
     */
    public function getImageName()
    {
        return $this->imageName;
    }

	/**
     * @param string $imageName
     * @return Server_Model_Template_Localization_Image
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
     * @return base64Binary $imageSource
     */
    public function getImageSource()
    {
        return $this->imageSource;
    }

	/**
     * @param base64Binary $imageSource
     * @return Server_Model_Template_Localization_Image
     */
    public function setImageSource( $imageSource )
    {
        $this->imageSource = $imageSource;
        return $this;
    }

	/**
     * @return string $imageContentType
     */
    public function getImageContentType()
    {
        return $this->imageContentType;
    }

	/**
     * @param string $imageContentType
     * @return Server_Model_Template_Localization_Image
     */
    public function setImageContentType( $imageContentType )
    {
        $this->imageContentType = $imageContentType;
        return $this;
    }

    
    /**
     * Remove localization image by image name and localizationId
     * @param string $imageName
     * @param string $localizationId
     * @throws Exception
     * @return boolean
     */
    static public function deleteByName($imageName, $localizationId)
    {
        if ( null === $localizationId ) throw new Exception('Incorrect localization id');
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $delete_sql = "DELETE FROM mail_templates__localizations_images WHERE image_name = :image_name AND localization_id = :localization_id";
        $stmt = $db->prepare($delete_sql);
        $stmt->bindParam(':image_name', $imageName);     
        $stmt->bindParam(':localization_id', $localizationId);    
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        return true;
    }
    
    
    /**
     * @param int $localizationId
     * @return Server_Model_Template_Localization_Image
     */
    static public function loadByLocalization( $localizationId )
    {
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT * FROM mail_templates__localizations_images WHERE localization_id = :localization_id";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':localization_id', $localizationId);
        try { $stmt->execute(); } 
        catch ( PDOException $e ) {
            $db = NULL;
            throw $e;
        }       
        
        $return = array();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ( $results && sizeof($results) ) {
            foreach ( $results as $result ) {
                $objImage = new Server_Model_Template_Localization_Image();
                $objImage->setId($result['id']);
                $objImage->setLocalizationId($result['localization_id']);            
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
    
    
    /**
     * Conver image class to array
     * @author Alex Che
     * @return array 
     */
    public function toArray()
    {
        return array(
            'id' => $this->id,
            'imageName' => $this->imageName,
            'imageSource' => $this->imageSource,
            'imageContentType' => $this->imageContentType
        );
    }
    
}