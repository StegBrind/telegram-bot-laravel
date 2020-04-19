<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetWebhook extends Command
{
    use \App\Telegram\Traits\SendTelegramData;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:webhook {url : Webhook URL}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets the webhook URL for Telegram server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->sendTelegramData('deleteWebhook');

        $result = $this->sendTelegramData('setWebhook', [
            'url' => $this->argument('url') . '/' . \Telegram::getAccessToken()
        ]);
        echo $result;
    }
}
