<?php


namespace App\Services\HttpClient\Request;


use App\Services\HttpClient\Response\ResponseInterface;

interface RequestInterface
{
    public function get(string $url, array $data) : ResponseInterface;

    public function post(string $url, array $data) : ResponseInterface;

    public function put(string $url, array $data) : ResponseInterface;

    public function patch(string $url, array $data) : ResponseInterface;

    public function delete(string $url) : ResponseInterface;
}
