<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

namespace pocketmine\item;

use pocketmine\entity\Entity;
use pocketmine\entity\projectile\Projectile;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\level\sound\LaunchSound;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\Player;

class SplashPotion extends ProjectileItem{

	public function __construct($meta = 0){
		parent::__construct(self::SPLASH_POTION, $meta, $this->getNameByMeta($meta));
	}

	public function getNameByMeta($meta){
		switch ($meta){
			case Potion::WATER_BOTTLE:
				return "Splash Water Bottle";
			case Potion::MUNDANE:
			case Potion::MUNDANE_EXTENDED:
				return "Splash Mundane Potion";
			case Potion::THICK:
				return "Splash Thick Potion";
			case Potion::AWKWARD:
				return "Splash Awkward Potion";
			case Potion::INVISIBILITY:
			case Potion::INVISIBILITY_T:
				return "Splash Potion of Invisibility";
			case Potion::LEAPING:
			case Potion::LEAPING_T:
				return "Splash Potion of Leaping";
			case Potion::LEAPING_TWO:
				return "Splash Potion of Leaping II";
			case Potion::FIRE_RESISTANCE:
			case Potion::FIRE_RESISTANCE_T:
				return "Splash Potion of Fire Residence";
			case Potion::SPEED:
			case Potion::SPEED_T:
				return "Splash Potion of Swiftness";
			case Potion::SPEED_TWO:
				return "Splash Potion of Swiftness II";
			case Potion::SLOWNESS:
			case Potion::SLOWNESS_T:
				return "Splash Potion of Slowness";
			case Potion::WATER_BREATHING:
			case Potion::WATER_BREATHING_T:
				return "Splash Potion of Water Breathing";
			case Potion::HARMING:
				return "Splash Potion of Harming";
			case Potion::HARMING_TWO:
				return "Splash Potion of Harming II";
			case Potion::POISON:
			case Potion::POISON_T:
				return "Splash Potion of Poison";
			case Potion::POISON_TWO:
				return "Splash Potion of Poison II";
			case Potion::HEALING:
				return "Splash Potion of Healing";
			case Potion::HEALING_TWO:
				return "Splash Potion of Healing II";
			case Potion::NIGHT_VISION:
			case Potion::NIGHT_VISION_T:
				return "Splash Potion of Night Vision";
			default:
				return "Splash Potion";
		}
	}

	public function getProjectileEntityType(): string{
		return "ThrownPotion";
	}

	public function getThrowForce(): float{
		return 1.1;
	}

	public function onClickAir(Player $player, Vector3 $directionVector) : bool{//TODO optimise
		$nbt = Entity::createBaseNBT($player->add(0, $player->getEyeHeight(), 0), $directionVector, $player->yaw, $player->pitch);
		$nbt->PotionId = new ShortTag("PotionId", $this->getDamage());

		$projectile = Entity::createEntity($this->getProjectileEntityType(), $player->getLevel(), $nbt, $player);
		if($projectile !== null){
			$projectile->setMotion($projectile->getMotion()->multiply($this->getThrowForce()));
		}

		$this->count--;

		if($projectile instanceof Projectile){
			$player->getServer()->getPluginManager()->callEvent($projectileEv = new ProjectileLaunchEvent($projectile));
			if($projectileEv->isCancelled()){
				$projectile->kill();
			}else{
				$projectile->spawnToAll();
				$player->getLevel()->addSound(new LaunchSound($player), $player->getViewers());
			}
		}else{
			$projectile->spawnToAll();
		}

		return true;
	}
}