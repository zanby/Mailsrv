<?php
    ini_set("soap.wsdl_cache_enabled", "0");
    $home = realpath( dirname( __FILE__) . DIRECTORY_SEPARATOR . "..");
    define('ENGINE_DIR', $home.'/library');
    require_once ENGINE_DIR . '/bootstrap_script.php';
    require_once ENGINE_DIR . '/bootstrap.php';
    require_once ENGINE_DIR . '/Server/Client/Bootstrap.php';

    try {
        $client = new Server_Client_Bootstrap(SERVER_URL."/wsdl.php?t=bootstrap", array('timeout' => 600, 'trace' => 1) );
        $client->setUsername(CREDENTIAL_USERNAME);
        $client->setPassword(CREDENTIAL_PASSWORD);
    } catch ( Exception $ex ) { print $ex->getMessage(); exit; }
    
    try {
        //$request = $client->startBuilder(BUILDER_THREADS, BUILDER_ITERATIONS, BUILDER_EXECUTION_TIME);
        //$request = $client->startDeliver(DELIVER_THREADS, DELIVER_ITERATIONS, DELIVER_EXECUTION_TIME);
        $request = $client->startBuilder(1, 1, 0);
        $request = $client->startDeliver(1, 1, 0);
    } catch ( Exception $ex ) { 
        print $ex->getMessage();  exit; 
    }
    
    exit("\nEnd\n");