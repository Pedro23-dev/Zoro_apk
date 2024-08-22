<?php

namespace App\Http\Controllers;

use App\Http\Requests\saveDepartementRequest;
use App\Models\Departement;
use Exception;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for creating a new resource.
     */
    public function index()
    {
        $departements = Departement::paginate(10);
        return view('departements.index', compact('departements'));
    }
    public function create()
    {
        return view('departements.create');
    }
    public function edit(Departement $departement)
    {
        return view('departements.edit', compact('departement'));
    }
    //interagir avec la bd
    public function store(Departement $departement, saveDepartementRequest $request){

      try {
            // il y a cette methode
            // $newDepartement = new Departement();
            $departement->name = $request->name;
            $departement->save();
            return redirect()->route('departement.index')->with('success', 'Departement enregistrer');
      } catch (Exception $e) {
            dd($e);
      }


    }
    public function update(Departement $departement, saveDepartementRequest $request){

      try {
            // il y a cette methode
            // $newDepartement = new Departement();
            $departement->name = $request->name;
            $departement->update();
            return redirect()->route('departement.index')->with('success', 'Departement mis a jour');
      } catch (Exception $e) {
            dd($e);
      }



    }
    public function delete(Departement $departement){

      try {
            // il y a cette methode
            // $newDepartement = new Departement();

            $departement->delete();
            return redirect()->route('departement.index')->with('success', 'Departement supprimé ');
      } catch (Exception $e) {
            throw new Exception("Une erreur est survenue lors de la suppression");

      }


    }
}
