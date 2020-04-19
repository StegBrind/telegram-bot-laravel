<?php

namespace App\Telegram\Commands\Phrases;

use App\Telegram\Interfaces\ExtraCommandInfo;
use Telegram\Bot\Commands\Command;

class MainMenuCommand extends Command implements ExtraCommandInfo
{
    public $name = 'Main menu';

    public function isHidden(): bool
    {
        return false;
    }

    public function isPhrase(): bool
    {
        return true;
    }

    public function handle($arguments)
    {
        $this->replyWithMessage(['reply_markup' => json_encode([
                'keyboard' => [
                    ['View companies'],
                    ['Add company']
                ],
                'resize_keyboard' => true
            ]),
            'text' => 'Back to Main menu'
        ]);
    }
}
