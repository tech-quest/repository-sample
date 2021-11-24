<?php

final class UserRepository 
{
  /**
   * @var UserDao
   */
  private $userDao;

  public function __construct()
  {
    $this->userDao = new UserDao();
  }

  public function findByEmail(Email $email): ?User
  {
    $userMapper = $this->userDao->findByMail($email);

    if ($this->notExistsUser($userMapper)) {
      return null;
    }
    return new User(new UserId($userMapper['id']), new UserName($userMapper['name']), new Email($userMapper['email']), new HashedPassword($userMapper['password']));
  }

  private function notExistsUser(?array $user): bool
  {
    return is_null($user);
  }

  public function insert(UserName $name, Email $email, InputPassword $password): void
  {
    $this->userDao->create($name, $email, $password);
  }
}