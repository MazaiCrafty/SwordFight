<?php

namespace mazaicrafty\swordfight\command;

use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;

use mazaicrafty\swordfight\Main;

class SwordFightCommand extends PluginCommand{

    public function __construct(Main $plugin){
        parent::__construct("sf", $plugin);
        $this->setDescription("edit config");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool{
        if (!$sender->isOp() && !$sender instanceof ConsoleCommandSender){
            $sender->sendMessage("権限がありません");
            return false;
        }

        if (!isset($args[0]) || !isset($args[1])){
            $sender->sendMessage(
                "/sf <ct/weapon/world>\n".
                "ct <count>\n".
                "weapon <add/remove/list> <id:meta>\n".
                "world <add/remoce/list> <id:meta>"
            );
            return false;
        }

        switch (true){
            case $args[0] === "ct":
                $command = new CoolTimeCommand($sender, $args);
                return $command->execute();
            case $args[0] === "weapon":
                $command = new WeaponCommand($sender, $args);
                return $command->execute();
            case $args[0] === "world":
                $command = new WorldCommand($sender, $args);
                return $command->execute();
        }
        return false;
    }
}
