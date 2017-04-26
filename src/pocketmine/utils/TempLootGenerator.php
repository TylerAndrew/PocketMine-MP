<?php

namespace pocketmine\utils;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class TempLootGenerator {
	public function __construct(Config $lootFile) {
		$this->lootFile = $lootFile;
	}

	public function getRandomLoot() {
		$array = [];
		$items = [];
		foreach ($this->lootFile->get("pools") as $rolls) {
			$maxrolls = $rolls["rolls"];//TODO: $rolls["conditions"]
			while ($maxrolls > 0) {
				$maxrolls--;
				foreach ($rolls["entries"] as $index => $entries) {
					$array[] = $entries["weight"]??1;
				}
			}
			$val = $rolls["entries"][$this->getRandomWeightedElement($array)];
			//typecheck
			if ($val["type"] == "loot_table") {
				$loottable = new TempLootGenerator(new Config(\pocketmine\Server::getInstance()->getFilePath() . "src/pocketmine/resources/" . $val["name"] . ".json", Config::JSON, []));
				$items = array_merge($items, $loottable->getRandomLoot());
				unset($loottable);
			} elseif ($val["type"] == "item") {
				print $val["name"] . PHP_EOL;
				//name fix
				if ($val["name"] == "minecraft:fish" || $val["name"] == "fish") $val["name"] = "raw_fish";
				$item = Item::fromString($val["name"]);
				if (isset($val["functions"])) {
					foreach ($val["functions"] as $function) {
						switch ($functionname = $function["function"]) {
							case "set_damage": {
								if ($item instanceof Tool) $item->setDamage(mt_rand($function["damage"]["min"] * $item->getMaxDurability(), $function["damage"]["max"] * $item->getMaxDurability()));
								else $item->setDamage(mt_rand($function["damage"]["min"], $function["damage"]["max"]));
							}
								break;
							case "set_data": {
								//fish fix, blame mojang
								if ($item->getId() == Item::RAW_FISH) {
									switch ($function["data"]) {
										case 1:
											$item = Item::get(Item::RAW_SALMON, $item->getDamage(), $item->getCount(), $item->getCompoundTag());
											break;
										case 2:
											$item = Item::get(Item::CLOWN_FISH, $item->getDamage(), $item->getCount(), $item->getCompoundTag());
											break;
										case 3:
											$item = Item::get(Item::PUFFER_FISH, $item->getDamage(), $item->getCount(), $item->getCompoundTag());
											break;
										default:
											break;
									}
								} else $item->setDamage($function["data"]);
							}
								break;
							case "set_count": {
								$item->setCount(mt_rand($function["count"]["min"], $function["count"]["max"]));
							}
								break;
							case "furnace_smelt": {
								/* TODO
								Mostly bound to conditions (burning)
                            "conditions": [
                                {
                                    "condition": "entity_properties",
                                    "entity": "this",
                                    "properties": {
                                        "on_fire": true
                                    }
                                }
                            ]
								*/
							}
								break;
							case "enchant_randomly": {
								//TODO
							}
								break;
							case "enchant_with_levels": {
								//TODO
							}
								break;
							case "looting_enchant": {
								//TODO
							}
								break;
							default:
								assert("Unknown looting table function $functionname, skipping");
						}
					}
				}
				$items[] = $item;
			}
		}
		return $items;
	}

	public function getRandomWeightedElement(array $weightedValues) {
		$array = array();
		foreach ($weightedValues as $key => $weight) {
			$array = array_merge(array_fill(0, $weight, $key), $array);
		}
		return $array[array_rand($array)];
	}
}