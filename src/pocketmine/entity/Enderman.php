<?php

namespace pocketmine\entity;

use pocketmine\nbt\tag\ByteTag;

class Enderman extends Monster{
	const NETWORK_ID = self::ENDERMAN;

	public $height = 2.875;
	public $width = 1.094;
	public $lenght = 0.5;

	protected $exp_min = 5;
	protected $exp_max = 5;


	public function initEntity(){
		$this->setMaxHealth(40);
		parent::initEntity();
		if (!isset($this->namedtag->Angry)){
			$this->setAngry(false);
		}
	}

	public function getName(): string{
		return "Enderman";
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
