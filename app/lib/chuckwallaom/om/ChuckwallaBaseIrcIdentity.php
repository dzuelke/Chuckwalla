<?php

abstract class ChuckwallaBaseIrcIdentity extends BaseObject implements Persistent, AgaviIModel {
	
	protected $context = null;

	public function initialize(AgaviContext $context, array $parameters = array())
	{
		$this->context = $context;
	}
	
	public function getContext()
	{
		return $this->context;
	}

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ChuckwallaIrcIdentityPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the user_id field.
	 * @var        int
	 */
	protected $user_id;


	/**
	 * The value for the is_online field.
	 * @var        boolean
	 */
	protected $is_online = true;


	/**
	 * The value for the ident field.
	 * @var        string
	 */
	protected $ident;


	/**
	 * The value for the realname field.
	 * @var        string
	 */
	protected $realname;


	/**
	 * The value for the host field.
	 * @var        string
	 */
	protected $host;


	/**
	 * The value for the server field.
	 * @var        string
	 */
	protected $server;


	/**
	 * The value for the ircop field.
	 * @var        boolean
	 */
	protected $ircop = true;


	/**
	 * The value for the is_away field.
	 * @var        boolean
	 */
	protected $is_away = true;


	/**
	 * The value for the last_quit_time field.
	 * @var        int
	 */
	protected $last_quit_time;


	/**
	 * The value for the last_quit_message field.
	 * @var        string
	 */
	protected $last_quit_message;

	/**
	 * @var        User
	 */
	protected $aUser;

	/**
	 * @var        array ChuckwallaNick[] Collection to store aggregation of ChuckwallaNick objects.
	 */
	protected $collNicks;

	/**
	 * @var        Criteria The criteria used to select the current contents of collNicks.
	 */
	private $lastNickCriteria = null;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{

		return $this->id;
	}

	/**
	 * Get the [user_id] column value.
	 * 
	 * @return     int
	 */
	public function getUserId()
	{

		return $this->user_id;
	}

	/**
	 * Get the [is_online] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsOnline()
	{

		return $this->is_online;
	}

	/**
	 * Get the [ident] column value.
	 * 
	 * @return     string
	 */
	public function getIdent()
	{

		return $this->ident;
	}

	/**
	 * Get the [realname] column value.
	 * 
	 * @return     string
	 */
	public function getRealname()
	{

		return $this->realname;
	}

	/**
	 * Get the [host] column value.
	 * 
	 * @return     string
	 */
	public function getHost()
	{

		return $this->host;
	}

	/**
	 * Get the [server] column value.
	 * 
	 * @return     string
	 */
	public function getServer()
	{

		return $this->server;
	}

	/**
	 * Get the [ircop] column value.
	 * 
	 * @return     boolean
	 */
	public function getIrcop()
	{

		return $this->ircop;
	}

	/**
	 * Get the [is_away] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsAway()
	{

		return $this->is_away;
	}

	/**
	 * Get the [optionally formatted] [last_quit_time] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getLastQuitTime($format = 'Y-m-d H:i:s')
	{

		if ($this->last_quit_time === null || $this->last_quit_time === '') {
			return null;
		} elseif (!is_int($this->last_quit_time)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->last_quit_time);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [last_quit_time] as date/time value: " . var_export($this->last_quit_time, true));
			}
		} else {
			$ts = $this->last_quit_time;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	/**
	 * Get the [last_quit_message] column value.
	 * 
	 * @return     string
	 */
	public function getLastQuitMessage()
	{

		return $this->last_quit_message;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setId($v)
	{

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ChuckwallaIrcIdentityPeer::ID;
		}

	} // setId()

	/**
	 * Set the value of [user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setUserId($v)
	{

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = ChuckwallaIrcIdentityPeer::USER_ID;
		}

		if ($this->aUser !== null && $this->aUser->getId() !== $v) {
			$this->aUser = null;
		}

	} // setUserId()

	/**
	 * Set the value of [is_online] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsOnline($v)
	{

		if ($this->is_online !== $v || $v === true) {
			$this->is_online = $v;
			$this->modifiedColumns[] = ChuckwallaIrcIdentityPeer::IS_ONLINE;
		}

	} // setIsOnline()

	/**
	 * Set the value of [ident] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setIdent($v)
	{

		if ($this->ident !== $v) {
			$this->ident = $v;
			$this->modifiedColumns[] = ChuckwallaIrcIdentityPeer::IDENT;
		}

	} // setIdent()

	/**
	 * Set the value of [realname] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setRealname($v)
	{

		if ($this->realname !== $v) {
			$this->realname = $v;
			$this->modifiedColumns[] = ChuckwallaIrcIdentityPeer::REALNAME;
		}

	} // setRealname()

	/**
	 * Set the value of [host] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setHost($v)
	{

		if ($this->host !== $v) {
			$this->host = $v;
			$this->modifiedColumns[] = ChuckwallaIrcIdentityPeer::HOST;
		}

	} // setHost()

	/**
	 * Set the value of [server] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setServer($v)
	{

		if ($this->server !== $v) {
			$this->server = $v;
			$this->modifiedColumns[] = ChuckwallaIrcIdentityPeer::SERVER;
		}

	} // setServer()

	/**
	 * Set the value of [ircop] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIrcop($v)
	{

		if ($this->ircop !== $v || $v === true) {
			$this->ircop = $v;
			$this->modifiedColumns[] = ChuckwallaIrcIdentityPeer::IRCOP;
		}

	} // setIrcop()

	/**
	 * Set the value of [is_away] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsAway($v)
	{

		if ($this->is_away !== $v || $v === true) {
			$this->is_away = $v;
			$this->modifiedColumns[] = ChuckwallaIrcIdentityPeer::IS_AWAY;
		}

	} // setIsAway()

	/**
	 * Set the value of [last_quit_time] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setLastQuitTime($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [last_quit_time] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->last_quit_time !== $ts) {
			$this->last_quit_time = $ts;
			$this->modifiedColumns[] = ChuckwallaIrcIdentityPeer::LAST_QUIT_TIME;
		}

	} // setLastQuitTime()

	/**
	 * Set the value of [last_quit_message] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setLastQuitMessage($v)
	{

		if ($this->last_quit_message !== $v) {
			$this->last_quit_message = $v;
			$this->modifiedColumns[] = ChuckwallaIrcIdentityPeer::LAST_QUIT_MESSAGE;
		}

	} // setLastQuitMessage()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->user_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->is_online = ($row[$startcol + 2] !== null) ? (boolean) $row[$startcol + 2] : null;
			$this->ident = $row[$startcol + 3];
			$this->realname = $row[$startcol + 4];
			$this->host = $row[$startcol + 5];
			$this->server = $row[$startcol + 6];
			$this->ircop = ($row[$startcol + 7] !== null) ? (boolean) $row[$startcol + 7] : null;
			$this->is_away = ($row[$startcol + 8] !== null) ? (boolean) $row[$startcol + 8] : null;
			$this->last_quit_time = $row[$startcol + 9]; // FIXME - this is a timestamp, we should maybe convert it (?)
			$this->last_quit_message = $row[$startcol + 10];
			$this->resetModified();

			$this->setNew(false);

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 11; // 11 = ChuckwallaIrcIdentityPeer::NUM_COLUMNS - ChuckwallaIrcIdentityPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating IrcIdentity object", $e);
		}
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ChuckwallaIrcIdentityPeer::DATABASE_NAME);
		}

		try {
			$con->beginTransaction();
			ChuckwallaIrcIdentityPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Stores the object in the database.  If the object is new,
	 * it inserts it; otherwise an update is performed.  This method
	 * wraps the doSave() worker method in a transaction.
	 *
	 * @param      PDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ChuckwallaIrcIdentityPeer::DATABASE_NAME);
		}

		try {
			$con->beginTransaction();
			$affectedRows = $this->doSave($con);
			$con->commit();
			ChuckwallaIrcIdentityPeer::addInstanceToPool($this);
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Stores the object in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUser !== null) {
				if ($this->aUser->isModified() || $this->aUser->isNew()) {
					$affectedRows += $this->aUser->save($con);
				}
				$this->setUser($this->aUser);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ChuckwallaIrcIdentityPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ChuckwallaIrcIdentityPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collNicks !== null) {
				foreach ($this->collNicks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUser !== null) {
				if (!$this->aUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
				}
			}


			if (($retval = ChuckwallaIrcIdentityPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collNicks !== null) {
					foreach ($this->collNicks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants TYPE_PHPNAME,
	 *                     TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ChuckwallaIrcIdentityPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getUserId();
				break;
			case 2:
				return $this->getIsOnline();
				break;
			case 3:
				return $this->getIdent();
				break;
			case 4:
				return $this->getRealname();
				break;
			case 5:
				return $this->getHost();
				break;
			case 6:
				return $this->getServer();
				break;
			case 7:
				return $this->getIrcop();
				break;
			case 8:
				return $this->getIsAway();
				break;
			case 9:
				return $this->getLastQuitTime();
				break;
			case 10:
				return $this->getLastQuitMessage();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType One of the class type constants TYPE_PHPNAME,
	 *                        TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ChuckwallaIrcIdentityPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUserId(),
			$keys[2] => $this->getIsOnline(),
			$keys[3] => $this->getIdent(),
			$keys[4] => $this->getRealname(),
			$keys[5] => $this->getHost(),
			$keys[6] => $this->getServer(),
			$keys[7] => $this->getIrcop(),
			$keys[8] => $this->getIsAway(),
			$keys[9] => $this->getLastQuitTime(),
			$keys[10] => $this->getLastQuitMessage(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants TYPE_PHPNAME,
	 *                     TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ChuckwallaIrcIdentityPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setUserId($value);
				break;
			case 2:
				$this->setIsOnline($value);
				break;
			case 3:
				$this->setIdent($value);
				break;
			case 4:
				$this->setRealname($value);
				break;
			case 5:
				$this->setHost($value);
				break;
			case 6:
				$this->setServer($value);
				break;
			case 7:
				$this->setIrcop($value);
				break;
			case 8:
				$this->setIsAway($value);
				break;
			case 9:
				$this->setLastQuitTime($value);
				break;
			case 10:
				$this->setLastQuitMessage($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME,
	 * TYPE_NUM. The default key type is the column's phpname (e.g. 'authorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ChuckwallaIrcIdentityPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIsOnline($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setIdent($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setRealname($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setHost($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setServer($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIrcop($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsAway($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setLastQuitTime($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setLastQuitMessage($arr[$keys[10]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ChuckwallaIrcIdentityPeer::DATABASE_NAME);

		if ($this->isColumnModified(ChuckwallaIrcIdentityPeer::ID)) $criteria->add(ChuckwallaIrcIdentityPeer::ID, $this->id);
		if ($this->isColumnModified(ChuckwallaIrcIdentityPeer::USER_ID)) $criteria->add(ChuckwallaIrcIdentityPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(ChuckwallaIrcIdentityPeer::IS_ONLINE)) $criteria->add(ChuckwallaIrcIdentityPeer::IS_ONLINE, $this->is_online);
		if ($this->isColumnModified(ChuckwallaIrcIdentityPeer::IDENT)) $criteria->add(ChuckwallaIrcIdentityPeer::IDENT, $this->ident);
		if ($this->isColumnModified(ChuckwallaIrcIdentityPeer::REALNAME)) $criteria->add(ChuckwallaIrcIdentityPeer::REALNAME, $this->realname);
		if ($this->isColumnModified(ChuckwallaIrcIdentityPeer::HOST)) $criteria->add(ChuckwallaIrcIdentityPeer::HOST, $this->host);
		if ($this->isColumnModified(ChuckwallaIrcIdentityPeer::SERVER)) $criteria->add(ChuckwallaIrcIdentityPeer::SERVER, $this->server);
		if ($this->isColumnModified(ChuckwallaIrcIdentityPeer::IRCOP)) $criteria->add(ChuckwallaIrcIdentityPeer::IRCOP, $this->ircop);
		if ($this->isColumnModified(ChuckwallaIrcIdentityPeer::IS_AWAY)) $criteria->add(ChuckwallaIrcIdentityPeer::IS_AWAY, $this->is_away);
		if ($this->isColumnModified(ChuckwallaIrcIdentityPeer::LAST_QUIT_TIME)) $criteria->add(ChuckwallaIrcIdentityPeer::LAST_QUIT_TIME, $this->last_quit_time);
		if ($this->isColumnModified(ChuckwallaIrcIdentityPeer::LAST_QUIT_MESSAGE)) $criteria->add(ChuckwallaIrcIdentityPeer::LAST_QUIT_MESSAGE, $this->last_quit_message);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ChuckwallaIrcIdentityPeer::DATABASE_NAME);

		$criteria->add(ChuckwallaIrcIdentityPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of ChuckwallaIrcIdentity (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setUserId($this->user_id);

		$copyObj->setIsOnline($this->is_online);

		$copyObj->setIdent($this->ident);

		$copyObj->setRealname($this->realname);

		$copyObj->setHost($this->host);

		$copyObj->setServer($this->server);

		$copyObj->setIrcop($this->ircop);

		$copyObj->setIsAway($this->is_away);

		$copyObj->setLastQuitTime($this->last_quit_time);

		$copyObj->setLastQuitMessage($this->last_quit_message);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getNicks() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
				$copyObj->addNick($relObj->copy($deepCopy));
			}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a pkey column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     ChuckwallaIrcIdentity Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
($this->context);

		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     ChuckwallaIrcIdentityPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ChuckwallaIrcIdentityPeer();
($this->context);

		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a ChuckwallaUser object.
	 *
	 * @param      ChuckwallaUser $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setUser(ChuckwallaUser $v = null)
	{
		if ($v === null) {
			$this->setUserId(NULL);
		} else {
			$this->setUserId($v->getId());
		}

		$this->aUser = $v;


	}


	/**
	 * Get the associated User object
	 *
	 * @param      PDO Optional Connection object.
	 * @return     User The associated User object.
	 * @throws     PropelException
	 */
	public function getUser(PDO $con = null)
	{
		if ($this->aUser === null && ($this->user_id !== null)) {
			$this->aUser = ChuckwallaUserPeer::retrieveByPK($this->user_id, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aUser->addIrcIdentitys($this);
			 */
		}
		return $this->aUser;
	}

	/**
	 * Temporary storage of collNicks to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 *
	 * @return     void
	 * @deprecated - This method will be removed in 2.0 since arrays
	 *				are automatically initialized in the addNicks() method.
	 * @see        addNicks()
	 */
	public function initNicks()
	{
		if ($this->collNicks === null) {
			$this->collNicks = array();
		}
	}

	/**
	 * Gets an array of  objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this ChuckwallaIrcIdentity has previously been saved, it will retrieve
	 * related Nicks from storage. If this ChuckwallaIrcIdentity is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PDO $con
	 * @param      Criteria $criteria
	 * @return     array []
	 * @throws     PropelException
	 */
	public function getNicks($criteria = null, PDO $con = null)
	{
		
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collNicks === null) {
			if ($this->isNew()) {
			   $this->collNicks = array();
			} else {

				$criteria->add(ChuckwallaNickPeer::IRC_IDENTITY_ID, $this->getId());

				ChuckwallaNickPeer::addSelectColumns($criteria);
				$this->collNicks = ChuckwallaNickPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ChuckwallaNickPeer::IRC_IDENTITY_ID, $this->getId());

				ChuckwallaNickPeer::addSelectColumns($criteria);
				if (!isset($this->lastNickCriteria) || !$this->lastNickCriteria->equals($criteria)) {
					$this->collNicks = ChuckwallaNickPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastNickCriteria = $criteria;
		return $this->collNicks;
	}

	/**
	 * Returns the number of related Nicks.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PDO $con
	 * @throws     PropelException
	 */
	public function countNicks($criteria = null, $distinct = false, PDO $con = null)
	{
		
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ChuckwallaNickPeer::IRC_IDENTITY_ID, $this->getId());

		return ChuckwallaNickPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ChuckwallaNick object to this object
	 * through the ChuckwallaNick foreign key attribute.
	 *
	 * @param      ChuckwallaNick $l ChuckwallaNick
	 * @return     void
	 * @throws     PropelException
	 */
	public function addNick(ChuckwallaNick $l)
	{
		$this->collNicks = (array) $this->collNicks;
		array_push($this->collNicks, $l);
		$l->setIrcIdentity($this);
	}

} // ChuckwallaBaseIrcIdentity
