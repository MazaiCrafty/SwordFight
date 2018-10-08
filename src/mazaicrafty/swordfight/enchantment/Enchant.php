<?php

namespace mazaicrafty\swordfight\enchantment;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;

class Enchant{

    private $weapon;
    private $id;
    private $level;

    public function __construct(Item $weapon, int $id, int $level){
        $this->weapon = $weapon;
        $this->id = $id;
        $this->level = $level;
    }

    public function enchant(): EnchantmentInstance{
        return new EnchantmentInstance(
            Enchantment::getEnchantment($this->id), $this->level
        );
    }
}
