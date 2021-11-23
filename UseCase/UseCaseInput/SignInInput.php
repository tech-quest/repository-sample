<?php

/**
 * ログインユースケースの入力値
 */
final class SignInInput
{
    /**
     * @var Email
     */
    private $email;

    /**
     * @var InputPassword
     */
    private $password;

    /**
     * コンストラクタ
     * 
     * @param Email $email
     * @param InputPassword $password
     */
    public function __construct(Email $email, InputPassword $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * @return InputPassword
     */
    public function password(): InputPassword
    {
        return $this->password;
    }
}