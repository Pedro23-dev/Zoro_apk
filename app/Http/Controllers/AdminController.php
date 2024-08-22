<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\submitDefineAccessRequest;
use App\Http\Requests\updateAdminRequest;
use App\Models\ResetCodePassword;
use App\Models\User;
use App\Notifications\SendEmail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::paginate(10);
        return view('admins.index', compact('admins'));
    }
    public function create()
    {
        return view('admins.create');
    }
    public function edit(User $user)
    {
        return view('admins.edit', compact('user'));
    }
    public function store(StoreAdminRequest $request)
    {
        // dd($request);
        try {
            //logique de creqtion de compte
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make('default'); //encodage du mot de passe
            $user->save();


            //envoie de mail pour confirmation de compte



            //envoyer de code par mail pour vérification
            if ($user) {
                try {
                    ResetCodePassword::where('email', $user->email)->delete();
                    //valeur minimale et maximale
                    $code = rand(1000, 4000);
                    $data = [
                        'code' => $code,
                        'email' => $user->email,
                    ];
                    ResetCodePassword::create($data);

                    Notification::route('mail', $user->email)->notify(new SendEmail($code, $user->email));
                    return redirect()->route('administrateurs')->with('success', 'L\'administrateur a été créé avec succès');

                } catch (Exception $e) {
                    dd($e);
                    // throw new Exception('une erreur est survenue lors de l\'envoie du mail');
                    //throw $th;
                }

            }



        } catch (Exception $e) {
            dd($e);
            throw new Exception('Une erreur est survenue lors de la création de cet admin');
        }
    }
    public function update(updateAdminRequest $request, User $user)
    {
        try {
            //logique de modification de compte
        } catch (Exception $e) {
            // dd($e);
            throw new Exception('Une erreur est survenue lors de la modification de cet admin');
        }

    }
    public function defineAccess($email)
    {

        $checkUserExist = User::where('email', $email)->first();
        if ($checkUserExist) {
            return view('auth/validate-acount', compact('email'));

        } else {

            return redirect()->route('login');
        }
    }
    public function delete(User $user) {

        try {
            //recuperer l'id de l'admin connecté
            $connectedAdminId = Auth::user()->id;
            // condition pour vérifier si l'id de l'admin connecté est différent de l'id d'un autre utilis
            // teur(admin)
            if ($connectedAdminId!=$user->id) {
                //supprimer l'administrateur
                $user->delete();
                return redirect()->back()->with('success_message', 'Admin supprimé');
            }else{
                return redirect()->back()->with('error_message', 'Vous ne pouvez pas supprimer votre propre compte');
            }
        } catch (Exception $e) {
            // dd($e);
            throw new Exception('Une erreur est survenue lors de la suppression de cet admin');
        }

    }
    public function submitDefineAccess(submitDefineAccessRequest $request)
    {
       try {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $user->password = Hash::make($request->password);
                $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
                $user->update();

                if ($user) {
                    $existing= ResetCodePassword::where('email', $user->email)->count();

                    if ($existing>=1) {

                        $existing = ResetCodePassword::where('email', $user->email)->delete();
                    }
                }

                return redirect()->route('login')->with('success', 'Vos accces ont été defini correctement');
            }else{
                //404
            }
       } catch (\Throwable $th) {
        //throw $th;
       }

    }
}
