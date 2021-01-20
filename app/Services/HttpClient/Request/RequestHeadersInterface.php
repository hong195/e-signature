<?php


namespace App\Services\HttpClient\Request;


interface RequestHeadersInterface
{
    public function setHeaders(array $headers);
}
