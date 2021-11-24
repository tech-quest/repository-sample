<?php

/**
 * ユーザー情報を操作するDAO
 */
final class UserDao
{
	/**
	 * DBのテーブル名
	 */
	const TABLE_NAME = 'users';

	/**
	 * @var [type]
	 */
	private $pdo;

	/**
	 * コンストラクタ
	 * @param PDO $pdo
	 */
	public function __construct()
	{
		try {
			$this->pdo = new PDO('mysql:dbname=blog;host=localhost;charset=utf8', 'root', 'root');
		} catch (PDOException $e) {
			exit('DB接続エラー:' . $e->getMessage());
		}
	}

	/**
	 * ユーザーを追加する
	 * @param  UserName $name
	 * @param  Email $email
	 * @param  InputPassword $password
	 */
	public function create(UserName $name, Email $email, InputPassword $password): void
	{
		$hashedPassword = $password->hash();

		$sql = sprintf(
			"INSERT INTO %s (name, email, password) VALUES (:name, :email, :password)",
			self::TABLE_NAME
		);
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':name', $name->value(), PDO::PARAM_STR);
		$statement->bindValue(':email', $email->value(), PDO::PARAM_STR);
		$statement->bindValue(':password', $hashedPassword->value(), PDO::PARAM_STR);
		$statement->execute();
	}

	/**
	 * ユーザーを検索する
	 * @param  Email $email
	 * @return array | null
	 */
	public function findByEmail(Email $email): ?array
	{
		$sql = sprintf(
			"SELECT * FROM %s WHERE email = :email",
			self::TABLE_NAME
		);
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':email', $email->value(), PDO::PARAM_STR);
		$statement->execute();
		$user = $statement->fetch(PDO::FETCH_ASSOC);

		return $user === false ? null : $user;
	}
}
