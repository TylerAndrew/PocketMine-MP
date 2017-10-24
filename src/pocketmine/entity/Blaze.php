<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;

class Blaze extends Monster{
	const NETWORK_ID = self::BLAZE;

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

	public function getDrops(): array{
		return [
			ItemItem::get(ItemItem::BLAZE_ROD, 0, mt_rand(0, 1))
		];
	}
}