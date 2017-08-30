<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class Wither extends Monster implements ProjectileSource{
	const NETWORK_ID = 52;

	public $height = 2;
	public $width = 3;
	public $lenght = 1;//TODO: check

	protected $exp_min = 20;
	protected $exp_max = 20;
	protected $maxHealth = 600;

	public function initEntity(){
		parent::initEntity();
	}

	public function getName(): string{
		return "Wither Boss";
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
		return [ItemItem::get(ItemItem::NETHER_STAR)];
	}
}
