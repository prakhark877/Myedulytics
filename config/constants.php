<?php

use Carbon\Carbon;

return [
    'WEBSITE_URL' => "//13.200.47.71/",
    'AWS_CREDENTIALS' => [
        'IDENTITYPOOLID' => "ap-south-1:6cfbe6e5-6132-4178-9059-bfcf1655c107",
        'TOKENDURATION' => 86400,
        //1440,
        'PROVIDERNAME' => 'littleedventure',
        'S3BUCKET' => [
            'PUBLIC' => "littleedvanture",
            'PRIVATE' => "littleedvanture",
            'REGION' => "ap-south-1"
        ],
        'CLOUDFRONTURL' => "https://d2vmtwtvjnckox.cloudfront.net",
        'REGION' => "ap-south-1"
    ],
    'AGE_GROUP' =>[
        ['name' => 'Ages 9–14', 'min' => 9, 'max' => 14, 'value' => '1'],
        ['name' => 'Ages 8–16', 'min' => 8, 'max' => 16, 'value' => '2'],
        ['name' => 'Ages 12–18', 'min' => 12, 'max' => 18, 'value' => '3'],
        ['name' => 'Ages 14–18', 'min' => 14, 'max' => 18, 'value' => '4'],
    ]
        
];
