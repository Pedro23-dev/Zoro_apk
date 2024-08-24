<?php

namespace App\Http\Controllers;

use App\Models\Configuation;
use App\Models\Employer;
use App\Models\Payment;
// use Barryvdh\DomPDF\PDF;
// use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use PDF;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(){
        $defaultPaymentDateQuery = Configuation::where('type', 'PAYMENT_DATE')->first();
        $defaultPaymentDate = $defaultPaymentDateQuery->value;
        $convertedPaymentDate = intval($defaultPaymentDate);

        $today= date('d');

        $isPaymentDay = false;
        if($today==$convertedPaymentDate){
            $isPaymentDay = true;
        }
        // dd(date('d'));

        $payments = Payment::latest()
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('payments.index' , compact('payments', 'isPaymentDay'));
    }
    public function initPayment()
    {
        $monthMapping = [
            'JANUARY' => 'JANVIER',
            'FEBRUARY' => 'FEVRIER',
            'MARCH' => 'MARS',
            'APRIL' => 'AVRIL',
            'MAY' => 'MAI',
            'JUNE' => 'JUIN',
            'JULY' => 'JUILLET',
            'AUG' => 'AOUT',
            'SEPTEMBER' => 'SEPTEMBRE',
            'OCTOBER' => 'OCTOBRE',
            'NOVEMBER' => 'NOVEMBRE',
            'DECEMBER' => 'DECEMBRE'
        ];


        $currentMonth = strtoupper(Carbon::now()->locale('fr')->isoFormat('MMMM'));

        $currentYear = carbon::now()->format('Y');


        //Simuler des paiements
        // try {
        //     $employers = Employer::whereDoesntHave('payments', function ($query) use ($currentMonth, $currentYear) {
        //         $query->where('month', '=', $currentMonth)
        //             ->where('year', '=', $currentYear);
        //     })->get();
        // } catch (Exception $e) {
        //     dd($e);
        // }

        //recuperer la liste des employers qui n'ont pas été payer pour le mois en cours
        $employers = Employer::whereDoesntHave('payments', function ($query) use ($currentMonth, $currentYear) {
            $query->where('month', '=', $currentMonth)
                ->where('year', '=', $currentYear);
        })->get();

        if ($employers->count() === 0) {
            return redirect()->back()->with('error_message', 'Tous les employés ont été payés pour le mois de '. $currentMonth);
        }
        // dd($employers);

        //faire les paiements

        foreach ($employers as $employer) {
            $aEtePayer = $employer->payments()->where('month', '=', $currentMonth)
                ->where('year', '=', $currentYear)->exists();

            if (!$aEtePayer) {
                $salaire = $employer->montant_journalier * 31;
                $payement = new Payment([
                    //Str qui permet de générer les chaines de caractères aléatoires
                    'reference' => strtoupper(Str::random(10)),
                    'employer_id' => $employer->id,
                    'amount' => $salaire,
                    'launch_date' => now(),
                    'done_time' => now(),
                    'status' => 'SUCCESS',
                    'month' => $currentMonth,
                    'year' => $currentYear
                ]);
                $payement->save();
            }
        }

        //rediriger l'user
        return redirect()->back()->with('success', 'Paiement des employers effectuer pour le mois de' . $currentMonth);
    }
    public function effectuerPaid(Payment $payment){
        try {
            $fullPaymentInfo = Payment::with('employer')->find($payment->id);

            // return view('payments.facture', compact('fullPaymentInfo'));
            $pdf = PDF::loadView('payments/facture',compact('fullPaymentInfo'));
            return $pdf->download('facture_' . $fullPaymentInfo->employer->nom . '.pdf');
            // $pdf->setPaper('a4', 'landscape');
        } catch (Exception $e) {
            dd($e);
        }
    }
}
