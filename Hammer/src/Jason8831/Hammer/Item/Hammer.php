<?php

namespace Jason8831\Hammer\Item;

use Jason8831\Hammer\Main;
use pocketmine\block\BlockFactory;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\item\ItemFactory;
use pocketmine\utils\Config;

class Hammer implements Listener
{

    public function onBreak(BlockBreakEvent $event){
        $config = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);

        $hammer = $config->get("Hammer");
        $item = $event->getItem();
        $block = $event->getBlock();
        $minX = $block->getPosition()->add(-1,0,0)->getX();
        $maxX = $block->getPosition()->add(1,0,0)->getX();
        $minY = $block->getPosition()->add(0,-1,0)->getY();
        $maxY = $block->getPosition()->add(0,1,0)->getY();
        $minZ = $block->getPosition()->add(0,0,-1)->getZ();
        $maxZ = $block->getPosition()->add(0,0,1)->getZ();
        if ($item->getId() . ":" . $item->getMeta() === $hammer){
            for ($x = $minX; $x <= $maxX; $x++) {
                for ($y = $minY; $y <= $maxY; $y++) {
                    for ($z = $minZ; $z <= $maxZ; $z++) {
                        if($block->getPosition()->getWorld()->getBlockAt($x, $y, $z, true)->getId() == 7){
                            $event->cancel();
                        }else{
                            $air = BlockFactory::getInstance()->get(0, 0, 1);
                            $drop = $block->getPosition()->getWorld()->getBlockAt($x, $y, $z, true)->getId();
                            $drops = ItemFactory::getInstance()->get($drop, 0, 1);
                            $block->getPosition()->getWorld()->setBlockAt($x, $y, $z, $air, true);
                            $block->getPosition()->getWorld()->dropItem($block->getPosition(), $drops);
                        }
                    }
                }
            }
        }
    }
}