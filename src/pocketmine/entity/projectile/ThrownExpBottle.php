<?php

namespace pocketmine\entity;

use pocketmine\entity\projectile\Throwable;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ShortTag;

class ThrownExpBottle extends Throwable{
	const NETWORK_ID = 68;

	public $width = 0.25;
	public $length = 0.25;
	public $height = 0.25;

	protected $gravity = 0.1;
	protected $drag = 0.05;

	public function getName(){
		return "Thrown Exp Bottle";
	}

	public function onUpdate(int $currentTick): bool{
		if ($this->closed){
			return false;
		}

		$this->timings->startTiming();

		$hasUpdate = parent::entityBaseTick();

		if ($this->onGround){
			$this->kill();
			$this->close();
			$nbt = new CompoundTag("", [
				new ListTag("Pos", [
					new DoubleTag("", $this->getX()),
					new DoubleTag("", $this->getY() + 1),
					new DoubleTag("", $this->getZ())
				]),
				new ListTag("Motion", [
					new DoubleTag("", 0),
					new DoubleTag("", 0),
					new DoubleTag("", 0)
				]),
				new ListTag("Rotation", [
					new FloatTag("", lcg_value() * 360),
					new FloatTag("", 0)
				]),
				new ShortTag("Experience", mt_rand(3, 11)),
			]);
			$exp = Entity::createEntity(ExperienceOrb::NETWORK_ID, $this->getLevel(), $nbt);
			$this->getLevel()->addEntity($exp);
		}

		$this->timings->stopTiming();

		return $hasUpdate;
	}
}