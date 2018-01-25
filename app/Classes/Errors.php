<?php

namespace App\Classes;

trait Errors
{

    protected $_error = [];

    public function error($msg)
    {
        $arguments = array_slice(func_get_args(), 0);
        $msg = call_user_func_array('sprintf', $arguments);
        array_push($this->_error, $msg);
        return false;
    }

    public function message()
    {
        return $this->_error;
    }

    public function firstErrorMessage($custom_msg)
    {
        if ($this->_error && !empty($this->_error)) {
            return $this->_error[0];
        }
        return $custom_msg;
    }

}