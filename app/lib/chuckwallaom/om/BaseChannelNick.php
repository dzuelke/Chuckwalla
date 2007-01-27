<?php

abstract class BaseChannelNick extends BaseObject implements Persistent, AgaviIModel {
	
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
	 * @var        ChannelNickPeer
	 */
	protected static $peer;


	/**
	 * The value for the channel_id field.
	 * @var        int
	 */
	protected $channel_id;


	/**
	 * The value for the nick_id field.
	 * @var        int
	 */
	protected $nick_id;

	/**
	 * @var        Channel
	 */
	protected $aChannel;

	/**
	 * @var        Nick
	 */
	protected $aNick;

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
	 * Get the [channel_id] column value.
	 * 
	 * @return     int
	 */
	public function getChannelId()
	{

		return $this->channel_id;
	}

	/**
	 * Get the [nick_id] column value.
	 * 
	 * @return     int
	 */
	public function getNickId()
	{

		return $this->nick_id;
	}

	/**
	 * Set the value of [channel_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setChannelId($v)
	{

		if ($this->channel_id !== $v) {
			$this->channel_id = $v;
			$this->modifiedColumns[] = ChannelNickPeer::CHANNEL_ID;
		}

		if ($this->aChannel !== null && $this->aChannel->getId() !== $v) {
			$this->aChannel = null;
		}

	} // setChannelId()

	/**
	 * Set the value of [nick_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setNickId($v)
	{

		if ($this->nick_id !== $v) {
			$this->nick_id = $v;
			$this->modifiedColumns[] = ChannelNickPeer::NICK_ID;
		}

		if ($this->aNick !== null && $this->aNick->getId() !== $v) {
			$this->aNick = null;
		}

	} // setNickId()

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

			$this->channel_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->nick_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->resetModified();

			$this->setNew(false);

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 2; // 2 = ChannelNickPeer::NUM_COLUMNS - ChannelNickPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating ChannelNick object", $e);
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
			$con = Propel::getConnection(ChannelNickPeer::DATABASE_NAME);
		}

		try {
			$con->beginTransaction();
			ChannelNickPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ChannelNickPeer::DATABASE_NAME);
		}

		try {
			$con->beginTransaction();
			$affectedRows = $this->doSave($con);
			$con->commit();
			ChannelNickPeer::addInstanceToPool($this);
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

			if ($this->aChannel !== null) {
				if ($this->aChannel->isModified() || $this->aChannel->isNew()) {
					$affectedRows += $this->aChannel->save($con);
				}
				$this->setChannel($this->aChannel);
			}

			if ($this->aNick !== null) {
				if ($this->aNick->isModified() || $this->aNick->isNew()) {
					$affectedRows += $this->aNick->save($con);
				}
				$this->setNick($this->aNick);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ChannelNickPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += ChannelNickPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
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

			if ($this->aChannel !== null) {
				if (!$this->aChannel->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aChannel->getValidationFailures());
				}
			}

			if ($this->aNick !== null) {
				if (!$this->aNick->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aNick->getValidationFailures());
				}
			}


			if (($retval = ChannelNickPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
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
		$pos = ChannelNickPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getChannelId();
				break;
			case 1:
				return $this->getNickId();
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
		$keys = ChannelNickPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getChannelId(),
			$keys[1] => $this->getNickId(),
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
		$pos = ChannelNickPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setChannelId($value);
				break;
			case 1:
				$this->setNickId($value);
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
		$keys = ChannelNickPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setChannelId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setNickId($arr[$keys[1]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ChannelNickPeer::DATABASE_NAME);

		if ($this->isColumnModified(ChannelNickPeer::CHANNEL_ID)) $criteria->add(ChannelNickPeer::CHANNEL_ID, $this->channel_id);
		if ($this->isColumnModified(ChannelNickPeer::NICK_ID)) $criteria->add(ChannelNickPeer::NICK_ID, $this->nick_id);

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
		$criteria = new Criteria(ChannelNickPeer::DATABASE_NAME);

		$criteria->add(ChannelNickPeer::CHANNEL_ID, $this->channel_id);
		$criteria->add(ChannelNickPeer::NICK_ID, $this->nick_id);

		return $criteria;
	}

	/**
	 * Returns the composite primary key for this object.
	 * The array elements will be in same order as specified in XML.
	 * @return     array
	 */
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getChannelId();

		$pks[1] = $this->getNickId();

		return $pks;
	}

	/**
	 * Set the [composite] primary key.
	 *
	 * @param      array $keys The elements of the composite key (order must match the order in XML file).
	 * @return     void
	 */
	public function setPrimaryKey($keys)
	{

		$this->setChannelId($keys[0]);

		$this->setNickId($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of ChannelNick (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{


		$copyObj->setNew(true);

		$copyObj->setChannelId(NULL); // this is a pkey column, so set to default value

		$copyObj->setNickId(NULL); // this is a pkey column, so set to default value

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
	 * @return     ChannelNick Clone of current object.
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
	 * @return     ChannelNickPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ChannelNickPeer();
($this->context);

		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Channel object.
	 *
	 * @param      Channel $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setChannel(Channel $v = null)
	{
		if ($v === null) {
			$this->setChannelId(NULL);
		} else {
			$this->setChannelId($v->getId());
		}

		$this->aChannel = $v;


	}


	/**
	 * Get the associated Channel object
	 *
	 * @param      PDO Optional Connection object.
	 * @return     Channel The associated Channel object.
	 * @throws     PropelException
	 */
	public function getChannel(PDO $con = null)
	{
		if ($this->aChannel === null && ($this->channel_id !== null)) {
			$this->aChannel = ChannelPeer::retrieveByPK($this->channel_id, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aChannel->addChannelNicks($this);
			 */
		}
		return $this->aChannel;
	}

	/**
	 * Declares an association between this object and a Nick object.
	 *
	 * @param      Nick $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setNick(Nick $v = null)
	{
		if ($v === null) {
			$this->setNickId(NULL);
		} else {
			$this->setNickId($v->getId());
		}

		$this->aNick = $v;


	}


	/**
	 * Get the associated Nick object
	 *
	 * @param      PDO Optional Connection object.
	 * @return     Nick The associated Nick object.
	 * @throws     PropelException
	 */
	public function getNick(PDO $con = null)
	{
		if ($this->aNick === null && ($this->nick_id !== null)) {
			$this->aNick = NickPeer::retrieveByPK($this->nick_id, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aNick->addChannelNicks($this);
			 */
		}
		return $this->aNick;
	}

} // BaseChannelNick
