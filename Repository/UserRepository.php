<?php
require_once(__DIR__ . '/../Entity/User.php');
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

    return ($this->notExistsUser($userMapper)) 
      ? null 
      : new User(
          new UserId($userMapper['id']),
          new UserName($userMapper['name']), 
          new Email($userMapper['email']), 
          new HashedPassword($userMapper['password']));
  }

  private function notExistsUser(?array $user): bool
  {
    return is_null($user);
  }

  public function insert(NewUser $user): void
  {
    $this->userDao->create($user->name, $user->email, $user->password);
  }
}