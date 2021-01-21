<?php


namespace App\Services\ResourceService\Interfaces;


interface ResourceServiceInterface
{
    public function store(array $data);

    public function delete(int $resourceId);

    public function get(array $options);

    public function update(int $id, array $data);
}
