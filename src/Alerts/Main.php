<?php

namespace Alerts;

use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
use pocketmine\server\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config; 

class Main extends PluginBase {
	public function onEnable(): void {
		$this->getLogger()->info("Plugin enabled");
		$this->saveResource("config.yml");
		$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
	}
	public function onDisable(): void {
		$this->getLogger()->info("Plugin disabled");
		$this->config->save();
        $this->getLogger()->info("Config saved");
	}
	public function onCommand(CommandSender $sender, Command $cmd, String $label, array $args): bool {
		if ($cmd->getName() == "alert") {
			if ($sender->hasPermission("alert.command")) {
				$wiadomosc = trim(implode(" ", $args));
				$alertTitle = $this->PluginBase->getConfig("alertTitle");
				$alertColor = $this->PluginBase->getConfig("alertColor");
				$messageColor = $this->PluginBase->getConfig("messageColor");
				foreach ($this->getServer()->getOnlinePlayers() as $p) {
					$p->sendTitle("$alertColor$alertTitle", "$messageColor$wiadomosc", 0, 20 * 2, 0);
				}
			}
		}
		return false;
	}
}
