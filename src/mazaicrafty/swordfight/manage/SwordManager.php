<?php

namespace mazaicrafty\swordfight\manage;

use pocketmine\Player;
use pocketmine\item\Item;

class SwordManager{

    private static $enablingFight = [];

    public static function setEnableFight(Player $player, array $data){
        self::setData($player, $data);
        $player->getInventory()->setItemInHand(self::getWeapon($player));
    }

    public static function existsPlayer(Player $player): bool{
        if (isset(self::$enablingFight[$player->getName()])){
            return true;
        }
        return false;
    }

    public static function isCoolTime(Player $player): bool{
        if (self::getData($player, 'mode') === 'CT'){
            return true;
        }
        return false;
    }

    public static function setData(Player $player, array $data){
        self::$enablingFight[$player->getName()] = $data;
    }

    public static function getData(Player $player, string $data){
        return self::$enablingFight[$player->getName()][$data];
    }

    public static function getWeapon(Player $player): Item{
        return self::getData($player, 'using-weapon');
    }
}
