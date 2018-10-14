<?php

namespace mazaicrafty\swordfight\command;

use pocketmine\Player;

use mazaicrafty\swordfight\ConfigManager;

class CoolTimeCommand{
    
    private $player;
    private $args = [];

    public function __construct(Player $player, array $args){
        $this->player = $player;
        $this->args = $args;
    }

    public function execute(): bool{
        if (!(is_numeric($this->args[1]))){
            $this->sender->sendMessage("数字で入力してください");
            return false;
        }

        $config = ConfigManager::getConfig();
        $config->set('cool-time', $this->args[1]);
        $config->save();
        return true;
    }
}
