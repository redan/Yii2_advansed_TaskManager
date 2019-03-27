<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'bot' => [
            'class' => \SonkoDmitry\Yii\TelegramBot\Component::class,
            'apiToken' => '879312686:AAHGoCiOHUZ7h1bx-aeEKK0Ylu6uZMlp_i8',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
