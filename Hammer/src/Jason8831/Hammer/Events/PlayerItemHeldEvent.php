<?php

namespace Jason8831\Hammer\Events;

use Jason8831\Hammer\Main;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

class PlayerItemHeldEvent implements Listener
{
    private $active = [];

    public function onItemHeld(\pocketmine\event\player\PlayerItemHeldEvent $event){

        $config = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);

        if($event->isCancelled())return;

        $player = $event->getPlayer();
        $item = $event->getItem();

        $hammer = $config->get("Hammer");
        if ($item->getId() . ":" . $item->getMeta() === $hammer){
            $this->active[$player->getName()] = true;
            $player->getEffects()->add(new EffectInstance(
                VanillaEffects::HASTE(),
                9999999, //temps
                $config->get( "niveauxEffectHaste"), //amplification
                false //visible
            ));
        }else{
            if(isset($this->active[$player->getName()])){
                $player->getEffects()->remove(VanillaEffects::HASTE());
                unset($this->active[$player->getName()]);
            }
        }
    }
}