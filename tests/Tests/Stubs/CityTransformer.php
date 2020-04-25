<?php

namespace Xenus\Tests\Tests\Stubs;

class CityTransformer extends \Xenus\Document
{
    public function setId($id)
    {
        return $this->set('_id', (string) $id);
    }

    public function setZip($zip)
    {
        return $this->set('zip_code', $zip);
    }
}

