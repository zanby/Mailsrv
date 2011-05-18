<?php
    ini_set("soap.wsdl_cache_enabled", "0");
    $home = realpath( dirname( __FILE__) . DIRECTORY_SEPARATOR . "..");
    define('ENGINE_DIR', $home.'/library');
    require_once ENGINE_DIR . '/bootstrap_script.php';
    require_once ENGINE_DIR . '/bootstrap.php';
    require_once ENGINE_DIR . '/Server/Client/Bootstrap.php';

    try {
        $client = new Server_Client_Bootstrap(SERVER_URL."/wsdl.php?t=tools", array('timeout' => 600, 'trace' => 1) );
        $client->setUsername(CREDENTIAL_USERNAME);
        $client->setPassword(CREDENTIAL_PASSWORD);
    } catch ( Exception $ex ) { print $ex->getMessage(); exit; }
    
    try {        
        $request = $client->countRawMessages();
        print "\n countRawMessages : "; print_r($request); 
        
        $request = $client->countRawMessagesByCampaign(320);
        print "\n countRawMessagesByCampaign : "; print_r($request);
        
        $request = $client->countRawMessagesByDate('2010-01-13');
        print "\n countRawMessagesByDate : "; print_r($request);

        $request = $client->countRawMessagesByCampaignAndDate(320, '2010-01-13');
        print "\n countRawMessagesByCampaignAndDate : "; print_r($request);

        $request = $client->countRawMessagesByEmail('artem.sukharev+0@warecorp.com');
        print "\n countRawMessagesByEmail : "; print_r($request);

        $request = $client->countRawMessagesByEmailAndCampaign('artem.sukharev+0@warecorp.com', 320);
        print "\n countRawMessagesByEmailAndCampaign : "; print_r($request);

        $request = $client->countRawMessagesByEmailAndCampaignAndDate('artem.sukharev+0@warecorp.com', 320, '2010-01-13');
        print "\n countRawMessagesByEmailAndCampaignAndDate : "; print_r($request);

        $request = $client->countRawMessagesByEmailAndDate('artem.sukharev+0@warecorp.com', '2010-01-13');
        print "\n countRawMessagesByEmailAndDate : "; print_r($request);

        //$request = $client->clearLogs();
        //$request = $client->clearRawMessagesLog();
    } catch ( Exception $ex ) { 
        print $ex->getMessage();  exit; 
    }
    
    exit("\nEnd\n");