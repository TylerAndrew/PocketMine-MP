<?php

namespace pocketmine\entity;

class Endermite extends Monster{
	const NETWORK_ID = self::ENDERMITE;

	public $height = 0.438;
	public $width = 0.609;
	public $lenght = 1.094;

	protected $exp_min = 3;
	protected $exp_max = 3;

	public function initEntity(){
		$this->setMaxHealth(8);
		parent::initEntity();
	}

	public function getName(): string{
		return "Endermite";
	}
}
