<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity_logs_con extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'task_id',
        'deal_id',
        'log_type',
        'remark',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function userdetail()
    {
        return $this->hasOne('App\Models\UserDetail', 'user_id', 'user_id');
    }

    public function getRemark()
    {
        $remark = json_decode($this->remark, true);

        if ($remark) {
            $user_name = $this->user ? $this->user->name : '';

            if ($this->log_type == 'Invite User') {
                return $user_name.' '.__('has invited').' <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'User Assigned to the Task') {
                return $user_name.' '.__('has assigned task ').' <b>'.$remark['task_name'].'</b> '.__(' to').' <b>'.$remark['member_name'].'</b>';
            } elseif ($this->log_type == 'User Removed from the Task') {
                return $user_name.' '.__('has removed ').' <b>'.$remark['member_name'].'</b>'.__(' from task').' <b>'.$remark['task_name'].'</b>';
            } elseif ($this->log_type == 'Upload File') {
                return $user_name.' '.__('Upload new file').' <b>'.$remark['file_name'].'</b>';
            } elseif ($this->log_type == 'Create Bug') {
                return $user_name.' '.__('Created new bug').' <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Create Milestone') {
                return $user_name.' '.__('Create new milestone').' <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Create Task') {
                return $user_name.' '.__('Create new Task').' <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Move Task') {
                return $user_name.' '.__('Moved the Task').' <b>'.$remark['title'].'</b> '.__('from').' '.__(ucwords($remark['old_stage'])).' '.__('to').' '.__(ucwords($remark['new_stage']));
            } elseif ($this->log_type == 'Create Expense') {
                return $user_name.' '.__('Create new Expense').' <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Create Task') {
                return $user_name.' '.__('Create new Task').' <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Add Product') {
                return $user_name.' '.__('Add new Products').' <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Update Sources') {
                return $user_name.' '.__('Update Sources');
            } elseif ($this->log_type == 'Create Deal Call') {
                return $user_name.' '.__('Create new Deal Call');
            } elseif ($this->log_type == 'Create Deal Email') {
                return $user_name.' '.__('Create new Deal Email');
            } elseif ($this->log_type == 'Move') {
                return $user_name.' '.__('Moved the deal').' <b>'.$remark['title'].'</b> '.__('from').' '.__(ucwords($remark['old_status'])).' '.__('to').' '.__(ucwords($remark['new_status']));
            } elseif ($this->log_type == 'Added Progress') {
                return $user_name.' '.__('Added a Progress for this Task').' <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Updated Progress') {
                return $user_name.' '.__('Updated a Progress for this Task').' <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Added New Task') {
                return $user_name.' '.__('Added New Task').' <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Deleted Task') {
                return $user_name.' '.__('Deleted Task').' <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Updated Task') {
                return $user_name.' '.__('Updated Task').' <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Store Predecessors') {
                return $user_name.' '.__('Store Predecessors').' <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Update Predecessors') {
                return $user_name.' '.__('Update Predecessors').' <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Deleted Predecessors') {
                return $user_name.' '.__('Deleted Predecessors').' <b>'.$remark['title'].'</b>';
            }
        } else {
            return $this->remark;
        }
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
            }
        }

        return $icon;
    }
}
