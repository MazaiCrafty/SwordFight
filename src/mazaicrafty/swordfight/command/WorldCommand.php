<?php

namespace mazaicrafty\swordfight\command;

use pocketmine\command\CommandSender;

use mazaicrafty\swordfight\ConfigManager;

class WorldCommand{

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
                $worlds = implode(",\n", $config->get("world"));
                $this->sender->sendMessage(
                    "Worlds List\n".
                    $worlds
                );
                return true;
            case $this->args[1] === self::COMMAND_ADD:
                if (!isset($this->args[2])){
                    $this->sender->sendMessage("パラメータが不足しています");
                    return false;
                }
                $this->sender->sendMessage($this->args[2] . "を追加しました");
                $worlds = $config->get('world');
                array_push($worlds, $this->args[2]);
                $config->set('world', $worlds);
                $config->save();
                return true;
            case $this->args[1] === self::COMMAND_REMOVE:
                if (!isset($this->args[2])){
                    $this->sender->sendMessage("パラメータが不足しています");
                    return false;
                }
                $this->sender->sendMessage($this->args[2] . "を除外しました");
                $worlds = $config->get("world");
                foreach ($worlds as $world){
                    if ($world === $this->args[2]) continue;
                    $overwrite[] = $world;
                }
                $config->set("world", $overwrite);
                $config->save();
                return true;
        }
        return false;
    }
}
