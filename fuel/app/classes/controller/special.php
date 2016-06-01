<?php
/**
 * The Site Controller.
 *
 * A basic controller. Will deliver the basic html to our client browser
 *
 * @package app
 * @extends Controller
 */
class Controller_Special extends Controller_Hybrid
{
    public function action_login()
    {
        // Render the login page
        $this->template->title = 'Please Login';
        $this->template->content = View::forge('site/login', array());
    }

    public function action_logout()
    {
        // Logout user and redirect to front page
        Log::debug("Logout page");
        $result = Auth::instance()->logout();
        Log::debug("logged out, result:$result");
        //Log::debug("redirecting to /");
        Response::redirect('/login');
        Log::debug("redirected");
    }

    public function post_check()
    {
        // pull the username/password from the post data
        $username = html_entity_decode(Input::post('username'));
        $password = html_entity_decode(Input::post('password'));

        Log::debug("REST: post_check_login: $username / $password");

        // check if the login/password is valid
        $auth = Auth::instance();
        if($auth->login($username, $password))
        {

            $g = \Auth::instance()->get_groups();
            Log::debug("Groups : " . print_r($g,true));

            Log::debug("Admin : " . Auth::member(100));
            Log::debug("Mods  : " . Auth::member(50));
            Log::debug("Report: " . Auth::member(10));
            Log::debug("Users : " . Auth::member(1));
            Log::debug("Guest : " . Auth::member(0));
            Log::debug("Ban   : " . Auth::member(-1));
            if(Auth::member(-1)) {
                Log::debug("REST: login disabled for $username");
                $this->response->status = 401;
            }
            Log::debug("REST: User $username logged in");
            $user_id = $auth->get_user_id();
            
            if(Auth::member(100)) {
                $this->response(array('valid' => true, 'redirect' => '/#home'), 200);
            } else if(Auth::member(10)) {
                $this->response(array('valid' => true, 'redirect' => '/#reports/dashboard'));
            } else {
                $this->response(array('valid' => true, 'redirect' => '/survey/bbnew'), 200);
            }
        }
        else
        {
            Log::debug("REST: User $username failed to log in");
            // username/password is not valid, lets also add a little error message
            $this->response(array('valid' => false, 'error' => 'Invalid user name or password, please try again'), 200);
        }
        //sleep(1);
    }
}

