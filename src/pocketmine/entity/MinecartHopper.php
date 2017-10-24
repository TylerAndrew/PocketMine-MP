<?php

namespace pocketmine\entity;

use pocketmine\inventory\Inventory;
use pocketmine\inventory\InventoryHolder;
use pocketmine\item\Item as ItemItem;

class MinecartHopper extends Minecart implements InventoryHolder{

	const NETWORK_ID = self::HOPPER_MINECART;

	public function getName(){
		return "Minecart Hopper";
	}

	public function getDrops(): array{
		return [ItemItem::get(ItemItem::MINECART, 0, 1), ItemItem::get(ItemItem::HOPPER, 0, 1)];
	}

	//TODO: Open inventory, add inventory, drop inventory contents

	/**
	 * Get the object related inventory
	 *
	 * @return Inventory
	 */
	public function getInventory(){
		return null;//TODO hopper inventory
	}
}
