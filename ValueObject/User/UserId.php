<?php

/**
 * ユーザーIDのValueObject
 */
final class UserId
{
    const INVALID_MESSAGE = '不正な値です';

    /**
     * @var int
     */
    private $value;

    public function __construct(string $value)
    {
        if ($this->isInvalid($value)) {
            throw new Exception(self::INVALID_MESSAGE);
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * 正の整数かどうかを判定する
     *
     * @param string $value
     * @return boolean
     */
    private function isInvalid(string $value): bool
    {
        return !preg_match('\+?[1-9][0-9]*', $value);
    }
}