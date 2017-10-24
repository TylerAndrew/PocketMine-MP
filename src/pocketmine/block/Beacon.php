<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\tile\Beacon as TileBeacon;
use pocketmine\tile\Tile;

class Beacon extends Solid{

	protected $id = self::BEACON;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getLightLevel(): int{
		return 15;
	}

	public function getResistance(): float{
		return 15.0;
	}

	public function getHardness(): float{
		return 3.0;
	}

	public function canBeActivated(){
		return true;
	}

	public function getName(): string{
		return "Beacon";
	}

	public function place(Item $item, Block $block, Block $target, int $face, Vector3 $facePos, Player $player = null): bool{
		$this->getLevel()->setBlock($this, $this, true, true);
		Tile::createTile(Tile::BEACON, $this->getLevel(), Tile::createNBT($block));//TODO check/fix additional
		return true;
	}

	public function onActivate(Item $item, Player $player = null): bool{
		if ($player instanceof Player){
			$top = $this->getSide(1);
			if ($top->isTransparent() !== true){
				return true;
			}

			$t = $this->getLevel()->getTile($this);
			$beacon = null;
			if ($t instanceof TileBeacon){
				$beacon = $t;
			} else{
				Tile::createTile(Tile::BEACON, $this->getLevel(), Tile::createNBT($this));//TODO check/fix additional
			}

			if ($beacon instanceof TileBeacon){
				$player->addWindow($beacon->getInventory());
			}
		}

		return true;
	}
}