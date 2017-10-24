<?php

namespace pocketmine\entity;

use pocketmine\entity\projectile\Throwable;

class DragonFireball extends Throwable{
	const NETWORK_ID = self::DRAGON_FIREBALL;

	public $height = 1.5;
	public $width = 1.25;
	public $lenght = 0.906;//TODO

	public function getName(){
		return "Dragon Fireball";
	}
}