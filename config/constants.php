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
    ]
];
