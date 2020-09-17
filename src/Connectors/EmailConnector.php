<?php


namespace AlexanderKotov\Notifications\Connectors;


use AlexanderKotov\Notifications\NotificationModel;
use AlexanderKotov\Notifications\Response;
use Carbon\Carbon;

class EmailConnector implements ConnectorInterface
{
    private $emails = [];
    private $subject;
    private $text;
    private $host;
    private $port;
    private $username;
    private $password;
    private $from_name;

    public function __construct($emails)
    {
        $this->emails = is_array($emails) ? $emails : [$emails];
    }

    public function subject(string $subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function fromName(string $from_name)
    {
        $this->from_name = $from_name;
        return $this;
    }

    public function text(string $text)
    {
        $this->text = $text;
        return $this;
    }

    public function send(): Response
    {
        $transport = (new \Swift_SmtpTransport($this->host, $this->port))->setUsername($this->username)->setPassword($this->password);
        $transport->setEncryption('ssl');
        $mailer = new \Swift_Mailer($transport);
        $message = (new \Swift_Message($this->subject))->setFrom([$this->username => $this->from_name])->setTo($this->emails)->setBody($this->text);

        try {
            $mailer->send($message);
        } catch (\Exception $e) {
            return new Response('error', $e->getMessage());
        }
        return new Response('success');
    }

    public function setConfig(?array $data)
    {
        $this->host = $data['host'];
        $this->port = $data['port'];
        $this->username = $data['username'];
        $this->password = $data['password'];
    }

    public function date(Carbon $date)
    {
        NotificationModel::create([
            'connector' => 'email',
            'execute_at' => $date,
            'data' => $this->getData()
        ]);
    }

    public function getData(): array
    {
        return [
            'subject' => $this->subject,
            'from_name' => $this->from_name,
            'text' => $this->text,
            'emails' => $this->emails
        ];
    }

    public static function generateFromData(array $data):EmailConnector
    {
        return new self($data['emails']);
    }
}
