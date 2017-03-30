<?php

namespace FSth\Picker;

class Picker
{
    protected $middleWare;

    public function __construct($middleWare = null)
    {
        $this->middleWare = $middleWare;
    }

    public function setMiddleWare($middleWare)
    {
        $this->middleWare = $middleWare;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        return call_user_func_array([$this->middleWare, $name], $arguments);
    }
}