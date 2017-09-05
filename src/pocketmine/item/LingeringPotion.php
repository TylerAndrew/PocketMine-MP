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
use pocketmine\entity\Projectile;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\level\sound\LaunchSound;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\Player;

class LingeringPotion extends ProjectileItem{

	public function __construct($meta = 0){
		parent::__construct(self::LINGERING_POTION, $meta, $this->getNameByMeta($meta));
	}

	public function getNameByMeta($meta){
		switch ($meta){
			case Potion::WATER_BOTTLE:
				return "Lingering Water Bottle";
			case Potion::MUNDANE:
			case Potion::MUNDANE_EXTENDED:
				return "Lingering Mundane Potion";
			case Potion::THICK:
				return "Lingering Thick Potion";
			case Potion::AWKWARD:
				return "Lingering Awkward Potion";
			case Potion::INVISIBILITY:
			case Potion::INVISIBILITY_T:
				return "Lingering Potion of Invisibility";
			case Potion::LEAPING:
			case Potion::LEAPING_T:
				return "Lingering Potion of Leaping";
			case Potion::LEAPING_TWO:
				return "Lingering Potion of Leaping II";
			case Potion::FIRE_RESISTANCE:
			case Potion::FIRE_RESISTANCE_T:
				return "Lingering Potion of Fire Residence";
			case Potion::SPEED:
			case Potion::SPEED_T:
				return "Lingering Potion of Swiftness";
			case Potion::SPEED_TWO:
				return "Lingering Potion of Swiftness II";
			case Potion::SLOWNESS:
			case Potion::SLOWNESS_T:
				return "Lingering Potion of Slowness";
			case Potion::WATER_BREATHING:
			case Potion::WATER_BREATHING_T:
				return "Lingering Potion of Water Breathing";
			case Potion::HARMING:
				return "Lingering Potion of Harming";
			case Potion::HARMING_TWO:
				return "Lingering Potion of Harming II";
			case Potion::POISON:
			case Potion::POISON_T:
				return "Lingering Potion of Poison";
			case Potion::POISON_TWO:
				return "Lingering Potion of Poison II";
			case Potion::HEALING:
				return "Lingering Potion of Healing";
			case Potion::HEALING_TWO:
				return "Lingering Potion of Healing II";
			case Potion::NIGHT_VISION:
			case Potion::NIGHT_VISION_T:
				return "Lingerin Potion of Night Vision";
			default:
				return "Lingering Potion";
		}
	}

	public function getProjectileEntityType(): string{
		return "LingeringPotion";
	}

	public function getThrowForce(): float{
		return 1.1;
	}

	public function onClickAir(Player $player, Vector3 $directionVector) : bool{
		$nbt = new CompoundTag("", [
			new ListTag("Pos", [
				new DoubleTag("", $player->x),
				new DoubleTag("", $player->y + $player->getEyeHeight()),
				new DoubleTag("", $player->z)
			]),
			new ListTag("Motion", [
				new DoubleTag("", $directionVector->x),
				new DoubleTag("", $directionVector->y),
				new DoubleTag("", $directionVector->z)
			]),
			new ListTag("Rotation", [
				new FloatTag("", $player->yaw),
				new FloatTag("", $player->pitch)
			]),
			new ShortTag("PotionId", $this->getDamage()),
		]);

		$snowball = Entity::createEntity($this->getProjectileEntityType(), $player->getLevel(), $nbt, $player);
		$snowball->setMotion($snowball->getMotion()->multiply($this->getThrowForce()));

		$this->count--;

		if($snowball instanceof Projectile){
			$player->getServer()->getPluginManager()->callEvent($projectileEv = new ProjectileLaunchEvent($snowball));
			if($projectileEv->isCancelled()){
				$snowball->kill();
			}else{
				$snowball->spawnToAll();
				$player->getLevel()->addSound(new LaunchSound($player), $player->getViewers());
			}
		}else{
			$snowball->spawnToAll();
		}

		return true;
	}

}