<?php
require_once ('class/Messages.php');
class GuesBook
{
    private string $file;
    public function __construct($file)
    {
        $directory = dirname($file);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        if (!file_exists($file)) {
            touch($file);
        }
        $this->file = $file;
    }
    public function addMessage(Messages $mes): void
    {
        file_put_contents($this->file, $mes->toJSON() . PHP_EOL, FILE_APPEND);
    }
    public function getMessage(): array
    {
        $contents = trim(file_get_contents($this->file));
        $lines = explode(PHP_EOL, $contents);
        $messages = [];
        foreach ($lines as $line) {
            $data = json_decode($line, true);
            $messages[] = new Messages($data['username'], $data['message'], new DateTime('@' . $data['date']));
        }
        return array_reverse($messages);
    }
}