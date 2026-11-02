<?php

$number = 10;
$string = 'Строка';
$user = [
    'name' => 'Иван',
    'age' => 22
];

function getNumber(int $number): int
{
    return $number * 2;
}

class User
{
    private string $name;
    private int $age;

    public function __construct(string $name, int $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function calculateAge(): int
    {
        return $this->age * 2;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}

$user = new User('Иван', 22);

var_dump($user);
