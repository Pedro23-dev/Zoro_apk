<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeRequest;
use App\Models\Departement;
use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    /**
     * Show the form for creating a new resource.
     */
    public function index()
    {
        $employers = Employer::with('deps')->paginate(10);
        return view ('employers.index', compact('employers'));
    }
    public function create()
    {
        $departements= Departement::all();
        return view('employers.create', compact('departements'));
    }
    public function edit(Employer $employer)
    {
        return view('employers.edit', compact('employer'));
    }
    public function store(StoreEmployeRequest $request)
    {
        $query = Employer::create($request->all());
        if($query){
            return redirect()->route('employer.index')->with('success_message', 'Employer enregistré');
        }
        
    }

}
