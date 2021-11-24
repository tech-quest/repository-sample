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
	 * @param  Email $mail
	 * @param  InputPassword $password
	 */
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

	/**
	 * ユーザーを検索する
	 * @param  Email $mail
	 * @return array | null
	 */
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
