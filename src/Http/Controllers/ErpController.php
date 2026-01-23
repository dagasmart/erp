<?php

namespace DagaSmart\Erp\Http\Controllers;

class ErpController extends AdminController
{
    public function index()
    {
        $page = $this->basePage()->body('Erps Extension.');

        return $this->response()->success($page);
    }
}
