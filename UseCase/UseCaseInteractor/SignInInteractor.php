<?php
require_once(__DIR__ . '/../../Repository/UserRepository.php');
require_once(__DIR__ . '/../../UseCase/UseCaseOutput/SignInOutput.php');
/**
 * ログインユースケース
 */
final class SignInInteractor
{
    /**
     * ログイン失敗時のエラーメッセージ
     */
    const FAILED_MESSAGE = "メールアドレスまたは<br />パスワードが間違っています";

    /**
     * ログイン成功時のメッセージ
     */
    const SUCCESS_MESSAGE = "ログインしました";

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var SignInInput
     */
    private $input;

    /**
     * コンストラクタ
     *
     * @param SignInInput $input
     */
    public function __construct(SignInInput $input)
    {
        $this->userRepository = new UserRepository();
        $this->input = $input;
    }

    /**
     * ログイン処理
     * セッションへのユーザー情報の保存も行う
     * 
     * @return SignInOutput
     */
    public function handler(): SignInOutput
    {
        $user = $this->findUser();

        if ($this->notExistsUser($user)) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        if ($this->isInvalidPassword($user->password())) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        $this->saveSession($user->id(), $user->name());

        return new SignInOutput(true, self::SUCCESS_MESSAGE);
    }

    /**
     * ユーザーを入力されたメールアドレスで検索する
     * 
     * @return User | null
     */
    private function findUser(): ?User
    {
        return $this->userRepository->findByEmail($this->input->email());
    }

    /**
     * ユーザーが存在しない場合
     *
     * @param User|null $user
     * @return boolean
     */
    private function notExistsUser(?User $user): bool
    {
        return is_null($user);
    }

    /**
     * パスワードが正しいかどうか
     *
     * @param HashedPassword $hashedPassword
     * @return boolean
     */
    private function isInvalidPassword(HashedPassword $hashedPassword): bool
    {
        return !$hashedPassword->verify($this->input->password());
    }

    /**
     * セッションの保存処理
     *
     * @param User $user
     * @return void
     */
    private function saveSession(UserId $id, UserName $name): void
    {
        $_SESSION['user']['id'] = $id->value();
        $_SESSION['user']['name'] = $name->value();
    }
}