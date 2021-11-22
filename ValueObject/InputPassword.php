<?php

final class InputPassword
{
  private $value;

  public function __construct(string $value)
  {
    $this->value = $value;
  }

  public function value(): string
  {
    return $this->value;
  }

  public function hash(): string
  {
    return password_hash($this->value, PASSWORD_DEFAULT);
  }
}
