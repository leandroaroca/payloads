<?php

return [
    [
        'url' => '/oauth/token ',
        'method' => 'POST',
        'params' => [
            'grant_type',
            'username',
            'password',
            'scope',
            'client_id',
            'client_secret',
        ],
        'query_params' => [],
        'oauth' => false,
        'description' => 'Generate user token. With the required data, you must consume the endpoint. With the generated token, you can later make requests by sending that same token as an authentication header "Authorization: Bearer {TOKEN}"',
    ],
    [
        'url' => '/api/user',
        'method' => 'GET',
        'params' => [],
        'query_params' => [],
        'oauth' => true,
        'description' => 'Get current user',
    ],
    [
        'url' => '/api/payload',
        'method' => 'POST',
        'params' => [],
        'query_params' => [],
        'oauth' => true,
        'description' => 'Save payload. Send hexadecimal in the content of the request. View README.md',
    ],
    [
        'url' => '/api/payload',
        'method' => 'GET',
        'params' => [],
        'query_params' => [
            'sort' => [
                'asc' => [
                    'lat',
                    'lng',
                    'from',
                    'origin',
                    'address',
                    'created_at',
                ],
                'desc' => [
                    '-lat',
                    '-lng',
                    '-from',
                    '-origin',
                    '-address',
                    '-created_at',
                ],
                'example' => [
                    '?sort=lat',
                    '?sort=-lat',
                ],
            ],
            'filter' => [
                'created_at',
                'created_at_between',
                'example' => [
                    '?filter[created_at_between]=2021-05-09,2021-05-10',
                ],
            ]
        ],
        'oauth' => true,
        'description' => 'List payloads paginate.',
    ],
];
