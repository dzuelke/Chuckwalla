<?php

abstract class ChuckwallaBaseMessageLogPeer implements AgaviISingletonModel {
	
	protected static $context = null;
	
	public function initialize(AgaviContext $context, array $parameters = array())
	{
		self::$context = $context;
	}
	
	public function getContext()
	{
		return self::$context;
	}

	/** the default database name for this class */
	const DATABASE_NAME = 'chuckwalla';

	/** the table name for this class */
	const TABLE_NAME = 'message_log';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'chuckwallaom.ChuckwallaMessageLog';

	/** The total number of columns. */
	const NUM_COLUMNS = 5;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the ID field */
	const ID = 'message_log.ID';

	/** the column name for the TYPE field */
	const TYPE = 'message_log.TYPE';

	/** the column name for the NICK_ID field */
	const NICK_ID = 'message_log.NICK_ID';

	/** the column name for the CHANNEL_ID field */
	const CHANNEL_ID = 'message_log.CHANNEL_ID';

	/** the column name for the MESSAGE field */
	const MESSAGE = 'message_log.MESSAGE';

	/**
	 * An identiy map to hold any loaded instances of ChuckwallaMessageLog objects.
	 * This must be public so that other peer classes can access this when hydrating from JOIN
	 * queries.
	 * @var        array ChuckwallaMessageLog[]
	 */
	public static $instances = array();

	/**
	 * The MapBuilder instance for this peer.
	 * @var        MapBuilder
	 */
	private static $mapBuilder = null;

	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Type', 'NickId', 'ChannelId', 'Message', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::TYPE, self::NICK_ID, self::CHANNEL_ID, self::MESSAGE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'type', 'nick_id', 'channel_id', 'message', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Type' => 1, 'NickId' => 2, 'ChannelId' => 3, 'Message' => 4, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::TYPE => 1, self::NICK_ID => 2, self::CHANNEL_ID => 3, self::MESSAGE => 4, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'type' => 1, 'nick_id' => 2, 'channel_id' => 3, 'message' => 4, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	/**
	 * Get a (singleton) instance of the MapBuilder for this peer class.
	 * @return     MapBuilder The map builder for this peer
	 */
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			require 'chuckwallaom/map/ChuckwallaMessageLogMapBuilder.php';
			self::$mapBuilder = new ChuckwallaMessageLogMapBuilder();
		}
		return self::$mapBuilder;
	}
	/**
	 * Translates a fieldname to another type
	 *
	 * @param      string $name field name
	 * @param      string $fromType One of the class type constants TYPE_PHPNAME,
	 *                         TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @param      string $toType   One of the class type constants
	 * @return     string translated name of the field.
	 */
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	/**
	 * Returns an array of of field names.
	 *
	 * @param      string $type The type of fieldnames to return:
	 *                      One of the class type constants TYPE_PHPNAME,
	 *                      TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     array A list of field names
	 */

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	/**
	 * Convenience method which changes table.column to alias.column.
	 *
	 * Using this method you can maintain SQL abstraction while using column aliases.
	 * <code>
	 *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
	 *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
	 * </code>
	 * @param      string $alias The alias for the current table.
	 * @param      string $column The column name for current table. (i.e. ChuckwallaMessageLogPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(ChuckwallaMessageLogPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	/**
	 * Add all the columns needed to create a new object.
	 *
	 * Note: any columns that were marked with lazyLoad="true" in the
	 * XML schema will not be added to the select list and only loaded
	 * on demand.
	 *
	 * @param      criteria object containing the columns to add.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ChuckwallaMessageLogPeer::ID);

		$criteria->addSelectColumn(ChuckwallaMessageLogPeer::TYPE);

		$criteria->addSelectColumn(ChuckwallaMessageLogPeer::NICK_ID);

		$criteria->addSelectColumn(ChuckwallaMessageLogPeer::CHANNEL_ID);

		$criteria->addSelectColumn(ChuckwallaMessageLogPeer::MESSAGE);

	}

	const COUNT = 'COUNT(message_log.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT message_log.ID)';

	/**
	 * Returns the number of rows matching criteria.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      PDO $con
	 * @return     int Number of matching rows.
	 */
	public static function doCount(Criteria $criteria, $distinct = false, PDO $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ChuckwallaMessageLogPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ChuckwallaMessageLogPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach ($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$stmt = ChuckwallaMessageLogPeer::doSelectStmt($criteria, $con);
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			return (int) $row[0];
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}
	/**
	 * Method to select one object from the DB.
	 *
	 * @param      Criteria $criteria object used to create the SELECT statement.
	 * @param      PDO $con
	 * @return     ChuckwallaMessageLog
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, PDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = ChuckwallaMessageLogPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	/**
	 * Method to do selects.
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PDO $con
	 * @return     array Array of selected Objects
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelect(Criteria $criteria, PDO $con = null)
	{
		return ChuckwallaMessageLogPeer::populateObjects(ChuckwallaMessageLogPeer::doSelectStmt($criteria, $con));
	}
	/**
	 * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
	 *
	 * Use this method directly if you want to work with an executed statement durirectly (for example
	 * to perform your own object hydration).
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PDO $con The connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @return     PDOStatement The executed PDOStatement object.
	 * @see        BasePeer::doSelect()
	 */
	public static function doSelectStmt(Criteria $criteria, PDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ChuckwallaMessageLogPeer::addSelectColumns($criteria);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		// BasePeer returns a PDOStatement
		return BasePeer::doSelect($criteria, $con);
	}
	/**
	 * Adds an object to the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doSelect*()
	 * methods in your stub classes -- you may need to explicitly add objects
	 * to the cache in order to ensure that the same objects are always returned by doSelect*()
	 * and retrieveByPK*() calls.
	 *
	 * @param      ChuckwallaMessageLog $value A ChuckwallaMessageLog object.
	 */
	public static function addInstanceToPool(ChuckwallaMessageLog $obj)
	{
		// print "+Adding (by addInstanceToPool()) " . get_class($obj) . " " . var_export($obj->getPrimaryKey(),true) . " to instance pool.\n";
	
		$key = (string) $obj->getPrimaryKey();
		self::$instances[$key] = $obj;
	}

	/**
	 * Removes an object from the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doDelete
	 * methods in your stub classes -- you may need to explicitly remove objects
	 * from the cache in order to prevent returning objects that no longer exist.
	 *
	 * @param      mixed $value A ChuckwallaMessageLog object or a primary key value.
	 */
	public static function removeInstanceFromPool($value)
	{
		if (is_object($value) && $value instanceof ChuckwallaMessageLog) {
			// print "-Removing " . get_class($value) . " " . var_export($value->getPrimaryKey(),true) . " from instance pool.\n";
		
			$key = (string) $value->getPrimaryKey();
		} elseif (is_scalar($value)) {
			// print "-Removing pk: " . var_export($value,true) . " class: ChuckwallaMessageLog from instance pool.\n";
			// assume we've been passed a primary key
			$key = serialize($value);
		} else {

			$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or ChuckwallaMessageLog object: " . var_export($value,true));
			print $e;
			throw $e;
		}

		unset(self::$instances[$key]);

	} // removeInstanceFromPool()

	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
	 * @return     object or NULL if no instance exists for specified key.
	 * @see        getPrimaryKeyHash()
	 */
	public static function getInstanceFromPool($key)
	{
		if (isset(self::$instances[$key])) {
			//print "  <-Found ChuckwallaMessageLog " . self::$instances[$key] . " in instance pool.\n";
			return self::$instances[$key];
		} else {
			return null; // just to be explicit
		}
	}
	
	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      array $row PDO resultset row.
	 * @param      int $startcol The 0-based offset for reading from the resultset row.
	 * @return     string
	 */
	public static function clearInstancePool()
	{
		//print "\tClearing ChuckwallaMessageLogPeer instance pool.\n";
		self::$instances = array();
	}
	
	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      array $row PDO resultset row.
	 * @param      int $startcol The 0-based offset for reading from the resultset row.
	 * @return     string
	 */
	public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
	{
		return (string) $row[$startcol + 0];
	}

	/**
	 * The returned array will contain objects of the default type or
	 * objects that inherit from the default.
	 *
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function populateObjects(PDOStatement $stmt)
	{
		$results = array();
	
		// set the class once to avoid overhead in the loop
		$cls = ChuckwallaMessageLogPeer::getOMClass();
		$cls = substr($cls, strrpos($cls, '.') + 1);
		// populate the object(s)
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = ChuckwallaMessageLogPeer::getPrimaryKeyHashFromRow($row, 0);
			if (isset(self::$instances[$key])) {
				// print "  <-Found " . get_class(self::$instances[$key]) . " " . self::$instances[$key] . " in instance pool.\n";
				$results[] = self::$instances[$key];
			} else {
		
			$obj = new $cls();
$obj->initialize(self::$context);

				$obj->hydrate($row);
				$results[] = $obj;
				// print "->Adding " . get_class($obj) . " " . $obj . " into instance pool.\n";
				self::$instances[$key] = $obj;
			} // if key exists
		}
		return $results;
	}

	/**
	 * Returns the number of rows matching criteria, joining the related Channel table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      PDO $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinChannel(Criteria $criteria, $distinct = false, PDO $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ChuckwallaMessageLogPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ChuckwallaMessageLogPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach ($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ChuckwallaMessageLogPeer::CHANNEL_ID, ChuckwallaChannelPeer::ID);

		$stmt = ChuckwallaMessageLogPeer::doSelectStmt($criteria, $con);
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			return (int) $row[0];
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Nick table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      PDO $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinNick(Criteria $criteria, $distinct = false, PDO $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ChuckwallaMessageLogPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ChuckwallaMessageLogPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach ($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ChuckwallaMessageLogPeer::NICK_ID, ChuckwallaNickPeer::ID);

		$stmt = ChuckwallaMessageLogPeer::doSelectStmt($criteria, $con);
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			return (int) $row[0];
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of ChuckwallaMessageLog objects pre-filled with their ChuckwallaChannel objects.
	 *
	 * @return     array Array of ChuckwallaMessageLog objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinChannel(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ChuckwallaMessageLogPeer::addSelectColumns($c);
		$startcol = (ChuckwallaMessageLogPeer::NUM_COLUMNS - ChuckwallaMessageLogPeer::NUM_LAZY_LOAD_COLUMNS);
		ChuckwallaChannelPeer::addSelectColumns($c);

		$c->addJoin(ChuckwallaMessageLogPeer::CHANNEL_ID, ChuckwallaChannelPeer::ID);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = ChuckwallaMessageLogPeer::getPrimaryKeyHashFromRow($row, 0);
			if (isset(self::$instances[$key1])) {
				$obj1 = self::$instances[$key1];
				// print "  <-Found " . get_class($obj1) . " " . $obj1 . " into instance pool.\n";
			} else {

				$omClass = ChuckwallaMessageLogPeer::getOMClass();

				$cls = substr($omClass, strrpos($omClass, '.') + 1);
				$obj1 = new $cls();
$obj1->initialize(self::$context);

				$obj1->hydrate($row);
				// print "->Adding " . get_class($obj1) . " " . $obj1 . " into instance pool.\n";
				self::$instances[$key1] = $obj1;
			} // if $obj1 already loaded

			$key2 = ChuckwallaChannelPeer::getPrimaryKeyHashFromRow($row, $startcol);
			$obj2 = ChuckwallaChannelPeer::getInstanceFromPool($key2);
			if (!$obj2) {

				$omClass = ChuckwallaChannelPeer::getOMClass();

				$cls = substr($omClass, strrpos($omClass, '.') + 1);
				$obj2 = new $cls();
$obj2->initialize(self::$context);

				$obj2->hydrate($row, $startcol);
				ChuckwallaChannelPeer::addInstanceToPool($obj2); // FIXME, we should optimize this since we already calculated the key above
			} // if obj2 already loaded

			// Add the $obj1 (ChuckwallaMessageLog) to the collection in $obj2 (ChuckwallaChannel)
			$obj2->addMessageLog($obj1);

			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of ChuckwallaMessageLog objects pre-filled with their ChuckwallaNick objects.
	 *
	 * @return     array Array of ChuckwallaMessageLog objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinNick(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ChuckwallaMessageLogPeer::addSelectColumns($c);
		$startcol = (ChuckwallaMessageLogPeer::NUM_COLUMNS - ChuckwallaMessageLogPeer::NUM_LAZY_LOAD_COLUMNS);
		ChuckwallaNickPeer::addSelectColumns($c);

		$c->addJoin(ChuckwallaMessageLogPeer::NICK_ID, ChuckwallaNickPeer::ID);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = ChuckwallaMessageLogPeer::getPrimaryKeyHashFromRow($row, 0);
			if (isset(self::$instances[$key1])) {
				$obj1 = self::$instances[$key1];
				// print "  <-Found " . get_class($obj1) . " " . $obj1 . " into instance pool.\n";
			} else {

				$omClass = ChuckwallaMessageLogPeer::getOMClass();

				$cls = substr($omClass, strrpos($omClass, '.') + 1);
				$obj1 = new $cls();
$obj1->initialize(self::$context);

				$obj1->hydrate($row);
				// print "->Adding " . get_class($obj1) . " " . $obj1 . " into instance pool.\n";
				self::$instances[$key1] = $obj1;
			} // if $obj1 already loaded

			$key2 = ChuckwallaNickPeer::getPrimaryKeyHashFromRow($row, $startcol);
			$obj2 = ChuckwallaNickPeer::getInstanceFromPool($key2);
			if (!$obj2) {

				$omClass = ChuckwallaNickPeer::getOMClass();

				$cls = substr($omClass, strrpos($omClass, '.') + 1);
				$obj2 = new $cls();
$obj2->initialize(self::$context);

				$obj2->hydrate($row, $startcol);
				ChuckwallaNickPeer::addInstanceToPool($obj2); // FIXME, we should optimize this since we already calculated the key above
			} // if obj2 already loaded

			// Add the $obj1 (ChuckwallaMessageLog) to the collection in $obj2 (ChuckwallaNick)
			$obj2->addMessageLog($obj1);

			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining all related tables
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      PDO $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, PDO $con = null)
	{
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ChuckwallaMessageLogPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ChuckwallaMessageLogPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach ($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ChuckwallaMessageLogPeer::CHANNEL_ID, ChuckwallaChannelPeer::ID);

		$criteria->addJoin(ChuckwallaMessageLogPeer::NICK_ID, ChuckwallaNickPeer::ID);

		$stmt = ChuckwallaMessageLogPeer::doSelectStmt($criteria, $con);
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			return (int) $row[0];
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of ChuckwallaMessageLog objects pre-filled with all related objects.
	 *
	 * @return     array Array of ChuckwallaMessageLog objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAll(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ChuckwallaMessageLogPeer::addSelectColumns($c);
		$startcol2 = (ChuckwallaMessageLogPeer::NUM_COLUMNS - ChuckwallaMessageLogPeer::NUM_LAZY_LOAD_COLUMNS);

		ChuckwallaChannelPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ChuckwallaChannelPeer::NUM_COLUMNS;

		ChuckwallaNickPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ChuckwallaNickPeer::NUM_COLUMNS;

		$c->addJoin(ChuckwallaMessageLogPeer::CHANNEL_ID, ChuckwallaChannelPeer::ID);

		$c->addJoin(ChuckwallaMessageLogPeer::NICK_ID, ChuckwallaNickPeer::ID);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = ChuckwallaMessageLogPeer::getPrimaryKeyHashFromRow($row, 0);
			if (isset(self::$instances[$key1])) {
				$obj1 = self::$instances[$key1];
				// print "  <-Found " . get_class($obj1) . " " . $obj1 . " in instance pool.\n";
			} else {

				$omClass = ChuckwallaMessageLogPeer::getOMClass();

				$cls = substr($omClass, strrpos($omClass, '.') + 1);
				$obj1 = new $cls();
$obj1->initialize(self::$context);

				$obj1->hydrate($row);
				// print "->Adding " . get_class($obj1) . " " . $obj1 . " into instance pool.\n";
				self::$instances[$key1] = $obj1;
			} // if obj1 already loaded

			// Add objects for joined ChuckwallaNick rows

			$key2 = ChuckwallaNickPeer::getPrimaryKeyHashFromRow($row, $startcol2);

			$obj2 = ChuckwallaNickPeer::getInstanceFromPool($key2);
			if (!$obj2) {

				$omClass = ChuckwallaNickPeer::getOMClass();


				$cls = substr($omClass, strrpos($omClass, '.') + 1);
				$obj2 = new $cls();
$obj2->initialize(self::$context);

				$obj2->hydrate($row, $startcol2);
				ChuckwallaNickPeer::addInstanceToPool($obj2); // FIXME - Optimize: we already know the key
			} // if obj2 loaded

			// Add the $obj1 (ChuckwallaMessageLog) to the collection in $obj2 (ChuckwallaNick)
			$obj2->addMessageLog($obj1);

			// Add objects for joined ChuckwallaChannel rows

			$key3 = ChuckwallaChannelPeer::getPrimaryKeyHashFromRow($row, $startcol3);

			$obj3 = ChuckwallaChannelPeer::getInstanceFromPool($key3);
			if (!$obj3) {

				$omClass = ChuckwallaChannelPeer::getOMClass();


				$cls = substr($omClass, strrpos($omClass, '.') + 1);
				$obj3 = new $cls();
$obj3->initialize(self::$context);

				$obj3->hydrate($row, $startcol3);
				ChuckwallaChannelPeer::addInstanceToPool($obj3); // FIXME - Optimize: we already know the key
			} // if obj3 loaded

			// Add the $obj1 (ChuckwallaMessageLog) to the collection in $obj3 (ChuckwallaChannel)
			$obj3->addMessageLog($obj1);

			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Channel table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      PDO $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptChannel(Criteria $criteria, $distinct = false, PDO $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ChuckwallaMessageLogPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ChuckwallaMessageLogPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach ($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ChuckwallaMessageLogPeer::NICK_ID, ChuckwallaNickPeer::ID);

		$stmt = ChuckwallaMessageLogPeer::doSelectStmt($criteria, $con);
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			return (int) $row[0];
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Nick table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      PDO $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptNick(Criteria $criteria, $distinct = false, PDO $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ChuckwallaMessageLogPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ChuckwallaMessageLogPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach ($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ChuckwallaMessageLogPeer::CHANNEL_ID, ChuckwallaChannelPeer::ID);

		$stmt = ChuckwallaMessageLogPeer::doSelectStmt($criteria, $con);
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			return (int) $row[0];
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of ChuckwallaMessageLog objects pre-filled with all related objects except Channel.
	 *
	 * @return     array Array of ChuckwallaMessageLog objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptChannel(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ChuckwallaMessageLogPeer::addSelectColumns($c);
		$startcol2 = (ChuckwallaMessageLogPeer::NUM_COLUMNS - ChuckwallaMessageLogPeer::NUM_LAZY_LOAD_COLUMNS);

		ChuckwallaNickPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ChuckwallaNickPeer::NUM_COLUMNS;

		$c->addJoin(ChuckwallaMessageLogPeer::NICK_ID, ChuckwallaNickPeer::ID);


		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = ChuckwallaMessageLogPeer::getPrimaryKeyHashFromRow($row, 0);
			if (isset(self::$instances[$key1])) {
				$obj1 = self::$instances[$key1];
				// print "  <-Found " . get_class($obj1) . " " . $obj1 . " in instance pool.\n";
			} else {

				$omClass = ChuckwallaMessageLogPeer::getOMClass();

				$cls = substr($omClass, strrpos($omClass, '.') + 1);
				$obj1 = new $cls();
$obj1->initialize(self::$context);

				$obj1->hydrate($row);
				// print "->Adding " . get_class($obj1) . " " . $obj1 . " into instance pool.\n";
				self::$instances[$key1] = $obj1;
			} // if obj1 already loaded

				// Add objects for joined ChuckwallaNick rows

				$key2 = ChuckwallaNickPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				$obj2 = ChuckwallaNickPeer::getInstanceFromPool($key2);
				if (!2) {
	
					$omClass = ChuckwallaNickPeer::getOMClass();


				$cls = substr($omClass, strrpos($omClass, '.') + 1);
				$obj2 = new $cls();
$obj2->initialize(self::$context);

				$obj2->hydrate($row, $startcol2);
				ChuckwallaNickPeer::addInstanceToPool($obj2); // FIXME - Optimize: we already calculated the key
			} // if $obj2 already loaded

			// Add the $obj1 (ChuckwallaMessageLog) to the collection in $obj2 (ChuckwallaNick)
			$obj2->addMessageLog($obj1);

			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of ChuckwallaMessageLog objects pre-filled with all related objects except Nick.
	 *
	 * @return     array Array of ChuckwallaMessageLog objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptNick(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ChuckwallaMessageLogPeer::addSelectColumns($c);
		$startcol2 = (ChuckwallaMessageLogPeer::NUM_COLUMNS - ChuckwallaMessageLogPeer::NUM_LAZY_LOAD_COLUMNS);

		ChuckwallaChannelPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ChuckwallaChannelPeer::NUM_COLUMNS;

		$c->addJoin(ChuckwallaMessageLogPeer::CHANNEL_ID, ChuckwallaChannelPeer::ID);


		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = ChuckwallaMessageLogPeer::getPrimaryKeyHashFromRow($row, 0);
			if (isset(self::$instances[$key1])) {
				$obj1 = self::$instances[$key1];
				// print "  <-Found " . get_class($obj1) . " " . $obj1 . " in instance pool.\n";
			} else {

				$omClass = ChuckwallaMessageLogPeer::getOMClass();

				$cls = substr($omClass, strrpos($omClass, '.') + 1);
				$obj1 = new $cls();
$obj1->initialize(self::$context);

				$obj1->hydrate($row);
				// print "->Adding " . get_class($obj1) . " " . $obj1 . " into instance pool.\n";
				self::$instances[$key1] = $obj1;
			} // if obj1 already loaded

				// Add objects for joined ChuckwallaChannel rows

				$key2 = ChuckwallaChannelPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				$obj2 = ChuckwallaChannelPeer::getInstanceFromPool($key2);
				if (!2) {
	
					$omClass = ChuckwallaChannelPeer::getOMClass();


				$cls = substr($omClass, strrpos($omClass, '.') + 1);
				$obj2 = new $cls();
$obj2->initialize(self::$context);

				$obj2->hydrate($row, $startcol2);
				ChuckwallaChannelPeer::addInstanceToPool($obj2); // FIXME - Optimize: we already calculated the key
			} // if $obj2 already loaded

			// Add the $obj1 (ChuckwallaMessageLog) to the collection in $obj2 (ChuckwallaChannel)
			$obj2->addMessageLog($obj1);

			$results[] = $obj1;
		}
		return $results;
	}

	/**
	 * Returns the TableMap related to this peer.
	 * This method is not needed for general use but a specific application could have a need.
	 * @return     TableMap
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	/**
	 * The class that the Peer will make instances of.
	 *
	 * This uses a dot-path notation which is tranalted into a path
	 * relative to a location on the PHP include_path.
	 * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
	 *
	 * @return     string path.to.ClassName
	 */
	public static function getOMClass()
	{
		return ChuckwallaMessageLogPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a ChuckwallaMessageLog or Criteria object.
	 *
	 * @param      mixed $values Criteria or ChuckwallaMessageLog object containing data that is used to create the INSERT statement.
	 * @param      PDO $con the PDO connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from ChuckwallaMessageLog object
		}

		$criteria->remove(ChuckwallaMessageLogPeer::ID); // remove pkey col since this table uses auto-increment


		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		try {
			// use transaction because $criteria could contain info
			// for more than one table (I guess, conceivably)
			$con->beginTransaction();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a ChuckwallaMessageLog or Criteria object.
	 *
	 * @param      mixed $values Criteria or ChuckwallaMessageLog object containing data that is used to create the UPDATE statement.
	 * @param      PDO $con The connection to use (specify PDO connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, PDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(ChuckwallaMessageLogPeer::ID);
			$selectCriteria->add(ChuckwallaMessageLogPeer::ID, $criteria->remove(ChuckwallaMessageLogPeer::ID), $comparison);

		} else { // $values is ChuckwallaMessageLog object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	/**
	 * Method to DELETE all rows from the message_log table.
	 *
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(ChuckwallaMessageLogPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a ChuckwallaMessageLog or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or ChuckwallaMessageLog object or primary key or array of primary keys
	 *              which is used to create the DELETE statement
	 * @param      PDO $con the connection to use
	 * @return     int 	The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
	 *				if supported by native driver or if emulated using Propel.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	 public static function doDelete($values, PDO $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(ChuckwallaMessageLogPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			// invalidate the cache for all objects of this type, since we have no
			// way of knowing (without running a query) what objects should be invalidated
			// from the cache based on this Criteria.
			ChuckwallaMessageLogPeer::clearInstancePool();

			// rename for clarity
			$criteria = clone $values;
		} elseif ($values instanceof ChuckwallaMessageLog) {
			// invalidate the cache for this single object
			ChuckwallaMessageLogPeer::removeInstanceFromPool($values);
			// create criteria based on pk values
			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key

			// we can invalidate the cache for this single object
			ChuckwallaMessageLogPeer::removeInstanceFromPool($values);

			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ChuckwallaMessageLogPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);

			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Validates all modified columns of given ChuckwallaMessageLog object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      ChuckwallaMessageLog $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(ChuckwallaMessageLog $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ChuckwallaMessageLogPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ChuckwallaMessageLogPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach ($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		return BasePeer::doValidate(ChuckwallaMessageLogPeer::DATABASE_NAME, ChuckwallaMessageLogPeer::TABLE_NAME, $columns);
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      mixed $pk the primary key.
	 * @param      PDO $con the connection to use
	 * @return     ChuckwallaMessageLog
	 */
	public static function retrieveByPK($pk, PDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(ChuckwallaMessageLogPeer::DATABASE_NAME);

		$criteria->add(ChuckwallaMessageLogPeer::ID, $pk);


		$v = ChuckwallaMessageLogPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	/**
	 * Retrieve multiple objects by pkey.
	 *
	 * @param      array $pks List of primary keys
	 * @param      PDO $con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function retrieveByPKs($pks, PDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(ChuckwallaMessageLogPeer::ID, $pks, Criteria::IN);
			$objs = ChuckwallaMessageLogPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // ChuckwallaBaseMessageLogPeer

// This is the static code needed to register the MapBuilder for this table with the main Propel class.
//
// NOTE: This static code cannot call methods on the ChuckwallaMessageLogPeer class, because it is not defined yet.
// If you need to use overridden methods, you can add this code to the bottom of the ChuckwallaMessageLogPeer class:
//
// Propel::getDatabaseMap(ChuckwallaMessageLogPeer::DATABASE_NAME)->addTableBuilder(ChuckwallaMessageLogPeer::TABLE_NAME, ChuckwallaMessageLogPeer::getMapBuilder());
//
// Doing so will effectively overwrite the registration below.

Propel::getDatabaseMap(ChuckwallaBaseMessageLogPeer::DATABASE_NAME)->addTableBuilder(ChuckwallaBaseMessageLogPeer::TABLE_NAME, ChuckwallaBaseMessageLogPeer::getMapBuilder());

