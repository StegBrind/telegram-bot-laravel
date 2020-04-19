<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;
use Telegram\Bot\Objects\Update;

class TelegramController extends Controller
{
    private Update $webhookUpdate;

    public function webhook(Request $request)
    {
        $this->webhookUpdate = Telegram::getWebhookUpdate();
        $telegramUser = \Auth::guard('telegram_user')->user();

        if ($this->webhookUpdate->isType('callback_query'))
        {
            $this->handleCallbackQuery();
            return response('');
        }

        if ($telegramUser != null)
        {
            //continue solving multi step command
            if (!empty($telegramUser->current_action))
            {
                Telegram::triggerCommand($telegramUser->current_action['command'], $this->webhookUpdate);
                return response('');
            }
        }

        Telegram::commandsHandler(true); //handles command with a slash

        $this->handlePhraseCommand();
    }


    /**
     * Triggers CallbackQuery date as a command
     *
     */
    private function handleCallbackQuery()
    {
        $callbackQuery = $this->webhookUpdate->getCallbackQuery();

        $this->webhookUpdate->put('message', collect([
            'from' => $callbackQuery->getFrom(),
            'chat' => $callbackQuery->getMessage()->getChat(),
            'text' => $callbackQuery->getData()
        ]));
        Telegram::triggerCommand($callbackQuery->getData(), $this->webhookUpdate);
    }

    private function handlePhraseCommand()
    {
        $message_text = $this->webhookUpdate->getMessage()->getText();

        if ($message_text[0] != '/')
            Telegram::triggerCommand($message_text, $this->webhookUpdate);
    }
}
