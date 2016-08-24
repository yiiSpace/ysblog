<?php

return [
    'adminEmail' => 'admin@example.com',

    // 上传目录
    'uploadsDir'=>'@webroot/uploads',

    // @see https://github.com/tecnom1k3/sp-simple-jwt/blob/master/config/config.php.dist
    'jwt' => [
        'key'       => 'yiiblog',     // Key for signing the JWT's, I suggest generate it with base64_encode(openssl_random_pseudo_bytes(64))
        'algorithm' => 'HS512' // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
    ],
    'serverName' => 'yiiblog.com',
];
