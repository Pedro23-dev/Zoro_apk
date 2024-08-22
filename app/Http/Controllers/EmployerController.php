<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeRequest;
use App\Http\Requests\updateEmployerRequest;
use App\Models\Departement;
use App\Models\Employer;
use Exception;

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
    // public function edit($id)
    // {
    //     // dd($id);
    //     $employer = Employer::find($id);
    //     dd($employer);
    //     return view('employers.edit', compact('employer'));
    // }
    public function edit(Employer $employer)
    {
        $departements = Departement::all();
        return view('employers.edit', compact('employer', 'departements'));
    }
    public function update(updateEmployerRequest $request, Employer $employer){
        try {
            $employer->nom = $request->nom;
            $employer->prenom = $request->prenom;
            $employer->email = $request->email;
            $employer->contact = $request->contact;
            $employer->deps_id = $request->deps_id;
            $employer->montant_journalier = $request->montant_journalier;
            $employer->update();

            return redirect()->route('employer.index')->with('success_message', 'Employer modifié');



        } catch (Exception $e) {
            dd($e);
        }

    }
    
    //Pour creer l'employer dans la base de données
    public function store(StoreEmployeRequest $request)
    {
        try {

            $query = Employer::create($request->all());
            if ($query) {
                return redirect()->route('employer.index')->with('success_message', 'Employer enregistré');
            }
        } catch (Exception $e) {
            dd($e);
        }
        }
        public function delete(Employer $employer){
            try {
                $employer->delete();
                return redirect()->route('employer.index')->with('success_message', 'Employer supprimé');
            } catch (Exception $e) {
                dd($e);
            }
        }

    }


