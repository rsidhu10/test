<?php

class Controller_Common extends Controller_Hybrid
{
    protected $format = 'json';

    public function before()
    {
        parent::before();
        Log::debug('Controller: ' . $this->request->controller);
        Log::debug('    Action: ' . $this->request->action);

        Log::debug("Auth Check required");
        if (!\Auth::check()) {
            // user not logged in, send user to login page
            Log::debug("Not Authenticated, returning false!");
            $this->authenticated = false;
            Response::redirect('/login', 'refresh');
        } else {
            $this->authenticated = true;
            $user_id = \Auth::get_user_id();
            $this->user_id = $user_id[1];
            $group = -1;
            if (Auth::member(100)) {
                $group = 100;
            } else if (Auth::member(50)) {
                $group = 50;
            } else if (Auth::member(1)) {
                $group = 1;
            } else if (Auth::member(0)) {
                $group = 0;
            } else if (Auth::member(-1)) {
                $group = -1;
            }
            $this->group_id = $group;
        }

    }
}
