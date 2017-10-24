<?php

namespace pocketmine\entity;

use pocketmine\block\Block;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item as ItemItem;
use pocketmine\level\particle\DestroyBlockParticle;

class Painting extends Hanging{
	const NETWORK_ID = self::PAINTING;

	const MOTIVES = [
		// Motive Width Height
		["Kebab", 1, 1],
		["Aztec", 1, 1],
		["Alban", 1, 1],
		["Aztec2", 1, 1],
		["Bomb", 1, 1],
		["Plant", 1, 1],
		["Wasteland", 1, 1],
		["Wanderer", 1, 2],
		["Graham", 1, 2],
		["Pool", 2, 1],
		["Courbet", 2, 1],
		["Sunset", 2, 1],
		["Sea", 2, 1],
		["Creebet", 2, 1],
		["Match", 2, 2],
		["Bust", 2, 2],
		["Stage", 2, 2],
		["Void", 2, 2],
		["SkullAndRoses", 2, 2],
		//array("Wither", 2, 2),
		["Fighters", 4, 2],
		["Skeleton", 4, 3],
		["DonkeyKong", 4, 3],
		["Pointer", 4, 4],
		["Pigscene", 4, 4],
		["Flaming Skull", 4, 4],
	];

	private $motive;


	public function initEntity(){
		$this->setMaxHealth(1);
		parent::initEntity();

		if (isset($this->namedtag->Motive)){
			$this->motive = $this->namedtag["Motive"];
		} else{
			$this->close();
		}
	}

	public function getName(): string{
		return "Painting";
	}

	public function getMotive(){
		return $this->motive;
	}

	public function attack(EntityDamageEvent $source){
		parent::attack($source);
		if ($source->isCancelled()) return;
		$this->level->addParticle(new DestroyBlockParticle($this->add(0.5), Block::get(Block::LADDER)));
		$this->kill();
	}

	protected function updateMovement(){
		//Nothing to update, paintings cannot move.
	}


	public function getDrops(): array{
		return [ItemItem::get(ItemItem::PAINTING, 0, 1)];
	}
}