<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsidhu
 * Date: 08/08/2012
 * Time: 18:34
 * To change this template use File | Settings | File Templates.
 */

class Model_User extends Orm\Model {
    protected static $_properties = array(
        'id',
        'fullname',
        'username',
        'password',
        'email',
        'profile_fields',
        'group',    # 100 = admin, 1=user, 10=reports
        'last_login',
        'login_hash',
        'enabled',
        'verified',
        'deleted',
        'updated_at'
    );

    protected static $_many_many = array(
        'collectioncenters' => array(
            'key_from' => 'id',
            'key_through_from' => 'user_id', // column 1 from the table in between, should match a posts.id
            'table_through' => 'users_collectioncenters', // both models plural without prefix in alphabetical order
            'key_through_to' => 'collectioncenter_id', // column 2 from the table in between, should match a users.id
            'model_to' => 'Model_CollectionCenter',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    //     // in a Model_Consumer which has many payments
    //     'payments' => array(
    //         'key_from' => 'id',
    //         'model_to' => 'Model_Payment',
    //         'key_to' => 'user_id',
    //         'cascade_save' => true,
    //         'cascade_delete' => false,
    //     )
    // );
    protected static $_observers = array(
        'Orm\\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => true,
            'property' => 'updated_at',
        ),
    );
}

/* End of file users.php */