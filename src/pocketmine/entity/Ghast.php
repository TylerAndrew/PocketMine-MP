<?php

namespace pocketmine\entity;

use pocketmine\entity\projectile\ProjectileSource;
use pocketmine\item\Item as ItemItem;

class Ghast extends Monster implements ProjectileSource{
	const NETWORK_ID = self::GHAST;

	public $width = 4.5;
	public $length = 4.5;
	public $height = 4.5;

	public static $range = 16;
	public static $speed = 0.25;
	public static $jump = 1.8;
	public static $mindist = 3;

	protected $exp_min = 5;
	protected $exp_max = 5;

	public function initEntity(){
		$this->setMaxHealth(10);
		parent::initEntity();
	}

	public function getName(): string{
		return "Ghast";
	}

	public function getDrops(): array{
		return [
			ItemItem::get(ItemItem::GHAST_TEAR, 0, mt_rand(0, 1)),
			ItemItem::get(ItemItem::GUNPOWDER, 0, mt_rand(0, 2))
		];
	}

}
