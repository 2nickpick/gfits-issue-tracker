<?php

class User {
	protected $id;
	protected $first_name;
	protected $last_name;
	protected $email_address;
	protected $phone_number;
	protected $cell_phone_carrier_id;

	protected $profile_picture;

	protected $type_id;
	protected $last_password_change;

	protected $password;
	protected $password_again;

	/**
	 * @param $email - email address to login with
	 * @param $password - plaintext password
	 *
	 * @return User
	 *
	 */
	public static function logIn( $email, $password ) {
		$data = array(
			':email'    => $email,
			':password' => $password
		);

		return self::loadAll( 'tUser.EmailAddress = :email AND tLogin.Passwd = :password', $data, false );
	}

	public static function contactUs( $name, $email, $message ) {

		$recipients = array(
			'n00623697@ospreys.unf.edu'
		);

		$body = '';
		$body .= 'Name: ' . htmlentities( $name ) . "\r\n";
		$body .= 'Email: ' . htmlentities( $email ) . "\r\n";
		$body .= 'Message: ' . htmlentities( $message ) . "\r\n";

		if ( mail( implode( $recipients ), 'GFITS Contact Us', $body, 'From: website@gfits.com' . "\r\n" ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @param $users_id
	 *
	 * @return User
	 */
	public static function loadById( $users_id ) {
		$data = array( ':users_id' => $users_id );

		return self::loadAll( 'tUser.UserID = :users_id', $data, false );
	}

	/**
	 * @param $search
	 *
	 * @return User
	 */
	public static function loadBySearch( $search ) {
		$data = array(
			':first_name' => '%' . $search . '%',
			':last_name' => '%' . $search . '%',
			':email' => '%' . $search . '%'
		);

		$where =
			'tUser.FirstName LIKE :first_name
			OR tUser.LastName LIKE :last_name
            OR tUser.EmailAddress LIKE :email';

		return self::loadAll($where, $data, true);
	}

	/**
	 * @param string $where - WHERE of the sql query
	 * @param array $data - sql values to bind to the prepared query
	 *
	 * @return array
	 */
	public static function loadAll( $where = '', $data = array(), $return_array = true ) {
		global $con;

		if ( ! empty( $where ) ) {
			$where = ' WHERE ' . $where;
		}

		$sql =
			'SELECT
                tUser.UserID,
                FirstName,
                LastName,
                EmailAddress,
                PhoneNumber,
                CellPhoneCarrierID,
                ProfilePicture,

                tLogin.TypeID,
                tLogin.LastPasswordChange
            FROM tUser
            LEFT JOIN tLogin ON tLogin.UserID = tUser.UserID
            ' . $where . '';

		$statement = $con->prepare( $sql );
		$statement->execute( $data );

		$rows = $statement->fetchAll();

		$users = array();
		if ( ! empty( $rows ) ) {
			foreach ( $rows as $row ) {
				$user = new User(
					array(
						'id'                    => $row['UserID'],
						'first_name'            => $row['FirstName'],
						'last_name'             => $row['LastName'],
						'email_address'         => $row['EmailAddress'],
						'phone_number'          => $row['PhoneNumber'],
						'cell_phone_carrier_id' => $row['CellPhoneCarrierID'],
						'profile_picture'       => $row['ProfilePicture'],
						'type_id'               => $row['TypeID'],
						'last_password_change'  => $row['LastPasswordChange']
					)
				);

				if ( ! $return_array ) {
					return $user;
				}

				$users[] = $user;
			}
		}

		return $users;
	}

	public function __construct( $properties = array() ) {
		if ( ! empty( $properties ) ) {
			foreach ( $properties as $property => $value ) {
				$this->{$property} = $value;
			}
		}
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getFirstName() {
		return $this->first_name;
	}

	/**
	 * @param mixed $first_name
	 */
	public function setFirstName( $first_name ) {
		$this->first_name = $first_name;
	}

	/**
	 * @return mixed
	 */
	public function getLastName() {
		return $this->last_name;
	}

	/**
	 * @param mixed $last_name
	 */
	public function setLastName( $last_name ) {
		$this->last_name = $last_name;
	}

	/**
	 * @return mixed
	 */
	public function getEmailAddress() {
		return $this->email_address;
	}

	/**
	 * @param mixed $email_address
	 */
	public function setEmailAddress( $email_address ) {
		$this->email_address = $email_address;
	}

	/**
	 * @return mixed
	 */
	public function getPhoneNumber() {
		return $this->phone_number;
	}

	/**
	 * @param mixed $phone_number
	 */
	public function setPhoneNumber( $phone_number ) {
		$this->phone_number = $phone_number;
	}

	/**
	 * @return mixed
	 */
	public function getCellPhoneCarrierId() {
		return $this->cell_phone_carrier_id;
	}

	/**
	 * @param mixed $cell_phone_carrier_id
	 */
	public function setCellPhoneCarrierId( $cell_phone_carrier_id ) {
		$this->cell_phone_carrier_id = $cell_phone_carrier_id;
	}

	/**
	 * @return Type
	 */
	public function getType() {
		$type = Type::loadById( $this->type_id );

		return $type;
	}

	/**
	 * @return mixed
	 */
	public function getTypeId() {
		return $this->type_id;
	}

	/**
	 * @param mixed $type_id
	 */
	public function setTypeId( $type_id ) {
		$this->type_id = $type_id;
	}

	/**
	 * @return mixed
	 */
	public function getLastPasswordChange() {
		return $this->last_password_change;
	}

	/**
	 * @param mixed $last_password_change
	 */
	public function setLastPasswordChange( $last_password_change ) {
		$this->last_password_change = $last_password_change;
	}

	public function add() {
		global $con;

		$sql = '
			INSERT INTO tUser
			(
                FirstName,
                LastName,
                EmailAddress,
                PhoneNumber,
                CellPhoneCarrierID
			)
			VALUES
			(
				:first_name,
				:last_name,
				:email_address,
				:phone_number,
				:cell_phone_carrier_id
			)';

		$data = array(
			':first_name'            => $this->first_name,
			':last_name'             => $this->last_name,
			':email_address'         => $this->email_address,
			':phone_number'          => $this->phone_number,
			':cell_phone_carrier_id' => $this->cell_phone_carrier_id
		);

		$statement = $con->prepare( $sql );
		if ( $statement->execute( $data ) ) {

			$this->id = $con->lastInsertId();
			$sql      = '
				INSERT INTO tLogin
				(
	                UserID,
	                TypeID,
	                Passwd,
	                LastPasswordChange
				)
				VALUES
				(
					:user_id,
					:type_id,
					:password,
					NULL
				)';

			$data = array(
				':user_id'  => $this->id,
				':type_id'  => $this->type_id,
				':password' => $this->password,
			);

			$statement2 = $con->prepare( $sql );
			$statement2->execute( $data );

			return true;
		}

		return false;
	}

	public function update() {
		global $con;

		$sql = '
			UPDATE
				tUser
			SET
				FirstName = :first_name,
				LastName = :last_name,
				EmailAddress = :email_address,
				PhoneNumber = :phone_number,
				CellPhoneCarrierID = :cell_phone_carrier_id,
				ProfilePicture = :profile_picture
			WHERE
				UserId = :users_id
			';

		$data = array(
			':users_id'              => $this->id,
			':first_name'            => $this->first_name,
			':last_name'             => $this->last_name,
			':email_address'         => $this->email_address,
			':phone_number'          => $this->phone_number,
			':cell_phone_carrier_id' => $this->cell_phone_carrier_id,
			':profile_picture'       => $this->profile_picture
		);

		$statement = $con->prepare( $sql );
		if ( $statement->execute( $data ) ) {

			$this->id = $con->lastInsertId();

			$data = array(
				':user_id' => $this->id,
				':type_id' => $this->type_id
			);

			$password_sql = '';
			if ( ! empty( $this->password ) ) {
				$password_sql      = ',
				Passwd = :password,
				LastPasswordChange = CURRENT_TIMESTAMP';
				$data[':password'] = $this->password;
			}

			if ( ! empty( $password_sql ) || ! empty( $type_sql ) ) {
				$sql = '
					UPDATE tLogin
					SET
					TypeId = :type_id
					' . $password_sql . '
					WHERE
						UserID = :user_id';

				$statement2 = $con->prepare( $sql );
				$statement2->execute( $data );
			}

			return true;
		}

		return false;
	}

	public function delete() {
		global $con;

		$sql = '
			DELETE FROM
				tLogin
			WHERE
				UserId = :users_id
			';

		$data = array(
			':users_id'              => $this->id
		);

		$statement = $con->prepare( $sql );
		if ( $statement->execute( $data ) ) {

			$sql = '
				DELETE FROM
					tUser
				WHERE
					UserID = :users_id';

			$statement2 = $con->prepare( $sql );
			$statement2->execute( $data );

			return true;
		}

		return false;
	}

	/**
	 * @param mixed $password
	 */
	public function setPassword( $password ) {
		$this->password = $password;
	}

	/**
	 * @return mixed
	 */
	public function getProfilePicture() {
		return $this->profile_picture;
	}

	/**
	 * @param mixed $profile_picture
	 */
	public function setProfilePicture( $profile_picture ) {
		$this->profile_picture = $profile_picture;
	}
}

class Type {
	protected $id;
	protected $name;
	protected $description;

	/**
	 * @param $types_id
	 *
	 * @return Type
	 */
	public static function loadById( $types_id ) {
		$data = array( ':types_id' => $types_id );

		return self::loadAll( 'tType.TypeID = :types_id', $data, false );
	}

	/**
	 * @param string $where - WHERE of the sql query
	 * @param array $data - sql values to bind to the prepared query
	 *
	 * @return array
	 */
	public static function loadAll( $where = '', $data = array(), $return_array = true ) {
		global $con;

		if ( ! empty( $where ) ) {
			$where = ' WHERE ' . $where;
		}

		$sql =
			'SELECT
                tType.TypeID,
                TypeName,
                Description
            FROM tType
            ' . $where . '';

		$statement = $con->prepare( $sql );
		$statement->execute( $data );

		$rows = $statement->fetchAll();

		$types = array();
		if ( ! empty( $rows ) ) {
			foreach ( $rows as $row ) {
				$type = new Type(
					array(
						'id'          => $row['TypeID'],
						'name'        => $row['TypeName'],
						'description' => $row['Description'],
					)
				);

				if ( ! $return_array ) {
					return $type;
				}

				$types[] = $type;
			}
		}

		return $types;
	}

	public function __construct( $properties = array() ) {
		if ( ! empty( $properties ) ) {
			foreach ( $properties as $property => $value ) {
				$this->{$property} = $value;
			}
		}
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription( $description ) {
		$this->description = $description;
	}

}

class CellPhoneCarrier {
	protected $id;
	protected $name;
	protected $email_domain;

	/**
	 * @param $carriers_id
	 *
	 * @return Type
	 */
	public static function loadById( $carriers_id ) {
		$data = array( ':carriers_id' => $carriers_id );

		return self::loadAll( 'tCellPhoneCarrier.CellPhoneCarrierId = :carriers_id', $data, false );
	}

	/**
	 * @param string $where - WHERE of the sql query
	 * @param array $data - sql values to bind to the prepared query
	 *
	 * @return array
	 */
	public static function loadAll( $where = '', $data = array(), $return_array = true ) {
		global $con;

		if ( ! empty( $where ) ) {
			$where = ' WHERE ' . $where;
		}

		$sql =
			'SELECT
                tCellPhoneCarrier.CellPhoneCarrierID,
                CellPhoneCarrierName,
                CellPhoneCarrierEmailDom
            FROM tCellPhoneCarrier
            ' . $where . '';

		$statement = $con->prepare( $sql );
		$statement->execute( $data );

		$rows = $statement->fetchAll();

		$carriers = array();
		if ( ! empty( $rows ) ) {
			foreach ( $rows as $row ) {
				$carrier = new CellPhoneCarrier(
					array(
						'id'           => $row['CellPhoneCarrierID'],
						'name'         => $row['CellPhoneCarrierName'],
						'email_domain' => $row['CellPhoneCarrierEmailDom'],
					)
				);

				if ( ! $return_array ) {
					return $carrier;
				}

				$carriers[] = $carrier;
			}
		}

		return $carriers;
	}

	public function __construct( $properties = array() ) {
		if ( ! empty( $properties ) ) {
			foreach ( $properties as $property => $value ) {
				$this->{$property} = $value;
			}
		}
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getEmailDomain() {
		return $this->email_domain;
	}

	/**
	 * @param mixed $email_domain
	 */
	public function setEmailDomain( $email_domain ) {
		$this->email_domain = $email_domain;
	}

}


