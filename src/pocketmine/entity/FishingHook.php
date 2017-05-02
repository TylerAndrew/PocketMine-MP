<?php

namespace pocketmine\entity;

use pocketmine\block\Lava;
use pocketmine\block\Water;
use pocketmine\entity\Item as DroppedItem;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TempLootGenerator;

class FishingHook extends Projectile {
	const NETWORK_ID = 77;

	public $width = 0.25;
	public $length = 0.25;
	public $height = 0.25;
	protected $gravity = 0.1;
	protected $drag = 0.05;
	private $loottable = null;

	public function __construct(Level $level, CompoundTag $nbt, Entity $shootingEntity = null) {
		parent::__construct($level, $nbt, $shootingEntity);
		$this->loottable = new TempLootGenerator(new Config(Server::getInstance()->getFilePath() . "src/pocketmine/resources/loot_tables/gameplay/fishing.json", Config::JSON, []));
	}

	public function initEntity() {
		parent::initEntity();
		$this->setDataProperty(self::DATA_OWNER_EID, self::DATA_TYPE_LONG, $this->getOwner()->getId());
	}

	/**
	 * @return Player|Entity
	 */
	private function getOwner() {
		return $this->shootingEntity;
	}

	public function onUpdate($currentTick) {
		if ($this->closed) {
			return false;
		}

		if ($this->getOwner() === null) {
			$this->close();
			return true;
		}

		#$this->timings->startTiming();

		$hasUpdate = parent::onUpdate($currentTick);

		if ($this->onGround) {
			$hasUpdate = false;
		}
		if (/*$this->hasCollision*/
		true
		) {
			if ($this->isInsideOfWater() && $this->level->getBlock($this->add(0, 1)) instanceof Water) {//move to surface of water
				$this->setMotion($this->getMotion()->add(0, .1, 0));//todo: only do this as long motion is negative y
				$hasUpdate = true;
			} elseif ($this->level->getBlock($this) instanceof Lava) {//kill
				$this->kill();
			}
		}

		#$this->timings->stopTiming();

		if ($hasUpdate) {

		}

		return $hasUpdate;
	}

	public function kill() {
		$this->setHealth(0);
		$this->getOwner()->reelRod();
		$this->scheduleUpdate();
	}

	public function canCollideWith(Entity $entity) {
		//return $this->canBeHooked($entity) and !$this->onGround; #BlameArrows //todo
		return false;
	}

	public function canBeHooked(Entity $entity) {
		return ($entity instanceof DroppedItem || ($entity instanceof Living && !$entity instanceof AreaEffectCloud && !$entity instanceof Projectile && !$entity instanceof ExperienceOrb && !$entity->getId() == $this->getOwner()->getId()));
	}

	public function retrieve() {
		if($this->isInsideOfWater()) $this->createLoot();
		$this->getOwner()->reelRod();
	}

	public function createLoot() {
		foreach ($this->loottable->getRandomLoot() as $loot) {
			$this->getLevel()->dropItem($this, $loot, $this->getOwner()->subtract($this));
		}
	}

	public function spawnTo(Player $player) {
		$pk = new AddEntityPacket();
		$pk->type = self::NETWORK_ID;
		$pk->eid = $this->getId();
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->speedX = $this->motionX;
		$pk->speedY = $this->motionY;
		$pk->speedZ = $this->motionZ;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}
}