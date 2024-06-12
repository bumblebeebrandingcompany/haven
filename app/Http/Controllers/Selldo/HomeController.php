<?php

namespace App\Http\Controllers\Selldo;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Utils\Util;
use Illuminate\Http\Request;

class HomeController
{
    /**
    * All Utils instance.
    *
    */
    protected $util;

    /**
    * Constructor
    *
    */
    public function __construct(Util $util)
    {
        $this->util = $util;
    }

    public function index()
    {
        return view('selldo.home');
    }
}
