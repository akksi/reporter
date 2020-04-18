<?php

namespace App\Http\Controllers;

use App\Organization;
use App\UpworkTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use League\Csv\Reader;

class UpworkTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizations = Organization::all();

        return view('upload_upwork_statement', compact('organizations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //todo: add validation
        $organization = Organization::find($request->get('organization_id'));

        $upworkStatement = $request->file('upwork_statement');

        $csv = Reader::createFromPath($upworkStatement->getPathname(), 'r');
        $csv->setHeaderOffset(0);
        $transactions = $csv->getRecords();

        foreach ($transactions as $transaction) {
            $transaction = UpworkTransaction::firstOrNew(
                [
                    'reference_id' => $transaction['Ref ID'],
                ],
                [
                    'date' => Carbon::parse($transaction['Date']),
                    'type' => $transaction['Type'],
                    'description' => $transaction['Description'],
                    'agency' => $transaction['Agency'] ?: null,
                    'freelancer' => $transaction['Freelancer'] ?: null,
                    'team' => $transaction['Team'] ?: null,
                    'account_name' => $transaction['Account Name'],
                    'po' => $transaction['PO'] ?: null,
                    'amount' => $transaction['Amount'],
                    'amount_in_local_currency' => $transaction['Amount in local currency'] ?: null,
                    'currency' => $transaction['Currency'] ?: null,
                    'balance' => $transaction['Balance'] ?: null,
                ]
            );

            $organization->transactions()->save($transaction);
        }

        return back()->with('status', 'Statement is uploaded successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\UpworkTransaction $upworkTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(UpworkTransaction $upworkTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\UpworkTransaction $upworkTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(UpworkTransaction $upworkTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\UpworkTransaction $upworkTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UpworkTransaction $upworkTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\UpworkTransaction $upworkTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(UpworkTransaction $upworkTransaction)
    {
        //
    }
}
