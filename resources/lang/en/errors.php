<?php

return [
    'show' => [
        'errors' => [
            [
                'code' => 404,
                'detail' => 'The URI requested is invalid or the resource requested does not exist.',
            ]
        ]
    ],
    'update' => [
        'errors' => [
            [
                'code' => 400,
                'detail' => 'Update request is invalid or cannot be otherwise served.',
            ]
        ]
    ],
    'create' => [
        'errors' => [
            [
                'code' => 400,
                'detail' => 'Create request is invalid or cannot be otherwise served.',
            ]
        ]
    ],
    'delete' => [
        'errors' => [
            [
                'code' => 400,
                'detail' => 'Delete request is invalid or cannot be otherwise served.',
            ]
        ]
    ],
    'forbidden' => [
        'errors' => [
            [
                'code' => 403,
                'detail' => 'This action is unauthorized.',
            ]
        ]
    ],
    'unknown' => [
        'errors' => [
            [
                'code' => 500,
                'detail' => 'An unknown error occurred. Check the logs for details.',
            ]
        ]
    ],
    'xclass' => [
        'errors' => [
            [
                'code' => 400,
                'detail' => 'Invalid class type.',
            ]
        ]
    ],
    'login' => [
        'errors' => [
            [
                'code' => 401,
                'detail' => 'Invalid email or password',
            ]
        ]
    ],
    'token' => [
        'errors' => [
            [
                'code' => 401,
                'detail' => 'Invalid token or expired.',
            ]
        ]
    ],
    'format' => [
        'errors' => [
            [
                'code' => 400,
                'detail' => 'Invalid data format.',
            ]
        ]
    ],
    'not_found' => [
        'errors' => [
            [
                'code' => 404,
                'detail' => 'Resource requested could not be found.'
            ]
        ]
    ]
];
