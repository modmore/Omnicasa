<?php
namespace modmore\Omnicasa\Model\mysql;

use xPDO\xPDO;

class ocProperty extends \modmore\Omnicasa\Model\ocProperty
{

    public static $metaMap = array (
        'package' => 'modmore\\Omnicasa\\Model',
        'version' => '3.0',
        'table' => 'omnicasa_properties',
        'tableMeta' => 
        array (
            'engine' => 'InnoDB',
        ),
        'fields' => 
        array (
            'alias' => '',
            'oc_ID' => 0,
            'type_of_property' => 'sale',
            'CreatedDate' => NULL,
            'LastChangedDate' => NULL,
            'SynchronisedDate' => NULL,
            'OfficeName' => '',
            'SiteID' => '',
            'WebID' => 0,
            'WebIDName' => '',
            'Ident' => '',
            'TypeDescription' => '',
            'Street' => '',
            'HouseNumber' => '',
            'City' => '',
            'Zip' => '',
            'District' => '',
            'GoogleX' => '',
            'GoogleY' => '',
            'CountryAbbr' => '',
            'CountryName' => '',
            'DescriptionA' => '',
            'Price' => 0,
            'SubStatus' => '',
            'SubStatusName' => '',
            'ConditionID' => 0,
            'ConditionName' => '',
            'SurfaceTotal' => 0,
            'SurfaceLiving' => 0,
            'SurfaceGarden' => 0,
            'SurfaceTerrace' => 0,
            'SurfaceConstructed' => 0,
            'SurfaceOffice' => 0,
            'SurfaceGround' => 0,
            'SurfaceGround2' => 0,
            'SurfaceStore' => 0,
            'NumberOfBedRooms' => 0,
            'NumberOfBathRooms' => 0,
            'NumberOfShowerRooms' => 0,
            'NumberOfToilets' => 0,
            'NumberOfGarages' => 0,
            'NumberOfParkings' => 0,
            'HasGarden' => 0,
            'HasFurnished' => 0,
            'HasLift' => 0,
            'HasCellar' => 0,
            'HasAttic' => 0,
            'all_data' => '',
        ),
        'fieldMeta' => 
        array (
            'alias' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
            'oc_ID' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => false,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'type_of_property' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '20',
                'phptype' => 'string',
                'null' => false,
                'default' => 'sale',
            ),
            'CreatedDate' => 
            array (
                'dbtype' => 'datetime',
                'phptype' => 'string',
                'null' => true,
            ),
            'LastChangedDate' => 
            array (
                'dbtype' => 'datetime',
                'phptype' => 'string',
                'null' => true,
            ),
            'SynchronisedDate' => 
            array (
                'dbtype' => 'datetime',
                'phptype' => 'string',
                'null' => true,
            ),
            'OfficeName' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => true,
                'default' => '',
            ),
            'SiteID' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => true,
                'default' => '',
            ),
            'WebID' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
            ),
            'WebIDName' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
            'Ident' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
            'TypeDescription' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
            'Street' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
            'HouseNumber' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
            'City' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
            'Zip' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
            'District' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
            'GoogleX' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
            'GoogleY' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
            'CountryAbbr' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
            'CountryName' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
            'DescriptionA' => 
            array (
                'dbtype' => 'mediumtext',
                'phptype' => 'string',
                'null' => true,
                'default' => '',
            ),
            'Price' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => false,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'SubStatus' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => true,
                'default' => '',
            ),
            'SubStatusName' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => true,
                'default' => '',
            ),
            'ConditionID' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'ConditionName' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '191',
                'phptype' => 'string',
                'null' => true,
                'default' => '',
            ),
            'SurfaceTotal' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'SurfaceLiving' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'SurfaceGarden' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'SurfaceTerrace' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'SurfaceConstructed' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'SurfaceOffice' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'SurfaceGround' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'SurfaceGround2' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'SurfaceStore' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'NumberOfBedRooms' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'NumberOfBathRooms' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'NumberOfShowerRooms' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'NumberOfToilets' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'NumberOfGarages' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'NumberOfParkings' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => true,
                'default' => 0,
                'attributes' => 'unsigned',
            ),
            'HasGarden' => 
            array (
                'dbtype' => 'tinyint',
                'precision' => '1',
                'phptype' => 'boolean',
                'null' => false,
                'default' => 0,
            ),
            'HasFurnished' => 
            array (
                'dbtype' => 'tinyint',
                'precision' => '1',
                'phptype' => 'boolean',
                'null' => false,
                'default' => 0,
            ),
            'HasLift' => 
            array (
                'dbtype' => 'tinyint',
                'precision' => '1',
                'phptype' => 'boolean',
                'null' => false,
                'default' => 0,
            ),
            'HasCellar' => 
            array (
                'dbtype' => 'tinyint',
                'precision' => '1',
                'phptype' => 'boolean',
                'null' => false,
                'default' => 0,
            ),
            'HasAttic' => 
            array (
                'dbtype' => 'tinyint',
                'precision' => '1',
                'phptype' => 'boolean',
                'null' => false,
                'default' => 0,
            ),
            'all_data' => 
            array (
                'dbtype' => 'mediumtext',
                'phptype' => 'array',
                'null' => true,
                'default' => '',
            ),
        ),
        'indexes' => 
        array (
            'oc_ID' => 
            array (
                'alias' => 'oc_ID',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'oc_ID' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'type_of_property' => 
            array (
                'alias' => 'type_of_property',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'type_of_property' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'SiteID' => 
            array (
                'alias' => 'SiteID',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'SiteID' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'WebID' => 
            array (
                'alias' => 'WebID',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'WebID' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'Ident' => 
            array (
                'alias' => 'Ident',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'Ident' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'TypeDescription' => 
            array (
                'alias' => 'TypeDescription',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'TypeDescription' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'Street' => 
            array (
                'alias' => 'Street',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'Street' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'City' => 
            array (
                'alias' => 'City',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'City' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'Zip' => 
            array (
                'alias' => 'Zip',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'Zip' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'District' => 
            array (
                'alias' => 'District',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'District' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'GoogleX' => 
            array (
                'alias' => 'GoogleX',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'GoogleX' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'GoogleY' => 
            array (
                'alias' => 'GoogleY',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'GoogleY' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'CountryAbbr' => 
            array (
                'alias' => 'CountryAbbr',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'CountryAbbr' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'Price' => 
            array (
                'alias' => 'Price',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'Price' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'SubStatus' => 
            array (
                'alias' => 'SubStatus',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'SubStatus' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'ConditionID' => 
            array (
                'alias' => 'ConditionID',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'ConditionID' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'SurfaceTotal' => 
            array (
                'alias' => 'SurfaceTotal',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'SurfaceTotal' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'SurfaceLiving' => 
            array (
                'alias' => 'SurfaceLiving',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'SurfaceLiving' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'SurfaceTerrace' => 
            array (
                'alias' => 'SurfaceTerrace',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'SurfaceTerrace' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'SurfaceConstructed' => 
            array (
                'alias' => 'SurfaceConstructed',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'SurfaceConstructed' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'SurfaceOffice' => 
            array (
                'alias' => 'SurfaceOffice',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'SurfaceOffice' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'SurfaceGround' => 
            array (
                'alias' => 'SurfaceGround',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'SurfaceGround' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'SurfaceStore' => 
            array (
                'alias' => 'SurfaceStore',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'SurfaceStore' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'NumberOfBedRooms' => 
            array (
                'alias' => 'NumberOfBedRooms',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'NumberOfBedRooms' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'NumberOfBathRooms' => 
            array (
                'alias' => 'NumberOfBathRooms',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'NumberOfBathRooms' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'NumberOfShowerRooms' => 
            array (
                'alias' => 'NumberOfShowerRooms',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'NumberOfShowerRooms' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'NumberOfToilets' => 
            array (
                'alias' => 'NumberOfToilets',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'NumberOfToilets' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'NumberOfGarages' => 
            array (
                'alias' => 'NumberOfGarages',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'NumberOfGarages' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'NumberOfParkings' => 
            array (
                'alias' => 'NumberOfParkings',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'NumberOfParkings' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'HasGarden' => 
            array (
                'alias' => 'HasGarden',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'HasGarden' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'HasFurnished' => 
            array (
                'alias' => 'HasFurnished',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'HasFurnished' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'HasLift' => 
            array (
                'alias' => 'HasLift',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'HasLift' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'HasCellar' => 
            array (
                'alias' => 'HasCellar',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'HasCellar' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'HasAttic' => 
            array (
                'alias' => 'HasAttic',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'HasAttic' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'CreatedDate' => 
            array (
                'alias' => 'CreatedDate',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'CreatedDate' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'LastChangedDate' => 
            array (
                'alias' => 'LastChangedDate',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'LastChangedDate' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'SynchronisedDate' => 
            array (
                'alias' => 'SynchronisedDate',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'SynchronisedDate' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
        ),
    );

}
