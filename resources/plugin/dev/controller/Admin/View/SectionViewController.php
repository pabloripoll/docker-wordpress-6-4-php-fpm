<?php

namespace Plugin\Controller\Admin\View;

use Plugin\Controller\Controller;

/**
 * Routes view requests
 */
class SectionViewController extends Controller
{
    public function index($request)
    {
        return $this->view('admin.section.index');
    }

    public function setting($request)
    {
        return $this->view('admin.section.setting');
    }
}
