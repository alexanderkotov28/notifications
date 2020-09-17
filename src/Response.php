<?php


namespace AlexanderKotov\Notifications;


class Response
{
    private $status;
    private $message;

    public function __construct(string $status, string $message = '')
    {
        $this->status = $status;
        $this->message = $message;
    }

    public function __toString(): string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }

    public function toArray()
    {
        $data = [
            'status' => $this->status
        ];
        if ($this->message) {
            $data['message'] = $this->message;
        }
        return $data;
    }
}
