<?php

/**
 * ユーザー登録ユースケースの入力値
 */
final class SignUpInput
{
  /**
   * @var UserName
   */
  private $name;

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
   * @param UserName $name
   * @param Email $email
   * @param InputPassword $password
   */
  public function __construct(UserName $name, Email $email, InputPassword $password)
  {
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
  }

  public function name(): UserName
  {
    return $this->name;
  }

  public function email(): Email
  {
    return $this->email;
  }

  public function password(): InputPassword
  {
    return $this->password;
  }
}