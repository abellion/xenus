<?php

namespace Xenus\Document;

use MongoDB\BSON\ObjectID;

trait HasId
{
    /**
     * Get the document's ID
     * @return mixed
     */
    public function getId()
    {
        return $this->get('_id');
    }

    /**
     * Set the document's ID
     * @param mixed $id
     * @return self
     */
    public function setId($id)
    {
        return $this->set('_id', new ObjectID($id));
    }
}
