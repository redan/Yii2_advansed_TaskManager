<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require_once(__DIR__ . '/../../common/config/bootstrap.php');
$_SERVER['SCRIPT_FILENAME'] = realpath(Yii::getAlias('frontend/web/index.php'));
$_SERVER['SCRIPT_NAME'] = '/'.basename($_SERVER['SCRIPT_FILENAME']);
return [
    'id' => 'app-frontend-tests',
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
        ],
    ],
];

