<?php

namespace pocketmine\entity;

use pocketmine\entity\projectile\ProjectileSource;

class EnderDragon extends Boss implements ProjectileSource{
	const NETWORK_ID = self::ENDER_DRAGON;

	public $height = 2;
	public $width = 3;
	public $lenght = 1;//TODO

	protected $exp_min = 12500;
	protected $exp_max = 12500;

	public function initEntity(){
		$this->setMaxHealth(200);
		parent::initEntity();
	}

	public function getName(): string{
		return "Ender Dragon";
	}
}
