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
require_once ENGINE_DIR.'/Server/Model/Template.php';
require_once ENGINE_DIR.'/Server/Model/Template/Localization.php';
require_once ENGINE_DIR.'/Server/Model/Template/Localization/Image.php';

class Server_Service_Template
{
    /**
     * @return boolean
     */
    public function testTemplate()
    {
        return true;
    }
	
    /** 
     * @return string
     */
    public function getDefaultLocale()
    {
        return LOCALIZATION_DEFAULT_LOCALE;
    }
    
    /**
     * @param string $uid First string
     * @param string $instanceKey
     * @return array
     */
    public function getTemplate( $uid, $instanceKey )
    {
        try { $result = Server_Model_Template::existsByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');
        
        $objTemplate = new Server_Model_Template();
        try { $result = $objTemplate->loadByUidAsArray( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');        
        
        
        
        //attach avaliable localizations
        $localizations = Server_Model_Template_Localization::loadListByTempate($result['id']);
        $resultLocalizations = array();
        foreach ($localizations as $localization) {
            $resultLocalizations[] = array (
                'locale' => $localization->getLocale(),
                'isDefault' => ($localization->getIsDefault()) ? true: false
            );
        }
        $result['locales'] = $resultLocalizations;
        unset($result['id']);
        
        return $result;
    }
    
    

    /**
     * Get list templates registered for instance 
     * 
     * @param string $instanceKey
     * @throws SoapFault
     * @return array
     */
    public function getRegisteredTemplates($instanceKey)
    {
        if ( !$instanceKey || '' == trim($instanceKey) ) throw new SoapFault("HTTP", 'Incorrect value of instanceKey.');
        
        $templates = Server_Model_Template::getTemapltesListByInstance($instanceKey);

        $result = array();
        foreach ($templates as $template) {
            $result[] = array(
                'uid' => $template->getUid(),
                'description' => $template->getDescription(),
            	'create_date' => $template->getCreateDate(),
            	'last_used' => $template->getLastUsedDate(),
            	'status' => $template->getStatus()
            );
        }
        return $result;
    }
    
    
    /**
     * Deprecated.
     * 
     * @param string $html First string
     * @param string $plain Second string
	 * @param string $subject Third string
     * @param string $locale Fourth string
     * @return string
     * @deprecated
     */
	public function registerTemplate($html, $plain, $subject, $locale = LOCALIZATION_DEFAULT_LOCALE)
	{
        $objTemplate = new Server_Model_Template();
        try { $result = $objTemplate->save(); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage());}
				
		$objLocalization = new Server_Model_Template_Localization();
		$objLocalization->setTemplateId($objTemplate->getId());
		$objLocalization->setLocale($locale);
		$objLocalization->setSubject($subject);
		$objLocalization->setBodyHtml($html);
		$objLocalization->setBodyPlain($plain);
		$objLocalization->setIsDefault(1);
        try { $result = $objLocalization->save(); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
		
        return $objTemplate->getUid();
	}
		
    /**
     * @param string $uid First string
     * @param string $instanceKey Second string
     * @return string
     */
	public function isRegisteredForImpl( $uid, $instanceKey )
	{
        if ( !$uid || '' == trim($uid) ) throw new SoapFault("HTTP", 'Incorrect value of uid.');
        if ( !$instanceKey || '' == trim($instanceKey) ) throw new SoapFault("HTTP", 'Incorrect value of instanceKey.');
              
        try { $result = Server_Model_Template::existsByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        if ( $result ) return $uid;
        else return '';
	}
	
    /**
     * @param string $uid First string
     * @param string $instanceKey Second string
     * @param string $html Third string
     * @param string $plain Fourth string
     * @param string $subject Fifth string
     * @param string $locale Sixth string
     * @param boolean $force Seventh boolean
     * @return string
     */
	public function registerTemplateForImpl($uid, $instanceKey, $html, $plain, $subject, $locale = LOCALIZATION_DEFAULT_LOCALE, $force = false)
	{
	    if ( !$uid || '' == trim($uid) ) throw new SoapFault("HTTP", 'Incorrect value of uid.');
	    if ( !$instanceKey || '' == trim($instanceKey) ) throw new SoapFault("HTTP", 'Incorrect value of instanceKey.');
	    	    
        try { $result = Server_Model_Template::existsByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        if ( !$result ) {
            $objTemplate = new Server_Model_Template();
            $objTemplate->setUid( $uid );
            $objTemplate->setInstanceKey($instanceKey);
            try { $result = $objTemplate->save(); } 
            catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage());}
                    
            $objLocalization = new Server_Model_Template_Localization();
            $objLocalization->setTemplateId($objTemplate->getId());
            $objLocalization->setLocale($locale);
            $objLocalization->setSubject($subject);
            $objLocalization->setBodyHtml($html);
            $objLocalization->setBodyPlain($plain);
            $objLocalization->setIsDefault(1);
            try { $result = $objLocalization->save(); } 
            catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
            
            return $objTemplate->getUid();            
        } elseif ( $force ) {
            
            $objTemplate = new Server_Model_Template();
            try { $result = $objTemplate->loadByUid( $uid ); } 
            catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
            if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');
             
            $objTemplate->deactivate();
            Server_Model_Template_Localization::deleteAllByTempate( $objTemplate->getId() );
            
            $objLocalization = new Server_Model_Template_Localization();
            $objLocalization->setTemplateId($objTemplate->getId());
            $objLocalization->setLocale($locale);
            $objLocalization->setSubject($subject);
            $objLocalization->setBodyHtml($html);
            $objLocalization->setBodyPlain($plain);
            $objLocalization->setIsDefault(1);
            try { $result = $objLocalization->save(); } 
            catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
            
            return $objTemplate->getUid();
            
        } else return $uid;
	}
	
    /**
     * @param string $uid First string
     * @param string $instanceKey
     * @return boolean
     */
    public function unregisterTemplate( $uid, $instanceKey )
    {
        try { $result = Server_Model_Template::existsByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');
        
        $objTemplate = new Server_Model_Template();
        $objTemplate->setUid( $uid );
        $objTemplate->setInstanceKey($instanceKey);
        try { $result = $objTemplate->deleteByUid();
        } catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        
        return $result;
    }
    
    /**
     * @param string $uid
     * @param string $instanceKey
     * @param string $description
     * @return boolean
     */
	public function setDescription( $uid, $instanceKey, $description )
	{
        try { $result = Server_Model_Template::existsByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');
        
        $objTemplate = new Server_Model_Template();
        try { $result = $objTemplate->loadByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');        

        $objTemplate->setDescription($description);
        try { $objTemplate->saveDescription(); }
	    catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
	    
	    return true;
	}
	
    /**
     * @param string $uid
     * @param string $instanceKey
     * @param string $locale
     * @param string $html
	 * @param string $plain
	 * @param string $subject
     * @return int
     */
	public function addLocalization( $uid, $instanceKey, $locale, $html, $plain, $subject )
	{
        try { $result = Server_Model_Template::existsByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');
        
        try { $result = Server_Model_Template_Localization::existsByUid( $uid, $instanceKey, $locale ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( $result ) throw new SoapFault("HTTP", 'Template localization already exists');
        
        $objTemplate = new Server_Model_Template();
        try { $result = $objTemplate->loadByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');        

		$objLocalization = new Server_Model_Template_Localization();
		$objLocalization->setTemplateId( $objTemplate->getId() );
		$objLocalization->setLocale( $locale );
		$objLocalization->setSubject( $subject );
		$objLocalization->setBodyHtml( $html );
		$objLocalization->setBodyPlain( $plain );
		$objLocalization->setIsDefault( 0 );
        try { $result = $objLocalization->save(); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }

		return $objLocalization->getId();
	}
	
    /**
     * @param string $uid
     * @param string $instanceKey
     * @param string $locale
     * @param string $html
     * @param string $plain
     * @param string $subject
     * @return boolean
     */
	public function updateLocalization( $uid, $instanceKey, $locale, $html, $plain, $subject )
	{
        try { $result = Server_Model_Template::existsByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');
        
        try { $result = Server_Model_Template_Localization::existsByUid( $uid, $instanceKey, $locale ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Template localization doesn\'t exist');

        $objLocalization = new Server_Model_Template_Localization();
        try { $result = $objLocalization->loadByTempateUidAndLocale( $uid, $instanceKey, $locale );  } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Template localization doesn\'t exist');
        
        //$objLocalization->setTemplateId( $objTemplate->getId() );
        //$objLocalization->setLocale( $locale );
        $objLocalization->setSubject( $subject );
        $objLocalization->setBodyHtml( $html );
        $objLocalization->setBodyPlain( $plain );
        //$objLocalization->setIsDefault( 0 );
        
        try { $result = $objLocalization->update(); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
        
        return true;
	}
	
	

	
	/**
	 * Update key and instance for template
	 * 
	 * @param string $uid
	 * @param string $newUid
	 * @param string $instanceKey
	 * @throws SoapFault
	 * @return boolean
	 */
	public function updateInstanceAndUidForRegisteredTemplate( $uid, $newUid,  $instanceKey )
	{
        $objTemplate = new Server_Model_Template();
        try { $result = $objTemplate->loadByUidOnly( $uid ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');        
	            
        $objTemplate->setInstanceKey($instanceKey);
        $objTemplate->setUid($newUid);

        try { $objTemplate->saveInstanceKey(); }
	    catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }
	    
	    return true;
	}
	
	
	/**
	 * Remove localization
	 * 
	 * @param string $uid
	 * @param string $instanceKey
	 * @param string $locale
	 * @throws SoapFault
	 * @return boolean
	 */
	public function removeLocalization($uid, $instanceKey, $locale)
	{
        try { $result = Server_Model_Template::existsByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');
        
        $objLocalization = new Server_Model_Template_Localization();
        try { $result = $objLocalization->loadByTempateUidAndLocale( $uid, $instanceKey, $locale );  } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Template localization doesn\'t exist');
        
        if ((int)$result->getIsDefault()) {
            throw new SoapFault("HTTP", 'Can\'t remove default localization');
        }
        
        try { Server_Model_Template_Localization::deleteByLocale($result->getId(), $locale);  } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        
        return true;
	}
	
	
    /**
     * @param string $uid First string
     * @param string $instanceKey
     * @param string $locale Second string
     * @return array
     */
	public function getLocalization( $uid, $instanceKey, $locale)
	{
        try { $result = Server_Model_Template::existsByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');
        
        try { $result = Server_Model_Template_Localization::existsByUid( $uid, $instanceKey, $locale ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Template localization doesn\'t exist');
        
        $objLocalization = new Server_Model_Template_Localization();
        try { $result = $objLocalization->loadByTempateUidAndLocaleAsArray( $uid, $instanceKey, $locale );  } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Template localization doesn\'t exist');
        
        unset($result['id']);
        unset($result['template_id']);
        unset($result['is_default']);
        
        return $result;
	}
	
	
	/**
	 * Get localuization embeded image
	 * @param string $uid
	 * @param string $instanceKey
	 * @param string $locale
	 * @throws SoapFault
	 * @return array
	 */
	public function getLocalizationEmbededImages($uid, $instanceKey, $locale)
	{
        try { $result = Server_Model_Template::existsByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');

        $objLocalization = new Server_Model_Template_Localization();
        try { $localization = $objLocalization->loadByTempateUidAndLocaleAsArray( $uid, $instanceKey, $locale );  } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$localization ) throw new SoapFault("HTTP", 'Template localization doesn\'t exist');

        $objLocalization = new Server_Model_Template_Localization();
        $objLocalization->setId($localization['id']);
	    $result = $objLocalization->getImages();
        if (is_array($result) ) {
            foreach ($result as $key => &$value) {
                $value = $value->toArray();
            }
        }

	    return $result;
	}
	
    /**
     * @param string $uid
     * @param string $instanceKey
     * @param string $locale
     * @param string $imageName
     * @param base64Binary $imageSource Fourth base64Binary
     * @return boolean
     */
    public function addEmbededImage( $uid, $instanceKey, $locale, $imageName, $imageSource )
    {
        try { $result = Server_Model_Template::existsByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');
        
        try { $result = Server_Model_Template_Localization::existsByUid( $uid, $instanceKey, $locale ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Template localization doesn\'t exist');        
                
        $objLocalization = new Server_Model_Template_Localization();
        try { $objLocalization->loadByTempateUidAndLocale( $uid, $instanceKey, $locale ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$objLocalization->getId() ) throw new SoapFault("HTTP", 'Template localization doesn\'t exist');        

        $objImage = new Server_Model_Template_Localization_Image();
        $objImage->setLocalizationId( $objLocalization->getId() );
        $objImage->setImageName( $imageName );
        $objImage->setImageSource( base64_encode($imageSource) );

        try { $objLocalization->addImage($objImage); }
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }

        try { $objLocalization->saveImages(); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); } 
        
        return true;
	}
	
	
	/**
	 * Remove embeded image from locale
	 * @param string $uid
	 * @param string $instanceKey
	 * @param string $locale
	 * @param string $imageName
	 * @throws SoapFault
	 * @return boolean
	 */
	public function removeEmbededImage($uid, $instanceKey, $locale, $imageName)
	{
        try { $result = Server_Model_Template::existsByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');
        
        try { $result = Server_Model_Template_Localization::existsByUid( $uid, $instanceKey, $locale ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Template localization doesn\'t exist');        
                
        $objLocalization = new Server_Model_Template_Localization();
        try { $objLocalization->loadByTempateUidAndLocale( $uid, $instanceKey, $locale ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$objLocalization->getId() ) throw new SoapFault("HTTP", 'Template localization doesn\'t exist');        

        Server_Model_Template_Localization_Image::deleteByName($imageName, $objLocalization->getId());
        
        return true;
	}
	
	
    /**
     * @param string $uid
     * @param string $instanceKey
     * @param string $locale
     * @param string $subject
     * @param string $message
     * @return boolean
     */
	public function addPMBMessage( $uid, $instanceKey, $locale, $subject, $message )
	{
        try { $result = Server_Model_Template::existsByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');
        
        try { $result = Server_Model_Template_Localization::existsByUid( $uid, $instanceKey, $locale ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Template localization doesn\'t exist');        
                
        $objLocalization = new Server_Model_Template_Localization();
        try { $objLocalization->loadByTempateUidAndLocale( $uid, $instanceKey, $locale ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$objLocalization->getId() ) throw new SoapFault("HTTP", 'Template localization doesn\'t exist');        
	    
        try { $objLocalization->savePMBMessage($subject, $message); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); } 
        
	    return true;
	}
	
    /**
     * @param string $uid
     * @param string $instanceKey
     * @return boolean
     */
	public function activate( $uid, $instanceKey )
	{
        try { $result = Server_Model_Template::existsByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        if ( !$result ) throw new SoapFault("HTTP", 'Incorrect template uid');
	    
        $objTemplate = new Server_Model_Template();
        try { $result = $objTemplate->loadByUid( $uid, $instanceKey ); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        
        try { $result = $objTemplate->activate(); } 
        catch ( Exception $e ) { throw new SoapFault("HTTP", $e->getMessage()); }        
        
		return $result;
	}
	

	
	/**
	 * Get current service version
	 * 
	 * @return int
	 */
	public function getVersion()
	{
	    return 20110120; //YYYYMMDD
	}

}