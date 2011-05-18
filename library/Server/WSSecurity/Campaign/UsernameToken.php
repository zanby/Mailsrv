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
require_once ENGINE_DIR . '/Server/WSSecurity/UsernameToken.php';

class Server_WSSecurity_Campaign_UsernameToken extends Server_WSSecurity_UsernameToken
{
    protected function validate()
    {        
        $this->is_validated = true;
        
        if ( !$this->getUsername() ) return false;
        if ( !$this->getPassword() ) return false;
        
        try { $db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); } 
        catch ( PDO_Exception $e ) { 
            $db = NULL;
            throw $e;
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $select_sql = "SELECT password FROM mail_accounts WHERE username = :username AND status = 'active'";
        $stmt = $db->prepare($select_sql);
        $stmt->bindParam(':username', $this->getUsername());
        try { $stmt->execute(); } 
        catch ( PDOException $e ) { $db = NULL; return false; }       
        
        $result = $stmt->fetchColumn();
        if ( !$result ) return false;

        if ( $result == $this->getPassword() ) return true;
        
        return false;
    }
}