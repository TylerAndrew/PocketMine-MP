<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class IronGolem extends Animal{
	const NETWORK_ID = 20;

	public $height = 2.688;
	public $width = 1.625;
	public $lenght = 0.906;
	protected $maxHealth = 100;

	public function initEntity(){
		parent::initEntity();
	}

	public function getName(): string{
		return "Iron Golem";
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

	public function getDrops(): array{
		return [
			ItemItem::get(ItemItem::IRON_INGOT, 0, mt_rand(3, 5)),
			ItemItem::get(ItemItem::POPPY, 0, mt_rand(0, 2))
		];
	}

	public function isLeashableType(){
		return false;
	}
}