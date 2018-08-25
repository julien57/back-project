<?php

namespace Project;

interface FormatInterface
{
    public function getLimitTakers(array $takers, int $limit, ?int $offset = 0);

    public function getByName(array $takers, string $name);

    public function getByOffset(array $takers, int $offset);
}