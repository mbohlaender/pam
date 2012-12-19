<?php



/**
 * This class defines the structure of the 'note' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.pam.map
 */
class NoteTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'pam.map.NoteTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('note');
        $this->setPhpName('Note');
        $this->setClassname('Note');
        $this->setPackage('pam');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'user', 'ID', true, null, null);
        $this->addColumn('TITLE', 'Title', 'VARCHAR', true, 128, null);
        $this->addColumn('CONTENT', 'Content', 'VARCHAR', true, 1024, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'VARCHAR', true, 1024, null);
        $this->addColumn('VALID_TO', 'ValidTo', 'VARCHAR', true, 1024, null);
        $this->addColumn('CATEGORY', 'Category', 'VARCHAR', true, 1024, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', 'User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
    } // buildRelations()

} // NoteTableMap
