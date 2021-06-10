<?php

return [
    'parameters' => [
        /**
         * Provide parameter value here
         * all fields are optional
         * @see \App\BuildingBlocks\ActionGenerator\MessageClassParameterParser for list of available fields
         * missing fields will automatically field by the parser
         */
        \Derhub\BusinessManagement\Business\Services\GetBusinessById\GetBusinessById::class => [
            'businessId' => [
                'alias' => 'id',
                'types' => ['string'],
                'rules' => ['required', 'uuid'],
            ],
//            'complicatedField' => [
//                'required' => true,
//                'default' => [1, 2, 3, 4, 5, 6],
//                'rules' => ['required', 'array', 'int'],
//            ],
        ],
    ],
];
