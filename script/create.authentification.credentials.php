#! /usr/bin/env php
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
    /**
     * This script generate authentification credentials.
     * Script works with database
     * The result is stored to database and prited to console. 
     * 
     * @param string login - login for new credential
     * @param string password - password for new credential
	 * @param int type - flag that shows is credential system or not system|application
     */

	/* ########################################################################## */
	
	$home = realpath( dirname( __FILE__) . DIRECTORY_SEPARATOR . "..");
	define('ENGINE_DIR', $home.'/library');
	require_once ENGINE_DIR . '/bootstrap_script.php';
	require_once ENGINE_DIR . '/bootstrap.php';
	
	if ( !isset($argv[1]) || !isset($argv[2]) || !isset($argv[3]) ) {
		echo "Use : {$argv[0]} login password type\n";
		exit(1);
	}
	
	$params['login'] = $argv[1];
	$params['password'] = $argv[2];
	$params['en_password'] = md5($argv[2]);
	$params['type'] = in_array($argv[3], array('application', 'system')) ? $argv[3] : null;

	if ( empty($params['login']) || empty($params['password']) ) {
		echo "Use : {$argv[0]} login password type\n";
		exit(1);
	}
	
	if ( empty($params['type']) ) {
		echo "Use : {$argv[0]} login password type (type must be 'system' or 'application')\n";
		exit(1);
	}
	
    
    /* ########################################################################## */    
    
	$output = '';
	$output .= 'Login: '.$params['login']."\n";
	$output .= 'Password: '.$params['password']."\n";
	$output .= 'Encrypted Password: '.$params['en_password']."\n";
	$output .= '---------------------------------------------------'."\n";
	
	$output .= 'Write information below to "config/cfg.script.xml" configuration file'."\n";
	$output .= "
<credentials>
    <uid>".$params['login']."</uid>     <!--  valid username  -->
    <pass>".$params['password']."</pass>    <!--  valid password  -->
</credentials>";
        
	/* ==================== */
	
	try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
	catch ( PDO_Exception $e ) { 
		$db = NULL;
		throw $e;
	}
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$select_sql = "SELECT count(*) FROM mail_accounts where username = :username";
	$stmt = $db->prepare($select_sql);
	$stmt->bindParam(':username', $params['login']);
	try { $stmt->execute(); } 
	catch ( PDOException $e ) {
		$db = NULL;
		throw $e;
	}       	
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN);    
	if ( $result[0] ) {
		echo "Use : {$argv[0]} login password type (user with login '".$params['login']." already exists.')\n";
		exit(1);
	}
	
	
	date_default_timezone_set('UTC');        
	$created_date = date('Y-m-d H:i:s');
	
	$null = null;
	$statusActive = 'active';
	$isSystem = $params['type'] == 'system' ? 1 : 0;
	
	$insert_sql = "INSERT INTO mail_accounts (username, password, domain, status, is_system, created, last_access) 
		VALUES (:username, :password, :domain, :status, :is_system, :created, :last_access)";		
	$stmt = $db->prepare($insert_sql);
	$stmt->bindParam(':username', $params['login']);
	$stmt->bindParam(':password', $params['en_password']);
	$stmt->bindParam(':domain', $null);
	$stmt->bindParam(':status', $statusActive);
	$stmt->bindParam(':is_system', $isSystem);
	$stmt->bindParam(':created', $created_date);
	$stmt->bindParam(':last_access', $null);
	try { $stmt->execute(); } 
	catch ( PDOException $e ) {
		$db = NULL;
		throw $e;
	}


		
	echo $output;
    echo "\nDone\n";
    exit();
    