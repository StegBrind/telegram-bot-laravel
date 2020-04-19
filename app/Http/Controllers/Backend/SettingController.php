<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use \App\Telegram\Traits\SendTelegramData;

    public function makeChanges(Request $request)
    {
        if ($request->type == 'webhook')
        {
            return $this->setWebhook($request);
        }
    }

    public function showWebhook()
    {
        return redirect()->route('setting')->with([
            'show_info' => $this->sendTelegramData('getWebhookInfo')]);
    }

    private function setWebhook(Request $request)
    {
        $this->sendTelegramData('deleteWebhook');
        $result = $this->sendTelegramData('setWebhook', [
            'url' => $request->url_webhook . '/' . \Telegram::getAccessToken()
        ]);
        return redirect()->route('setting')->with(['show_info' => $result]);
    }
}
