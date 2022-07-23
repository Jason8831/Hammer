<?php

namespace Jason8831\Hammer;

use Jason8831\Hammer\Events\PlayerItemHeldEvent;
use Jason8831\Hammer\Item\Hammer;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener
{

    public Config $config;

    /**
     * @var Main
     */
    private static $instance;

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->getLogger()->info("§f[§l§4Hammer§r§f]: activée");
        $this->saveResource("config.yml");

        $this->getServer()->getPluginManager()->registerEvents(new PlayerItemHeldEvent(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new Hammer(), $this);
    }

    public static function getInstance(): self{
        return self::$instance;
    }
}