<?php
declare(strict_types=1);

namespace Models;

require_once 'src/lib/DatabaseConnection.php';

use Database\DatabaseConnection;
use DateTime;
use PDO;
use RuntimeException;
use Utils\Blob;
use function array_values;
use function Lib\Utils\display_icon;
use function strtolower;

enum Color: int {
	case Orange = 0;
	case Purple = 1;
	case Blue = 2;
	case Gray = 3;

	public static function fromInt(int $value): self {
		return match ($value) {
			1 => self::Purple,
			2 => self::Blue,
			3 => self::Gray,
			default => self::Orange,
		};
	}

	public function lowercaseName(): string {
		return strtolower($this->name);
	}
}

enum Background: int {
	case Light = 0;
	case Gray = 1;
	case Black = 2;

	public static function fromInt(int $value): self {
		return match ($value) {
			1 => self::Gray,
			2 => self::Black,
			default => self::Light,
		};
	}

	public static function frenchName(self $background): string {
		return match ($background) {
			self::Light => 'Blanc',
			self::Gray => 'Gris',
			self::Black => 'Noir',
		};
	}

	public function lowercaseName(): string {
		return strtolower($this->name);
	}
}

class User {
	public ?Blob $avatar = null;
	public Background $background;
	public DateTime $birthDate;
	public Color $color;
	public DateTime $createdAt;

	public function __construct(
		public float   $id,
		public string  $username,
		public string  $password,
		?string        $avatar,
		string         $createdAt,
		string         $birthDate,
		public ?string $display_name,
		int            $color,
		int            $background,
		public string  $gender,
		public string  $email,
		public ?string $bio,
	) {
		$this->background = Background::fromInt($background);
		$this->birthDate = date_create_from_format('Y-m-d', $birthDate);
		$this->createdAt = date_create_from_format('Y-m-d H:i:s', $createdAt);
		$this->color = Color::fromInt($color);
		if ($avatar !== null) {
			$this->avatar = new Blob($avatar);
		}
	}

	public function getDisplayOrUsername(): string {
		return htmlspecialchars($this->display_name ?? $this->username);
	}

	public function displayAvatar(): string {
		return $this->avatar?->toLink() ?? display_icon($this);
	}
}

class UserRepository {
	public PDO $databaseConnection;

	public function __construct() {
		$this->databaseConnection = (new DatabaseConnection())->getConnection();
	}

	public function createUser(string $username, string $email, string $password, string $gender, DateTime $birth_date): bool {
		$statement = $this->databaseConnection->prepare(
			'INSERT INTO users (birth_date, email, sexe, password, username) VALUES (:birth_date, :email, :sexe, :password, :username)'
		);

		$password = password_hash($password, PASSWORD_DEFAULT);

		$result = $statement->execute([
			'birth_date' => $birth_date->format('Y-m-d'),
			'email' => $email,
			'sexe' => $gender,
			'password' => $password,
			'username' => $username,
		]);

		return $result || throw new RuntimeException('Could not create user');
	}

	public function deleteUserById(float $id): void {
		$statement = $this->databaseConnection->prepare('DELETE FROM users WHERE id = :id');
		$statement->execute(compact('id'));
	}

	/**
	 * @param float $id
	 * @return Array<User>
	 */
	public function getFriendsOfUser(float $id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM users WHERE id IN (SELECT requested_id FROM friends WHERE requester_id = :id)');
		$statement->execute(compact('id'));
		$users = [];

		while ($user = $statement->fetch(PDO::FETCH_ASSOC)) {
			$users[] = new User(...array_values($user));
		}

		return $users;
	}

	public function getUserById(float $id): ?User {
		$statement = $this->databaseConnection->prepare('SELECT * FROM users WHERE id = :id');
		$statement->execute(compact('id'));
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		if ($result === false) return null;
		return new User(...array_values($result));
	}

	public function isUserAlreadyRegistered(string $email, string $username): bool {
		$statement = $this->databaseConnection->prepare('SELECT * FROM users WHERE email = :email OR username = :username');
		$statement->execute(compact('email', 'username'));
		$user = $statement->fetch(PDO::FETCH_ASSOC);
		return $user !== false;
	}

	public function getUserByEmail(string $email): ?User {
		$statement = $this->databaseConnection->prepare('SELECT * FROM users WHERE email = :email');
		$statement->execute(compact('email'));
		$user = $statement->fetch(PDO::FETCH_ASSOC);
		if ($user === false) return null;
		return new User(...array_values($user));
	}

	public function getUserByUsername(string $username): ?User {
		$statement = $this->databaseConnection->prepare('SELECT * FROM users WHERE username = :username');
		$statement->execute(compact('username'));
		$user = $statement->fetch(PDO::FETCH_ASSOC);
		if ($user === false) return null;
		return new User(...array_values($user));
	}

	public function loginUser(string $email, string $password): ?User {
		$statement = $this->databaseConnection->prepare(
			'SELECT * FROM users WHERE (email = :email OR username = :email)'
		);

		$statement->execute(compact('email'));
		$user = $statement->fetch(PDO::FETCH_ASSOC);
		if ($user === false) return null;

		$password_good = $this->checkHash($email, $password);
		if (!$password_good) return null;
		return new User(...array_values($user));
	}

	public function checkHash(string $email, string $password): bool {
		$statement = $this->databaseConnection->prepare(
			'SELECT password FROM users WHERE (email = :email OR username = :email)'
		);

		$statement->execute(compact('email'));
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return password_verify($password, $result['password']);
	}

	public function updateUser(User $user): bool {
		$statement = $this->databaseConnection->prepare(
			'UPDATE users
			SET
				avatar = :avatar,
				background = :background,
				bio = :bio,
				birth_date = :birth_date,
				color = :color,
				display_name = :display_name,
				email = :email,
				sexe = :gender,
				password = :password,
				username = :username
				WHERE
					id = :id'
		);

		$result = $statement->execute([
			'avatar' => $user->avatar?->data,
			'background' => $user->background->value,
			'bio' => $user->bio,
			'birth_date' => $user->birthDate->format('Y-m-d'),
			'color' => $user->color->value,
			'display_name' => $user->display_name,
			'email' => $user->email,
			'gender' => $user->gender,
			'password' => $user->password,
			'username' => $user->username,
			'id' => $user->id,
		]);

		return $result === false ? throw new RuntimeException('Could not update user') : true;
	}
}
