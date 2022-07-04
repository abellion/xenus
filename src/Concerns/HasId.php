<?php

namespace Xenus\Concerns;

use MongoDB\BSON\ObjectID;

trait HasId
{
    /**
     * @return ObjectID
     */
    public function getId()
    {
        return $this->get('_id');
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId($id)
    {
        return $this->set('_id', new ObjectID($id));
    }
}
