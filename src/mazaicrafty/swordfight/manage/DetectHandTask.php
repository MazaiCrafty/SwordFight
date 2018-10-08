<?php

namespace mazaicrafty\swordfight\manage;

use pocketmine\scheduler\Task;
use pocketmine\item\Item;

use mazaicrafty\swordfight\Main;
use mazaicrafty\swordfight\enchantment\Enchant;
use mazaicrafty\swordfight\sound\Sound;
use mazaicrafty\swordfight\sound\SoundModule;

class DetectHandTask extends Task{

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
                    $weapon = SwordManager::getWeapon($player);
                    if ($weapon->getId() !== $player->getInventory()->getItemInHand()->getId()){
                        $this->plugin->getScheduler()->schedulerRepeatingTask(
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
        return $this->plugin->getConfig()->get('world');
    }

    public function getWeaponIds(): array{
        return $this->plugin->getConfig()->get('weapon');
    }
}
