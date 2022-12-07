<?php
declare(strict_types = 1);
namespace Attributes\Attributes;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Required {
    private readonly string $message;

    function __construct (string $ErrorMessage = 'O Campo é obrigatório')
    {
        $this->message = $ErrorMessage;
    }

    public function validate (?string $value)
    {
        if (empty($value)) {
            throw new \LengthException(message: $this->message);
        }
    }
}