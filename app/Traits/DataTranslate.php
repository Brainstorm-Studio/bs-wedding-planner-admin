<?php

namespace App\Traits;

trait DataTranslate
{
    public function getDataTranslated($data)
    {
        $translateData = $data->translations;
        return $translateData;
    }
}
