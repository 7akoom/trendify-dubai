<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(private HomeService $service) {}

    public function index()
    {
        $data = $this->service->index();

        return view('home', $data);
    }
}
