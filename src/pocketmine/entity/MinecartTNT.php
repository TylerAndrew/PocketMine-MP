<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;

class MinecartTNT extends Minecart{
	const NETWORK_ID = self::TNT_MINECART;
	public $height = 0.9;
	public $width = 1.1;
	protected $maxHealth = 4;
	public $drag = 0.1;
	public $gravity = 0.5;
	public $isMoving = false;
	public $moveSpeed = 0.4;
	public $isFreeMoving = false;
	public $isLinked = false;

	public function getName(){
		return "Minecart TNT";
	}

	public function getDrops(): array{
		return [ItemItem::get(ItemItem::MINECART, 0, 1), ItemItem::get(ItemItem::TNT, 0, 1)];
	}
}
