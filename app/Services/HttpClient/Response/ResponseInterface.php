<?php


namespace App\Services\HttpClient\Response;


interface ResponseInterface
{
    public function isClientError() : bool;

    public function isServerError() : bool;

    public function isOk() : bool;

    public function getBody() : string;

    public function json() : array;
}
