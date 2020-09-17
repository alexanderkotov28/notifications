<?php


namespace AlexanderKotov\Notifications\Connectors;


use AlexanderKotov\Notifications\Response;
use Carbon\Carbon;

class TelegramConnector extends AbstractConnector implements ConnectorInterface
{
    private $token;
    protected $chats = [];
    protected $text;
    protected $not_empty = ['chats', 'text'];

    const EXECUTABLE = true;

    public function __construct($chat_id)
    {
        $this->chats = is_array($chat_id) ? $chat_id : [$chat_id];
    }

    public function text(string $text): TelegramConnector
    {
        $this->text = $text;
        return $this;
    }

    public function send(): Response
    {
        $this->validate();
        foreach ($this->chats as $chat) {
            $res = $this->sendMessage($chat);
            if ($res !== true) {
                return $res;
            }
        }

        $this->setExecuted();
        return new Response('success');
    }

    public function date(Carbon $date)
    {
        $this->validate();
        $this->createModel('email', $date, $this->getData());
    }

    public function getData(): array
    {
        return [
            'text' => $this->text,
            'chats' => $this->chats
        ];
    }

    public function setConfig(?array $data)
    {
        if (!isset($data['token'])) {
            throw new \Exception('Please fill config data for "telegram" in your config/notifications.php');
        }
        $this->token = $data['token'];
    }

    public static function generateFromData(array $data): TelegramConnector
    {
        $connector = new self($data['chats']);
        $connector->text($data['text']);
        return $connector;
    }

    private function sendMessage($chat_id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.telegram.org/bot' . $this->token . '/sendMessage',
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => [
                'chat_id' => $chat_id,
                'text' => $this->text
            ]
        ]);
        $curl_resp = curl_exec($curl);
        curl_close($curl);
        if ($curl_resp === false) {
            throw new \Exception('Try to use VPN');
        }
        $curl_resp = json_decode($curl_resp);
        if (!$curl_resp->ok) {
            return new Response('error', $curl_resp->description);
        }
        return true;
    }
}
