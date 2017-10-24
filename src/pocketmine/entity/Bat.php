<?php

namespace pocketmine\entity;


class Bat extends Animal{
	const NETWORK_ID = self::BAT;

	public $width = 0.469;
	public $length = 0.484;
	public $height = 0.5;

	public static $range = 16;
	public static $speed = 0.25;
	public static $jump = 1.8;
	public static $mindist = 3;

	public function initEntity(){
		$this->setMaxHealth(6);
		parent::initEntity();
	}

	public function getName(): string{
		return "Bat";
	}

}
