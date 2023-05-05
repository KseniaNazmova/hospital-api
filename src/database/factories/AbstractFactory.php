<?php

namespace Database\Factories;

class AbstractFactory
{
    protected static function enrichParams(array $params, array $enrichment): array
    {
        foreach ($enrichment as $k => $v) {
            $params[$k] = $v;
        }

        return $params;
    }
}
