<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function get($uri, array $headers = [])
    {
        return parent::get(
            uri: value(value: $uri),
            headers: $headers,
        );
    }

    public function post($uri, array $data = [], array $headers = [])
    {
        return parent::post(
            uri: value(value: $uri),
            data: $data,
            headers: $headers,
        );
    }

    public function patch($uri, array $data = [], array $headers = [])
    {
        return parent::patch(
            uri: value(value: $uri),
            data: $data,
            headers: $headers,
        );
    }
}
