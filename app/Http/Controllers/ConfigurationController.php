<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeConfigRequest;
use App\Models\Configuation;
use Exception;
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
    public function store(storeConfigRequest $request){
        try {
            Configuation::create($request->all());
            return redirect()->route('configurations')->with('success', 'Configuration enregistrée');
        } catch (Exception $e) {


            throw new Exception('Erreur lors de la configuration');
        }


    }
    public function delete(Configuation $configuration){
        try {
            $configuration->delete();
            return redirect()->route('configurations')->with('success', 'Configuration supprimée');
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la suppression de la configuration');
        }

    }
}
