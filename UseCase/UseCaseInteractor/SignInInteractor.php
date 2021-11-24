<?php
require_once(__DIR__ . '/../../UseCase/UseCaseOutput/SignInOutput.php');
require_once(__DIR__ . '/../../Entity/User.php');

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
     * @var UserDao
     */
    private $userDao;

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
        $this->userDao = new UserDao();
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
        $userMapper = $this->findUser();

        if ($this->notExistsUser($userMapper)) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        $user = $this->buildUserEntity($userMapper);

        if ($this->isInvalidPassword($user->password())) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        $this->saveSession($user);

        return new SignInOutput(true, self::SUCCESS_MESSAGE);
    }

    /**
     * ユーザーを入力されたメールアドレスで検索する
     * 
     * @return array | null
     */
    private function findUser(): ?array
    {
        return $this->userDao->findByEmail($this->input->email());
    }

    /**
     * ユーザーが存在しない場合
     *
     * @param array|null $user
     * @return boolean
     */
    private function notExistsUser(?array $user): bool
    {
        return is_null($user);
    }

    private function buildUserEntity(array $user): User
    {
        return new User(
            new UserId($user['id']), 
            new UserName($user['name']), 
            new Email($user['email']), 
            new HashedPassword($user['password']));
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
    private function saveSession(User $user): void
    {
        $_SESSION['user']['id'] = $user->id()->value();
        $_SESSION['user']['name'] = $user->name()->value();
    }
}