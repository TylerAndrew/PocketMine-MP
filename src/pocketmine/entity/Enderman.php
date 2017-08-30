<?php

namespace pocketmine\entity;

use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class Enderman extends Monster{
	const NETWORK_ID = 38;

	public $height = 2.875;
	public $width = 1.094;
	public $lenght = 0.5;

	protected $exp_min = 5;
	protected $exp_max = 5;
	protected $maxHealth = 40;

	public function initEntity(){
		parent::initEntity();
		if (!isset($this->namedtag->Angry)){
			$this->setAngry(false);
		}
	}

	public function getName(): string{
		return "Enderman";
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

	/*public function getDrops() : array {
		return [
			ItemItem::get(ItemItem::ENDERPEARL, 0, mt_rand(0, 1))
			// holding Block
		];
	}*/

	public function setAngry($angry = true){
		$this->namedtag->Angry = new ByteTag("Angry", intval($angry));
		$this->setDataProperty(self::DATA_FLAG_ANGRY, self::DATA_TYPE_BYTE, intval($angry));
	}

	public function getAngry(){
		return $this->namedtag["Angry"];
	}

}
