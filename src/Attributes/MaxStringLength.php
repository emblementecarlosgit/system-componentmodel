<?php
declare(strict_types = 1);
namespace Attributes\Attributes;

#[Attribute(Attribute::TARGET_PROPERTY)]
class MaxStringLength {
    public int $value;
    public readonly string $message;

    function __construct(int $value, string $ErrorMessage = 'Valor é menor do que o permitido.')
    {
        $this->value = $value;
        $this->message = $ErrorMessage;
    }

    public function validate (int $value)
    {
        if ($value > $this->value) {
            throw new \LengthException(message: $this->message);
        }
    }
}