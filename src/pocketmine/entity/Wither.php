<?php

namespace pocketmine\entity;

use pocketmine\entity\projectile\ProjectileSource;
use pocketmine\item\Item as ItemItem;

class Wither extends Boss implements ProjectileSource{
	const NETWORK_ID = self::WITHER;

	public $height = 2;
	public $width = 3;
	public $lenght = 1;//TODO: check

	protected $exp_min = 20;
	protected $exp_max = 20;

	public function initEntity(){
		$this->setMaxHealth(600);
		parent::initEntity();
	}

	public function getName(): string{
		return "Wither Boss";
	}

	public function getDrops(): array{
		return [ItemItem::get(ItemItem::NETHER_STAR)];
	}
}
