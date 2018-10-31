<?php

namespace mazaicrafty\swordfight\manage;

use pocketmine\Player;
use pocketmine\item\Item;

use mazaicrafty\swordfight\sound\Sound;
use mazaicrafty\swordfight\sound\SoundModule;

class SwordManager{

    private static $enablingFight = [];

    private function __construct(){ }

    /**
     * @param   Player  $player
     * @param   array   $data
     */
    public static function setEnableFight(Player $player, array $data): void{
        self::setData($player, $data);
        $player->getLevel()->addSound(
            SoundModule::createSoundToPlayer(Sound::CLICK, $player)
        );
        $player->getInventory()->setItemInHand(self::getWeapon($player));
    }

    /**
     * @param   Player  $player
     */
    public static function removePlayer(Player $player): void{
        if (self::existsPlayer($player)){
            $weapon = self::getWeapon($player);
            $player->getInventory()->removeItem($weapon);
            $player->getInventory()->addItem(Item::get($weapon->getId(), $weapon->getDamage(), 1));
            unset(self::$enablingFight[$player->getName()]);
        }
    }

    /**
     * @param   Player  $player
     * @return  Boolean
     */
    public static function existsPlayer(Player $player): bool{
        if (isset(self::$enablingFight[$player->getName()])){
            return true;
        }
        return false;
    }

    /**
     * @param   Player  $player
     */
    public static function setCoolTime(Player $player): void{
        self::setData($player, ['cool-time' => true]);
    }

    /**
     * @param   Player  $player
     * @return  Boolean
     */
    public static function isCoolTime(Player $player): bool{
        return self::getData($player, 'cool-time');
    }

    /**
     * @param   Player  $player
     * @param   Array   $data
     */
    public static function setData(Player $player, array $data){
        foreach ($data as $key => $value){
            self::$enablingFight[$player->getName()][$key] = $value;
        }
    }

    /**
     * @param   Player  $player
     * @param   String  $key
     */
    public static function getData(Player $player, string $key){
        return self::$enablingFight[$player->getName()][$key];
    }

    /**
     * @param   Player  $player
     * @return  Item
     */
    public static function getWeapon(Player $player): Item{
        return self::getData($player, 'using-weapon');
    }
}
