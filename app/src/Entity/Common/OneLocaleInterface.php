<?php

namespace App\Entity\Common;

interface OneLocaleInterface
{
    public function getLocale();

    public function setLocale($locale);
}