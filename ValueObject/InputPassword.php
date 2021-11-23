<?php

/**
 * ユーザーが入力したパスワード用のValueObject
 */
final class InputPassword
{
  
  const PASSWORD_REGULAR_EXPRESSIONS = "^(?=.*[A-Z])[a-zA-Z0-9.?/-]{8,24}$";
  const INVALID_MESSAGE = "パスワードの形式が正しくありません";

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
   * ユーザーが入力したパスワードをハッシュ化したパスワードに変換する
   * 
   * @return HashedPassword
   */
  public function hash(): HashedPassword
  {
    return new HashedPassword(password_hash($this->value, PASSWORD_DEFAULT));
  }

  private function isInvalid(string $value): bool
  {
    return !preg_match(self::PASSWORD_REGULAR_EXPRESSIONS, $value);
  }
}
