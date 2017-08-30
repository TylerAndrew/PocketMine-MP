<?php

namespace pocketmine\entity;

use pocketmine\nbt\tag\IntTag;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class ZombieVillager extends Zombie{
	const NETWORK_ID = 44;

	public $width = 1.031;
	public $length = 0.891;
	public $height = 2.125;
	protected $maxHealth = 20;

	public function initEntity(){
		parent::initEntity();
		if (!isset($this->namedtag->Profession) || $this->getVariant() > 4){
			$this->setVariant(mt_rand(0, 4));
		}
		$this->setDataProperty(16, self::DATA_TYPE_BYTE, $this->getVariant());
	}

	public function getName(): string{
		return "Zombie Villager";
	}

	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->entityRuntimeId = $this->getId();
		$pk->type = self::NETWORK_ID;
		$pk->position = $this->asVector3();
		$pk->motion = $this->getMotion();
		$pk->yaw = $this->yaw;
		$pk->pitch = $this->pitch;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}

	/**
	 * Sets the Zombie Villager's profession
	 *
	 * @param $type
	 */
	public function setVariant($type){
		$this->namedtag->Profession = new IntTag("Profession", $type);
		$this->setDataProperty(16, self::DATA_TYPE_BYTE, $type);
	}

	public function getVariant(){
		return $this->namedtag["Profession"];
	}

}
