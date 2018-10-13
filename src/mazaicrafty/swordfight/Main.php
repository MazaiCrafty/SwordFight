<?php

namespace mazaicrafty\swordfight;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use mazaicrafty\swordfight\manage\DetectHandTask;
use mazaicrafty\swordfight\sound\SoundModule;

class Main extends PluginBase{

    private $config;
    private static $instance;

    protected function onLoad(): void{
        self::$instance = $this;
        SoundModule::init();
    }

    protected function onEnable(): void{
        if (!file_exists($this->getDataFolder())){
            @mkdir($this->getDataFolder());
        }

        $this->config = new Config($this->getDataFolder() . 'Config.yml', Config::YAML, [
            'enable-plugin' => true,
            'world' => ['world'],
            'weapon' => ['267:0'],
            'cool-time' => 5
        ]);

        $this->getServer()->getPluginManager()->registerEvents(
            new EventListener(), $this
        );

        $this->getScheduler()->scheduleRepeatingTask(
            new DetectHandTask($this), 20 * 1
        );
    }

    public function getConfig(): Config{
        return $this->config;
    }

    public static function getInstance(): self{
        return self::$instance;
    }
}
