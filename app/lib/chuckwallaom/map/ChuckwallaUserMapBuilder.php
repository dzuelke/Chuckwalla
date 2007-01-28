<?php


/**
 * This class adds structure of 'user' table to 'chuckwalla' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 01/28/07 02:02:21
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    chuckwallaom.map
 */
class ChuckwallaUserMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'chuckwallaom.map.ChuckwallaUserMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(ChuckwallaUserPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ChuckwallaUserPeer::TABLE_NAME);
		$tMap->setPhpName('User');
		$tMap->setClassname('ChuckwallaUser');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('EMAIL', 'Email', 'VARCHAR', true);

		$tMap->addColumn('PASSWORD', 'Password', 'VARCHAR', true);

		$tMap->addColumn('IS_ACTIVE', 'IsActive', 'VARCHAR', true);

		$tMap->addColumn('IS_ADMIN', 'IsAdmin', 'VARCHAR', true);

		$tMap->addColumn('TS_REGISTERED', 'TsRegistered', 'TIMESTAMP', true);

		$tMap->addColumn('TS_LASTLOGIN', 'TsLastlogin', 'TIMESTAMP', true);

		$tMap->addColumn('LOCALE', 'Locale', 'VARCHAR', true);

	} // doBuild()

} // ChuckwallaUserMapBuilder
