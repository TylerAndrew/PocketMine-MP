<?php

namespace pocketmine\entity;

use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class Witch extends Monster implements ProjectileSource{
	const NETWORK_ID = 45;

	public $width = 0.938;
	public $length = 0.609;
	public $height = 2;

	protected $exp_min = 5;
	protected $exp_max = 5;
	protected $maxHealth = 20;

	public function initEntity(){
		parent::initEntity();
	}

	public function getName(): string{
		return "Witch";
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
		$drops = []; //TODO: Drops
		return $drops;
	}
}
