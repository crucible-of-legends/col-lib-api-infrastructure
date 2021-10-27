<?php

namespace COL\Library\Infrastructure\Common\Controller;

use Symfony\Component\Form\FormInterface;
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

    protected function getFormErrorResponse(FormInterface $form): JsonResponse
    {
        return new JsonResponse($this->getFormErrorsAsFormattedArray($form), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function getFormErrorsAsFormattedArray(FormInterface $form, int $level = 0)
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            if (0 === $level) {
                $errors['global'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        $fields = $form->all();
        foreach ($fields as $key => $child) {
            $error = $this->getFormErrorsAsFormattedArray($child, $level + 4);
            if ($error) {
                $errors[$key] = $error;
            }
        }

        return $errors;
    }
}
