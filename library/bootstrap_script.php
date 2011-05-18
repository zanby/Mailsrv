<?php
    $configPath = ENGINE_DIR."/../config/cfg.script.xml";
    if ( !is_readable($configPath) ) throw new Exception('Can not read configuration file "'.$configPath.'"');
    $xml = simplexml_load_file($configPath);
    
    if ( !defined('APPLICATION_ENV') ) {
        if ( !isset($xml->application_env) || !$xml->application_env ) throw new Exception('Incorrect configuration file "'.$configPath.'"');
        define('APPLICATION_ENV', $xml->application_env);
    }

    if ( !isset($xml->credentials) || !$xml->credentials ) throw new Exception('Incorrect configuration file "'.$configPath.'". Please fill credentials.');
    if ( !isset($xml->credentials->uid) || !$xml->credentials->uid ) throw new Exception('Incorrect configuration file "'.$configPath.'". Please fill credentials username.');
    if ( !isset($xml->credentials->pass) || !$xml->credentials->pass ) throw new Exception('Incorrect configuration file "'.$configPath.'". Please fill credentials password.');
        
    define('CREDENTIAL_USERNAME', $xml->credentials->uid);
    define('CREDENTIAL_PASSWORD', $xml->credentials->pass);