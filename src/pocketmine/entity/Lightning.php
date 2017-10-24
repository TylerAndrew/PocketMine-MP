<?php

namespace pocketmine\entity;

class Lightning extends Entity{
	const NETWORK_ID = self::LIGHTNING_BOLT;

	public $width = 0;
	public $length = 0;
	public $height = 0;

	public function entityBaseTick(int $tickDiff = 1): bool{
		if ($this->age > 1) $this->close();
		return true;
	}
}