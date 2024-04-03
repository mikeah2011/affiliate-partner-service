<?php

use Kkday\Tracing\Tracing\Sampler\SamplerOptions;

return [
    /**
     * Trace service name.
     * use env APP_NAME
     */
    'service' => env('APP_NAME', 'tracing-sdk-php'),

    /**
     * Jaeger Agent Server Host and Port.
     */
    'connection' => env('JAEGER_AGENT', '0.0.0.0:6831'),

    /**
     * Header keys
     * name: trace id
     * prefix: baggage prefix
     */
    'headers' => [
        'name' => 'kkday-trace-id',
        'baggage_prefix' => 'kkdayctx-',
    ],

    /**
     * sampler options
     * default: const
     */
    'sampler' => SamplerOptions::const(true),

    /**
     * max finished span size for flush
     */
    'max_finished_span_size' => 500,

    'options' => [
        'enable' => true,
        'db' => [
            'enable' => false,
            'slow_query_ms' => 2000,
        ],
        'redis' => [
            'enable' => false,
            'slow_query_ms' => 30,
        ],
        'event' => [
            'enable' => false,
            'wildcard_events' => [
                'App\*',
            ]
        ],
        'queue' => [
            'enable' => false,
        ],
        'command' => [
            'enable' => false,
            'except' => [
                'queue:work'
            ],
        ],
        'outbound' => [
            'enable' => false,
            'host_transformers' => [
                /**
                 * method 1.
                 * use DefaultTransformer
                 * 'host.method.1' => [
                 *     '/v1/api/order/*' => 'order'
                 * ],
                 */

                /**
                 * method 2.
                 * use DefaultTransformer with complete structure
                 * 'host.method.2' => [
                 *     'class' => \Kkday\Tracing\Laravel\Transformers\DefaultTransformer::class,
                 *     'options' => [
                 *         'path_mapping_group' => [
                 *             '/v1/api/order/*' => 'order',
                 *         ],
                 *     ],
                 * ],
                 */

                /**
                 * method 3.
                 * use CustomTransformer implements \Kkday\Tracing\Laravel\Transformers\OutboundTransformer
                 * 'host.method.3' => [
                 *     'class' => CustomTransformer::class,
                 *     'options' => [
                 *     ],
                 * ],
                 */
            ],
        ]
    ],
];
