<?php

namespace mazaicrafty\swordfight;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use mazaicrafty\swordfight\sound\SoundModule;

class Main extends PluginBase{

    private $config;
    private static $instance;

    protected function onLoad(): void{
        self::$instance = $this;
    }

    protected function onEnable(): void{
        if (!file_exists($this->getDataFolder())){
            @mkdir($this->getDataFolder());
        }

        $this->config = new Config($this->getDataFolder() . 'Config.yml', Config::YAML, [
            'enable-plugin' => true,
            'world' => ['world'],
            'weapon' => ['267'],
            'cool-time' => 5
        ]);

        new EventListener($this);
        SoundModule::init();

        $this->getScheduler()->schedulerRepeatingTask(
            
        );
    }

    public function getConfig(): Config{
        return $this->config;
    }

    public static function getInstance(): self{
        return self::$instance;
    }
}
