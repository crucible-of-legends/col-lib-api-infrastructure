<?php

namespace COL\Library\Infrastructure\Common\View\ViewFormatter;

trait DateViewFormatterTrait
{
    protected function dateTimeString(?\DateTimeInterface $dateTime): string
    {
        if (null === $dateTime) {
            return '';
        }

        return $dateTime->format($this->displayFormats['datetime']);
    }

    protected function dateString(?\DateTimeInterface $dateTime): string
    {
        if (null === $dateTime) {
            return '';
        }

        return $dateTime->format($this->displayFormats['date']);
    }
}