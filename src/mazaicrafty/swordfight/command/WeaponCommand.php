<?php

namespace mazaicrafty\swordfight\command;

use pocketmine\Player;

class WeaponCommand{

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

                $id = explode(':', $this->args[3]);
                if (!is_numeric($id[0]) || !is_numeric($id[1])){
                    $this->player->sendMessage("数字で入力してください");
                    return false;
                }
                $config->set('weapon', [$this->args[3]]);
                $config->save();
                return true;
            case $this->args[2] === "remove":
                if (!isset($this->args[3])){
                    $this->player->sendMessage("パラメータが不足しています");
                    return false;
                }

                $id = explode(':', $this->args[3]);
                if (!is_numeric($id[0]) || !is_numeric($id[1])){
                    $this->player->sendMessage("数字で入力してください");
                    return false;
                }
                $weapons = $config->get("weapon");
                array_splice($weapons, $this->args[3], 1);
                $config->set("weapon", $weapons);
                $config->save();
                return true;
            case $this->args[2] === "list":
                $weaponIds = implode(",\n", $config->get("weapon"));
                $this->player->sendMessage(
                    "Weapons List\n".
                    $weaponIds
                );
                return true;
        }
    }
}
