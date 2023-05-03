<?php

namespace App\Entities\Interfaces;

interface PrePersistable
{
    public function prePersist(): void;

    public function preUpdate(): void;
}
