<?php

use App\LogStandardize\Collectors\RequestCollector;
use App\LogStandardize\Collectors\ResponseCollector;
use Kkday\Log\Laravel\Collectors\TraceCollector;
use Kkday\Log\Laravel\Collectors\ExceptionCollector;
use Kkday\Log\Laravel\Collectors\OutboundCollector;
use Kkday\Log\Laravel\CustomStandardizeFormatter;
use Kkday\Log\Laravel\Transformers\DefaultTransformer;
use Kkday\Log\Laravel\Transformers\DefaultJsonResponseTransformer;

return [
    'collectors' => [
        'request' => RequestCollector::class,
        'response' => ResponseCollector::class,
        'trace' => TraceCollector::class,
        'exception' => ExceptionCollector::class,
        'outbound' => OutboundCollector::class,
    ],

    'formatter' => CustomStandardizeFormatter::class,

    'custom_params' => [
        // 'refer' => 'string'
    ],

    'dont_trim_text_list' => [
        // 'request.headers' => true,
    ],

    'split_length' => CustomStandardizeFormatter::SPLIT_LENGTH,

    'split_field_list' => [
        // 'response.body' => true,
    ],

    'options' => [
        'enable' => true,
        'outbound' => [
            'enable' => false,
            'host_transformers' => [
                // host(support * as wildcard) => Transformer
                // e.g. 'api-product*.kkday.com' => DefaultTransformer::class
                // e.g. 'svc-common*.kkday.com' => DefaultJsonResponseTransformer::class
            ],
        ],
    ],
];
