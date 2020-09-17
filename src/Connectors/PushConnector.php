<?php


namespace AlexanderKotov\Notifications\Connectors;


use AlexanderKotov\Notifications\Response;
use Carbon\Carbon;

class PushConnector extends AbstractConnector implements ConnectorInterface
{
    private $text;
    protected $not_empty = ['user_id', 'text'];

    public function __construct($user_id = null)
    {
        if (!is_null($user_id)){
            $this->setUser($user_id);
        }
    }

    public function text(string $text)
    {
        $this->text = $text;
        return $this;
    }

    public function setConfig(?array $data)
    {
        // TODO: Implement setConfig() method.
    }

    public function send(): Response
    {
        $this->validate();
        if (!$this->model) {
            $this->createModel('push', Carbon::now(), $this->getData());
        } else {
            $this->setExecuted();
        }
        return new Response('success');
    }

    public function date(Carbon $date)
    {
        $this->validate();
        $this->createModel('push', $date, $this->getData());
    }

    public function getData(): array
    {
        return [
            'text' => $this->text
        ];
    }

    public static function generateFromData(array $data)
    {
        return new self();
    }
}
