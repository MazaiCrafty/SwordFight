<?php

namespace mazaicrafty\swordfight;

use pocketmine\utils\Config;

class ConfigManager{

    private static $config;

    public static function init(){
        self::$config = new Config(Main::getInstance()->getDataFolder() . 'Config.yml', Config::YAML, [
            'enable-plugin' => true,
            'world' => ['world'],
            'weapon' => ['267:0'],
            'cool-time' => 5
        ]);
    }

    public static function getConfig(): Config{
        return self::$config;
    }
}
