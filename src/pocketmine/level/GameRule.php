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

namespace pocketmine\level;

use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\NamedTag;

class GameRule{

	const TYPE_BOOL = 1;
	const TYPE_INT = 2;
	const TYPE_FLOAT = 3;

	//TODO cheats enabled"
	const RULE_COMMANDBLOCKOUTPUT = "commandblockoutput";
	const RULE_DODAYLIGHTCYCLE = "dodaylightcycle";
	const RULE_DOENTITYDROPS = "doentitydrops";
	const RULE_DOFIRETICK = "dofiretick";
	const RULE_DOMOBLOOT = "domobloot";
	const RULE_DOMOBSPAWNING = "domobspawning";
	const RULE_DOTILEDROPS = "dotiledrops";
	const RULE_DOWEATHERCYCLE = "doweathercycle";
	const RULE_DROWNINGDAMAGE = "drowningdamage";
	const RULE_FALLDAMAGE = "falldamage";
	const RULE_FIREDAMAGE = "firedamage";
	const RULE_KEEPINVENTORY = "keepinventory";
	const RULE_MOBGRIEFING = "mobgriefing";
	const RULE_NATURALREGENERATION = "naturalregeneration";
	const RULE_PVP = "pvp";
	const RULE_SENDCOMMANDFEEDBACK = "sendcommandfeedback";
	const RULE_SHOWCOORDINATES = "showcoordinates";
	const RULE_TNTEXPLODES = "tntexplodes";

	/**
	 * GameRule constructor.
	 * @param string $name
	 * @param int $type
	 * @param mixed $value
	 */
	public function __construct(string $name, int $type = self::TYPE_BOOL, $value = false){
		$this->$name = [$type, $value];
	}

	/**
	 * @return int
	 */
	public function getType(): int{
		return $this[0][0];
	}

	/**
	 * @return mixed
	 */
	public function getValue(){
		return $this[0][1];
	}

	/**
	 * @return string
	 */
	public function getName(): string{
		return $this[0];
	}

	/**
	 * @param int $type
	 */
	public function setType(int $type = self::TYPE_BOOL){
		$this[0][0] = $type;
	}

	/**
	 * @param $value
	 */
	public function setValue($value){
		$this[0][1] = $value;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name){
		$this[0] = $name;
	}

	/**
	 * Serializes the GameRule to an NBT CompoundTag
	 *
	 * @param string $tagName the name to assign to the NamedTag object
	 *
	 * @return NamedTag
	 */
	public function nbtSerialize(string $tagName = ""): NamedTag{
		$nbt = NBT::fromArrayGuesser($this->getName(), $this->getValue());
		$nbt->setName($tagName);
		return $nbt;
	}

	/**
	 * Deserializes a GameRule from an NBT CompoundTag
	 *
	 * @param CompoundTag $tag
	 *
	 * @return GameRule
	 */
	public static function nbtDeserialize(CompoundTag $tag): GameRule{
		$nbt = new NBT();
		$nbt->setData($tag);
		$array = $nbt->getArray();
		var_dump($array);
		return new GameRule(...$array);
	}

}