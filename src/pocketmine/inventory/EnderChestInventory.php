<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

namespace pocketmine\inventory;

use pocketmine\entity\Human;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\BlockEventPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\types\WindowTypes;
use pocketmine\Player;

class EnderChestInventory extends ContainerInventory{
	public function __construct(Position $pos){
		parent::__construct(new FakeBlockMenu($this, $pos));
	}

	/**
	 * @return Human|InventoryHolder
	 */
	public function getHolder(){
		return $this->holder;
	}

	public function onOpen(Player $who): void{
		$this->setContents($who->getEnderChestInventory()->getContents());
		parent::onOpen($who);

		if (count($this->getViewers()) === 1 and ($level = $this->getHolder()->getLevel()) instanceof Level){
			$this->broadcastBlockEventPacket($this->getHolder(), true);
			$level->broadcastLevelSoundEvent($this->getHolder()->add(0.5, 0.5, 0.5), LevelSoundEventPacket::SOUND_CHEST_OPEN);
		}
	}

	public function onClose(Player $who): void{
		if (count($this->getViewers()) === 1 and ($level = $this->getHolder()->getLevel()) instanceof Level){
			$this->broadcastBlockEventPacket($this->getHolder(), false);
			$level->broadcastLevelSoundEvent($this->getHolder()->add(0.5, 0.5, 0.5), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
		}
		parent::onClose($who);
	}

	protected function broadcastBlockEventPacket(Vector3 $vector, bool $isOpen): void{
		$pk = new BlockEventPacket();
		$pk->x = (int)$vector->x;
		$pk->y = (int)$vector->y;
		$pk->z = (int)$vector->z;
		$pk->eventType = 1; //it's always 1 for a chest
		$pk->eventData = $isOpen ? 1 : 0;
		$this->getHolder()->getLevel()->addChunkPacket($this->getHolder()->getX() >> 4, $this->getHolder()->getZ() >> 4, $pk);
	}

	public function getName(): string{
		return "Ender Chest";
	}

	/**
	 * Returns the Minecraft PE inventory type used to show the inventory window to clients.
	 * @return int
	 */
	public function getNetworkType(): int{
		return WindowTypes::CONTAINER;
	}

	public function getDefaultSize(): int{
		return 27;
	}
}
