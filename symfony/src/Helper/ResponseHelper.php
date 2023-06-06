<?php

namespace App\Helper;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Mapping\MappingException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseHelper
{

    private $om;

    public function __construct(EntityManagerInterface $om)
    {
        $this->om = $om;
    }

    public function successDelete($entity, int $code = 200): JsonResponse
    {

        $objectName = $this->om->getClassMetadata($entity)->getTableName();

        $response = new JsonResponse();

        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($code);
        $response->setData([
            'success' => true,
            'code' => $code,
            'message' => 'The '.$objectName.' was successfully deleted.',
        ]);

        return $response;
    }

    public function successUpdate($responseObject, $entity, int $code = 200): JsonResponse
    {

        $objectName = $this->om->getClassMetadata($entity)->getTableName();

        $response = new JsonResponse();

        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($code);
        $response->setData([
            'success' => true,
            'code' => $code,
            'message' => 'The '.$objectName.' was successfully updated.',
            'data' => $responseObject
        ]);

        return $response;
    }

    public function successCreate($responseObject, $entity, int $code = 201): JsonResponse
    {

        $objectName = $this->om->getClassMetadata($entity)->getTableName();

        $response = new JsonResponse();

        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($code);
        $response->setData([
            'success' => true,
            'code' => $code,
            'message' => 'The '.$objectName.' was successfully created.',
            'data' => $responseObject
        ]);

        return $response;
    }

    public function notFound($entity, int $code = 400): JsonResponse
    {

        $objectName = $this->om->getClassMetadata($entity)->getTableName();

        $response = new JsonResponse();

        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($code);
        $response->setData([
            'success' => false,
            'code' => $code,
            'message' => $objectName.' not found!',
        ]);

        return $response;
    }

    public function fieldRequired(string $field, int $code = 400): JsonResponse
    {

        $response = new JsonResponse();

        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($code);
        $response->setData([
            'success' => false,
            'code' => $code,
            'message' => $field.' is required!',
        ]);

        return $response;
    }

    public function allowedMimeType(string $field, array $mimeTypes, int $code = 415): JsonResponse
    {
        $response = new JsonResponse();

        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($code);
        $response->setData([
            'success' => false,
            'code' => $code,
            'message' => $field.' must be '.implode(', ', $mimeTypes).'!'
        ]);

        return $response;
    }

    public function alreadyExists($entity, int $code = 409): JsonResponse
    {

        $objectName = $this->om->getClassMetadata($entity)->getTableName();

        $response = new JsonResponse();

        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($code);
        $response->setData([
            'success' => false,
            'code' => $code,
            'message' => $objectName.' already exists!',
        ]);

        return $response;
    }

    public function customResponse($message, int $code = 400, $success = false): JsonResponse
    {

        $response = new JsonResponse();

        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($code);
        $response->setData([
            'success' => $success,
            'code' => $code,
            'message' => $message,
        ]);

        return $response;
    }

    public function customResponseWithToken($message, $token, int $code = 400, $success = false): JsonResponse
    {

        $response = new JsonResponse();

        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($code);
        $response->setData([
            'success' => $success,
            'code' => $code,
            'message' => $message,
            'token' => $token,
        ]);

        return $response;
    }

}