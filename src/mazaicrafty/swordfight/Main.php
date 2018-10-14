<?php

namespace mazaicrafty\swordfight;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use mazaicrafty\swordfight\command\SwordFightCommand;
use mazaicrafty\swordfight\manage\DetectHandTask;
use mazaicrafty\swordfight\sound\SoundModule;

class Main extends PluginBase{

    private $config;
    private static $instance;

    protected function onLoad(): void{
        self::$instance = $this;
        SoundModule::init();
        ConfigManager::init();
    }

    protected function onEnable(): void{
        if (!file_exists($this->getDataFolder())){
            @mkdir($this->getDataFolder());
        }

        $this->getServer()->getCommandMap()->register(
            $this->getName(), new SwordFightCommand($this)
        );

        $this->getServer()->getPluginManager()->registerEvents(
            new EventListener($this), $this
        );

        $this->getScheduler()->scheduleRepeatingTask(
            new DetectHandTask($this), 20 * 1
        );
    }

    // only debug
    function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        return false;
    }

    public static function getInstance(): self{
        return self::$instance;
    }
}
