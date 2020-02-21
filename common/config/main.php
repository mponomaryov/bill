<?php
return [
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'class' => 'common\components\Formatter',
            'dateFormat' => 'dd.MM.yyyy',
        ],
        'response' => [
            'formatters' => [
                'html' => [
                    'class' => 'yii\web\HtmlResponseFormatter',
                ],
                'pdf' => [
                    'class' => 'robregonm\pdf\PdfResponseFormatter',
                    'marginLeft' => 15,
                    'marginRight' => 10,
                ],
            ],
        ],
    ],
];
