<?php

namespace mazaicrafty\swordfight\command;

use pocketmine\command\CommandSender;

use mazaicrafty\swordfight\ConfigManager;

class WeaponCommand{

    private const COMMAND_LIST = "list";
    private const COMMAND_ADD = "add";
    private const COMMAND_REMOVE = "remove";

    private $sender;
    private $args = [];

    public function __construct(CommandSender $sender, array $args){
        $this->sender = $sender;
        $this->args = $args;
    }
    
    public function execute(): bool{
        $config = ConfigManager::getConfig();
        switch (true){
            case $this->args[1] === self::COMMAND_LIST:
                $weaponIds = implode(",\n", $config->get("weapon"));
                $this->sender->sendMessage(
                    "Weapons List\n".
                    $weaponIds
                );
                return true;
            case $this->args[1] === self::COMMAND_ADD:
                if (!isset($this->args[2])){
                    $this->sender->sendMessage("パラメータが不足しています");
                    return false;
                }
                $id = explode(':', $this->args[2]);
                if (!is_numeric($id[0]) || !is_numeric($id[1])){
                    $this->sender->sendMessage("数字で入力してください");
                    return false;
                }
                $this->sender->sendMessage($this->args[2] . "を追加しました");
                $weapons = $config->get('weapon');
                array_push($weapons, $this->args[2]);
                $config->set('weapon', $weapons);
                $config->save();
                return true;
            case $this->args[1] === self::COMMAND_REMOVE:
                if (!isset($this->args[2])){
                    $this->sender->sendMessage("パラメータが不足しています");
                    return false;
                }
                $id = explode(':', $this->args[2]);
                if (!is_numeric($id[0]) || !is_numeric($id[1])){
                    $this->sender->sendMessage("数字で入力してください");
                    return false;
                }
                $this->sender->sendMessage($this->args[2] . "を除外しました");
                $weapons = $config->get("weapon");
                foreach ($weapons as $weapon){
                    if ($weapon === $this->args[2]) continue;
                    $overwrite[] = $weapon;
                }
                $config->set("weapon", $overwrite);
                $config->save();
                return true;
        }
        return false;
    }
}
