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

/**
 * Enum Color is used to represent the different themes that the user can choose.
 */
enum Color: int {
	case Orange = 0;
	case Purple = 1;
	case Blue = 2;
	case Gray = 3;

	/**
	 * fromInt returns the Color corresponding to the given int.
	 * @param int $value - The int to convert.
	 * @return static - The Color corresponding to the given int.
	 */
	public static function fromInt(int $value): self {
		return match ($value) {
			1 => self::Purple,
			2 => self::Blue,
			3 => self::Gray,
			default => self::Orange,
		};
	}

	/**
	 * lowercaseName returns the lowercase name of the Color.
	 * @return string - The lowercase name of the Color.
	 */
	public function lowercaseName(): string {
		return strtolower($this->name);
	}
}

/**
 * Enum Background is used to represent the different backgrounds that the user can choose.
 */
enum Background: int {
	case Light = 0;
	case Gray = 1;
	case Black = 2;

	/**
	 * fromInt returns the Background corresponding to the given int.
	 * @param int $value - The int to convert.
	 * @return static - The Background corresponding to the given int.
	 */
	public static function fromInt(int $value): self {
		return match ($value) {
			1 => self::Gray,
			2 => self::Black,
			default => self::Light,
		};
	}

	/**
	 * frenchName returns the french name of the Background.
	 * @param Background $background - The Background to get the french name.
	 * @return string - The french name of the Background.
	 */
	public static function frenchName(self $background): string {
		return match ($background) {
			self::Light => 'Blanc',
			self::Gray => 'Gris',
			self::Black => 'Noir',
		};
	}

	/**
	 * lowercaseName returns the lowercase name of the Background.
	 * @return string - The lowercase name of the Background.
	 */
	public function lowercaseName(): string {
		return strtolower($this->name);
	}
}

/**
 * Class User represents a user in the database.
 */
class User {
	public ?Blob $avatar = null;
	public Background $background;
	public DateTime $birthDate;
	public Color $color;
	public DateTime $createdAt;

	/**
	 * __construct creates a new User.
	 * @param float $id - The id of the User.
	 * @param string $username - The username of the User.
	 * @param string $password - The password of the User.
	 * @param string|null $avatar - The avatar of the User.
	 * @param string $createdAt - The creation date of the User.
	 * @param string $birthDate - The birth date of the User.
	 * @param string|null $display_name - The display name of the User.
	 * @param int $color - The color of the User.
	 * @param int $background - The background of the User.
	 * @param string $gender - The gender of the User.
	 * @param string $email - The email of the User.
	 * @param string|null $bio - The bio of the User.
	 */
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

	/**
	 * getDisplayOrUsername returns the display name of the User if it is not null, otherwise it returns the username.
	 * @return string - The display name of the User if it is not null, otherwise it returns the username.
	 */
	public function getDisplayOrUsername(): string {
		return htmlspecialchars($this->display_name ?? $this->username);
	}

	/**
	 * displayAvatar displays the avatar of the User.
	 * @return string - The HTML code to display the avatar of the User.
	 */
	public function displayAvatar(): string {
		return $this->avatar?->data ?? display_icon($this);
	}
}

/**
 * Class UserRepository is used to interact with the users table in the database.
 */
class UserRepository {
	public PDO $databaseConnection;

	/**
	 * __construct is the constructor of the class
	 */
	public function __construct() {
		$this->databaseConnection = (new DatabaseConnection())->getConnection();
	}

	/**
	 * createUser creates a new user in the database.
	 * @param string $username - The username of the user.
	 * @param string $email - The email of the user.
	 * @param string $password - The password of the user.
	 * @param string $gender - The gender of the user.
	 * @param DateTime $birth_date - The birth date of the user.
	 * @return bool - True if the user has been created, false otherwise.
	 */
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

	/**
	 * deleteUserById deletes the user with the given id.
	 * @param float $id - The id of the user to delete.
	 * @return void - This function does not return a value.
	 */
	public function deleteUserById(float $id): void {
		$statement = $this->databaseConnection->prepare('DELETE FROM users WHERE id = :id');
		$statement->execute(compact('id'));
	}

	/**
	 * getUserById returns the user with the given id.
	 * @param float $id - The id of the user to get.
	 * @return User|null - The user with the given id, null if the user does not exist.
	 */
	public function getUserById(float $id): ?User {
		$statement = $this->databaseConnection->prepare('SELECT * FROM users WHERE id = :id');
		$statement->execute(compact('id'));
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		if ($result === false) return null;
		return new User(...array_values($result));
	}

	/**
	 * isUserAlreadyRegistered checks if the user is already registered.
	 * @param string $email - The email of the user.
	 * @param string $username - The username of the user.
	 * @return bool - True if the user is already registered, false otherwise.
	 */
	public function isUserAlreadyRegistered(string $email, string $username): bool {
		$statement = $this->databaseConnection->prepare('SELECT * FROM users WHERE email = :email OR username = :username');
		$statement->execute(compact('email', 'username'));
		$user = $statement->fetch(PDO::FETCH_ASSOC);
		return $user !== false;
	}

	/**
	 * getUserByEmail returns the user with the given email.
	 * @param string $email - The email of the user to get.
	 * @return User|null - The user with the given email, null if the user does not exist.
	 */
	public function getUserByEmail(string $email): ?User {
		$statement = $this->databaseConnection->prepare('SELECT * FROM users WHERE email = :email');
		$statement->execute(compact('email'));
		$user = $statement->fetch(PDO::FETCH_ASSOC);
		if ($user === false) return null;
		return new User(...array_values($user));
	}

	/**
	 * getUserByUsername returns the user with the given username.
	 * @param string $username - The username of the user to get.
	 * @return User|null - The user with the given username, null if the user does not exist.
	 */
	public function getUserByUsername(string $username): ?User {
		$statement = $this->databaseConnection->prepare('SELECT * FROM users WHERE username = :username');
		$statement->execute(compact('username'));
		$user = $statement->fetch(PDO::FETCH_ASSOC);
		if ($user === false) return null;
		return new User(...array_values($user));
	}

	/**
	 * loginUser logs the user in.
	 * @param string $email - The email of the user.
	 * @param string $password - The password of the user.
	 * @return User|null - The user if the login is successful, null otherwise.
	 */
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

	/**
	 * checkHash checks if the given password matches the password of the user with the given email.
	 * @param string $email - The email of the user.
	 * @param string $password - The password to check.
	 * @return bool - True if the password matches, false otherwise.
	 */
	public function checkHash(string $email, string $password): bool {
		$statement = $this->databaseConnection->prepare(
			'SELECT password FROM users WHERE (email = :email OR username = :email)'
		);

		$statement->execute(compact('email'));
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return password_verify($password, $result['password']);
	}

	/**
	 * updateUser updates the user with the given id.
	 * @param User $user - The user to update.
	 * @return bool - True if the user was updated, false otherwise.
	 */
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

	/**
	 * getUsersBySearch returns the users that match the given search.
	 * @param string $search - The search to match.
	 * @return array - The users that match the given search.
	 */
	public function getUsersBySearch(string $search): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM users WHERE username LIKE :search OR display_name LIKE :search');
		$statement->execute(['search' => "%$search%"]);
		$users = [];

		while ($user = $statement->fetch(PDO::FETCH_ASSOC)) {
			$users[] = new User(...array_values($user));
		}

		return $users;
	}
}
