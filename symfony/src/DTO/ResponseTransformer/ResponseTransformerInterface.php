<?php
namespace App\DTO\ResponseTransformer;

interface ResponseTransformerInterface {

    public function transformObject($object);
    public function transformObjects(array $objects);
}