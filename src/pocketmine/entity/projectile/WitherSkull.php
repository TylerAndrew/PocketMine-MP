<?php

namespace pocketmine\entity;

use pocketmine\entity\projectile\Throwable;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;

class WitherSkull extends Throwable{
	const NETWORK_ID = self::WITHER_SKULL;

	public $width = 0.5;
	public $length = 0.5;
	public $height = 0.5;

	public function __construct(Level $level, CompoundTag $nbt){
		parent::__construct($level, $nbt);
	}
}