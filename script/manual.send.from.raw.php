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
    require_once ENGINE_DIR . '/bootstrap_script.php';
    require_once ENGINE_DIR . '/bootstrap.php';
    require_once ENGINE_DIR . '/Server/Model/Log.php';
    
    define('DISPLAY_XPM4_ERRORS', true);
    $arr = array( 'type' => 3, 'destination' => Server_Model_Log::getXPM4LogFile() );
    define('LOG_XPM4_ERRORS', serialize($arr));        
    require_once(ENGINE_DIR.'/XPertMailer/FUNC5.php');
    require_once(ENGINE_DIR.'/XPertMailer/MIME5.php');
    require_once(ENGINE_DIR.'/XPertMailer/SMTP5.php');

    ////////////////////////////////////////
    require_once ENGINE_DIR.'/PEAR/Console/Getopt.php';    
    $cg = new Console_Getopt();
    $allowedShortOptions = "";
    $allowedLongOptions = array('path=', 'to=');
    $args = $cg->readPHPArgv();
    $ret = $cg->getopt( $args, $allowedShortOptions, $allowedLongOptions);
    if ( PEAR::isError( $ret)) die ("Error in command line: " . $ret->getMessage() . "\n");

    $SCRIPT_CONFIG = array( 
        'path' =>  null,
        'to' =>  null,
    );

    $opts = $ret[0];
    if ( sizeof($opts) > 0 ) {
        foreach ($opts as $o) {
            switch ($o[0]) {
                case '--path':
                    if ( isset($o[1]) && trim($o[1]) != '' ) $SCRIPT_CONFIG['path'] = $o[1];
                    break;
                case '--to':
                    if ( isset($o[1]) && trim($o[1]) != '' ) $SCRIPT_CONFIG['to'] = trim($o[1]);
                    break;
                /*
                case '--re_register':
                    $SCRIPT_CONFIG['re_register'] = true;
                    break;
                */ 
            }
        }
    }
    $rawMessagesPath = ENGINE_DIR.'/../logs/raw_messages/';
    if ( !$SCRIPT_CONFIG['path'] ) throw new Exception('Please specify path to raw message to send.');
    if ( !file_exists($rawMessagesPath.$SCRIPT_CONFIG['path']) || !is_readable($rawMessagesPath.$SCRIPT_CONFIG['path']) ) {
        throw new Exception('Incorrect raw message path. File hasn\'t been found. Entered path "'.$SCRIPT_CONFIG['path'].'".');
    }
    ////////////////////////////////////////    
    
    try { $conn = SMTP5::connect(SMTP_HOST, SMTP_PORT); } 
    catch ( Exception $e ) {
        throw new Exception("Could not connect to SMTP server.");
    }               
    if ( !$conn ) {
        throw new Exception("Could not connect to SMTP server.");
    }
    
    if ( !file_exists( $rawMessagesPath.$SCRIPT_CONFIG['path'] ) ) {
        throw new Exception('File doesn\'t exists');
    }
    
    $message = file_get_contents( $rawMessagesPath.$SCRIPT_CONFIG['path'] );

    /* Form */
    preg_match('/From:\s{1,}(.*?)$/mi', $message, $matches);
    if ( !isset($matches[1]) || empty($matches[1]) ) {
        throw new Exception('Cannot find From:');
    }
    preg_match('/^(.*?)<(.*?)>/mi', $matches[1], $matches1);
    if ( isset($matches1[2]) && !empty($matches1[2]) ) $from = trim($matches1[2]);
    else $from = trim($matches[1]);
    
    /* To */
    if ( empty($SCRIPT_CONFIG['to']) ) {
        preg_match('/To:\s{1,}(.*?)$/mi', $message, $matches);
        if ( !isset($matches[1]) || empty($matches[1]) ) {
            throw new Exception('Cannot find To:');
        }
        preg_match('/^(.*?)<(.*?)>/mi', $matches[1], $matches1);
        if ( isset($matches1[2]) && !empty($matches1[2]) ) $to = array($matches1[2]);
        else $to = array( trim($matches[1]) );
    } else {
        $message = preg_replace('/To:\s{1,}(.*?)$/mi', 'To: '.$SCRIPT_CONFIG['to'], $message);
        $to = array( $SCRIPT_CONFIG['to'] );
    }
    
    try {                   
        $status = SMTP5::send($conn, $to, $message, $from);
        $smtpResult = $_RESULT;
    } catch ( Exception $e ) {   
        SMTP5::disconnect($conn);                               
        throw new Exception($e->getMessage());
    }
    
    /* 
     * some unknown error has been detected from smtp server
     * in this case we cannot sent this email and we must mark it as CANCELED 
     */        
    if ( $status === false ) {
        SMTP5::disconnect($conn);
        throw new Exception("Could not send email wia SMTP server.");
    } 
    /* 
     * certain error has been detected from smtp server, like incorrect recipient's mailbox
     * in this case we cannot sent this email and we must mark it as CANCELED 
     */
    elseif ( $status !== true ) {
        SMTP5::disconnect($conn);
        throw new Exception($status);
    }
        
    SMTP5::disconnect($conn);
    
    print_r($smtpResult);
    