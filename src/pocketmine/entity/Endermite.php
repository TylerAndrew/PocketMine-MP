<?php

namespace pocketmine\entity;

use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class Endermite extends Monster{
	const NETWORK_ID = 55;

	public $height = 0.438;
	public $width = 0.609;
	public $lenght = 1.094;

	protected $exp_min = 3;
	protected $exp_max = 3;
	protected $maxHealth = 8;

	public function initEntity(){
		parent::initEntity();
	}

	public function getName(): string{
		return "Endermite";
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
}
