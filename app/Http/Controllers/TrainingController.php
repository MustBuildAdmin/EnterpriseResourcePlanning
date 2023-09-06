<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Trainer;
use App\Models\Training;
use App\Models\TrainingType;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TrainingController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('manage training')) {
            $trainings = Training::where('created_by', '=', \Auth::user()->creatorId())->get();
            $status = Training::$Status;

            return view('training.index', compact('trainings', 'status'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create training')) {
            $setting = Utility::settings();
            $branches = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $trainingTypes = TrainingType::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $trainers = Trainer::where('created_by', \Auth::user()->creatorId())->get()->pluck('firstname', 'id');
            $employees = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $options = Training::$options;

            return view('training.create', compact('branches', 'trainingTypes', 'trainers', 'employees', 'options', 'setting'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create training')) {

            $validator = \Validator::make(
                $request->all(), [
                    'branch' => 'required',
                    'training_type' => 'required',
                    'training_cost' => 'required',
                    'employee' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $training = new Training();
            $training->branch = $request->branch;
            $training->trainer_option = $request->trainer_option;
            $training->training_type = $request->training_type;
            $training->trainer = $request->trainer;
            $training->training_cost = $request->training_cost;
            $training->employee = $request->employee;
            $training->start_date = $request->start_date;
            $training->end_date = $request->end_date;
            $training->description = $request->description;
            $training->created_by = \Auth::user()->creatorId();
            $training->save();

            return redirect()->route('training.index')->with('success', __('Training successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show($id)
    {
        $traId = Crypt::decrypt($id);
        $training = Training::find($traId);
        $performance = Training::$performance;
        $status = Training::$Status;

        return view('training.show', compact('training', 'performance', 'status'));
    }

    public function edit(Training $training)
    {
        if (\Auth::user()->can('create training')) {
            $branches = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $trainingTypes = TrainingType::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $trainers = Trainer::where('created_by', \Auth::user()->creatorId())->get()->pluck('firstname', 'id');
            $employees = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $options = Training::$options;

            return view('training.edit', compact('branches', 'trainingTypes', 'trainers', 'employees', 'options', 'training'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, Training $training)
    {
        if (\Auth::user()->can('edit training')) {

            $validator = \Validator::make(
                $request->all(), [
                    'branch' => 'required',
                    'training_type' => 'required',
                    'training_cost' => 'required',
                    'employee' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $training->branch = $request->branch;
            $training->trainer_option = $request->trainer_option;
            $training->training_type = $request->training_type;
            $training->trainer = $request->trainer;
            $training->training_cost = $request->training_cost;
            $training->employee = $request->employee;
            $training->start_date = $request->start_date;
            $training->end_date = $request->end_date;
            $training->description = $request->description;
            $training->save();

            return redirect()->route('training.index')->with('success', __('Training successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Training $training)
    {
        if (\Auth::user()->can('delete training')) {
            if ($training->created_by == \Auth::user()->creatorId()) {
                $training->delete();

                return redirect()->route('training.index')->with('success', __('Training successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function updateStatus(Request $request)
    {
        $training = Training::find($request->id);
        $training->performance = $request->performance;
        $training->status = $request->status;
        $training->remarks = $request->remarks;
        $training->save();

        return redirect()->route('training.index')->with('success', __('Training status successfully updated.'));
    }
}
