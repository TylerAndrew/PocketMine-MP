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

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\tile\Skull as TileSkull;
use pocketmine\tile\Tile;

class Skull extends Flowable{

	protected $id = self::SKULL_BLOCK;

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

	public function getHardness(): float{
		return 1;
	}

	public function getName(): string{
		return "Mob Head";
	}

	protected function recalculateBoundingBox(): AxisAlignedBB{
		$x1 = 0;
		$x2 = 0;
		$z1 = 0;
		$z2 = 0;
		if ($this->meta === 0 || $this->meta === 1){
			return new AxisAlignedBB(
				$this->x + 0.25,
				$this->y,
				$this->z + 0.25,
				$this->x + 0.75,
				$this->y + 0.5,
				$this->z + 0.75
			);
		} elseif ($this->meta === 2){
			$x1 = 0.25;
			$x2 = 0.75;
			$z1 = 0;
			$z2 = 0.5;
		} elseif ($this->meta === 3){
			$x1 = 0.5;
			$x2 = 1;
			$z1 = 0.25;
			$z2 = 0.75;
		} elseif ($this->meta === 4){
			$x1 = 0.25;
			$x2 = 0.75;
			$z1 = 0.5;
			$z2 = 1;
		} elseif ($this->meta === 5){
			$x1 = 0;
			$x2 = 0.5;
			$z1 = 0.25;
			$z2 = 0.75;
		}
		return new AxisAlignedBB(
			$this->x + $x1,
			$this->y + 0.25,
			$this->z + $z1,
			$this->x + $x2,
			$this->y + 0.75,
			$this->z + $z2
		);
	}

	public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $facePos, Player $player = null): bool{
		if ($face === Vector3::SIDE_DOWN){
			return false;
		}

		$this->meta = $face;
		$this->getLevel()->setBlock($blockReplace, $this, true);
		Tile::createTile(Tile::SKULL, $this->getLevel(), TileSkull::createNBT($this, $face, $item, $player));

		return true;
	}

	public function getDrops(Item $item): array{
		$tile = $this->level->getTile($this);
		if ($tile instanceof TileSkull){
			return [
				ItemFactory::get(Item::SKULL, $tile->getType(), 1)
			];
		}

		return [];
	}
}