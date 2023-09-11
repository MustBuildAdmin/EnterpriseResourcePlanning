<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Budget;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\ProductServiceCategory;
use App\Models\Revenue;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->can('manage budget plan')) {
            $budgets = Budget::where('created_by', '=', \Auth::user()->creatorId())->get();
            $periods = Budget::$period;

            return view('accounting.budget.index', compact('budgets', 'periods'));
            // return view('budget.index', compact('budgets', 'periods'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (\Auth::user()->can('create budget plan')) {
            $periods = Budget::$period;

            $data['monthList'] = $month = $this->yearMonth();          //Monthly

            $data['quarterly_monthlist'] = [                          //Quarterly
                'Jan-Mar',
                'Apr-Jun',
                'Jul-Sep',
                'Oct-Dec',
            ];

            $data['half_yearly_monthlist'] = [                     // Half - Yearly
                'Jan-Jun',
                'Jul-Dec',
            ];

            $data['yearly_monthlist'] = [                   // Yearly
                'Jan-Dec',
            ];

            $data['yearList'] = $this->yearList();

            $incomeproduct = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 1)->get();
            $expenseproduct = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 2)->get();

            return view('accounting.budget.create', compact('periods', 'incomeproduct', 'expenseproduct'), $data);
            // return view('budget.create', compact('periods', 'incomeproduct', 'expenseproduct'), $data);
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);

        }

    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (\Auth::user()->can('create budget plan')) {
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                //                'from' => 'required',
                //                'to' => 'required',
                'period' => 'required',

            ]);
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $budget = new Budget();
            $budget->name = $request->name;
            $budget->from = $request->year;
            $budget->period = $request->period;
            $budget->income_data = json_encode($request->income);
            $budget->expense_data = json_encode($request->expense);
            $budget->created_by = \Auth::user()->creatorId();
            $budget->save();

            //Slack Notification
            $setting = Utility::settings(\Auth::user()->creatorId());
            if (isset($setting['budget_notification']) && $setting['budget_notification'] == 1) {
                $msg = \App\Models\Budget::$period[$request->period].' '.__('budget of').' '.$request->year.' '.__('created for').' '.$request->name.'.';

                Utility::send_slack_msg($msg);
            }

            //Telegram Notification
            $setting = Utility::settings(\Auth::user()->creatorId());
            if (isset($setting['telegram_budget_notification']) && $setting['telegram_budget_notification'] == 1) {
                $msg = \App\Models\Budget::$period[$request->period].' '.__('budget of').' '.$request->year.' '.__('created for').' '.$request->name.'.';

                Utility::send_telegram_msg($msg);
            }

            return redirect()->route('budget.index')->with('success', __('Budget Plan successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function show($ids)
    {

        if (\Auth::user()->can('view budget plan')) {
            $id = Crypt::decrypt($ids);
            $budget = Budget::find($id);
            $budget['income_data'] = json_decode($budget->income_data, true);
            $budgetTotalArrs = ! empty($budget['income_data']) ? (array_values($budget['income_data'])) : [];

            $budgetTotal = [];
            foreach ($budgetTotalArrs as $budgetTotalArr) {
                foreach ($budgetTotalArr as $k => $value) {
                    $budgetTotal[$k] = (isset($budgetTotal[$k]) ? $budgetTotal[$k] + $value : $value);

                }
            }

            $budget['expense_data'] = json_decode($budget->expense_data, true);
            $budgetExpenseTotalArrs = ! empty($budget['expense_data']) ? (array_values($budget['expense_data'])) : [];

            $budgetExpenseTotal = [];
            foreach ($budgetExpenseTotalArrs as $budgetExpenseTotalArr) {

                foreach ($budgetExpenseTotalArr as $k => $value) {
                    $budgetExpenseTotal[$k] = (isset($budgetExpenseTotal[$k]) ? $budgetExpenseTotal[$k] + $value : $value);

                }

            }

            $data['monthList'] = $month = $this->yearMonth();          //Monthly

            $data['quarterly_monthlist'] = [                          //Quarterly
                '1-3' => 'Jan-Mar',
                '4-6' => 'Apr-Jun',
                '7-9' => 'Jul-Sep',
                '10-12' => 'Oct-Dec',
            ];

            $data['half_yearly_monthlist'] = [                     // Half - Yearly
                '1-6' => 'Jan-Jun',
                '7-12' => 'Jul-Dec',
            ];

            $data['yearly_monthlist'] = [                   // Yearly
                '1-12' => 'Jan-Dec',
            ];

            $data['yearList'] = $this->yearList();
            if (! empty($budget->from)) {
                $year = $budget->from;
            } else {
                $year = date('Y');
            }
            $data['currentYear'] = $year;

            $incomeproduct = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 1)->get();

            $incomeArr = [];
            $incomeTotalArr = [];

            foreach ($incomeproduct as $cat) {

                if ($budget->period == 'monthly') {
                    $monthIncomeArr = [];
                    $monthTotalIncomeArr = [];
                    for ($i = 1; $i <= 12; $i++) {
                        $revenuAmount = Revenue::where('created_by', '=', \Auth::user()->creatorId());
                        $revenuAmount->where('category_id', $cat->id);
                        $revenuAmount->whereRAW('YEAR(date) =?', [$year]);
                        $revenuAmount->whereRAW('MONTH(date) =?', [$i]);
                        $revenuAmount = $revenuAmount->sum('amount');

                        $revenuTotalAmount = Revenue::where('created_by', '=', \Auth::user()->creatorId());
                        $revenuTotalAmount->whereRAW('YEAR(date) =?', [$year]);
                        $revenuTotalAmount->whereRAW('MONTH(date) =?', [$i]);
                        $revenuTotalAmount = $revenuTotalAmount->sum('amount');

                        $invoices = Invoice::where('created_by', '=', \Auth::user()->creatorId());
                        $invoices->where('category_id', $cat->id);
                        $invoices->whereRAW('YEAR(send_date) =?', [$year]);
                        $invoices->whereRAW('MONTH(send_date) =?', [$i]);
                        $invoices = $invoices->get();
                        $invoiceAmount = 0;
                        foreach ($invoices as $invoice) {
                            $invoiceAmount += $invoice->getTotal();
                        }

                        $invoicesTotal = Invoice::where('created_by', '=', \Auth::user()->creatorId());
                        $invoicesTotal->whereRAW('YEAR(send_date) =?', [$year]);
                        $invoicesTotal->whereRAW('MONTH(send_date) =?', [$i]);
                        $invoicesTotal = $invoicesTotal->get();

                        $invoiceTotalAmount = 0;
                        foreach ($invoicesTotal as $invoiceTotal) {
                            $invoiceTotalAmount += $invoiceTotal->getTotal();
                        }

                        $month = date('F', strtotime(date('Y-'.$i)));

                        $monthIncomeArr[$month] = $invoiceAmount + $revenuAmount;
                        $incomeTotalArr[$month] = $invoiceTotalAmount + $revenuTotalAmount;
                    }
                    $incomeArr[$cat->id] = $monthIncomeArr;

                } elseif ($budget->period == 'quarterly' || $budget->period == 'half-yearly' || $budget->period == 'yearly') {

                    if ($budget->period == 'quarterly') {
                        $durations = $data['quarterly_monthlist'];
                    } elseif ($budget->period == 'yearly') {
                        $durations = $data['yearly_monthlist'];
                    } else {
                        $durations = $data['half_yearly_monthlist'];
                    }

                    $monthIncomeArr = [];
                    foreach ($durations as $monthnumber => $monthName) {
                        $month = explode('-', $monthnumber);
                        $revenuAmount = Revenue::where('created_by', '=', \Auth::user()->creatorId());
                        $revenuAmount->where('category_id', $cat->id);
                        $revenuAmount->whereRAW('YEAR(date) =?', [$year]);
                        $revenuAmount->whereRAW('MONTH(date) >=?', $month[0]);
                        $revenuAmount->whereRAW('MONTH(date) <=?', $month[1]);
                        $revenuAmount = $revenuAmount->sum('amount');

                        $month = explode('-', $monthnumber);
                        $revenuTotalAmount = Revenue::where('created_by', '=', \Auth::user()->creatorId());
                        $revenuTotalAmount->whereRAW('YEAR(date) =?', [$year]);
                        $revenuTotalAmount->whereRAW('MONTH(date) >=?', $month[0]);
                        $revenuTotalAmount->whereRAW('MONTH(date) <=?', $month[1]);
                        $revenuTotalAmount = $revenuTotalAmount->sum('amount');

                        $invoices = Invoice::where('created_by', '=', \Auth::user()->creatorId());
                        $invoices->where('category_id', $cat->id);
                        $invoices->whereRAW('YEAR(send_date) =?', [$year]);
                        $invoices->whereRAW('MONTH(send_date) >=?', $month[0]);
                        $invoices->whereRAW('MONTH(send_date) <=?', $month[1]);
                        $invoices = $invoices->get();

                        $invoiceAmount = 0;
                        foreach ($invoices as $invoice) {
                            $invoiceAmount += $invoice->getTotal();

                        }

                        $invoicesTotal = Invoice::where('created_by', '=', \Auth::user()->creatorId());
                        $invoicesTotal->whereRAW('YEAR(send_date) =?', [$year]);
                        $invoicesTotal->whereRAW('MONTH(send_date) >=?', $month[0]);
                        $invoicesTotal->whereRAW('MONTH(send_date) <=?', $month[1]);
                        $invoicesTotal = $invoicesTotal->get();

                        $invoiceTotalAmount = 0;
                        foreach ($invoicesTotal as $invoiceTotal) {
                            $invoiceTotalAmount += $invoiceTotal->getTotal();
                        }

                        $monthIncomeArr[$monthName] = $invoiceAmount + $revenuAmount;
                        $incomeTotalArr[$monthName] = $invoiceTotalAmount + $revenuTotalAmount;

                    }
                    $incomeArr[$cat->id] = $monthIncomeArr;

                }

            }

            $expenseproduct = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 2)->get();

            $expenseArr = [];
            $expenseTotalArr = [];

            foreach ($expenseproduct as $expense) {
                if ($budget->period == 'monthly') {
                    $monthExpenseArr = [];
                    $monthTotalExpenseArr = [];
                    for ($i = 1; $i <= 12; $i++) {

                        $paymentAmount = Payment::where('created_by', '=', \Auth::user()->creatorId());
                        $paymentAmount->where('category_id', $expense->id);
                        $paymentAmount->whereRAW('YEAR(date) =?', [$year]);
                        $paymentAmount->whereRAW('MONTH(date) =?', [$i]);
                        $paymentAmount = $paymentAmount->sum('amount');

                        $paymentTotalAmount = Payment::where('created_by', '=', \Auth::user()->creatorId());
                        $paymentTotalAmount->whereRAW('YEAR(date) =?', [$year]);
                        $paymentTotalAmount->whereRAW('MONTH(date) =?', [$i]);
                        $paymentTotalAmount = $paymentTotalAmount->sum('amount');

                        $bills = Bill::where('created_by', '=', \Auth::user()->creatorId());
                        $bills->where('category_id', $expense->id);
                        $bills->whereRAW('YEAR(send_date) =?', [$year]);
                        $bills->whereRAW('MONTH(send_date) =?', [$i]);
                        $bills = $bills->get();

                        $billAmount = 0;
                        foreach ($bills as $bill) {
                            $billAmount += $bill->getTotal();

                        }

                        $billsTotal = Bill::where('created_by', '=', \Auth::user()->creatorId());
                        $billsTotal->whereRAW('YEAR(send_date) =?', [$year]);
                        $billsTotal->whereRAW('MONTH(send_date) =?', [$i]);
                        $billsTotal = $billsTotal->get();

                        $billTotalAmount = 0;
                        foreach ($billsTotal as $billTotal) {
                            $billTotalAmount += $billTotal->getTotal();
                        }

                        $month = date('F', strtotime(date('Y-'.$i)));
                        $monthExpenseArr[$month] = $billAmount + $paymentAmount;
                        $expenseTotalArr[$month] = $billTotalAmount + $paymentTotalAmount;

                    }
                    $expenseArr[$expense->id] = $monthExpenseArr;
                } elseif ($budget->period == 'quarterly' || $budget->period == 'half-yearly' || $budget->period == 'yearly') {
                    if ($budget->period == 'quarterly') {
                        $durations = $data['quarterly_monthlist'];
                    } elseif ($budget->period == 'yearly') {
                        $durations = $data['yearly_monthlist'];
                    } else {
                        $durations = $data['half_yearly_monthlist'];
                    }

                    $monthExpenseArr = [];
                    foreach ($durations as $monthnumber => $monthName) {
                        $month = explode('-', $monthnumber);
                        $paymentAmount = Payment::where('created_by', '=', \Auth::user()->creatorId());
                        $paymentAmount->where('category_id', $cat->id);
                        $paymentAmount->whereRAW('YEAR(date) =?', [$year]);
                        $paymentAmount->whereRAW('MONTH(date) >=?', $month[0]);
                        $paymentAmount->whereRAW('MONTH(date) <=?', $month[1]);
                        $paymentAmount = $paymentAmount->sum('amount');

                        $month = explode('-', $monthnumber);
                        $paymentTotalAmount = Payment::where('created_by', '=', \Auth::user()->creatorId());
                        $paymentTotalAmount->whereRAW('YEAR(date) =?', [$year]);
                        $paymentTotalAmount->whereRAW('MONTH(date) >=?', $month[0]);
                        $paymentTotalAmount->whereRAW('MONTH(date) <=?', $month[1]);
                        $paymentTotalAmount = $paymentTotalAmount->sum('amount');

                        $bills = Bill::where('created_by', '=', \Auth::user()->creatorId());
                        $bills->where('category_id', $cat->id);
                        $bills->whereRAW('YEAR(send_date) =?', [$year]);
                        $bills->whereRAW('MONTH(send_date) >=?', $month[0]);
                        $bills->whereRAW('MONTH(send_date) <=?', $month[1]);
                        $bills = $bills->get();

                        $billAmount = 0;
                        foreach ($bills as $bill) {
                            $billAmount += $bill->getTotal();
                        }

                        $billsTotal = Bill::where('created_by', '=', \Auth::user()->creatorId());
                        $billsTotal->whereRAW('YEAR(send_date) =?', [$year]);
                        $billsTotal->whereRAW('MONTH(send_date) >=?', $month[0]);
                        $billsTotal->whereRAW('MONTH(send_date) <=?', $month[1]);
                        $billsTotal = $billsTotal->get();

                        $BillTotalAmount = 0;
                        foreach ($billsTotal as $billTotal) {
                            $BillTotalAmount += $billTotal->getTotal();
                        }

                        $monthExpenseArr[$monthName] = $billAmount + $paymentAmount;
                        $expenseTotalArr[$monthName] = $BillTotalAmount + $paymentTotalAmount;

                    }
                    $expenseArr[$expense->id] = $monthExpenseArr;

                }
                // NET PROFIT OF BUDGET
                $budgetprofit = [];
                $keys = array_keys($budgetTotal + $budgetExpenseTotal);
                foreach ($keys as $v) {
                    $budgetprofit[$v] = (empty($budgetTotal[$v]) ? 0 : $budgetTotal[$v]) - (empty($budgetExpenseTotal[$v]) ? 0 : $budgetExpenseTotal[$v]);
                }
                $data['budgetprofit'] = $budgetprofit;

                // NET PROFIT OF ACTUAL
                $actualprofit = [];
                $keys = array_keys($incomeTotalArr + $expenseTotalArr);
                foreach ($keys as $v) {
                    $actualprofit[$v] = (empty($incomeTotalArr[$v]) ? 0 : $incomeTotalArr[$v]) - (empty($expenseTotalArr[$v]) ? 0 : $expenseTotalArr[$v]);
                }
                $data['actualprofit'] = $actualprofit;

            }

            return view('accounting.budget.show', compact('id', 'budget', 'incomeproduct', 'expenseproduct', 'incomeArr', 'expenseArr', 'incomeTotalArr', 'expenseTotalArr', 'budgetTotal', 'budgetExpenseTotal'
            ), $data);
            // return view('budget.show', compact('id', 'budget', 'incomeproduct', 'expenseproduct', 'incomeArr', 'expenseArr', 'incomeTotalArr','expenseTotalArr','budgetTotal','budgetExpenseTotal'
            // ), $data);

        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function edit($ids)
    {

        if (\Auth::user()->can('edit budget plan')) {
            $id = Crypt::decrypt($ids);
            $budget = Budget::find($id);

            $budget['income_data'] = json_decode($budget->income_data, true);
            $budget['expense_data'] = json_decode($budget->expense_data, true);

            $periods = Budget::$period;

            $data['monthList'] = $month = $this->yearMonth();        //Monthly

            $data['quarterly_monthlist'] = [                      //Quarterly
                'Jan-Mar',
                'Apr-Jun',
                'Jul-Sep',
                'Oct-Dec',
            ];

            $data['half_yearly_monthlist'] = [                      // Half - Yearly
                'Jan-Jun',
                'Jul-Dec',
            ];

            $data['yearly_monthlist'] = [                           // Yearly
                'Jan-Dec',
            ];

            $data['yearList'] = $this->yearList();

            $incomeproduct = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 1)->get();
            $expenseproduct = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 2)->get();

            return view('accounting.budget.edit', compact('periods', 'budget', 'incomeproduct', 'expenseproduct'), $data);
            // return view('budget.edit', compact('periods', 'budget', 'incomeproduct', 'expenseproduct'), $data);

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Budget $budget)
    {

        if (\Auth::user()->can('edit budget plan')) {
            if ($budget->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make($request->all(), [
                    'name' => 'required',
                    'period' => 'required',

                ]);
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $budget->name = $request->name;
                $budget->from = $request->year;
                $budget->period = $request->period;
                $budget->income_data = json_encode($request->income);
                $budget->expense_data = json_encode($request->expense);
                $budget->save();

                return redirect()->route('budget.index')->with('success', __('Budget Plan successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Budget $budget)
    {
        if (\Auth::user()->can('delete budget plan')) {
            if ($budget->created_by == \Auth::user()->creatorId()) {
                $budget->delete();

                return redirect()->route('budget.index')->with('success', __('Budget Plan successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function yearMonth()
    {

        $month[] = 'January';
        $month[] = 'February';
        $month[] = 'March';
        $month[] = 'April';
        $month[] = 'May';
        $month[] = 'June';
        $month[] = 'July';
        $month[] = 'August';
        $month[] = 'September';
        $month[] = 'October';
        $month[] = 'November';
        $month[] = 'December';

        return $month;
    }

    public function yearList()
    {
        $starting_year = date('Y', strtotime('-5 year'));
        $ending_year = date('Y');

        foreach (range($ending_year, $starting_year) as $year) {
            $years[$year] = $year;
        }

        return $years;
    }
}
