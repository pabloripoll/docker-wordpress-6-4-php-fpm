<?php

namespace Plugin\Controller\Admin\View;

use Plugin\Controller\Controller;

/**
 * Routes view requests
 */
class SectionViewController extends Controller
{
    public function example($request)
    {
        return $this->view('admin.example.dashboard');
    }

    public function setting($request)
    {
        return $this->view('admin.section.setting');
    }
}
