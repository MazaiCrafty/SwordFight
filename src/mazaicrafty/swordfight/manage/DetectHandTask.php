<?php

namespace mazaicrafty\swordfight\manage;

use pocketmine\scheduler\Task;
use pocketmine\item\Item;

use mazaicrafty\swordfight\Main;
use mazaicrafty\swordfight\ConfigManager;
use mazaicrafty\swordfight\enchantment\Enchant;
use mazaicrafty\swordfight\sound\Sound;
use mazaicrafty\swordfight\sound\SoundModule;

class DetectHandTask extends Task{

    // Air itemID
    const AIR = 0;

    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function onRun(int $currentTick): void{
        foreach ($this->getPlayers() as $player){
            foreach ($this->getWorlds() as $world){
                if ($player->getLevel()->getName() !== $world){
                    continue;
                }
                if (SwordManager::existsPlayer($player)){
                    if (SwordManager::isCoolTime($player)) continue;
                    if ($player->getInventory()->getItemInHand()->getId() === self::AIR){
                        $this->plugin->getScheduler()->scheduleRepeatingTask(
                            new CoolTimeTask($player), 20 * 1
                        );
                    }
                    continue;
                }

                foreach ($this->getWeaponIds() as $weaponId){
                    if ($player->getInventory()->getItemInHand()->getId() == $weaponId){
                        $id = explode(':', $weaponId);
                        $item = Item::get((int) $id[0], (int) $id[1], 1);
                        $instance = new Enchant($item, 0, 1);
                        $item->addEnchantment($instance->enchant());
                        SwordManager::setEnableFight($player, [
                            'using-weapon' => $item,
                            'mode' => 'FIGHT'
                        ]);
                    }
                }
            }
        }
    }

    public function getPlayers(): array{
        return $this->plugin->getServer()->getOnlinePlayers();
    }

    public function getWorlds(): array{
        return ConfigManager::getConfig()->get('world');
    }

    public function getWeaponIds(): array{
        return ConfigManager::getConfig()->get('weapon');
    }
}
