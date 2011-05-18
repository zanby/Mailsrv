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
	$home = realpath( dirname( __FILE__) . DIRECTORY_SEPARATOR . "..");
	define('ENGINE_DIR', $home.'/library');
	require_once ENGINE_DIR . '/bootstrap.php';
	
	if ( !isset($_GET['t']) || !$_GET['t'] ) throw new Exception('Incorrect request');
	
	$dom = new DOMDocument('1.0', 'UTF-8');

	switch ( $_GET['t'] ) {
		case 'service' : 
			$dom->load(ENGINE_DIR.'/../wsdl/service.wsdl');
			$element = $dom->getElementsByTagNameNS('http://schemas.xmlsoap.org/wsdl/soap/', 'address');
			$element->item(0)->setAttribute('location', SERVER_URL . '/mail.server.php');
			break;
		case 'bootstrap' : 
			$dom->load(ENGINE_DIR.'/../wsdl/bootstrap.wsdl');
			$element = $dom->getElementsByTagNameNS('http://schemas.xmlsoap.org/wsdl/soap/', 'address');
			$element->item(0)->setAttribute('location', SERVER_URL . '/mail.server.service.php');
			break;
		case 'template' : 
			$dom->load(ENGINE_DIR.'/../wsdl/template.wsdl');
			$element = $dom->getElementsByTagNameNS('http://schemas.xmlsoap.org/wsdl/soap/', 'address');
			$element->item(0)->setAttribute('location', SERVER_URL . '/mail.server.template.php');
			break;		
		case 'tools' : 
			$dom->load(ENGINE_DIR.'/../wsdl/tools.wsdl');
			$element = $dom->getElementsByTagNameNS('http://schemas.xmlsoap.org/wsdl/soap/', 'address');
			$element->item(0)->setAttribute('location', SERVER_URL . '/mail.server.tools.php');
			break;		
        case 'builder' : 
            $dom->load(ENGINE_DIR.'/../wsdl/builder.wsdl');
            $element = $dom->getElementsByTagNameNS('http://schemas.xmlsoap.org/wsdl/soap/', 'address');
            $element->item(0)->setAttribute('location', SERVER_URL . '/mail.server.builder.php');
            break;
        case 'deliver' : 
            $dom->load(ENGINE_DIR.'/../wsdl/deliver.wsdl');
            $element = $dom->getElementsByTagNameNS('http://schemas.xmlsoap.org/wsdl/soap/', 'address');
            $element->item(0)->setAttribute('location', SERVER_URL . '/mail.server.deliver.php');
            break;      
		default :
			throw new Exception('Incorrect request');
	}
	$dom->formatOutput = false;
	header("Content-type: text/xml");
	print $dom->saveXML();
