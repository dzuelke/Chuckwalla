<?php


/**
 * This class adds structure of 'irc_identity' table to 'chuckwalla' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 01/28/07 04:28:34
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    chuckwallaom.map
 */
class ChuckwallaIrcIdentityMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'chuckwallaom.map.ChuckwallaIrcIdentityMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(ChuckwallaIrcIdentityPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ChuckwallaIrcIdentityPeer::TABLE_NAME);
		$tMap->setPhpName('IrcIdentity');
		$tMap->setClassname('ChuckwallaIrcIdentity');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'user', 'ID', false, null);

		$tMap->addColumn('IS_ONLINE', 'IsOnline', 'BOOLEAN', false);

		$tMap->addColumn('IDENT', 'Ident', 'VARCHAR', false);

		$tMap->addColumn('REALNAME', 'Realname', 'VARCHAR', false);

		$tMap->addColumn('HOST', 'Host', 'VARCHAR', false);

		$tMap->addColumn('SERVER', 'Server', 'VARCHAR', false);

		$tMap->addColumn('IRCOP', 'Ircop', 'BOOLEAN', false);

		$tMap->addColumn('IS_AWAY', 'IsAway', 'BOOLEAN', false);

		$tMap->addColumn('LAST_QUIT_TIME', 'LastQuitTime', 'TIMESTAMP', false);

		$tMap->addColumn('LAST_QUIT_MESSAGE', 'LastQuitMessage', 'LONGVARCHAR', false);

	} // doBuild()

} // ChuckwallaIrcIdentityMapBuilder
