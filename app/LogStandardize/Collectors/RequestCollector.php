<?php

namespace App\LogStandardize\Collectors;

use Illuminate\Support\Facades\Route;
use Kkday\Log\Laravel\Collectors\RequestCollector as BaseRequestCollector;
use Kkday\Log\Laravel\Collectors\Traits\FormatLaravelHeaders;

class RequestCollector extends BaseRequestCollector
{
    use FormatLaravelHeaders;

    protected function prepareRequestHeaders()
    {
        return $this->formatHeaders($this->request->headers->all());
    }

    protected function prepareRequestRoute()
    {
        if (null === Route::current()) {
            return implode(' ', array_slice($this->request->server()['argv'], 0, 2));
        }
        return Route::current()->uri();
    }

    protected function prepareRequestUrl()
    {
        if (null === Route::current()) {
            return implode(' ', $this->request->server()['argv']);
        }
        return $this->request->fullUrl();
    }

    protected function prepareRequestBody()
    {
        return $this->request->all();
    }
}
