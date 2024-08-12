<?php

namespace App\Http\Controllers;

use App\Models\Configuation;
use App\Models\Departement;
use App\Models\Employer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index(){
        $totalDepartements = Departement::all()->count();
        $totalEmployers = Employer::all()->count();
        $totalAdmin = User::all()->count();
        // $appName = Configuation::where('type', 'APP_NAME')->first();;
        // dd($appName->value);
        $defaultPaymentDate=null;
        $paymentNotification = "";

        $currentDate= Carbon::now()->day;

        // dd($currentDate);

        $defaultPaymentDateQuery= Configuation::where('type', 'PAYMENT_DATE')->first();
        if ($defaultPaymentDateQuery) {
            $defaultPaymentDate = $defaultPaymentDateQuery->value;
            $convertedPaymentDate = intval($defaultPaymentDate);
            if($currentDate < $convertedPaymentDate){
                $paymentNotification = "Le payement doit avoir lieu le" . $defaultPaymentDate . " de ce mois";
            }else{
                $nextMonth= Carbon::now()->addMonth();
                $nextMonthName = $nextMonth->format('F');

                $paymentNotification = "Le payement doit avoir lieu le" . $defaultPaymentDate . " du mois de" . $nextMonthName;
            }

        }

        return view('dashboard', compact('totalDepartements','totalEmployers', 'totalAdmin', 'paymentNotification'));
    }
}
