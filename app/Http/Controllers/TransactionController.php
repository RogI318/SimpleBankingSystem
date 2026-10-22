<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;


class TransactionController extends Controller
{
     public function index()
    {
        $transactions = Transaction::with('account')->latest()->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $accounts = Account::all();
        return view('transactions.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:deposit,withdrawal',
            'amount' => 'required|numeric|min:1',
        ]);

        // Validation: check funds BEFORE trying to save
        $validator->after(function ($validator) use ($request) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            if ($request->type === 'withdrawal') {
                $account = Account::find($request->account_id);

                if (($account->balance - $request->amount) < $account->minimum_balance) {
                    $validator->errors()->add('amount', 'Insufficient funds for this withdrawal.');
                }
            }
        });

        $validator->validate();

        try {
            DB::transaction(function () use ($request) {
                Transaction::create([
                    'account_id' => $request->account_id,
                    'type' => $request->type,
                    'amount' => $request->amount,
                ]);
            });

            return redirect()->route('transactions.index')
                ->with('success', 'Transaction completed successfully.');
        } catch (Exception $e) {
            return back()->withErrors(['amount' => $e->getMessage()])->withInput();
        }
    }

}
