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

/*
 * Copied from @beito123's FlowerPot plugin
 */

namespace pocketmine\tile;

use pocketmine\level\Level;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\utils\Color;

class Cauldron extends Spawnable{

	public function __construct(Level $level, CompoundTag $nbt){
		if(!isset($nbt->PotionId)){
			$nbt->PotionId = new ShortTag("PotionId", 0);
		}
		if(!isset($nbt->SplashPotion)){
			$nbt->SplashPotion = new ByteTag("SplashPotion", 0);
		}
		parent::__construct($level, $nbt);
	}

	public function getPotionId(){
		return $this->namedtag["PotionId"];
	}

	public function setPotionId($potionId){
		$this->namedtag->PotionId = new ShortTag("PotionId", $potionId);

		$this->spawnToAll();
		if($this->chunk){
			$this->chunk->setChanged();
			$this->level->clearChunkCache($this->chunk->getX(), $this->chunk->getZ());
		}
	}

	public function hasPotion(){
		return $this->namedtag["PotionId"] !== 0;
	}

	public function getSplashPotion(){
		return ($this->namedtag["SplashPotion"] == true);
	}

	public function setSplashPotion($bool){
		$this->namedtag->SplashPotion = new ByteTag("SplashPotion", ($bool == true) ? 1 : 0);

		$this->spawnToAll();
		if($this->chunk){
			$this->chunk->setChanged();
			$this->level->clearChunkCache($this->chunk->getX(), $this->chunk->getZ());
		}
	}

	/**
	 * @return null|Color
	 */
	public function getCustomColor(){
		if($this->isCustomColor()){
			$color = $this->namedtag["CustomColor"];
			$green = ($color >> 8) & 0xff;
			$red = ($color >> 16) & 0xff;
			$blue = ($color) & 0xff;
			return new Color($red, $green, $blue);
		}
		return null;
	}

	public function getCustomColorRed(){
		return ($this->namedtag["CustomColor"] >> 16) & 0xff;
	}

	public function getCustomColorGreen(){
		return ($this->namedtag["CustomColor"] >> 8) & 0xff;
	}

	public function getCustomColorBlue(){
		return ($this->namedtag["CustomColor"]) & 0xff;
	}

	public function isCustomColor(){
		return isset($this->namedtag->CustomColor);
	}

	public function setCustomColor($r, $g = 0xff, $b = 0xff){
		if($r instanceof Color){
			$color = ($r->getR() << 16 | $r->getG() << 8 | $r->getB()) & 0;
		}else{
			$color = ($r << 16 | $g << 8 | $b) & 0;
		}
		$this->namedtag->CustomColor = new IntTag("CustomColor", $color);

		$this->spawnToAll();
		if($this->chunk){
			$this->chunk->setChanged();
			$this->level->clearChunkCache($this->chunk->getX(), $this->chunk->getZ());
		}
	}

	public function clearCustomColor(){
		if(isset($this->namedtag->CustomColor)){
			unset($this->namedtag->CustomColor);
		}

		$this->spawnToAll();
		if($this->chunk){
			$this->chunk->setChanged();
			$this->level->clearChunkCache($this->chunk->getX(), $this->chunk->getZ());
		}
	}

	public function getSpawnCompound(){
		$nbt = new CompoundTag("", [
			new StringTag("id", Tile::CAULDRON),
			new IntTag("x", (Int) $this->x),
			new IntTag("y", (Int) $this->y),
			new IntTag("z", (Int) $this->z),
			new ShortTag("PotionId", $this->namedtag["PotionId"] > ((2 ** 15) - 1) ? 0 : $this->namedtag["PotionId"]),
			new ByteTag("SplashPotion", $this->namedtag["SplashPotion"])
		]);

		if($this->getPotionId() === 0 and $this->isCustomColor()){
			$nbt->CustomColor = $this->namedtag->CustomColor;
		}
		return $nbt;
	}
}