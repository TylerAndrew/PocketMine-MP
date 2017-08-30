<?php

namespace pocketmine\entity;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class LeashKnot extends Entity{
	const NETWORK_ID = 88;

	public $width = 0.1;
	public $length = 0.1;//TODO
	public $height = 0.1;
	protected $maxHealth = 1;

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

	public function numberofAnimalsAttached(){ }

	public function isPickable(){ }

	public function removeAnimals(Player $player){ }

	public function interactWithPlayer(Player $player){ }

	public function addAdditionalSaveData(CompoundTag $compound){ }

	public function readAdditionalSaveData(CompoundTag $compound){ }

	public function recalculateBoundingBox(){ }

	public function shouldRenderAtSqrDistance(){ }

	public function remove(){ }

	public function setDir(int $dir){ }

	public function dropItem(){ }

	public function getWidth(){ }

	public function survives(){ }

	public function getHeight(){ }

	public function getEyeHeight(): float{ return 0.0; }//TODO

}