<?php

namespace pocketmine\entity;

class Silverfish extends Monster{
	const NETWORK_ID = self::SILVERFISH;

	public $height = 0.438;
	public $width = 0.609;
	public $lenght = 1.094;

	protected $exp_min = 5;
	protected $exp_max = 5;

	public function initEntity(){
		$this->setMaxHealth(8);
		parent::initEntity();
	}

	public function getName(): string{
		return "Silverfish";
	}
}
