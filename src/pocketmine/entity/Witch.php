<?php

namespace pocketmine\entity;

use pocketmine\entity\projectile\ProjectileSource;

class Witch extends Monster implements ProjectileSource{
	const NETWORK_ID = self::WITCH;

	public $width = 0.938;
	public $length = 0.609;
	public $height = 2;

	protected $exp_min = 5;
	protected $exp_max = 5;

	public function initEntity(){
		$this->setMaxHealth(20);
		parent::initEntity();
	}

	public function getName(): string{
		return "Witch";
	}

	public function getDrops(): array{
		return [];//TODO: Drops
	}
}
