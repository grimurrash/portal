<?php

namespace App\Dto;

readonly class OptionItemDto
{
    public function __construct(
        public int    $id,
        public string $label,
    )
    {
    }
}
