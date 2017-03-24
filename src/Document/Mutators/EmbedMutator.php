<?php

namespace Xenus\Document\Mutators;

trait EmbedMutator
{
	public function embed(string $embed)
	{
		return new class($embed, $this) {
			private $root, $embed;
			private $in, $on, $as;

			public function __construct($embed, $root)
			{
				$this->root = $root;
				$this->embed = $embed;
			}

			public function in($in)
			{
				$this->in = $in;

				return (isset($this->as)) ? $this->make() : $this;
			}

			public function on($on)
			{
				$this->on = $on;

				return (isset($this->as)) ? $this->make() : $this;
			}

			public function as($as)
			{
				$this->as = $as;

				return (isset($this->in) || isset($this->on)) ? $this->make() : $this;
			}

			private function make()
			{
				if (isset($this->on)) {
					return $this->makeOn();
				} else {
					return $this->makeIn();
				}
			}

			private function makeOn()
			{
				$on = ($this->on instanceof $this->embed) ? $this->on : new $this->embed($this->on);

				return $this->root->set($this->as, $on);
			}

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
