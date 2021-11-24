<?php
require_once(__DIR__ . '/../../UseCase/UseCaseOutput/SignUpOutput.php');

/**
 * ユーザー登録ユースケース
 */
final class SignUpInteractor
{
  /**
   * メールアドレスがすでに存在している場合のエラーメッセージ
   */
  const ALLREADY_EXISTS_MESSAGE = "すでに登録済みのメールアドレスです";

  /**
   * ユーザー登録成功時のメッセージ
   */
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
    $userMapper = $this->findUser();

    if ($this->existsUser($userMapper)) {
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
  private function findUser(): ?array
  {
    return $this->userDao->findByEmail($this->input->email());
  }

  /**
   * ユーザーが存在するかどうか
   *
   * @param array|null $user
   * @return boolean
   */
  private function existsUser(?array $user): bool
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