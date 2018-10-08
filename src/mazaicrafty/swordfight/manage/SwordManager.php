<?php

namespace mazaicrafty\swordfight\manage;

use pocketmine\Player;
use pocketmine\item\Item;

use mazaicrafty\swordfight\sound\Sound;
use mazaicrafty\swordfight\sound\SoundModule;

class SwordManager{

    private static $enablingFight = [];

    public static function setEnableFight(Player $player, array $data){
        self::setData($player, $data);
        $player->getLevel()->addSound(
            SoundModule::createSoundToPlayer(Sound::CLICK, $player)
        );
        $player->getInventory()->setItemInHand(self::getWeapon($player));
    }

    public static function removePlayer(Player $player){
        if (self::existsPlayer($player)){
            $player->getInventory()->removeItem(self::getWeapon($player));
            unset(self::$enablingFight[$player->getName()]);
        }
    }

    public static function existsPlayer(Player $player): bool{
        if (isset(self::$enablingFight[$player->getName()])){
            return true;
        }
        return false;
    }

    public static function setCoolTime(Player $player){
        self::setData($player, ['mode' => 'CT']);
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

    public static function getData(Player $player, string $key){
        return self::$enablingFight[$player->getName()][$key];
    }

    public static function getWeapon(Player $player): Item{
        return self::getData($player, 'using-weapon');
    }
}
