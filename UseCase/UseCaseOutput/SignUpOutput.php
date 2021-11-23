<?php

/**
 * ユーザー登録ユースケースの返り値
 */
final class SignUpOutput
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
     * コンストラクタ
     *
     * @param boolean $isSuccess
     * @param string $message
     */
    public function __construct(bool $isSuccess, string $message)
    {
        $this->isSuccess = $isSuccess;
        $this->message = $message;

        if (!$isSuccess) {
            $_SESSION['errors'][] = $message;
        }
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