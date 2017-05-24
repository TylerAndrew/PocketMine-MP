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

namespace pocketmine\level\generator\object;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class EndIsland {
	public function placeObject(ChunkManager $level, $x, $y, $z, Random $random) {
		$vector3 = new Vector3($x, $y, $z);
		$baseSize = $random->nextBoundedInt(3) + 4;

		for ($z = 0; $baseSize > 0.5; --$z) {
			for ($y = floor(-$baseSize); $y <= ceil($baseSize); ++$y) {
				for ($x = floor(-$baseSize); $x <= ceil($baseSize); ++$x) {
					if (($y * $y + $x * $x) <= ($baseSize + 1) * ($baseSize + 1)) {
						$vec3 = $vector3->add($y, $z, $x);
						$level->setBlockIdAt($vec3->x, $vec3->y, $vec3->z, Block::END_STONE);
					}
				}
			}
			$baseSize = ($baseSize - ($random->nextBoundedInt(2) + 0.5));
		}

		return true;
	}
}