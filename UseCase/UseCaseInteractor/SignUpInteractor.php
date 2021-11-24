<?php

/**
 * ユーザー登録ユースケース
 */
final class SignUpInteractor
{
  const ALLREADY_EXISTS_MESSAGE = "すでに登録済みのメールアドレスです";
  const COMPLETED_MESSAGE = "登録が完了しました";

  /**
   * @var SignUpInput
   */
  private $input;

  /**
   * コンストラクタ
   *
   * @param SignUpInput $input
   */
  public function __construct(SignUpInput $input)
  {
    $this->userDao = new UserDao();
    $this->input = $input;
  }

  /**
   * ユーザー登録処理
   * すでに存在するメールアドレスの場合はエラーとする
   *
   * @return SignUpOutput
   */
  public function handler(): SignUpOutput
  {
    $user = $this->findUser();

    if ($this->isExistsUser($user)) {
      return new SignUpOutput(false, self::ALLREADY_EXISTS_MESSAGE);
    }

    $this->signup();
    return new SignUpOutput(true, self::COMPLETED_MESSAGE);
  }

  /**
   * ユーザーを入力されたメールアドレスで検索する
   *
   * @return array
   */
  private function findUser(): User
  {
    return $this->userDao->findByMail($this->input->email());
  }

  /**
   * ユーザーが存在するかどうか
   *
   * @param array|null $user
   * @return boolean
   */
  private function isExistsUser(?User $user): bool
  {
    return !is_null($user);
  }

  /**
   * ユーザーを登録する
   *
   * @return void
   */
  private function signup(): void
  {
    $this->userDao->create($this->input->name(), $this->input->email(), $this->input->password());
  }
}