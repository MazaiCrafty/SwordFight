<?php

namespace mazaicrafty\swordfight\command;

use pocketmine\Player;

class WorldCommand{

    private $player;
    private $args = [];

    public function __construct(Player $player, array $args){
        $this->player = $player;
        $this->args = $args;
    }

    public function execute(): bool{
        if (!isset($this->args[2])){
            $this->player->sendMessage("パラメータが不足しています");
            return false;
        }
        
        $config = ConfigManager::getConfig();
        switch (true){
            case $this->args[2] === "add":
                if (!isset($this->args[3])){
                    $this->player->sendMessage("パラメータが不足しています");
                    return false;
                }

                $config->set('world', [$this->args[3]]);
                $config->save();
                return true;
            case $this->args[2] === "remove":
                if (!isset($this->args[3])){
                    $this->player->sendMessage("パラメータが不足しています");
                    return false;
                }

                $worlds = $config->get("world");
                array_splice($worlds, $this->args[3], 1);
                $config->set("world", $worlds);
                $config->save();
                return true;
            case $this->args[2] === "list":
                $worlds = implode(",\n", $config->get("world"));
                $this->player->sendMessage(
                    "Worlds List\n".
                    $worlds
                );
                return true;
        }
    }
}
