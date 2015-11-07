<?php

class Ticket {
	protected $id;
	protected $category;
	protected $opened_by;
	protected $date_opened;
	protected $issue_title;
	protected $description;

	protected $notes;

	/**
	 * @param $tickets_id
	 *
	 * @return Ticket
	 */
	public static function loadById( $tickets_id ) {
		$data = array( ':tickets_id' => $tickets_id );

		return self::loadAll( 'tTicket.TicketID = :tickets_id', $data, false );
	}

	/**
	 * @param $search
	 *
	 * @return Ticket
	 */
	public static function loadBySearch( $search, $order_by ) {
		$data = array(
			':first_name'  => '%' . $search . '%',
			':last_name'   => '%' . $search . '%',
			':email'       => '%' . $search . '%',
			':issue_title' => '%' . $search . '%',
			':description' => '%' . $search . '%'
		);

		$where =
			'jOpenedBy.FirstName LIKE :first_name
			OR jOpenedBy.LastName LIKE :last_name
            OR jOpenedBy.EmailAddress LIKE :email
            OR tTicket.IssueTitle LIKE :issue_title
            OR tTicket.Description LIKE :description';

		return self::loadAll( $where, $data, true, $order_by );
	}

	/**
	 * @param string $where - WHERE of the sql query
	 * @param array $data - sql values to bind to the prepared query
	 *
	 * @return array
	 */
	public static function loadAll( $where = '', $data = array(), $return_array = true, $order_by = '' ) {
		global $con;

		if ( ! empty( $where ) ) {
			$where = ' WHERE ' . $where;
		}

		if ( ! empty( $order_by ) ) {
			$order_by = ' ORDER BY ' . $order_by;
		}

		$sql =
			'SELECT
                tTicket.TicketID AS ticket_id,
                tTicket.IssueTitle as ticket_issue_title,
                tTicket.Description as ticket_description,
                UNIX_TIMESTAMP(tTicket.DateOpened) AS ticket_date_opened,

                tTicket.CategoryID AS category_id,
				jCategory.Description AS category_description,

				tTicket.OpenedBy AS opened_by_id,
                jOpenedBy.FirstName AS opened_by_first_name,
                jOpenedBy.LastName AS opened_by_last_name,
                jOpenedBy.EmailAddress AS opened_by_email_address,
                jOpenedBy.PhoneNumber AS opened_by_phone_number,
                jOpenedBy.CellPhoneCarrierID AS opened_by_cell_phone_carrier_id,
                jOpenedBy.ProfilePicture AS opened_by_profile_picture,

                jOpenedByLogin.TypeID AS opened_by_type_id,
                jOpenedByLogin.LastPasswordChange AS opened_by_last_password_change
            FROM tTicket
            LEFT JOIN tUser jOpenedBy ON jOpenedBy.UserID = tTicket.OpenedBy
            LEFT JOIN tLogin jOpenedByLogin ON jOpenedBy.UserID = jOpenedByLogin.UserID
            LEFT JOIN tCategory jCategory ON jCategory.CategoryID = tTicket.CategoryID
            ' . $where . '
            ' . $order_by . '';

		$statement = $con->prepare( $sql );
		$statement->execute( $data );

		$rows = $statement->fetchAll();

		$tickets = array();
		if ( ! empty( $rows ) ) {
			foreach ( $rows as $row ) {
				$ticket = new Ticket(
					array(
						'id'          => $row['ticket_id'],
						'category'    => array(
							'id'          => $row['category_id'],
							'description' => $row['category_description']
						),
						'opened_by'   => array(
							'id'                    => $row['opened_by_id'],
							'first_name'            => $row['opened_by_first_name'],
							'last_name'             => $row['opened_by_last_name'],
							'email_address'         => $row['opened_by_email_address'],
							'phone_number'          => $row['opened_by_phone_number'],
							'cell_phone_carrier_id' => $row['opened_by_cell_phone_carrier_id'],
							'profile_picture'       => $row['opened_by_profile_picture'],
							'type_id'               => $row['opened_by_type_id'],
							'last_password_change'  => $row['opened_by_last_password_change']
						),
						'issue_title' => $row['ticket_issue_title'],
						'description' => $row['ticket_description'],
						'date_opened' => $row['ticket_date_opened'],
					)
				);

				$ticket->loadNotes();

				if ( ! $return_array ) {
					return $ticket;
				}

				$tickets[] = $ticket;
			}
		}

		return $tickets;
	}

	public function __construct( $properties = array() ) {
		if ( ! empty( $properties ) ) {
			foreach ( $properties as $property => $value ) {
				$this->{$property} = $value;
			}

			if ( ! empty( $properties['category'] ) ) {
				$this->category = new Category( $properties['category'] );
			}
			if ( ! empty( $properties['opened_by'] ) ) {
				$this->opened_by = new User( $properties['opened_by'] );
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

	public function add() {
		global $con;

		$sql = '
			INSERT INTO tTicket
			(
                TicketID,
                CategoryID,
                OpenedBy,
                DateOpened,
                IssueTitle,
                Description
			)
			VALUES
			(
				:ticket_id,
				1,
				:opened_by_id,
				NOW(),
				:issue_title,
				:description
			)';

		$data = array(
			':ticket_id'    => $this->id,
			':opened_by_id' => $this->opened_by->getId(),
			':issue_title'  => $this->issue_title,
			':description'  => $this->description
		);

		$statement = $con->prepare( $sql );
		if ( $statement->execute( $data ) ) {

			$this->id = $con->lastInsertId();

			return true;
		}

		return false;
	}

	public function update() {
		global $con;

		$sql = '
			UPDATE
				tTicket
			SET
				CategoryID = :category_id,
				OpenedBy = :opened_by_id,
				DateOpened = :date_opened,
				IssueTitle = :issue_title,
				Description = :description
			WHERE
				TicketID = :tickets_id
			';

		$data = array(
			':tickets_id'   => $this->id,
			':category_id'  => $this->category->getId(),
			':opened_by_id' => $this->opened_by->getId(),
			':issue_title'  => $this->issue_title,
			':description'  => $this->description
		);

		$statement = $con->prepare( $sql );
		if ( $statement->execute( $data ) ) {

			$this->id = $con->lastInsertId();

			return true;
		}

		return false;
	}

	public function delete() {
		global $con;

		$sql = '
			DELETE FROM
				tTicket
			WHERE
				TicketID = :tickets_id
			';

		$data = array(
			':tickets_id' => $this->id
		);

		$statement = $con->prepare( $sql );
		if ( $statement->execute( $data ) ) {

			return true;
		}

		return false;
	}

	/**
	 * @return Category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * @param Category $category
	 */
	public function setCategory( $category ) {
		$this->category = $category;
	}

	/**
	 * @return User
	 */
	public function getOpenedBy() {
		return $this->opened_by;
	}

	/**
	 * @return mixed
	 */
	public function getDateOpened() {
		return $this->date_opened;
	}

	/**
	 * @param mixed $date_opened
	 */
	public function setDateOpened( $date_opened ) {
		$this->date_opened = $date_opened;
	}

	/**
	 * @return mixed
	 */
	public function getIssueTitle() {
		return $this->issue_title;
	}

	/**
	 * @param mixed $issue_title
	 */
	public function setIssueTitle( $issue_title ) {
		$this->issue_title = $issue_title;
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

	/**
	 * @return bool
	 */
	public function isOpen() {
		$notes = $this->getNotes();
		return empty($notes) || !in_array($notes[count($notes)-1]->getStatus()->getId(), array(3,5));
	}

	/**
	 * @return array
	 */
	public function getNotes() {
		return $this->notes;
	}

	public function getDateLastReplied() {
		if(!empty($this->notes)) {
			return $this->notes[count($this->notes)-1]->getDate();
		} else {
			return null;
		}
	}

	/**
	 *
	 */
	public function loadNotes() {
		$this->notes = TicketNote::loadByTicket($this->id);
	}
}

class Category {
	protected $id;
	protected $description;

	/**
	 * @param $categories_id
	 *
	 * @return Category
	 */
	public static function loadById( $categories_id ) {
		$data = array( ':categories_id' => $categories_id );

		return self::loadAll( 'tCategory.CategoryID = :categories_id', $data, false );
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
                tCategory.CategoryID,
                Description
            FROM tCategory
            ' . $where . '';

		$statement = $con->prepare( $sql );
		$statement->execute( $data );

		$rows = $statement->fetchAll();

		$categories = array();
		if ( ! empty( $rows ) ) {
			foreach ( $rows as $row ) {
				$category = new Category(
					array(
						'id'          => $row['CategoryID'],
						'description' => $row['Description'],
					)
				);

				if ( ! $return_array ) {
					return $category;
				}

				$categories[] = $category;
			}
		}

		return $categories;
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

class Status {
	protected $id;
	protected $description;

	/**
	 * @param $statuses_id
	 *
	 * @return Category
	 */
	public static function loadById( $statuses_id ) {
		$data = array( ':statuses_id' => $statuses_id );

		return self::loadAll( 'tStatus.StatusID = :statuses_id', $data, false );
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
                tStatus.StatusID,
                Description
            FROM tStatus
            ' . $where . '';

		$statement = $con->prepare( $sql );
		$statement->execute( $data );

		$rows = $statement->fetchAll();

		$statuses = array();
		if ( ! empty( $rows ) ) {
			foreach ( $rows as $row ) {
				$status = new Status(
					array(
						'id'          => $row['StatusID'],
						'description' => $row['Description'],
					)
				);

				if ( ! $return_array ) {
					return $status;
				}

				$statuses[] = $status;
			}
		}

		return $statuses;
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

class TicketNote
{
	protected $id;
	protected $ticket;
	protected $user;
	protected $status;
	protected $date;
	protected $note_text;

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
	public function getTicket() {
		return $this->ticket;
	}

	/**
	 * @param mixed $ticket
	 */
	public function setTicket( $ticket ) {
		$this->ticket = $ticket;
	}

	/**
	 * @return mixed
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param mixed $user
	 */
	public function setUser( $user ) {
		$this->user = $user;
	}

	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param mixed $status
	 */
	public function setStatus( $status ) {
		$this->status = $status;
	}

	/**
	 * @return mixed
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @param mixed $date
	 */
	public function setDate( $date ) {
		$this->date = $date;
	}

	/**
	 * @return mixed
	 */
	public function getNoteText() {
		return $this->note_text;
	}

	/**
	 * @param mixed $note_text
	 */
	public function setNoteText( $note_text ) {
		$this->note_text = $note_text;
	}

	/**
	 * @param $tickets_id
	 * @param $order_by
	 *
	 * @return array
	 */
	public static function loadByTicket( $tickets_id, $order_by = 'tTicketNote.NoteDate' ) {
		$data = array(
			':tickets_id'  => $tickets_id
		);

		$where = 'tTicketNote.TicketID = :tickets_id';

		return self::loadAll( $where, $data, true, $order_by );
	}

	/**
	 * @param string $where - WHERE of the sql query
	 * @param array $data - sql values to bind to the prepared query
	 *
	 * @return array
	 */
	public static function loadAll( $where = '', $data = array(), $return_array = true, $order_by = '' ) {
		global $con;

		if ( ! empty( $where ) ) {
			$where = ' WHERE ' . $where;
		}

		if ( ! empty( $order_by ) ) {
			$order_by = ' ORDER BY ' . $order_by;
		}

		$sql =
			'SELECT
                tTicketNote.TicketNoteID AS ticket_note_id,
                tTicketNote.TicketID as ticket_id,

                tTicketNote.UserID as user_id,
                jUser.FirstName as user_first_name,
                jUser.LastName as user_last_name,
                jUser.ProfilePicture as user_profile_picture,

                tTicketNote.StatusID as status_id,
                UNIX_TIMESTAMP(tTicketNote.NoteDate) AS note_date,
                tTicketNote.NoteText AS note_text
            FROM tTicketNote
            LEFT JOIN tUser jUser ON jUser.UserID = tTicketNote.UserID
            ' . $where . '
            ' . $order_by . '';

		$statement = $con->prepare( $sql );
		$statement->execute( $data );

		$rows = $statement->fetchAll();

		$ticket_notes = array();
		if ( ! empty( $rows ) ) {
			foreach ( $rows as $row ) {
				$ticket_note = new TicketNote(
					array(
						'id'          => $row['ticket_note_id'],
						'ticket'   => array(
							'id' => $row['ticket_id']
						),
						'user'     => array(
							'id' => $row['user_id'],
							'first_name' => $row['user_first_name'],
							'last_name' => $row['user_last_name'],
							'profile_picture' => $row['user_profile_picture']
						),
						'status'   => array(
							'id' => $row['status_id']
						),
						'date'   => $row['note_date'],
						'note_text'   => $row['note_text']
					)
				);

				if ( ! $return_array ) {
					return $ticket_note;
				}

				$ticket_notes[] = $ticket_note;
			}
		}

		return $ticket_notes;
	}


	public function __construct( $properties = array() ) {
		if ( ! empty( $properties ) ) {
			foreach ( $properties as $property => $value ) {
				$this->{$property} = $value;
			}

			if(!empty($properties['status'])) {
				$this->status = new Status($properties['status']);
			}

			if(!empty($properties['user'])) {
				$this->user = new User($properties['user']);
			}

			if(!empty($properties['ticket'])) {
				$this->ticket = new Ticket($properties['ticket']);
			}
		}
	}
}
