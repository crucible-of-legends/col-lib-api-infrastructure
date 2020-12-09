<?php

namespace COL\Library\Infrastructure\Common\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
    protected function buildResponse($data, bool $emptyResponse = false): JsonResponse
    {
        if (true === $emptyResponse) {
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return $this->toJSON($data);
    }

    private function toJSON($data): JsonResponse
    {
        if (null === $data) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        if (true === empty($data)) {
            return new JsonResponse([], Response::HTTP_OK);
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}