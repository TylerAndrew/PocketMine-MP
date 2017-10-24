<?php

namespace pocketmine\entity;

use pocketmine\nbt\tag\IntTag;
use pocketmine\Player;

class ExperienceOrb extends Entity{
	const NETWORK_ID = self::XP_ORB;

	public $width = 0.1;
	public $length = 0.1;
	public $height = 0.1;

	protected $followrange = 5;
	protected $pickuprange = 1.2;
	protected $gravity = 0.01;
	protected $drag = 0;

	public $experience = 0;

	public function initEntity(){
		parent::initEntity();
		if (!isset($this->namedtag->Experience)){
			$this->close();
		} else{
			$this->setExperience($this->namedtag["Experience"]);
		}
	}

	public function FetchNearbyPlayer($DistanceRange){
		$MinDistance = $DistanceRange;
		$Target = null;
		foreach ($this->getLevel()->getPlayers() as $player){
			if ($player->isAlive() and $MinDistance >= $Distance = $player->distance($this)){
				$Target = $player;
				$MinDistance = $Distance;
			}
		}
		return $Target;
	}

	public function entityBaseTick(int $tickDiff = 1): bool{
		if ($this->closed){
			return false;
		}

		$this->timings->startTiming();

		$hasUpdate = parent::entityBaseTick($tickDiff);

		if ($this->age > 7000){
			$this->timings->stopTiming();
			$this->close();
			return true;
		}

		if (!$this->onGround){
			$this->motionY -= $this->gravity;
		}

		$Target = $this->FetchNearbyPlayer($this->followrange);
		if ($Target instanceof Player){
			$moveSpeed = 0.5;
			$motX = ($Target->getX() - $this->x) / 8;
			$motY = ($Target->getY()/* + $Target->getEyeHeight() */ - $this->y) / 8;
			$motZ = ($Target->getZ() - $this->z) / 8 /* * (1 / $Target->getZ())*/
			;
			$motSqrt = sqrt($motX * $motX + $motY * $motY + $motZ * $motZ);
			$motC = 1 - $motSqrt;

			if ($motC > 0){
				$motC *= $motC;
				$this->motionX = $motX / $motSqrt * $motC * $moveSpeed;
				$this->motionY = $motY / $motSqrt * $motC * $moveSpeed;
				$this->motionZ = $motZ / $motSqrt * $motC * $moveSpeed;
			}

			if ($Target->distance($this) <= $this->pickuprange){
				$this->timings->stopTiming();
				$this->close();
				if ($this->getExperience() > 0){
					$Target->setTotalXp($Target->getXpProgress() + $this->getExperience());
				}
				return true;
			}
		}

		$this->move($this->motionX, $this->motionY, $this->motionZ);

		$this->updateMovement();

		$this->timings->stopTiming();

		return $hasUpdate or !$this->onGround or abs($this->motionX) > 0.00001 or abs($this->motionY) > 0.00001 or abs($this->motionZ) > 0.00001;
	}

	public function canCollideWith(Entity $entity): bool{
		return false;
	}

	public function setExperience($exp){
		$this->experience = $exp;
	}

	public function getExperience(){
		return $this->experience;
	}

	public function saveNBT(){
		parent::saveNBT();
		$this->namedtag->Experience = new IntTag("Experience", $this->experience);
	}
}