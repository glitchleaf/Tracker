<?php

namespace App\Telegram\Commands;

use App\Models\Event;
use App\Models\Setting;
use App\Models\User;
use Telegram\Bot\Commands\Command as BaseCommand;
use Telegram\Bot\Keyboard\Keyboard;

abstract class Command extends BaseCommand {
	/**
	 * Whether the command should be hidden from the help output
	 */
	public bool $hidden = false;

	/**
	 * If true, the command should only be displayed in authenticated chats.
	 * If false, the command should only be displayed in unauthenticated chats.
	 * If null, the command should always be displayed.
	 */
	public ?bool $authVisibility = null;

	/**
	 * Check whether the command should be visible in the help command, taking into account authentication status
	 */
	public function isVisible(bool $authed): bool {
		if ($this->hidden) return false;
		if ($this->authVisibility === null) return true;
		return $this->authVisibility === $authed;
	}

	/**
	 * Gets the user associated with the Telegram chat. If there isn't one, then reply with a message.
	 */
	protected function getChatUserOrReply(): ?User {
		$chatId = $this->getUpdate()->getChat()->id;
		$user = User::whereTgChatId($chatId)->first();
		if (!$user) {
			$this->replyWithMessage([
				'text' => "I don't have a BLFC volunteer account associated with you yet. Please link your account by scanning a QR code at the volunteer desk.",
			]);
		}
		return $user;
	}

	/**
	 * Gets the active event. If there isn't one, then reply with a message.
	 */
	protected function getActiveEventOrReply(): ?Event {
		$event = Setting::activeEvent();
		if (!$event) {
			$this->replyWithMessage([
				'text' => "Enthusiastic, are we? There isn't any ongoing event right now. Soon™!",
				'reply_markup' => $this->buildStandardActionsKeyboard(),
			]);
		}
		return $event;
	}

	/**
	 * Builds reply markup for a keyboard that contains a list of standard actions while authenticated
	 */
	protected function buildStandardActionsKeyboard(): Keyboard {
		$keyboard = new Keyboard();
		$keyboard->setResizeKeyboard(true)
			->setIsPersistent(true)
			->row([
				'/code',
				'/hours',
				'/rewards',
			]);
		return $keyboard;
	}
}