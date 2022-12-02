<?php
declare(strict_types=1);

namespace Model;

require_once('src/lib/DatabaseConnection.php');

use Database\DatabaseConnection;
use DateTime;
use Exception;
use PDO;
use RuntimeException;
use Utils\Blob;

enum Color: int {
	case Orange = 0;
	case Purple = 1;
	case Blue = 2;
	case Grey = 3;

	public static function fromInt(int $value): self {
		return match ($value) {
			1 => self::Purple,
			2 => self::Blue,
			3 => self::Grey,
			default => self::Orange,
		};
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
}

enum FontSize: int {
	case Small = 0;
	case Medium = 1;
	case Large = 2;
	case ExtraLarge = 3;

	public static function fromInt(int $value): self {
		return match ($value) {
			1 => self::Medium,
			2 => self::Large,
			3 => self::ExtraLarge,
			default => self::Small,
		};
	}
}

class User {
	public ?Blob $avatar;
	public Background $background;
	public DateTime $birth_date;
	public DateTime $created_at;
	public FontSize $font_size;

	private function __construct(
		public string $bio,
		public Color  $color,
		public string $email,
		public string $gender,
		public int    $id,
		public string $password,
		public string $username,
		?string       $avatar,
		int           $background,
		string        $birth_date,
		string        $created_at,
		int           $font_size,
	) {
		$this->background = Background::fromInt($background);
		$this->birth_date = date_create_from_format('U', $birth_date);
		$this->created_at = date_create_from_format('U', $created_at);
		$this->font_size = FontSize::fromInt($font_size);
		if ($avatar !== null) {
			$this->avatar = new Blob($avatar);
		}
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

		return $result === false ? throw new RuntimeException('Could not create user') : true;
	}

    public function loginUser(string $email, string $password): bool {
        $passwordGood = $this->checkHash($email, $password);
        if($passwordGood){
            $statement = $this->databaseConnection->prepare(
                'SELECT * FROM users WHERE (email = :email OR username = :email)'
            );

            $statement->execute([
                'email' => $email,
            ]);

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return !($result === false);
        }
        return false;
    }

    public function checkHash(string $email, string $password): bool {
        $statement = $this->databaseConnection->prepare(
            'SELECT password FROM users WHERE (email = :email OR username = :email)'
        );

        $statement->execute([
            'email' => $email,
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return password_verify($password, $result['password']);
    }

    /**
     * @throws Exception
     */
    public function createSession(int $user_id): string {
        $session_id = bin2hex(random_bytes(32));
        $statement = $this->databaseConnection->prepare(
            'INSERT INTO sessions (id, user_id) VALUES (:id, :user_id)'
        );

        $statement->execute([
            'id' => $session_id,
            'user_id' => $user_id,
        ]);

        return $session_id;
    }

	public function deleteUserById(int $id): void {
		$statement = $this->databaseConnection->prepare('DELETE FROM users WHERE id = :id');
		$statement->execute(compact('id'));
	}

	/**
	 * @param int $id
	 * @return array<User>
	 */
	public function getFriendsOfUser(int $id): array {
		$statement = $this->databaseConnection->prepare('SELECT * FROM users WHERE id IN (SELECT requested_id FROM friends WHERE requester_id = :id)');
		$statement->execute(compact('id'));
		$user = $statement->fetch(PDO::FETCH_ASSOC);
        return $user === false ? throw new RuntimeException('User not found') : $user;
    }

    public function getUserById(int $id): User
    {
        $statement = $this->databaseConnection->prepare('SELECT * FROM users WHERE id = :id');
        $statement->execute(compact('id'));
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        return $user === false ? throw new RuntimeException('User not found') : $user;
    }

    public function getUserIdByEmailOrUsername(string $email): array
    {
        $statement = $this->databaseConnection->prepare('SELECT id FROM users WHERE (email = :email OR username = :email)');
        $statement->execute(compact('email'));
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        return $user === false ? throw new RuntimeException('User not found') : $user;
    }

    public function getUserBySessionId(string $session_id): User
    {
        $statement = $this->databaseConnection->prepare('SELECT * FROM users WHERE id = (SELECT user_id FROM sessions WHERE id = :session_id)');
        $statement->execute(compact('session_id'));
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        return $user === false ? throw new RuntimeException('User not found') : $user;
    }

    public function isUserAlreadyRegistered(string $email, string $username): bool
    {
        $statement = $this->databaseConnection->prepare('SELECT * FROM users WHERE email = :email OR username = :username');
        $statement->execute(compact('email', 'username'));
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        return $user !== false;
    }

    public function createSessionById(int $id): string
    {
        $session_id = bin2hex(random_bytes(32));
        $statement = $this->databaseConnection->prepare(
            'INSERT INTO sessions (id, user_id) VALUES (:id, :user_id)'
        );

        $statement->execute([
            'id' => $session_id,
            'user_id' => $id,
        ]);

        return $session_id;
    }

	public function updateUser(User $user): bool {
		$statement = $this->databaseConnection->prepare(
			'UPDATE users SET avatar = :avatar, background = :background, bio = :bio, birth_date = :birth_date, color = :color, email = :email, fontsize = :font_size, sexe = :gender, password = :password, username = :username WHERE id = :id'
		);

		$result = $statement->execute([
			'avatar' => $user->avatar->data,
			'background' => $user->background->value,
			'bio' => $user->bio,
			'birth_date' => $user->birth_date->getTimestamp(),
			'color' => $user->color->value,
			'email' => $user->email,
			'font_size' => $user->font_size->value,
			'password' => $user->password,
			'sexe' => $user->gender,
			'username' => $user->username,
		]);

		return $result === false ? throw new RuntimeException('Could not update user') : true;
	}
}
