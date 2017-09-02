<?php

namespace pocketmine\entity;

use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\level\Explosion;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class EnderCrystal extends Living implements Explosive{
	const NETWORK_ID = 71;

	public $height = 1;
	public $width = 1;
	public $length = 1;//TODO: Size

	public function initEntity(){
		$this->setMaxHealth(1);
		parent::initEntity();
	}

	public function getName(): string{
		return "Ender Crystal";
	}

	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->entityRuntimeId = $this->getId();
		$pk->type = self::NETWORK_ID;
		$pk->position = $this->asVector3();
		$pk->motion = $this->getMotion();
		$pk->yaw = $this->yaw;
		$pk->pitch = $this->pitch;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}

	public function kill(){
		if (!$this->isAlive()){
			return;
		}
		$this->explode();
		if (!$this->closed){
			$this->close();
		}
	}

	protected function applyGravity(){}

	public function explode(){
		$this->server->getPluginManager()->callEvent($ev = new ExplosionPrimeEvent($this, 6));

		if (!$ev->isCancelled()){
			$pos = $this->asPosition();
			$explosion = new Explosion($pos, $ev->getForce(), $this);
			$this->close();
			if ($ev->isBlockBreaking()){
				$explosion->explodeA();
			}
			$explosion->explodeB();
		}
	}
}
