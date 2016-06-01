<?php

class Model_CollectionCenter extends Orm\Model
{
    protected static $_properties = array('id', 'name', 'deleted');
    protected static $_table_name = 'collectioncenters';

    // in a Model_Panchayat which has many villages
    protected static $_has_many = array(
        'payments' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Payment',
            'key_to' => 'collectioncenter_id',
            'cascade_save' => true,
            'cascaded_delete' => false,
            'conditions' => array('where' => array(
                array('deleted', '!=', 1)
            ))
        )
    );

    protected static $_many_many = array(
        'users' => array(
            'key_from' => 'id',
            'key_through_from' => 'collectioncenter_id', // column 1 from the table in between, should match a posts.id
            'table_through' => 'users_collectioncenters', // both models plural without prefix in alphabetical order
            'key_through_to' => 'user_id', // column 2 from the table in between, should match a users.id
            'model_to' => 'Model_User',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'habitations' => array(
            'key_from' => 'id',
            'key_through_from' => 'collectioncenter_id', // column 1 from the table in between, should match a posts.id
            'table_through' => 'habitations_collectioncenters', // both models plural without prefix in alphabetical order
            'key_through_to' => 'habitation_id', // column 2 from the table in between, should match a users.id
            'model_to' => 'Model_Habitation',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'billgroups' => array(
            'key_from' => 'id',
            'key_through_from' => 'collectioncenter_id',
            'table_through' => 'collectioncenters_billgroups',
            'key_through_to' => 'billgroup_id',
            'model_to' => 'Model_Billgroup',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
//    protected static $_observers = array(
//        'Orm\\Observer_UpdatedAt' => array(
//            'events' => array('before_save'),
//            'mysql_timestamp' => true,
//            'property' => 'updated_at',
//        ),
//    );
}

/* End of file rule.php */