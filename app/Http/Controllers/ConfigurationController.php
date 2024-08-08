<?php

namespace App\Http\Controllers;

use App\Models\Configuation;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index(){
        $allConfigurations = Configuation::latest()->paginate(10);
        return view('config/index', compact('allConfigurations'));
    }
    public function create(){
        return view('config.create');
    }
}
