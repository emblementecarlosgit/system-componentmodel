<?php
declare(strict_types = 1);
namespace Attributes\Attributes;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Range {
    public int|float $value;
    public int|float $second;
    public readonly string $message;

    function __construct(int|float $value, int|float $second, string $ErrorMessage = 'Valor é menor do que o permitido.')
    {
        $this->value = $value;
        $this->second = $second;
        $this->message = $ErrorMessage;
    }

    public function validate (int $value)
    {
        if ((($value < $this->value) || ($value > $this->second))) {
            throw new \LengthException(message: $this->message);
        }
    }
}