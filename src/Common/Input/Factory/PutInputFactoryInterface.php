<?php

namespace COL\Library\Infrastructure\Common\Input\Factory;

use COL\Library\Infrastructure\Common\DTO\BaseDTOInterface;
use COL\Library\Infrastructure\Common\Input\Model\InputModelInterface;

interface PutInputFactoryInterface
{
    public function build(BaseDTOInterface $dto): InputModelInterface;
}