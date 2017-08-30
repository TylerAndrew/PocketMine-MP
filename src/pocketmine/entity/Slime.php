<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\nbt\tag\IntTag;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class Slime extends Living{
	const NETWORK_ID = 37;
	const DATA_SIZE = 16;

	public $height = 2;
	public $width = 2;
	public $lenght = 2;//TODO: Size

	protected $exp_min = 1;
	protected $exp_max = 1;//TODO: Size
	protected $maxHealth = 16;

	public function initEntity(){
		parent::initEntity();
		if (!isset($this->namedtag->Size)){
			$this->setSize(mt_rand(0, 3));
		}
	}

	public function getName(): string{
		return "Slime";
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
			ItemItem::get(ItemItem::SLIMEBALL, 0, mt_rand(0, 2))
		];
	}

	public function setSize($value){
		$this->namedtag->Size = new IntTag("Size", $value);
		$this->setDataProperty(self::DATA_SIZE, self::DATA_TYPE_BYTE, $value);
	}

	public function getSize(){
		return $this->namedtag["Size"];
	}

}
