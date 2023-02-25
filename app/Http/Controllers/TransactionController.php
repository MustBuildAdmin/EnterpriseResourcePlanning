<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\ProductServiceCategory;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index(Request $request)
    {

        if(\Auth::user()->can('manage transaction'))
        {

            $filter['account']  = __('All');
            $filter['category'] = __('All');

            $account = BankAccount::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('holder_name', 'id');
            $account->prepend(__('Stripe / Paypal'), 'strip-paypal');
            $account->prepend('Select Account', '');

            $accounts = Transaction::select('bank_accounts.id', 'bank_accounts.holder_name', 'bank_accounts.bank_name')
                                   ->leftjoin('bank_accounts', 'transactions.account', '=', 'bank_accounts.id')
                                   ->groupBy('transactions.account')->selectRaw('sum(amount) as total');

            $category = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->whereIn(
                'type', [
                          1,
                          2,
                      ]
            )->get()->pluck('name', 'name');

            $category->prepend('Invoice', 'Invoice');
            $category->prepend('Bill', 'Bill');
            $category->prepend('Select Category', '');

            $transactions = Transaction::orderBy('id', 'desc');

            if(!empty($request->start_month) && !empty($request->end_month))
            {
                $start = strtotime($request->start_month);
                $end   = strtotime($request->end_month);
            }
            else
            {
                $start = strtotime(date('Y-m'));
                $end   = strtotime(date('Y-m', strtotime("-5 month")));
            }

            $currentdate = $start;

            while($currentdate <= $end)
            {
                $data['month'] = date('m', $currentdate);
                $data['year']  = date('Y', $currentdate);

                $transactions->Orwhere(
                    function ($query) use ($data){
                        $query->whereMonth('date', $data['month'])->whereYear('date', $data['year']);
                        $query->where('transactions.created_by', '=', \Auth::user()->creatorId());
                    }
                );

                $accounts->Orwhere(
                    function ($query) use ($data){
                        $query->whereMonth('date', $data['month'])->whereYear('date', $data['year']);
                        $query->where('transactions.created_by', '=', \Auth::user()->creatorId());

                    }
                );

                $currentdate = strtotime('+1 month', $currentdate);
            }

            $filter['startDateRange'] = date('M-Y', $start);
            $filter['endDateRange']   = date('M-Y', $end);


            if(!empty($request->account))
            {
                $transactions->where('account', $request->account);

                if($request->account == 'strip-paypal')
                {
                    $accounts->where('account', 0);
                    $filter['account'] = __('Stripe / Paypal');
                }
                else
                {
                    $accounts->where('account', $request->account);
                    $bankAccount       = BankAccount::find($request->account);
                    $filter['account'] = !empty($bankAccount) ? $bankAccount->holder_name . ' - ' . $bankAccount->bank_name : '';
                    if($bankAccount->holder_name == 'Cash')
                    {
                        $filter['account'] = 'Cash';
                    }
                }

            }
            if(!empty($request->category))
            {
                $transactions->where('category', $request->category);
                $accounts->where('category', $request->category);

                $filter['category'] = $request->category;
            }

            $transactions->where('created_by', '=', \Auth::user()->creatorId());
            $accounts->where('transactions.created_by', '=', \Auth::user()->creatorId());
            $transactions = $transactions->get();
            $accounts     = $accounts->get();

            return view('transaction.index', compact('transactions', 'account', 'category', 'filter', 'accounts'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


}
