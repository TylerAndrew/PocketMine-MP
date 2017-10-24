<?php

namespace pocketmine\entity;

use pocketmine\entity\projectile\Projectile;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;

class FishingHook extends Projectile{
	const NETWORK_ID = self::FISHING_HOOK;
	public $width = 0.25;
	public $length = 0.25;
	public $height = 0.25;
	protected $gravity = 0.1;
	protected $drag = 0.05;
	public $data = 0;
	public $attractTimer = 100;
	public $coughtTimer = 0;
	public $damageRod = false;

	public function __construct(Level $level, CompoundTag $nbt, Entity $shootingEntity = null){
		parent::__construct($level, $nbt, $shootingEntity);
	}
}
