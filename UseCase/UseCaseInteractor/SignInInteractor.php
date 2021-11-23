<?php 

/**
 * ログインユースケース
 */
final class SignInInteractor
{
    const FAILED_MESSAGE = "メールアドレスまたは<br />パスワードが間違っています";
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
     * 
     * @return SignInOutput
     */
    public function handler(): SignInOutput
    {
        $user = $this->findUser();

        if ($this->notExistsUser($user)) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        $hashedPassword = new HashedPassword($user['password']);

        if ($this->isInvalidPassword($hashedPassword)) {
            return new SignInOutput(false, self::FAILED_MESSAGE);
        }

        $this->saveSession($user);

        return new SignInOutput(true, self::SUCCESS_MESSAGE);
    }

    /**
     * ユーザーを入力されたメールアドレスで検索する
     * 
     * @return array
     */
    private function findUser(): array
    {
        return $this->userDao->findByMail($this->input->email());
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
     * @param array $user
     * @return void
     */
    private function saveSession(array $user): void
    {
        $_SESSION['user']['id'] = $user['id'];
        $_SESSION['user']['name'] = $user['name'];
    }
}