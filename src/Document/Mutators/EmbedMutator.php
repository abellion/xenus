<?php

namespace Xenus\Document\Mutators;

trait EmbedMutator
{
    /**
     * Returns an utility to embed the given document class to an array
     *
     * @param  string $embed Adocument class
     *
     * @return object
     */
    public function embed(string $embed)
    {
        return new class($embed, $this) {
            private $root, $embed;
            private $in, $on, $as;

            /**
             * @param string $embed The document's class name to use when embeding
             * @param Xenus\Document $root  The document's instance
             */
            public function __construct($embed, $root)
            {
                $this->root = $root;
                $this->embed = $embed;
            }

            /**
             * Defines the array to work with
             *
             * @param  array $in The array to work with
             *
             * @return mixed This class instance or the document instance
             */
            public function in($in)
            {
                $this->in = $in;

                return (isset($this->as)) ? $this->make() : $this;
            }

            /**
             * Defines the array to work with
             *
             * @param  array $in The array to work with
             *
             * @return mixed This class instance or the document instance
             */
            public function on($on)
            {
                $this->on = $on;

                return (isset($this->as)) ? $this->make() : $this;
            }

            /**
             * Defines the key to use when setting the value
             *
             * @param  string $as The key to use when setting the value

             * @return mixed This class instance or the document instance
             */
            public function as($as)
            {
                $this->as = $as;

                return (isset($this->in) || isset($this->on)) ? $this->make() : $this;
            }

            /**
             * Calls one of `makeOn` or `makeIn` method
             *
             * @return Xenus\Document
             */
            private function make()
            {
                if (isset($this->on)) {
                    return $this->makeOn();
                } else {
                    return $this->makeIn();
                }
            }

            /**
             * Apply the given document on the array
             *
             * @return Xenus\Document
             */
            private function makeOn()
            {
                $on = ($this->on instanceof $this->embed) ? $this->on : new $this->embed($this->on);

                return $this->root->set($this->as, $on);
            }

            /**
             * Apply the given document in each array value
             *
             * @return Xenus\Document
             */
            private function makeIn()
            {
                $in = [];

                foreach ($this->in as $key => $value) {
                    $in[$key] = ($value instanceof $this->embed) ? $value : new $this->embed($value);
                }

                return $this->root->set($this->as, $in);
            }
        };
    }
}
