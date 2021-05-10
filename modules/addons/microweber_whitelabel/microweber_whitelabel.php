<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function microweber_whitelabel_config()
{
    $config = array(
        'name' => 'Microweber Whitelabel',
        'description' => 'This module allows to setup whitelabel whmcs',
        'version' => '1.0',
        'author' => 'Microweber',
        'language' => 'english',
        'fields' => [
            'free_subdomains' => [
                'FriendlyName' => 'Free sub domains',
                'Type' => 'text',
                'Description' => 'Type your free sub domains seperated by coma.',
            ],
            'primary_color' => [
                'FriendlyName' => 'Primary Color',
                'Type' => 'text',
            ],
            'dark_color' => [
                'FriendlyName' => 'Dark Color',
                'Type' => 'text',
            ],
            'white_color' => [
                'FriendlyName' => 'White Color',
                'Type' => 'text',
            ]
       ]
    );
    
    return $config;
}