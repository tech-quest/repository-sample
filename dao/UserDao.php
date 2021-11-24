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
	 * @param  NewUser $user
	 */
	public function create(NewUser $user): void
	{
		$hashedPassword = $user->password->hash();

		$sql = sprintf(
			"INSERT INTO %s (name, email, password) VALUES (:name, :email, :password)",
			self::TABLE_NAME
		);
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':name', $user->name->value(), PDO::PARAM_STR);
		$statement->bindValue(':email', $user->email->value(), PDO::PARAM_STR);
		$statement->bindValue(':password', $hashedPassword->value(), PDO::PARAM_STR);
		$statement->execute();
	}

	/**
	 * ユーザーを検索する
	 * @param  Email $mail
	 * @return array | null
	 */
	public function findByMail(Email $email): ?array
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
