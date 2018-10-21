<?php

namespace mazaicrafty\swordfight\command;

use pocketmine\command\CommandSender;

class WeaponCommand{

    private $sender;
    private $args = [];

    public function __construct(CommandSender $sender, array $args){
        $this->sender = $sender;
        $this->args = $args;
    }

    public function execute(): bool{
        $config = ConfigManager::getConfig();
        switch (true){
            case $this->args[1] === "list":
                $weaponIds = implode(",\n", $config->get("weapon"));
                $this->sender->sendMessage(
                    "Weapons List\n".
                    $weaponIds
                );
                return true;
            case $this->args[2] === "add":
                if (!isset($this->args[2]) || !isset($this->args[3])){
                    $this->sender->sendMessage("パラメータが不足しています");
                    return false;
                }
                $id = explode(':', $this->args[3]);
                if (!is_numeric($id[0] || !is_numeric($id[1]))){
                    $this->sender->sendMessage("数字で入力してください");
                    return false;
                }
                $this->sender->sendMessage($this->args[3] . "を追加しました");
                $weapons = $config->get('weapon');
                array_push($weapons, $this->args[2]);
                $config->set('weapon', $weapons);
                $config->save();
                return true;
            case $this->args[2] === "remove":
                if (!isset($this->args[2]) || !isset($this->args[3])){
                    $this->sender->sendMessage("パラメータが不足しています");
                    return false;
                }
                $id = explode(':', $this->args[3]);
                if (!is_numeric($id[0] || !is_numeric($id[1]))){
                    $this->sender->sendMessage("数字で入力してください");
                    return false;
                }
                $this->sender->sendMessage($this->args[3] . "を除外しました");
                $weapons = $config->get("weapon");
                array_splice($weapons, $this->args[3], 1);
                $config->set("weapon", $weapons);
                $config->save();
                return true;
        }
        return false;
    }
}
