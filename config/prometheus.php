<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Namespace
    |--------------------------------------------------------------------------
    |
    | The namespace to use as a prefix for all metrics.
    |
    | This will typically be the name of your project, eg: 'laravel'.
    |
    */

    'namespace' => env('PROMETHEUS_NAMESPACE'),

    /*
    |--------------------------------------------------------------------------
    | File
    |--------------------------------------------------------------------------
    |
    | If file.enabled is true then Outputs all metrics in the File.
    |
    | File Path = file.path + file.prefix + file.metrics.*
    |
    | Sample:
    |  path = /tmp/
    |  prefix = prometheus.metrics
    |  metrics = ['default' => 'test']
    |  The File Path is /tmp/prometheus.metrics-test
    |
    | Advance Sample(simple):
    |  path = /tmp/
    |  prefix = prometheus.metrics
    |  metrics = ['example-simple' => ['mode' => Prometheus::FILE_METRICS_MODE_SIMPLE, 'value' => 'simple']]
    |  The File Path is /tmp/prometheus.metrics-simple
    |
    | Advance Sample(multi):
    |  path = /tmp/
    |  prefix = prometheus.metrics
    |  metrics = ['example-multi' => ['mode' => Prometheus::FILE_METRICS_MODE_MULTI, 'value' => 'multi']]
    |  pid = 1010
    |  The File Path is /tmp/prometheus.metrics-multi-1010
    */
    'file' => [
        'enabled' => false,
        'path' => sys_get_temp_dir() . '/',
        'prefix' => env('PROMETHEUS_FILE_PREFIX', 'prometheus.metrics'),
        'metrics' => [
            /**
             * 預設 mode 為 simple
             */
            'default' => 'default',
            /**
             * cli command 類型，只能紀錄 Gauge 類型的 metrics
             * mode: Prometheus::FILE_METRICS_MODE_SIMPLE
             */
            'cli' => [
                'mode' => \Kkday\Monitor\Prometheus\Prometheus::FILE_METRICS_MODE_SIMPLE,
                'value' => 'cli'
            ],
            /**
             * cli daemon 類型，如 queue:work
             * 單台機器只有一個 Process
             * mode: Prometheus::FILE_METRICS_MODE_SIMPLE
             */
            'daemon-one-worker' => [
                'mode' => \Kkday\Monitor\Prometheus\Prometheus::FILE_METRICS_MODE_SIMPLE,
                'value' => 'daemon-one-worker',
            ],
            /**
             * cli daemon 類型，如 queue:work
             * 單台機器可有多個 Process，使用 pid 做為區隔
             * label 內需有 pid 切開 metrics data
             * mode: Prometheus::FILE_METRICS_MODE_MULTI
             */
            'daemon-multi-worker' => [
                'mode' => \Kkday\Monitor\Prometheus\Prometheus::FILE_METRICS_MODE_MULTI,
                'value' => 'daemon-multi-worker',
            ],
        ]
    ],

    'options' => [
        'enable' => true,
        'db' => [
            'enable' => true,
        ],
        'redis' => [
            'enable' => true,
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
                 *     'class' => \Kkday\Monitor\Laravel\Transformers\DefaultTransformer::class,
                 *     'options' => [
                 *         'path_mapping_group' => [
                 *             '/v1/api/order/*' => 'order',
                 *         ],
                 *     ],
                 * ],
                 */

                /**
                 * method 3.
                 * use CustomTransformer implements \Kkday\Monitor\Laravel\Transformers\OutboundTransformer
                 * 'host.method.2' => [
                 *     'class' => CustomTransformer::class,
                 *     'options' => [
                 *     ],
                 * ],
                 */
            ],
        ],
    ],
];
