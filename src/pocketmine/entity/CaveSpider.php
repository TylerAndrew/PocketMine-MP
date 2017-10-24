<?php

namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;

class CaveSpider extends Monster{
	const NETWORK_ID = self::CAVE_SPIDER;

	public $width = 1.438;
	public $length = 1.188;
	public $height = 0.547;

	protected $exp_min = 5;
	protected $exp_max = 5;
	protected $maxHealth = 12;

	public function getName(): string{
		return "Cave Spider";
	}

	public function getDrops(): array{
		return [
			ItemItem::get(ItemItem::STRING, 0, mt_rand(0, 2)),
			ItemItem::get(ItemItem::SPIDER_EYE, 0, mt_rand(0, 1))
		];
	}

}
