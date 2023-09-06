<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public static function get_activity($module_type, $module_id)
    {
        $result = ['name' => '-'];
        if ($module_type == 'contact') {
            $contact = Contact::where('id', $module_id)->orderBy('id', 'desc')->first();
            if ($contact) {
                $result = ['name' => $contact->name];
            }
        } elseif ($module_type == 'company') {
            $company = Company::where('id', $module_id)->orderBy('id', 'desc')->first();
            if ($company) {
                $result = ['name' => $company->name];
            }
        } elseif ($module_type == 'employee') {
            $employee = HrmEmployee::where('id', $module_id)->orderBy('id', 'desc')->first();
            if ($employee) {
                $result = ['name' => $employee->first_name.' '.$employee->last_name];
            }
        }

        return $result;
    }

    public function logIcon($type = '')
    {
        $icon = '';

        if (! empty($type)) {
            if ($type == 'Invite User') {
                $icon = 'user';
            } elseif ($type == 'User Assigned to the Task') {
                $icon = 'user-check';
            } elseif ($type == 'User Removed from the Task') {
                $icon = 'user-x';
            } elseif ($type == 'Upload File') {
                $icon = 'upload-cloud';
            } elseif ($type == 'Create Milestone') {
                $icon = 'crop';
            } elseif ($type == 'Create Bug') {
                $icon = 'alert-triangle';
            } elseif ($type == 'Create Task') {
                $icon = 'list';
            } elseif ($type == 'Move Task') {
                $icon = 'command';
            } elseif ($type == 'Create Expense') {
                $icon = 'clipboard';
            } elseif ($type == 'Move') {
                $icon = 'move';
            } elseif ($type == 'Add Product') {
                $icon = 'shopping-cart';
            } elseif ($type == 'Upload File') {
                $icon = 'file';
            } elseif ($type == 'Update Sources') {
                $icon = 'airplay';
            } elseif ($type == 'Create Deal Call') {
                $icon = 'phone-call';
            } elseif ($type == 'Create Deal Email') {
                $icon = 'voicemail';
            } elseif ($type == 'Create Invoice') {
                $icon = 'file-plus';
            } elseif ($type == 'Add Contact') {
                $icon = 'book';
            } elseif ($type == 'Create Task') {
                $icon = 'list';
            } else {
                $icon = 'list';
            }
        }

        return $icon;
    }
}
