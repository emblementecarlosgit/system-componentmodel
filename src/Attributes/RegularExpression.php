<?php
declare(strict_types = 1);
namespace Attributes\Attributes;

#[Attribute(Attribute::TARGET_PROPERTY)]
class RegularExpression {
    private readonly string $message;
    private readonly string $expression;

    function __construct (string $expression, string $ErrorMessage = 'O Campo é obrigatório')
    {
        $this->message = $ErrorMessage;
        $this->expression = $expression;
    }

    public function validate (string $value)
    {
        if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $value)) {
            throw new \LengthException(message: $this->message);
        }
    }
}