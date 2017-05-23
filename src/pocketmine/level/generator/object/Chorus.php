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

class Chorus {

	public function __construct() {}

	public function placeObject(ChunkManager $level, $x, $y, $z, Random $random) {
		$vec3 = new Vector3($x, $y, $z);
		foreach ($this->generateStem(new Vector3(0,0,0)) as $stem) {
			$pos = $stem->add($x, $y, $z);
			$level->setBlockIdAt($pos->getX(), $pos->getY(), $pos->getZ(), Block::CHORUS_PLANT);
		}
	}

	/**
	 * @param Vector3 $vec3
	 * @param int $meta
	 * @return Vector3[]
	 */
	private function generateStem(Vector3 $vec3, $meta = 0) {
		while (true) {
			if($meta >= 15) return null;
			$meta++;
			if($vec3->x > 5 ||$vec3->y > 15 ||$vec3->z > 5 ||$vec3->x < -5 ||$vec3->z < -5) return null;
			$vec3 = $vec3->add(mt_rand(-1,1), mt_rand(0,1), mt_rand(-1,1));
			yield $vec3;
		}
	}

	public function canSpreadTo(){
		$freespace = [];
		/** @var ChorusPlant $below */
		if(($below = $this->getSide(Vector3::SIDE_DOWN)) instanceof ChorusPlant && $below->countHorizontalStems() > 0 || $below->getId() === self::END_STONE){
			//it has a stem next to it so MUST spead up
			$freespace[] = yield $this->getSide(Vector3::SIDE_UP);
		}else{
			for($side = 1;$side<=5;$side++){
				$block = $this->getSide($side);
				$canGoHere = true;
				for($sideCheck = 2;$sideCheck<=5;$sideCheck++){
					if(!in_array($block->getSide($sideCheck)->getId(), [self::AIR, self::CHORUS_FLOWER])){//flower, its not yet replaced
						$canGoHere = false;
						var_dump($canGoHere);
					}
				}
				if($canGoHere) $freespace[] = $block;
			}
		}
		var_dump($freespace);
		return $freespace;
	}

	public function hasValidStem(Vector3 $target){
		if(in_array($this->getSide(Vector3::SIDE_DOWN)->getId(), [self::CHORUS_PLANT,self::END_STONE])) {
			print 'has valid below'.PHP_EOL;
			return true;
		}
		foreach([Vector3::SIDE_NORTH,Vector3::SIDE_SOUTH,Vector3::SIDE_WEST,Vector3::SIDE_EAST] as $side){
			print 'Testing side '.$side.PHP_EOL;
			if($this->getSide($side)->getId() === self::CHORUS_PLANT){
				print 'has valid next to it'.PHP_EOL;
				return true;
			}
		}
		return false;
	}

	public function shouldBreak(){
		if($this->hasValidStem($this)) {
			print 'flower has valid stem'.PHP_EOL;
			return false;
		}
		#print 'test side shit'.PHP_EOL;
		/*
		$tobreak = false;
		foreach([Vector3::SIDE_NORTH,Vector3::SIDE_SOUTH,Vector3::SIDE_WEST,Vector3::SIDE_EAST] as $side){
			if($this->getSide($side)->getId() === self::CHORUS_PLANT && $this->getSide(Vector3::SIDE_DOWN)->getSide($side)->getId() === self::CHORUS_PLANT){
				if($this->getId() === self::CHORUS_FLOWER){
					$tobreak = true;
				}
				else{
					$this->getLevel()->useBreakOn($this->getSide($side));
					$this->getLevel()->useBreakOn($this->getSide(Vector3::SIDE_DOWN));
					$this->tobreak = true;
				}
			}
		}
		return $tobreak;*/
		return true;
	}
}