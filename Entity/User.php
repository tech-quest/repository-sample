<?php

require_once __DIR__ . '/../ValueObject/User/UserId.php';
require_once __DIR__ . '/../ValueObject/User/UserName.php';
require_once __DIR__ . '/../ValueObject/Email.php';
require_once __DIR__ . '/../ValueObject/InputPassword.php';

/**
 * ユーザーのEntity
 */
final class User
{
    /**
     * @var UserId
     */
    private $id;

    /**
     * @var UserName
     */
    private $name;

    /**
     * @var Email
     */
    private $email;

    /**
     * @var HashedPassword
     */
    private $password;

    /**
     * コンストラクタ
     *
     * @param UserId $id
     * @param UserName $name
     * @param Email $email
     * @param HashedPassword $password
     */
    public function __construct(
        UserId $id,
        UserName $name,
        Email $email,
        HashedPassword $password
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return UserId
     */
    public function id(): UserId
    {
        return $this->id;
    }

    /**
     * @return UserName
     */
    public function name(): UserName
    {
        return $this->name;
    }

    /**
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * @return HashedPassword
     */
    public function password(): HashedPassword
    {
        return $this->password;
    }
}