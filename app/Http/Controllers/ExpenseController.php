<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Con_task;
use App\Models\Expense;
use App\Models\Project;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public $var = 'Permission Denied.';

    public function index($project_id)
    {
        if (\Auth::user()->can('manage expense')) {
            $project = Project::find($project_id);
            if (isset($project->expense)) {
                $amount = $project->expense->sum('amount');
            } else {
                $amount = 0;
            }

            $expense_cnt = Utility::projectCurrencyFormat($project_id, $amount);
            $expense_cnt = $expense_cnt.'/'.Utility::projectCurrencyFormat($project_id, $project->budget);

            return view('expenses.index', compact('project', 'expense_cnt'));
        } else {
            return redirect()->back()->with('error', __($var));
        }
    }

    public function create($project_id)
    {
        if (\Auth::user()->can('create expense')) {
            $project = Project::find($project_id);
            if (Session::has('project_instance')) {
                $instanceId = Session::get('project_instance');
            } else {
                $instanceId = $project->instance_id;
            }
            $tasks = Con_task::select('main_id as id', 'text as name')
                ->where(['project_id' => $project_id, 'instance_id' => $instanceId])
                ->get();

            return view('expenses.create', compact('project', 'tasks'));
        } else {
            return redirect()->back()->with('error', __($var));
        }
    }

    public function store(Request $request, $project_id)
    {
        if (\Auth::user()->can('create expense')) {
            $usr = \Auth::user();
            $validator = Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'amount' => 'required|numeric|min:0',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }

            $post = $request->all();
            $post['project_id'] = $project_id;
            $post['date'] = (! empty($request->date)) ? date('Y-m-d H:i:s', strtotime($request->start_date)) : null;
            $post['created_by'] = $usr->id;

            if ($request->hasFile('attachment')) {
                $fileNameToStore = time().'.'.$request->attachment->getClientOriginalExtension();
                $path = $request->file('attachment')->storeAs('expense', $fileNameToStore);
                $post['attachment'] = $path;
            }

            $expense = Expense::create($post);

            // Make entry in activity log
            ActivityLog::create(
                [
                    'user_id' => $usr->id,
                    'project_id' => $project_id,
                    'log_type' => 'Create Expense',
                    'remark' => json_encode(['title' => $expense->name]),
                ]
            );

            return redirect()->back()->with('success', __('Expense added successfully.'));
        } else {
            return redirect()->back()->with('error', __($var));
        }
    }

    public function edit($project_id, $expense_id)
    {
        if (\Auth::user()->can('edit expense')) {
            $project = Project::find($project_id);
            $expense = Expense::find($expense_id);
            if (Session::has('project_instance')) {
                $instanceId = Session::get('project_instance');
            } else {
                $instanceId = $project->instance_id;
            }

            $tasks = Con_task::select('main_id as id', 'text as name')
                ->where(['project_id' => $project_id, 'instance_id' => $instanceId])
                ->get();

            return view('expenses.edit', compact('project', 'expense', 'tasks'));
        } else {
            return redirect()->back()->with('error', __($var));
        }
    }

    public function update(Request $request, $project_id, $expense_id)
    {
        if (\Auth::user()->can('edit expense')) {
            $validator = Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'amount' => 'required|numeric|min:0',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }

            $expense = Expense::find($expense_id);
            $expense->name = $request->name;
            $expense->date = date('Y-m-d H:i:s', strtotime($request->date));
            $expense->amount = $request->amount;
            $expense->task_id = $request->task_id;
            $expense->description = $request->description;

            if ($request->hasFile('attachment')) {
                Utility::checkFileExistsnDelete([$expense->attachment]);

                $fileNameToStore = time().'.'.$request->attachment->extension();
                $path = $request->file('attachment')->storeAs('expense', $fileNameToStore);
                $expense->attachment = $path;
            }

            $expense->save();

            return redirect()->back()->with('success', __('Expense Updated successfully.'));
        } else {
            return redirect()->back()->with('error', __($var));
        }
    }

    public function destroy($expense_id)
    {
        if (\Auth::user()->can('delete expense')) {
            $expense = Expense::find($expense_id);
            if (isset($expense->attachment)) {
                Utility::checkFileExistsnDelete([$expense->attachment]);
            }

            $expense->delete();

            return redirect()->back()->with('success', __('Expense Deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __($var));
        }
    }
}
