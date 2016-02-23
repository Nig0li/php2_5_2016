<?php

namespace Components;


class Logger
{
    const FILE = 'logs.txt';

    protected $data = [];

    public function record($errors)
    {
        $this->data = [
            'date' => date('Y-d-m H:i:s'),
            'file' => $errors->getFile(),
            'line' => $errors->getLine(),
            'message' => $errors->getMessage(),
            'count' => count($errors->getTrace()),
        ];

        $mass = [];
        foreach ($this->data as $key => $value) {
            $mass[] = $key . ': ' . $value;
        }

        $str = implode("\n", $mass);

        file_put_contents(__DIR__ . '/../' . self::FILE, $str);
    }
}