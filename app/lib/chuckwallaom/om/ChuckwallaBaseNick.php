<?php

abstract class ChuckwallaBaseNick extends BaseObject implements Persistent, AgaviIModel {
	
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
	 * @var        ChuckwallaNickPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the nick field.
	 * @var        string
	 */
	protected $nick;


	/**
	 * The value for the irc_identity_id field.
	 * @var        int
	 */
	protected $irc_identity_id;

	/**
	 * @var        IrcIdentity
	 */
	protected $aIrcIdentity;

	/**
	 * @var        array ChuckwallaChannelNick[] Collection to store aggregation of ChuckwallaChannelNick objects.
	 */
	protected $collChannelNicks;

	/**
	 * @var        Criteria The criteria used to select the current contents of collChannelNicks.
	 */
	private $lastChannelNickCriteria = null;

	/**
	 * @var        array ChuckwallaMessageLog[] Collection to store aggregation of ChuckwallaMessageLog objects.
	 */
	protected $collMessageLogs;

	/**
	 * @var        Criteria The criteria used to select the current contents of collMessageLogs.
	 */
	private $lastMessageLogCriteria = null;

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
	 * Get the [nick] column value.
	 * 
	 * @return     string
	 */
	public function getNick()
	{

		return $this->nick;
	}

	/**
	 * Get the [irc_identity_id] column value.
	 * 
	 * @return     int
	 */
	public function getIrcIdentityId()
	{

		return $this->irc_identity_id;
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
			$this->modifiedColumns[] = ChuckwallaNickPeer::ID;
		}

	} // setId()

	/**
	 * Set the value of [nick] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setNick($v)
	{

		if ($this->nick !== $v) {
			$this->nick = $v;
			$this->modifiedColumns[] = ChuckwallaNickPeer::NICK;
		}

	} // setNick()

	/**
	 * Set the value of [irc_identity_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setIrcIdentityId($v)
	{

		if ($this->irc_identity_id !== $v) {
			$this->irc_identity_id = $v;
			$this->modifiedColumns[] = ChuckwallaNickPeer::IRC_IDENTITY_ID;
		}

		if ($this->aIrcIdentity !== null && $this->aIrcIdentity->getId() !== $v) {
			$this->aIrcIdentity = null;
		}

	} // setIrcIdentityId()

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
			$this->nick = $row[$startcol + 1];
			$this->irc_identity_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->resetModified();

			$this->setNew(false);

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 3; // 3 = ChuckwallaNickPeer::NUM_COLUMNS - ChuckwallaNickPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Nick object", $e);
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
			$con = Propel::getConnection(ChuckwallaNickPeer::DATABASE_NAME);
		}

		try {
			$con->beginTransaction();
			ChuckwallaNickPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ChuckwallaNickPeer::DATABASE_NAME);
		}

		try {
			$con->beginTransaction();
			$affectedRows = $this->doSave($con);
			$con->commit();
			ChuckwallaNickPeer::addInstanceToPool($this);
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

			if ($this->aIrcIdentity !== null) {
				if ($this->aIrcIdentity->isModified() || $this->aIrcIdentity->isNew()) {
					$affectedRows += $this->aIrcIdentity->save($con);
				}
				$this->setIrcIdentity($this->aIrcIdentity);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ChuckwallaNickPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ChuckwallaNickPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collChannelNicks !== null) {
				foreach ($this->collChannelNicks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collMessageLogs !== null) {
				foreach ($this->collMessageLogs as $referrerFK) {
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

			if ($this->aIrcIdentity !== null) {
				if (!$this->aIrcIdentity->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aIrcIdentity->getValidationFailures());
				}
			}


			if (($retval = ChuckwallaNickPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collChannelNicks !== null) {
					foreach ($this->collChannelNicks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collMessageLogs !== null) {
					foreach ($this->collMessageLogs as $referrerFK) {
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
		$pos = ChuckwallaNickPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getNick();
				break;
			case 2:
				return $this->getIrcIdentityId();
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
		$keys = ChuckwallaNickPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getNick(),
			$keys[2] => $this->getIrcIdentityId(),
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
		$pos = ChuckwallaNickPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setNick($value);
				break;
			case 2:
				$this->setIrcIdentityId($value);
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
		$keys = ChuckwallaNickPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setNick($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIrcIdentityId($arr[$keys[2]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ChuckwallaNickPeer::DATABASE_NAME);

		if ($this->isColumnModified(ChuckwallaNickPeer::ID)) $criteria->add(ChuckwallaNickPeer::ID, $this->id);
		if ($this->isColumnModified(ChuckwallaNickPeer::NICK)) $criteria->add(ChuckwallaNickPeer::NICK, $this->nick);
		if ($this->isColumnModified(ChuckwallaNickPeer::IRC_IDENTITY_ID)) $criteria->add(ChuckwallaNickPeer::IRC_IDENTITY_ID, $this->irc_identity_id);

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
		$criteria = new Criteria(ChuckwallaNickPeer::DATABASE_NAME);

		$criteria->add(ChuckwallaNickPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of ChuckwallaNick (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setNick($this->nick);

		$copyObj->setIrcIdentityId($this->irc_identity_id);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getChannelNicks() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
				$copyObj->addChannelNick($relObj->copy($deepCopy));
			}
			}

			foreach ($this->getMessageLogs() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
				$copyObj->addMessageLog($relObj->copy($deepCopy));
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
	 * @return     ChuckwallaNick Clone of current object.
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
	 * @return     ChuckwallaNickPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ChuckwallaNickPeer();
($this->context);

		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a ChuckwallaIrcIdentity object.
	 *
	 * @param      ChuckwallaIrcIdentity $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setIrcIdentity(ChuckwallaIrcIdentity $v = null)
	{
		if ($v === null) {
			$this->setIrcIdentityId(NULL);
		} else {
			$this->setIrcIdentityId($v->getId());
		}

		$this->aIrcIdentity = $v;


	}


	/**
	 * Get the associated IrcIdentity object
	 *
	 * @param      PDO Optional Connection object.
	 * @return     IrcIdentity The associated IrcIdentity object.
	 * @throws     PropelException
	 */
	public function getIrcIdentity(PDO $con = null)
	{
		if ($this->aIrcIdentity === null && ($this->irc_identity_id !== null)) {
			$this->aIrcIdentity = ChuckwallaIrcIdentityPeer::retrieveByPK($this->irc_identity_id, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aIrcIdentity->addNicks($this);
			 */
		}
		return $this->aIrcIdentity;
	}

	/**
	 * Temporary storage of collChannelNicks to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 *
	 * @return     void
	 * @deprecated - This method will be removed in 2.0 since arrays
	 *				are automatically initialized in the addChannelNicks() method.
	 * @see        addChannelNicks()
	 */
	public function initChannelNicks()
	{
		if ($this->collChannelNicks === null) {
			$this->collChannelNicks = array();
		}
	}

	/**
	 * Gets an array of  objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this ChuckwallaNick has previously been saved, it will retrieve
	 * related ChannelNicks from storage. If this ChuckwallaNick is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PDO $con
	 * @param      Criteria $criteria
	 * @return     array []
	 * @throws     PropelException
	 */
	public function getChannelNicks($criteria = null, PDO $con = null)
	{
		
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collChannelNicks === null) {
			if ($this->isNew()) {
			   $this->collChannelNicks = array();
			} else {

				$criteria->add(ChuckwallaChannelNickPeer::NICK_ID, $this->getId());

				ChuckwallaChannelNickPeer::addSelectColumns($criteria);
				$this->collChannelNicks = ChuckwallaChannelNickPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ChuckwallaChannelNickPeer::NICK_ID, $this->getId());

				ChuckwallaChannelNickPeer::addSelectColumns($criteria);
				if (!isset($this->lastChannelNickCriteria) || !$this->lastChannelNickCriteria->equals($criteria)) {
					$this->collChannelNicks = ChuckwallaChannelNickPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastChannelNickCriteria = $criteria;
		return $this->collChannelNicks;
	}

	/**
	 * Returns the number of related ChannelNicks.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PDO $con
	 * @throws     PropelException
	 */
	public function countChannelNicks($criteria = null, $distinct = false, PDO $con = null)
	{
		
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ChuckwallaChannelNickPeer::NICK_ID, $this->getId());

		return ChuckwallaChannelNickPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ChuckwallaChannelNick object to this object
	 * through the ChuckwallaChannelNick foreign key attribute.
	 *
	 * @param      ChuckwallaChannelNick $l ChuckwallaChannelNick
	 * @return     void
	 * @throws     PropelException
	 */
	public function addChannelNick(ChuckwallaChannelNick $l)
	{
		$this->collChannelNicks = (array) $this->collChannelNicks;
		array_push($this->collChannelNicks, $l);
		$l->setNick($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Nick is new, it will return
	 * an empty collection; or if this Nick has previously
	 * been saved, it will retrieve related ChannelNicks from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Nick.
	 */
	public function getChannelNicksJoinChannel($criteria = null, $con = null)
	{
		
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collChannelNicks === null) {
			if ($this->isNew()) {
				$this->collChannelNicks = array();
			} else {

				$criteria->add(ChuckwallaChannelNickPeer::NICK_ID, $this->getId());

				$this->collChannelNicks = ChuckwallaChannelNickPeer::doSelectJoinChannel($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ChuckwallaChannelNickPeer::NICK_ID, $this->getId());

			if (!isset($this->lastChannelNickCriteria) || !$this->lastChannelNickCriteria->equals($criteria)) {
				$this->collChannelNicks = ChuckwallaChannelNickPeer::doSelectJoinChannel($criteria, $con);
			}
		}
		$this->lastChannelNickCriteria = $criteria;

		return $this->collChannelNicks;
	}

	/**
	 * Temporary storage of collMessageLogs to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 *
	 * @return     void
	 * @deprecated - This method will be removed in 2.0 since arrays
	 *				are automatically initialized in the addMessageLogs() method.
	 * @see        addMessageLogs()
	 */
	public function initMessageLogs()
	{
		if ($this->collMessageLogs === null) {
			$this->collMessageLogs = array();
		}
	}

	/**
	 * Gets an array of  objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this ChuckwallaNick has previously been saved, it will retrieve
	 * related MessageLogs from storage. If this ChuckwallaNick is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PDO $con
	 * @param      Criteria $criteria
	 * @return     array []
	 * @throws     PropelException
	 */
	public function getMessageLogs($criteria = null, PDO $con = null)
	{
		
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMessageLogs === null) {
			if ($this->isNew()) {
			   $this->collMessageLogs = array();
			} else {

				$criteria->add(ChuckwallaMessageLogPeer::NICK_ID, $this->getId());

				ChuckwallaMessageLogPeer::addSelectColumns($criteria);
				$this->collMessageLogs = ChuckwallaMessageLogPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ChuckwallaMessageLogPeer::NICK_ID, $this->getId());

				ChuckwallaMessageLogPeer::addSelectColumns($criteria);
				if (!isset($this->lastMessageLogCriteria) || !$this->lastMessageLogCriteria->equals($criteria)) {
					$this->collMessageLogs = ChuckwallaMessageLogPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMessageLogCriteria = $criteria;
		return $this->collMessageLogs;
	}

	/**
	 * Returns the number of related MessageLogs.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PDO $con
	 * @throws     PropelException
	 */
	public function countMessageLogs($criteria = null, $distinct = false, PDO $con = null)
	{
		
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ChuckwallaMessageLogPeer::NICK_ID, $this->getId());

		return ChuckwallaMessageLogPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ChuckwallaMessageLog object to this object
	 * through the ChuckwallaMessageLog foreign key attribute.
	 *
	 * @param      ChuckwallaMessageLog $l ChuckwallaMessageLog
	 * @return     void
	 * @throws     PropelException
	 */
	public function addMessageLog(ChuckwallaMessageLog $l)
	{
		$this->collMessageLogs = (array) $this->collMessageLogs;
		array_push($this->collMessageLogs, $l);
		$l->setNick($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Nick is new, it will return
	 * an empty collection; or if this Nick has previously
	 * been saved, it will retrieve related MessageLogs from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Nick.
	 */
	public function getMessageLogsJoinChannel($criteria = null, $con = null)
	{
		
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMessageLogs === null) {
			if ($this->isNew()) {
				$this->collMessageLogs = array();
			} else {

				$criteria->add(ChuckwallaMessageLogPeer::NICK_ID, $this->getId());

				$this->collMessageLogs = ChuckwallaMessageLogPeer::doSelectJoinChannel($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ChuckwallaMessageLogPeer::NICK_ID, $this->getId());

			if (!isset($this->lastMessageLogCriteria) || !$this->lastMessageLogCriteria->equals($criteria)) {
				$this->collMessageLogs = ChuckwallaMessageLogPeer::doSelectJoinChannel($criteria, $con);
			}
		}
		$this->lastMessageLogCriteria = $criteria;

		return $this->collMessageLogs;
	}

} // ChuckwallaBaseNick
