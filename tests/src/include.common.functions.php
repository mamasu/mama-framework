<?php

function callbackConfig() {
    $functionArguments = func_get_args();
    $conection1 = array('host'=>'localhost', 'port'=>'8889', 'name'=>'marketplace', 'user'=>'root', 'pass'=>'root');
    $conection2 = array('host'=>'localhost', 'port'=>'8889', 'name'=>'marketplace1', 'user'=>'root', 'pass'=>'root');
    $language   = array('paths'=>array('/language'),
                        'translateClass'=>'\Mmf\Language\Translator',
                        'languageClass'=>'Language',
                        'locale'=>array('spa','eng'),
                        'translatePath'=> __DIR__ . '/../../app/translate/');
    $return = array('db_default'   => $conection1,
                    'db_secondary' => $conection2,
                    'auth'         => array('sessionTimeLife' => 86400),
                    'language'     => $language,
                    'URLBase'      => '');
    return $return[$functionArguments[0]];
}

