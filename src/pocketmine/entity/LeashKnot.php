<?php

namespace pocketmine\entity;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;

class LeashKnot extends Entity{
	const NETWORK_ID = self::LEASH_KNOT;

	public $width = 0.1;
	public $length = 0.1;//TODO
	public $height = 0.1;

	//TODO leash lines
	public function initEntity(){
		$this->setMaxHealth(1);
		parent::initEntity();
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