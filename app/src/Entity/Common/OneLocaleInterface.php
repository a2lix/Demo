<?php

declare(strict_types=1);

namespace App\Entity\Common;

interface OneLocaleInterface
{
    public function getLocale(): string;

    public function setLocale(string $locale);
}
