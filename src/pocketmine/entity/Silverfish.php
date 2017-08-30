<?php

namespace pocketmine\entity;

use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class Silverfish extends Monster{
	const NETWORK_ID = 39;

	public $height = 0.438;
	public $width = 0.609;
	public $lenght = 1.094;

	protected $exp_min = 5;
	protected $exp_max = 5;
	protected $maxHealth = 8;

	public function initEntity(){
		parent::initEntity();
	}

	public function getName(): string{
		return "Silverfish";
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
		return [];
	}
}
