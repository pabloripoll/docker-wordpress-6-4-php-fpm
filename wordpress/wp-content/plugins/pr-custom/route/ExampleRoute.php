<?php

namespace Plugin\Route;

class ExampleRoute
{
    public function example()
    {
        return [
            'page' => __FUNCTION__,
            'menu' => ucfirst(__FUNCTION__),
            'title' => ucfirst(__FUNCTION__),
            'sections' => [
                $this->dashboard(),
                $this->listing()
            ]
        ];
    }

    public function dashboard()
    {
        return [
            'section' => __FUNCTION__
        ];
    }

    public function listing()
    {
        return [
            'section' => __FUNCTION__
        ];
    }

}
