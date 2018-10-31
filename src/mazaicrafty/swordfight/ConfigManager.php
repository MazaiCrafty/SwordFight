<?php

namespace mazaicrafty\swordfight;

use pocketmine\utils\Config;

class ConfigManager{

    private static $config;
    private static $message;

    public static function init(){
        $plugin = Main::getInstance();
        self::$config = new Config($plugin->getDataFolder() . 'Config.yml', Config::YAML, [
            'enable-plugin' => true,
            'world' => ['world'],
            'weapon' => ['267:0'],
            'cool-time' => 5,
            'pvpmode-on-sound' => 6,
            'pvpmode-off-sound' => 5,
            'cool-time-sound' => 6
        ]);
        $plugin->saveResource('Messages.yml');
        self::$message = new Config($plugin->getDataFolder() . 'Messages.yml', Config::YAML);
    }

    /**
     * @return Config
     */
    public static function getConfig(): Config{
        return self::$config;
    }

    /**
     * @param   String  $key
     * @return  String
     */
    public static function getMessage(string $key): string{
        return self::$message->get($key);
    }
}
