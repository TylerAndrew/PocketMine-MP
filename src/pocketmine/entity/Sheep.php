<?php

namespace pocketmine\entity;

use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\nbt\tag\IntTag;

class Sheep extends Animal implements Colorable{
	const NETWORK_ID = self::SHEEP;
	public $lenght = 1.484;
	public $width = 0.719;
	public $height = 1.406;
	protected $exp_min = 1;
	protected $exp_max = 3;


	public function initEntity(){
		$this->setMaxHealth(8);
		parent::initEntity();

		if (!isset($this->namedtag->Color) || $this->getVariant() > 15){
			$this->setVariant(mt_rand(0, 15));
		}
		$this->setVariant($this->namedtag->Color);
	}

	public function getName(): string{
		return "Sheep";
	}

	public function setVariant($value){
		$this->namedtag->Color = new IntTag("Color", $value);
		$this->setDataProperty(self::DATA_COLOR, self::DATA_TYPE_INT, $value);
	}

	public function getVariant(){
		return $this->namedtag["Color"];
	}

	public function getDrops(): array{
		return [ItemFactory::get(ItemIds::WOOL, $this->getVariant(), 1)];//TODO wool, mutton
	}

	public function sheer(){
		if ($this->getDataFlag(self::DATA_FLAGS, self::DATA_FLAG_SHEARED)) return;
		$this->getLevel()->dropItem($this, ItemFactory::get(ItemIds::WOOL, $this->getVariant(), mt_rand(0, 2)));//TODO: check amount
		$this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_SHEARED, true);
	}
}