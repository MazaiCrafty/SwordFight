<?php

namespace mazaicrafty\swordfight\command;

use pocketmine\command\CommandSender;

use mazaicrafty\swordfight\ConfigManager;

class CoolTimeCommand{
    
    private $sender;
    private $args = [];

    public function __construct(CommandSender $sender, array $args){
        $this->sender = $sender;
        $this->args = $args;
    }

    public function execute(): bool{
        if (!(is_numeric($this->args[1]))){
            $this->sender->sendMessage("数字で入力してください");
            return false;
        }
        $this->sender->sendMessage($this->args[1] . "秒に設定しました");
        $config = ConfigManager::getConfig();
        $config->set('cool-time', $this->args[1]);
        $config->save();
        return true;
    }
}
