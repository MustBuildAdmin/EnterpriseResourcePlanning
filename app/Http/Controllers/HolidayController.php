<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Models\Utility;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function index(Request $request)
    {
        if (\Auth::user()->can('manage holiday')) {

            $holidays = Holiday::where('created_by', '=', \Auth::user()->creatorId());

            if (! empty($request->start_date)) {
                $holidays->where('date', '>=', $request->start_date);
            }
            if (! empty($request->end_date)) {
                $holidays->where('date', '<=', $request->end_date);
            }
            $holidays = $holidays->get();

            return view('hrm.admin_setup.holidays.holidays', compact('holidays'));
            // return view('holiday.index', compact('holidays'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function create()
    {
        if (\Auth::user()->can('create holiday')) {
            return view('hrm.admin_setup.holidays.holidays_create');
            // return view('holiday.create');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create holiday')) {
            $validator = \Validator::make(
                $request->all(), [
                    'date' => 'required',
                    'occasion' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $holiday = new Holiday();
            $holiday->date = $request->date;
            $holiday->end_date = $request->end_date;
            $holiday->occasion = $request->occasion;
            $holiday->created_by = \Auth::user()->creatorId();
            $holiday->save();

            //Slack Notification
            $setting = Utility::settings(\Auth::user()->creatorId());
            if (isset($setting['holiday_notification']) && $setting['holiday_notification'] == 1) {
                $msg = $request->occasion.' '.__('holiday on').' '.$request->date.'.';
                Utility::send_slack_msg($msg);
            }

            //Telegram Notification
            $setting = Utility::settings(\Auth::user()->creatorId());
            if (isset($setting['telegram_holiday_notification']) && $setting['telegram_holiday_notification'] == 1) {
                $msg = $request->occasion.' '.__('holiday on').' '.$request->date.'.';
                Utility::send_telegram_msg($msg);
            }

            return redirect()->route('holiday.index')->with(
                'success', 'Holiday successfully created.'
            );
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function show(Holiday $holiday)
    {
        //
    }

    public function edit(Holiday $holiday)
    {
        if (\Auth::user()->can('edit holiday')) {
            return view('hrm.admin_setup.holidays.holidays_edit', compact('holiday'));
            // return view('holiday.edit', compact('holiday'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function update(Request $request, Holiday $holiday)
    {
        if (\Auth::user()->can('edit holiday')) {
            $validator = \Validator::make(
                $request->all(), [
                    'date' => 'required',
                    'occasion' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $holiday->date = $request->date;
            $holiday->end_date = $request->end_date;
            $holiday->occasion = $request->occasion;
            $holiday->save();

            return redirect()->route('holiday.index')->with(
                'success', 'Holiday successfully updated.'
            );
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function destroy(Holiday $holiday)
    {
        if (\Auth::user()->can('delete holiday')) {
            $holiday->delete();

            return redirect()->route('holiday.index')->with(
                'success', 'Holiday successfully deleted.'
            );
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function calender(Request $request)
    {

        if (\Auth::user()->can('manage holiday')) {
            $transdate = date('Y-m-d', time());

            $holidays = Holiday::where('created_by', '=', \Auth::user()->creatorId());

            if (! empty($request->start_date)) {
                $holidays->where('date', '>=', $request->start_date);
            }
            if (! empty($request->end_date)) {
                $holidays->where('date', '<=', $request->end_date);
            }

            $holidays = $holidays->get();

            $arrHolidays = [];

            foreach ($holidays as $holiday) {
                $arr['id'] = $holiday['id'];
                $arr['title'] = $holiday['occasion'];
                $arr['start'] = $holiday['date'];
                $arr['end'] = $holiday['end_date'];
                $arr['className'] = 'event-primary';
                $arr['url'] = route('holiday.edit', $holiday['id']);
                $arrHolidays[] = $arr;
            }
            $arrHolidays = str_replace('"[', '[', str_replace(']"', ']', json_encode($arrHolidays)));

            return view('holiday.calender', compact('arrHolidays', 'transdate', 'holidays'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }
}
