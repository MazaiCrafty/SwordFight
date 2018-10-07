<?php

namespace mazaicrafty\swordfight\sound;

use pocketmine\level\sound\AnvilBreakSound;
use pocketmine\level\sound\AnvilFallSound;
use pocketmine\level\sound\AnvilUseSound;
use pocketmine\level\sound\BatSound;
use pocketmine\level\sound\BlazeShootSound;
use pocketmine\level\sound\ClickSound;
use pocketmine\level\sound\DoorBumpSound;
use pocketmine\level\sound\DoorCrashSound;
use pocketmine\level\sound\DoorSound;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\level\sound\FizzSound;
use pocketmine\level\sound\GhastShootSound;
use pocketmine\level\sound\GhastSound;
use pocketmine\level\sound\LaunchSound;
use pocketmine\level\sound\PopSound;
use pocketmine\level\sound\GenericSound;
use pocketmine\math\Vector3;

class SoundModule{

    private $sounds = [];

    public static function init(){
        self::$sounds[Sound::ANVIL_BREAK] = AnvilBreakSound::class;
        self::$sounds[Sound::ANVIL_FALL] = AnvilFallSound::class;
        self::$sounds[Sound::ANVIL_USE] = AnvilUseSound::class;
        self::$sounds[Sound::BAT] = BatSound::class;
        self::$sounds[Sound::BLAZESHOOT] = BlazeShootSound::class;
        self::$sounds[Sound::CLICK] = ClickSound::class;
        self::$sounds[Sound::DOOR_BUMP] = DoorBumpSound::class;
        self::$sounds[Sound::DOOR_CRASH] = DoorCrashSound::class;
        self::$sounds[Sound::DOOR] = DoorSound::class;
        self::$sounds[Sound::ENDERMAN_TELEPORT] = EndermanTeleportSound::class;
        self::$sounds[Sound::FIZZ] = FizzSound::class;
        self::$sounds[Sound::GHAST_SHOOT] = GhastShootSound::class;
        self::$sounds[Sound::GHAST] = GhastSound::class;
        self::$sounds[Sound::LAUNCH] = LaunchSound::class;
        self::$sounds[Sound::POP] = PopSound::class;
        self::$sounds[Sound::GENERIC] = GenericSound::class;
    }

    public static function createSoundToPlayer(int $soundId, Player $player, float $pitch = 0, int $id = null){
        $vector3 = new Vector3($player->getX(), $player->getY(), $player->getZ());
        return self::createSound($sound, $vector3, $pitch, $id);
    }

    public static function createSound(int $soundId, Vector3 $pos, float $pitch = 0, int $id = null){
        $sound = self::$sounds[$soundId];
        if ($soundId === Sound::GENERIC){
            return new $soundInstance($pos, $id, $pitch);
        }
        return new $sound($pos, $pitch);
    }
}
