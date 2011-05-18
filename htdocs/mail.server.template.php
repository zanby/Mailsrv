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
require_once ENGINE_DIR . '/Server/Service/Template.php';
require_once ENGINE_DIR . '/Server/WSSecurity.php';
require_once ENGINE_DIR . '/Server/WSSecurity/Campaign/UsernameToken.php';

$soap = new DOMDocument();
$soap->load('php://input');

$wss = new Server_WSSecurity( $soap );
$wss->setUsernameToken( new Server_WSSecurity_Campaign_UsernameToken() );
$soapServer = new SoapServer( SERVER_URL."/wsdl.php?t=template", array() );

try { $response = $wss->process(); }
catch ( Exception $e ) { $wss->failed($e->getMessage()); }
if ( !$response ) { $wss->failed('Cannot process soap request'); }

$soapServer->setObject(new Server_Service_Template());
$soapServer->handle($wss->saveXML());
