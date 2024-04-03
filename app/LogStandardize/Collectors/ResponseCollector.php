<?php

namespace App\LogStandardize\Collectors;

use Illuminate\Support\Arr;
use Kkday\Log\Laravel\Collectors\ResponseCollector as BaseResponseCollector;
use Kkday\Log\Laravel\Collectors\Traits\FormatLaravelHeaders;

class ResponseCollector extends BaseResponseCollector
{
    use FormatLaravelHeaders;

    protected function prepareResponseHeaders()
    {
        return $this->formatHeaders($this->response->headers->all());
    }

    protected function prepareResponseBody()
    {
        // 注意 $this->response->getContent() 與 $this->response->getOriginContent() 的差異
        $responseBody = json_decode($this->response->getContent(), true);
        if (!is_array($responseBody)) {
            return $this->response->getContent();
        }
        return $responseBody;
    }

    protected function prepareResponseMetaStatus()
    {
        return Arr::get($this->prepareResponseBody(), 'metadata.status');
    }

    protected function prepareResponseMetaDescription()
    {
        return Arr::get($this->prepareResponseBody(), 'metadata.desc');
    }
}
