<?php

namespace gallery\core\model;

use n2n\util\uri\Url;

class Breadcrumb {
	private $url;
	private $label;
	private $active;
	
	public function __construct(Url $url, string $label) {
		$this->url = $url;
		$this->label = $label;
	}
	
	public function getUrl() {
		return $this->url;
	}

	public function setUrl(Url $url) {
		$this->url = $url;
	}

	public function getLabel() {
		return $this->label;
	}

	public function setLabel(string $label) {
		$this->label = $label;
	}
	public function isActive() {
		return $this->active;
	}

	public function setActive(bool $active = false) {
		$this->active = (bool) $active;
	}
}