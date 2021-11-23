<?php
final class UserDao
{
	const TABLE_NAME = 'users';
	private $pdo;

	public function __construct()
	{
		try {
			$this->pdo = new PDO('mysql:dbname=blog;host=localhost;charset=utf8', 'root', 'root');
		} catch (PDOException $e) {
			exit('DB接続エラー:' . $e->getMessage());
		}
	}

	public function create(UserName $name, Email $mail, InputPassword $password): void
	{
		$hashedPassword = $password->hash();

		$sql = sprintf(
			"INSERT INTO %s (name, mail, password) VALUES (:name, :mail, :password)",
			self::TABLE_NAME
		);
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':name', $name->value(), PDO::PARAM_STR);
		$statement->bindValue(':mail', $mail->value(), PDO::PARAM_STR);
		$statement->bindValue(':password', $hashedPassword->value(), PDO::PARAM_STR);
		$statement->execute();
	}

	public function findByMail(Email $mail): ?array
	{
		$sql = sprintf(
			"SELECT * FROM %s WHERE mail = :mail",
			self::TABLE_NAME
		);
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':mail', $mail->value(), PDO::PARAM_STR);
		$statement->execute();
		$user = $statement->fetch(PDO::FETCH_ASSOC);

		return $user === false ? null : $user;
	}
}
