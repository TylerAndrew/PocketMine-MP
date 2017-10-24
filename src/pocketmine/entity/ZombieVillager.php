<?php

namespace pocketmine\entity;

use pocketmine\nbt\tag\IntTag;

class ZombieVillager extends Zombie{
	const NETWORK_ID = self::ZOMBIE_VILLAGER;

	public $width = 1.031;
	public $length = 0.891;
	public $height = 2.125;

	public function initEntity(){
		$this->setMaxHealth(20);
		parent::initEntity();
		if (!isset($this->namedtag->Profession) || $this->getVariant() > 4){
			$this->setVariant(mt_rand(0, 4));
		}
		$this->setVariant($this->getVariant());
	}

	public function getName(): string{
		return "Zombie Villager";
	}

	/**
	 * Sets the Zombie Villager's profession
	 *
	 * @param $type
	 */
	public function setVariant($type){
		$this->namedtag->Profession = new IntTag("Profession", $type);
		$this->setDataProperty(self::DATA_VARIANT, self::DATA_TYPE_INT, $type);
	}

	public function getVariant(){
		return $this->namedtag["Profession"];
	}

}
