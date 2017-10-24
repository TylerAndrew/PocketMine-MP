<?php

namespace pocketmine\entity;

class Wolf extends Animal implements Tameable, Colorable{
	const NETWORK_ID = self::WOLF;

	public $height = 0.969;
	public $width = 0.5;
	public $lenght = 1.594;

	protected $exp_min = 1;
	protected $exp_max = 3;

	public function initEntity(){
		$this->setMaxHealth(8);//untamed
		parent::initEntity();
	}

	public function getName(): string{
		return "Wolf";
	}

	public function isTamed(){
		return false;
	}

	public function canBeLeashed(){
		return $this->isTamed();//TODO: distance check
	}
}
