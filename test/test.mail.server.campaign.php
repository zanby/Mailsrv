<?php
    ini_set("soap.wsdl_cache_enabled", "0");
    $home = realpath( dirname( __FILE__) . DIRECTORY_SEPARATOR . "..");
    define('ENGINE_DIR', $home.'/library');
    require_once ENGINE_DIR . '/bootstrap_script.php';
    require_once ENGINE_DIR . '/bootstrap.php';
    require_once ENGINE_DIR . '/Server/Client/Bootstrap.php';

    try {
        $client = new Server_Client_Bootstrap(SERVER_URL."/wsdl.php?t=service", array('timeout' => 60, 'trace' => 1) );
        $client->setUsername(CREDENTIAL_USERNAME);
        $client->setPassword(CREDENTIAL_PASSWORD);
    } catch ( Exception $ex ) { print $ex->getMessage(); exit; }
    
    try {        
        $uid = $client->createCampaign();
        $request = $client->setSender($uid, 'artem.sukharev@warecorp.com', 'Artem Sukharev');
        $request = $client->setSubject($uid, 'Subject of email message');
        //$request = $client->setTemplate($uid, 'e1ae6fdf624b7cc6210796daa5e37099');
        $request = $client->setHtml($uid, 'HTML Part');
        $request = $client->setPlain($uid, 'Plain Part');
        
        //******************
        $request = $client->addParam($uid, 'site_param', 'site_param_value');
        $params = array(
            'site_name' => 'My Site',
            'site_url' => 'http:://warecorp.com',
            'logo_image' => 'http://warecorp.com/images/Logo.gif'
        );
        $request = $client->addParams($uid, $params);

        //******************        
        $request = $client->addEmbededImage($uid, 
            '3307e6dcf8c22a30ec79b9201f0963b5.gif', 
            file_get_contents('/home/sukharev/work_copy/cd/htdocs/upload/designs/gift/3307e6dcf8c22a30ec79b9201f0963b5.gif')
        );          
        
        //******************
        $request = $client->addRecipient($uid, array(
            'email' => 'artem.sukharev+000@warecorp.com',
            'name' => 'Artem Sukharev',
            'params' => array(
                'firstname' => 'Artem000',
                'lastname' => 'Sukharev000',
                'accesscode' => 'access code000'            
            )
        ));        
        $recipients = array();
        for ( $i = 0; $i < 9999; $i++ ) {
            $recipients[] = array(
                'email' => 'artem.sukharev+'.$i.'@warecorp.com',
                'name' => 'Artem Sukharev',
                'locale' => 'en',
                'params' => array(
                    'firstname' => 'Artem'.$i,
                    'lastname' => 'Sukharev'.$i,
                    'accesscode' => 'access code'.$i
                )
            );
        }
        $request = $client->addRecipients($uid, $recipients);

        //******************
        $request = $client->startCampaign($uid);        
    } catch ( Exception $ex ) { 
        print $ex->getMessage();  exit; 
    }
    
    exit("\nEnd\n");
