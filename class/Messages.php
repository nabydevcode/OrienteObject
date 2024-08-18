<?php
class Messages
{
    private string $username;
    private string $mes;
    private $date;

    public function __construct($username, $mes, $date = null)
    {
        $this->username = $username;
        $this->mes = $mes;
        if ($date === null) {
            $this->date = new DateTime();
        } else {
            $this->date = $date;
        }
    }

    public function is_valid(): bool
    {
        return empty($this->getError());
    }
    public function getError(): array
    {
        $errors = [];
        if (strlen($this->username) < 3) {
            $errors['username'] = "Votre noms est trop court";
        }
        if (strlen($this->mes) < 10) {
            $errors['message'] = "Votre Message doit depasser au moins 10 carracteres ";
        }
        return $errors;
    }
    public function toJSON(): string
    {
        return json_encode([
            'username' => $this->username,
            'message' => $this->mes,
            'date' => $this->date->getTimestamp()
        ]);
    }
    public function toHTML(): string
    {
        $username = htmlentities($this->username);
        $message = htmlentities($this->mes);
        $this->date->setTimezone(new DateTimeZone('Europe/Paris'));
        $date = $this->date->format('d/m/y à H:i');
        return <<<HTML
        <p>
            <strong>{$username}</strong> 
            <strong><em>{$date}</em></strong> <br/>
            {$message}
        </p>
    HTML;

    }

}