<?php

namespace pocketmine\entity;

class Husk extends Zombie{
	const NETWORK_ID = self::HUSK;

	public $width = 1.031;
	public $length = 0.891;
	public $height = 2;

	protected $exp_min = 5;
	protected $exp_max = 5;

	public function initEntity(){
		$this->setMaxHealth(20);
		parent::initEntity();
	}

	public function getName(): string{
		return "Husk";
	}
}
