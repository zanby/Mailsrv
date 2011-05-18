<?php		
    ini_set("soap.wsdl_cache_enabled", "0");
    $home = realpath( dirname( __FILE__) . DIRECTORY_SEPARATOR . "..");
    define('ENGINE_DIR', $home.'/library');
    require_once ENGINE_DIR . '/bootstrap_script.php';
    require_once ENGINE_DIR . '/bootstrap.php';
    require_once ENGINE_DIR . '/Server/Client/Bootstrap.php';

    try {
        $client = new Server_Client_Bootstrap(SERVER_URL."/wsdl.php?t=template", array('timeout' => 600, 'trace' => 1) );
        $client->setUsername(CREDENTIAL_USERNAME);
        $client->setPassword(CREDENTIAL_PASSWORD);
    } catch ( Exception $ex ) { print $ex->getMessage(); exit; }
    
    try {        
        $tuid = $client->registerTemplate( 'html part', 'plain part', 'subject', 'en' );
        $client->setDescription( $tuid, 'description' );
        $request = $client->addLocalization( $tuid, 'ru', 'хтмл', 'плайн', 'ТТТТема сообщения NEW' );
        $request = $client->addEmbededImage( $tuid, 'ru',
            '3307e6dcf8c22a30ec79b9201f0963b5.gif', 
            file_get_contents('/home/sukharev/work_copy/cd/htdocs/upload/designs/gift/3307e6dcf8c22a30ec79b9201f0963b5.gif')
        );
        $client->activate( $tuid );
    } catch ( Exception $ex ) { 
        print $ex->getMessage();  exit; 
    }
    
    exit("\nEnd\n");