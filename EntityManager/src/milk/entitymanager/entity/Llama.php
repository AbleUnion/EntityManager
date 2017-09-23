<?php

namespace milk\entitymanager\entity;

use pocketmine\entity\Rideable;
use pocketmine\network\mcpe\protocol\MobArmorEquipmentPacket;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\entity\Creature;
use pocketmine\entity\entity;

class Llama extends Animal implements Rideable{
    const NETWORK_ID = 29;
    const CREAMY = 0;
	  const WHITE = 1;
	  const BROWN = 2;
	  const GRAY = 3;

    public $width = 1.6;
    public $length = 0.8;
    public $height = 1.12;

    public function getName(){
        return "Llama";
    }

    public function initEntity(){
        $this->setMaxHealth(30);
        if(isset($this->namedtag->Health)){
            $this->setHealth((int) $this->namedtag["Health"]);
        }else{
            $this->setHealth($this->getMaxHealth());
        }
       $this->setDataProperty(Entity::DATA_VARIANT, Entity::DATA_TYPE_INT, rand(0, 3));
        parent::initEntity();
        $this->created = true;
    }

    public function targetOption(Creature $creature, $distance){
    	if($creature instanceof Player)
        	return $creature->spawned && $creature->isAlive() && !$creature->closed && $creature->getInventory()->getItemInHand()->getId() == Item::CARROT && $distance <= 49;
    	return false;
    }
    public function getDrops(){
        if($this->lastDamageCause instanceof EntityDamageByEntityEvent){
            return [Item::get(Item::RAW_PORKCHOP, 0, 1)];
        }
        return [];
    }

}