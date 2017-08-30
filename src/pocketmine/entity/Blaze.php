<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class Blaze extends Monster{
	const NETWORK_ID = 43;

	protected $gravity = 0.02;//TODO
	public $height = 1.5;
	public $width = 1.25;
	public $lenght = 0.906;

	protected $exp_min = 10;
	protected $exp_max = 10;

	public function initEntity(){
		$this->setMaxHealth(20);
		parent::initEntity();
	}

	public function getName(): string{
		return "Blaze";
	}

	protected function applyGravity(){
		//TODO if aggressive up
		parent::applyGravity();
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
			ItemItem::get(ItemItem::BLAZE_ROD, 0, mt_rand(0, 1))
		];
	}
}