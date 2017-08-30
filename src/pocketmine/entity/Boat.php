<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\level\Level;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class Boat extends Vehicle{
	const NETWORK_ID = 90;

	public $height = 0.7;
	public $width = 1.6;
	public $gravity = 0.5;
	public $drag = 0.1;
	protected $maxHealth = 4;

	public function __construct(Level $level, CompoundTag $nbt){
		if (!isset($nbt->WoodID)){
			$nbt->WoodID = new ByteTag("WoodID", 0);
		}
		parent::__construct($level, $nbt);
	}

	public function initEntity(){
		parent::initEntity();
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

	public function getWoodID(){
		return $this->namedtag["WoodID"];
	}

	public function getDrops(): array{
		return [
			ItemItem::get(ItemItem::BOAT, $this->getWoodID(), 1)
		];
	}
}
