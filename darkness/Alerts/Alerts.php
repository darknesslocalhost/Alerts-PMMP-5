<?php

namespace darkness\Alerts;

use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
use pocketmine\server\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

class Alerts extends PluginBase {
    private $config;

    public function onEnable(): void {
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

    public function onDisable(): void {
        $this->config->save();
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
        if ($cmd->getName() == "alert") {
            if ($sender->hasPermission("darknesspl.alerts.command")) {
                $wiadomosc = trim(implode(" ", $args));
                $alertTitle = $this->config->get("alertTitle");
                $alertColor = $this->config->get("alertColor");
                $messageColor = $this->config->get("messageColor");
                foreach ($this->getServer()->getOnlinePlayers() as $p) {
                    $p->sendTitle("$alertColor$alertTitle", "$messageColor$wiadomosc", 0, 20 * 2, 0);
                }
            }
        }
        return true;
    }
}
