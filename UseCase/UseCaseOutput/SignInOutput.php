<?php

/**
 * ログインユースケースの返り値
 */
final class SignInOutput
{
    /**
     * @var bool
     */
    private $isSuccess;

    /**
     * @var string
     */
    private $message;
    
    /**
     * @var User
     */
    public function __construct(bool $isSuccess, string $message)
    {
        $this->isSuccess = $isSuccess;
        $this->message = $message;
    }
    
    public function isSuccess(): bool
    {
      return $this->isSuccess;
    }

    public function message(): string
    {
      return $this->message;
    }
}