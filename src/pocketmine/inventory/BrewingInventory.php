<?php

namespace pocketmine\inventory;

use pocketmine\item\Item;
use pocketmine\network\mcpe\protocol\types\WindowTypes;
use pocketmine\Server;
use pocketmine\tile\BrewingStand;

class BrewingInventory extends ContainerInventory{

	public function __construct(BrewingStand $tile){
		parent::__construct($tile);
	}

	/**
	 *
	 * @return BrewingStand
	 */
	public function getHolder(){
		return $this->holder;
	}

	public function setIngredient(Item $item){
		$this->setItem(0, $item);
	}

	/**
	 *
	 * @return Item
	 */
	public function getIngredient(){
		return $this->getItem(0);
	}

	public function onSlotChange(int $index, Item $before, bool $send):void{
		parent::onSlotChange($index, $before, $send);
		$this->getHolder()->scheduleUpdate();
		$this->getHolder()->updateSurface();
	}

	public function getResult(){
		if($brew = Server::getInstance()->getCraftingManager()->matchBrewingRecipe($this->getIngredient(), $this->getIngredient())){//TODO check
			$canbrew = ($brew instanceof BrewingRecipe);
			if($canbrew) return $brew->getResult();
		}
		return Item::get(Item::AIR, 0, 1);
	}

	public function getName(): string{
		return "Brewing";
	}

	/**
	 * Returns the Minecraft PE inventory type used to show the inventory window to clients.
	 * @return int
	 */
	public function getNetworkType(): int{
		return WindowTypes::BREWING_STAND;
	}

	public function getDefaultSize(): int{
		return 4; //1 input, 3 outputs
	}
}