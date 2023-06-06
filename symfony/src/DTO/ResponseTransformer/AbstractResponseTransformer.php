<?php
namespace App\DTO\ResponseTransformer;

use App\DTO\ResponseTransformer\ResponseTransformerInterface;

abstract class AbstractResponseTransformer implements ResponseTransformerInterface {

    public function transformObjects($objects): array
    {
        return array_map(function ($object){
            return $this->transformObject($object);
        },$objects);
    }
}