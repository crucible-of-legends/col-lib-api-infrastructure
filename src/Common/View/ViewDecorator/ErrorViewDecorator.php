<?php

namespace COL\Library\Infrastructure\Common\View\ViewDecorator;

use COL\Library\Contracts\View\Decor\ErrorViewDecor;
use COL\Library\Contracts\View\Decor\ViewDecorInterface;
use Symfony\Component\HttpFoundation\Response;

final class ErrorViewDecorator implements ViewDecorInterface
{
    public function decorate($data, bool $isDataNullable = true): ?ErrorViewDecor
    {
        if (null === $data && false === $isDataNullable) {
            return $this->buildNotFoundError();
        }

        return null;
    }

    private function buildNotFoundError(): ErrorViewDecor
    {
        $error = new ErrorViewDecor();
        $error->errorCode = Response::HTTP_NOT_FOUND;
        $error->errorMessages =  ['Object not found.'];

        return $error;
    }
}