<?php

namespace RevivalPMMP\WelcomeMessage;


use pocketmine\Player;
use pocketmine\scheduler\PluginTask;


class BroadcastTitle extends PluginTask {

	private $player;
	private $msg;


	public function __construct(Player $player){
		parent::__construct(WelcomeMessage::getInstance());
		$this->player = $player;
		$this->msg = WelcomeMessage::getInstance()->getMessage();
	}
	public function onRun(int $currentTick){
		$this->player->getServer()->broadcastTitle($this->msg[WelcomeMessage::TITLE],
			$this->msg[WelcomeMessage::SUBTITLE],
			$this->msg[WelcomeMessage::FADE_IN],
			$this->msg[WelcomeMessage::STAY],
			$this->msg[WelcomeMessage::FADE_OUT],
			[$this->player]
		);
	}
}