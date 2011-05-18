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
require_once ENGINE_DIR.'/Dklab/SoapClient.php';
require_once ENGINE_DIR.'/Server/Model/Log.php';

class Server_Service_Tools
{
    /**
     * @return int
     */
	public function countRawMessages()
	{
		$ret = glob(ENGINE_DIR . '/../logs/raw_messages/*/*/*.log'); 
		return count($ret);
	}

    /**
     * @param string $date First string
     * @return int
     */
	public function countRawMessagesByDate($date)
	{
		$ret = glob(ENGINE_DIR . '/../logs/raw_messages/*/'.$date.'/*.log'); 
		return count($ret);
	}

    /**
     * @param int $campaignId First int
     * @return int
     */
	public function countRawMessagesByCampaign($campaignId)
	{
		$ret = glob(ENGINE_DIR . '/../logs/raw_messages/campaign_'.$campaignId.'/*/*.log'); 
		return count($ret);
	}

    /**
     * @param int $campaignId First int
     * @param string $date Second string
     * @return int
     */
	public function countRawMessagesByCampaignAndDate($campaignId, $date)
	{
		$ret = glob(ENGINE_DIR . '/../logs/raw_messages/campaign_'.$campaignId.'/'.$date.'/*.log'); 
		return count($ret);
	}

    /**
     * @param string $email First string
     * @return int
     */
	public function countRawMessagesByEmail($email)
	{
		$ret = glob(ENGINE_DIR . '/../logs/raw_messages/*/*/'.$email.'*.log'); 
		return count($ret);
	}

    /**
     * @param string $email First string
     * @param int $campaignId Second int
     * @return int
     */
	public function countRawMessagesByEmailAndCampaign($email, $campaignId)
	{
		$ret = glob(ENGINE_DIR . '/../logs/raw_messages/campaign_'.$campaignId.'/*/'.$email.'*.log'); 
		return count($ret);
	}

    /**
     * @param string $email First string
     * @param int $campaignId Second int
     * @param string $date Third string
     * @return int
     */
	public function countRawMessagesByEmailAndCampaignAndDate($email, $campaignId, $date)
	{
		$ret = glob(ENGINE_DIR . '/../logs/raw_messages/campaign_'.$campaignId.'/'.$date.'/'.$email.'*.log'); 
		return count($ret);
	}

    /**
     * @param string $email First string
     * @param string $date Second string
     * @return int
     */
	public function countRawMessagesByEmailAndDate($email, $date)
	{
		$ret = glob(ENGINE_DIR . '/../logs/raw_messages/*/'.$date.'/'.$email.'*.log'); 
		return count($ret);
	}

    /**
     * @return boolean
     */
	public function clearLogs()
	{
		exec('rm -rf '. ENGINE_DIR . '/../logs/*.log');
		
		return true;
	}

    /**
     * @return boolean
     */
	public function clearRawMessagesLog()
	{
		exec('rm -rf '. ENGINE_DIR . '/../logs/raw_messages/campaign_*');
		
		return true;
	}
	
    /**
     * @param string $logFile First string
     * @return boolean
     */
    public function backupLogs($logFile = 'messages')
    {
        date_default_timezone_set('UTC');
        $date = date('Y-m-d\THis').'_'.Server_Model_Log::getmicrotime();
        switch ( $logFile ) {
            case 'raw_messages' :
                exec('tar -zcvf '.ENGINE_DIR.'/../logs/raw_messages.'.$date.'.tar.gz '.ENGINE_DIR.'/../logs/raw_messages');
                exec('rm -rf '. ENGINE_DIR . '/../logs/raw_messages/campaign_*');
                break;
            case 'messages' :
                exec('tar -zcvf '.ENGINE_DIR.'/../logs/messages.log.'.$date.'.tar.gz '.ENGINE_DIR.'/../logs/messages.log');
                exec('rm -rf '. ENGINE_DIR . '/../logs/messages.log');
                break;
            case 'builder' :
                exec('tar -zcvf '.ENGINE_DIR.'/../logs/builder.log.'.$date.'.tar.gz '.ENGINE_DIR.'/../logs/builder.log');
                exec('rm -rf '. ENGINE_DIR . '/../logs/builder.log');
                break;
            case 'deliver' :
                exec('tar -zcvf '.ENGINE_DIR.'/../logs/deliver.log.'.$date.'.tar.gz '.ENGINE_DIR.'/../logs/deliver.log');
                exec('rm -rf '. ENGINE_DIR . '/../logs/deliver.log');
                break;
            case 'error_smtp' :
                exec('tar -zcvf '.ENGINE_DIR.'/../logs/deliver.log.'.$date.'.tar.gz '.ENGINE_DIR.'/../logs/error_smtp.log');
                exec('rm -rf '. ENGINE_DIR . '/../logs/error_smtp.log');
                break;
            default : 
                throw new SoapFault("HTTP", 'Incorrect log file');
        }        
        return true;
    }
	
}