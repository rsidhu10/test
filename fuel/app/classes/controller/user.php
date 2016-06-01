<?php

class Controller_User extends Controller_Rest
{
    protected $format = 'json';

    public function get_index()
    {
        //////////////////////////////////////////////////////////////
        if (!\Auth::check()) {
            $this->response->status = 403;
            return;
        }

        $isAdmin = \Auth::member(100);
        $id = $this->param("id");
        Log::Debug("isAdmin:$isAdmin id:$id");
        if (($isAdmin == 1) and isset($id) and ($id == 'all')) {
            $users = \Model_User::find('all', array(
                'where' => array(
                    array('deleted', '!=', 1),
                )));
            $result = array();
            foreach ($users as $user) {
                $aResult['id'] = $user->id;
                $aResult['username'] = $user->username;
//                $aResult['password'] = $user->password;
                $aResult['fullname'] = $user->fullname;
                $aResult['email'] = $user->email;
                $aResult['group'] = $user->group;
                $aResult['last_login'] = $user->last_login;
//                $aResult['login_hash'] = $user->login_hash;
                $aResult['enabled'] = $user->enabled;
                $aResult['verified'] = $user->deleted;
                $aResult['deleted'] = $user->deleted;
                $aResult['profile_fields'] = $user->profile_fields;
                $aResult['updated_at'] = $user->updated_at;
                $collectioncenters = $user->collectioncenters;
                $cc_name_string = "";
                foreach ($collectioncenters as $collectioncenter) {
                    $cc_name_string .= $collectioncenter->name . ', ';
                }
                if (count($collectioncenters) > 0) {
                    $cc_name_string = substr($cc_name_string, 0, -2);
                }
                $aResult['collectioncenters'] = $cc_name_string;
                $result[] = $aResult;
            }

            if (isset($result)) {
                $this->response($result, 200);
                return;
            } else {
                $this->response(array('empty' => true, 'message' => 'No records found.'), 204);
                return;
            }
        } else {
            $userObject = Auth::instance()->get_user_id();
            $id = $userObject[1];

            Log::debug("Controller_User: Get_Index called with id: " . $id);

            if (isset($id) and $id !== false) {
                $result = array();
                $groups = Auth::instance()->get_groups();
                //$result['groups'] =
                $result['logged_in'] = true;

                //$this->response($result, 200);
                $this->response(array(
                    'groups' => $groups[0][1],
                    'authenticated' => true
                ));
                return;
            } else {
                Log::debug('Returning empty, not logged in');
                $this->response(array('empty' => true, 'logged_in' => false));
                return;
            }
        }
    }

    public function post_index()
    {
        Log::debug("Controller_User :: post_index: Creating new user!");

        if (\Auth::check() && \Auth::member(100)) {
            $model = html_entity_decode(Input::post('model'));
            Log::debug("Model: " . print_r($model, true));
            $model = json_decode($model, true);

            $username = $model['username'];
            $fullname = $model['fullname'];
            $email = $model['email'];
            $password = $model['password'];
            $permission_group = $model['permission_group'];
            $collection_centers = $model['collection_centers'];

            if ($username != "" && $fullname != "" && $email != "" && $password != "" && $permission_group != "") {
                $pass_hash = \Auth::instance()->hash_password($password);
                $new_user = \Model_User::query()->where('username', '=', $username)->get_one();
                if (!isset($new_user)) {
                    $new_user = \Model_User::forge(array(
                        'username' => $username,
                        'password' => $pass_hash,
                        'fullname' => $fullname,
                        'email' => $email,
                        'group' => $permission_group,
                        'last_login' => 0,
                        'login_hash' => '',
                        'enabled' => 1,
                        'verified' => 1,
                        'deleted' => 0,
                        'profile_fields' => ''
                    ));

                    foreach ($collection_centers as $collection_center) {
                        Log::debug("$collection_center");
                        $new_user->collectioncenters[] = \Model_CollectionCenter::find($collection_center);
                    }

                    if ($new_user and $new_user->save()) {
//                        foreach($collection_centers as $collection_center) {
//                            Log::debug("$collection_center");
//                            $new_user->collectioncenters[] = \Model_CollectionCenter::find($collection_center);
//                        }
//                        $new_user->save();
                        Log::debug("added  account: " . print_r($new_user, true));

                        $user_id = Auth::instance()->get_user_id();
                        Auditlog::Log($user_id[1], 1, "User Created, username=$username", "");

                        $user = array();
                        $user[] = array('id' => $new_user->id);
                        $user[] = array('username' => $new_user->username);
                        $user[] = array('fullname' => $new_user->fullname);
                        $user[] = array('email' => $new_user->email);
                        $user[] = array('group' => $new_user->group);
                        $user[] = array('profile_fields' => $new_user->profile_fields);
                        $this->response($user, 200);

                    } else {
                        Log::debug("failed to add account: " . print_r($new_user, true));
                        $this->response->status = 500;
                    }
                } else {
                    $this->response->status = 400;
                }
            } else {
                $this->response->status = 400;
            }

        } else {
            Log::debug("failed to crate model, user not logged in");
            $this->response(array('error' => true, 'message' => 'Not authenticated.'), 500);
        }
    }

    public function post_changepassword()
    {
        Log::debug("Controller_User :: post_changepassword: Change Password!!");


        if (!\Auth::check()) {
            $this->response->status = 403;
            return;
        }

        $model = Input::post('model');

        $model = json_decode($model, true);
        Log::debug("Model: " . print_r($model, true));
        $current_password = $model['input_current_password']; //d-m-yyyy
        $new_password_1 = $model['input_password_1']; //d-m-yyyy
        $new_password_2 = $model['input_password_2']; //d-m-yyyy
        Log::debug("$current_password, $new_password_1, $new_password_2");

        $current_password_hash = \Auth::instance()->hash_password($current_password);
        $new_password_hash = \Auth::instance()->hash_password($new_password_1);

        $user_id = \Auth::get_user_id();
        $this->user_id = $user_id[1];
        $user = \Model_User::find($user_id[1]);
        if(isset($user)) {
            Log::debug("User found, $user_id[1]");
        } else {
            Log::debug("User not found, $user_id[1]");
        }
        $current_hash = $user->password;

        if($new_password_1 == $new_password_2) {
            Log::debug("$new_password_1 == $new_password_2");
            if($current_password_hash == $current_hash) {
                $user->password = $new_password_hash;
                $user->save();
                Auditlog::Log($this->user_id, 1, "User ".$user->username." changed password.", "");
                Log::debug("Password changed, $user_id[1]");
                $result = array('result' => "ok");
                $this->response($result);
            } else {
                Log::debug("invalid password, $user_id[1]");
                $this->response(array('id' => $user_id[1], 'empty' => true, 'message' => 'Invalid Password.'), 204);
            }
        } else {
            Log::debug("passwords ddint match, $user_id[1]");
            $this->response(array('empty' => true, 'message' => 'Passwords did not match.'), 204);
        }
    }
}