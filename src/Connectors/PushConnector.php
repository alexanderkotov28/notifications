<?php


namespace AlexanderKotov\Notifications\Connectors;


use AlexanderKotov\Notifications\Response;
use Carbon\Carbon;

class PushConnector extends AbstractConnector implements ConnectorInterface
{
	protected $topic;
    protected $text;
    protected $type;
    protected $not_empty = ['user_id', 'text', 'type'];

    public function __construct($user_id = null)
    {
        if (!is_null($user_id)){
            $this->setUser($user_id);
        }
    }

	public function topic(string $topic)
	{
		$this->topic = $topic;
		return $this;
	}

	public function text(string $text)
    {
        $this->text = $text;
        return $this;
    }

	public function type(string $type)
    {
        $this->type = $type;
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
            'topic' => $this->topic,
            'text' => $this->text,
            'type' => $this->type
        ];
    }

    public static function generateFromData(array $data)
    {
        return new self();
    }
}
