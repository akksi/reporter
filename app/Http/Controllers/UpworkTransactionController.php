<?php

namespace App\Http\Controllers;

use App\Entry;
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
        $transactionRecords = $csv->getRecords();

        foreach ($transactionRecords as $transactionRecord) {
            $upworkTransaction = UpworkTransaction::firstOrNew(
                [
                    'reference_id' => $transactionRecord['Ref ID'],
                ],
                [
                    'date' => Carbon::parse($transactionRecord['Date']),
                    'type' => $transactionRecord['Type'],
                    'description' => $transactionRecord['Description'],
                    'agency' => $transactionRecord['Agency'] ?: null,
                    'freelancer' => $transactionRecord['Freelancer'] ?: null,
                    'team' => $transactionRecord['Team'] ?: null,
                    'account_name' => $transactionRecord['Account Name'],
                    'po' => $transactionRecord['PO'] ?: null,
                    'amount' => $transactionRecord['Amount'],
                    'amount_in_local_currency' => $transactionRecord['Amount in local currency'] ?: null,
                    'currency' => $transactionRecord['Currency'] ?: null,
                    'balance' => $transactionRecord['Balance'] ?: null,
                ]
            );

            if ($upworkTransaction->exists) {
                continue;
            }

            $upworkTransaction->organization()->associate($organization);

            $entry = new Entry([
                'value' => $transactionRecord['Amount'],
                'date' => Carbon::parse($transactionRecord['Date']),
                'type' => 0
            ]);
            $organization->entries()->save($entry);
            $entry->upworkTransactions()->save($upworkTransaction);
            $organization->upworkTransactions()->save($upworkTransaction);
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
