<?php

namespace pocketmine\entity;

use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class EnderDragon extends Monster implements ProjectileSource{
	const NETWORK_ID = 53;

	public $height = 2;
	public $width = 3;
	public $lenght = 1;//TODO: check

	protected $exp_min = 12500;
	protected $exp_max = 12500;
	protected $maxHealth = 200;

	public function initEntity(){
		parent::initEntity();
	}

	public function getName(): string{
		return "Ender Dragon";
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
