<?php
/**
 * The Site Controller.
 *
 * A basic controller. Will deliver the basic html to our client browser
 *
 * @package app
 * @extends Controller
 */
class Controller_Site extends Controller_Common
{

    public function action_index()
    {
        $data = array();
        $this->template->title = 'Punjab Water';
        $this->template->content = View::forge('site/index', $data);
    }

}