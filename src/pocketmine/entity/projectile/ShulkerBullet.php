<?php

namespace pocketmine\entity;

use pocketmine\entity\projectile\Throwable;

class ShulkerBullet extends Throwable{
	const NETWORK_ID = self::SHULKER_BULLET;

	public $width = 0.5;
	public $length = 0.5;
	public $height = 0.5;

	public function getName(): string{
		return "Shulker Bullet";
	}
}