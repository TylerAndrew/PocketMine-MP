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

namespace pocketmine\command\defaults;

use function PHPSTORM_META\type;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\level\GameRule;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\Server;

class GameRuleCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%pocketmine.command.gamerule.description",
			"%commands.gamerule.usage"
		);
		$this->setPermission("pocketmine.command.gamerule");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if (!$this->testPermission($sender)){
			return true;
		}

		$level = null;
		if (!($sender instanceof Player) && count($args) > 0){
			$level = Server::getInstance()->getLevelByName(array_shift($args));
		} else{
			$level = $sender->getLevel();
		}
		if (!$level instanceof Level){
			$sender->sendMessage("Unknown level");
		}

		if (count($args) === 0){
			$r = new \ReflectionClass(GameRule::class);
			$constantNames = array_filter(array_flip($r->getConstants()), function (string $constant){ return strpos($constant, "RULE_") !== false; });
			$sender->sendMessage(implode(", ", array_map(function (string $constant){ return constant(GameRule::class . "::" . strtoupper($constant)); }, $constantNames)));
			return true;
		}

		if (!defined(GameRule::class . "::" . "RULE_" . strtoupper($args[0]))){
			$sender->sendMessage("Unknown gamerule");

			return false;
		}

		$gamerulename = constant(GameRule::class . "::" . "RULE_" . strtoupper($args[0]));

		if (!isset($args[1])){
			if (!is_null($level->getGameRule($gamerulename)))
				$sender->sendMessage($gamerulename . ": " . is_bool(($value = $level->getGameRule($gamerulename)->getValue())) ? ($value ? "true" : "false") : strval($value));
			else
				$sender->sendMessage("Could not find a value for " . $gamerulename . ". This might be due to the server's level settings - try setting the variable instead");
		} else{
			if ($args[1] === "true" || $args[1] === "false"){// THERE CURRENTLY ARE ONLY BOOLS
				$type = GameRule::TYPE_BOOL;
				$value = $args[1] === "true";
			} elseif (is_numeric($args[1]) && ctype_digit(strval($args[1])) && is_int($args[1] + 0)){ // is_int does not work properly so a ctype check is needed - Blame PHP 7.1 for that bug
				$type = GameRule::TYPE_INT;
				$value = intval($args[1]);
			} elseif (is_numeric($args[1]) && (is_double(($args[1] + 0.0)) || is_float(($args[1] + 0.0)))){
				$type = GameRule::TYPE_FLOAT;
				$value = floatval($args[1]);
			} else{
				$sender->sendMessage("Invalid value");
				return true;
			}

			if (is_null($gamerule = $level->getGameRule($gamerulename))){
				$gamerule = new GameRule($gamerulename, $type, $value);
			}
			$level->setGameRule($gamerule);
			Command::broadcastCommandMessage($sender, new TranslationContainer("commands.gamerule.success", [$gamerulename, is_bool($value) ? ($value ? "true" : "false") : strval($value)]));

			return true;
		}
		return false;
	}
}