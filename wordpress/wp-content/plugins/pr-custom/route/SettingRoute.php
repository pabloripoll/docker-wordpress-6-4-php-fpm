<?php

namespace Plugin\Route;

class SettingRoute
{
    public function setting()
    {
        return [
            'page' => __FUNCTION__,
            'menu' => ucfirst(__FUNCTION__),
            'title' => ucfirst(__FUNCTION__),
            'sections' => [
                $this->external(),
                $this->wordpress()
            ]
        ];
    }

    public function external()
    {
        return [
            'section' => __FUNCTION__
        ];
    }

    public function wordpress()
    {
        return [
            'section' => __FUNCTION__
        ];
    }

}
