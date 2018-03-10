<?php

namespace Xenus\Concerns;

use MongoDB\BSON\ObjectID;

trait HasId
{
    public function getId()
    {
        return $this->get('_id');
    }

    public function setId($id)
    {
        return $this->set('_id', new ObjectID($id));
    }
}
