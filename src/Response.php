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
        $data = [
            'status' => $this->status
        ];
        if ($this->message) {
            $data['message'] = $this->message;
        }
        return json_encode($data);
    }
}
