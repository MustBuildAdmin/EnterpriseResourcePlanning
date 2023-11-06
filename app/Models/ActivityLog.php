<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
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

    public function doneBy()
    {
        return $this->user ? $this->user->name : '';

    }
    public function getRemark()
    {
        $remark = json_decode($this->remark, true);

        if ($remark) {
            $user_name = $this->user ? $this->user->name : '';

            if ($this->log_type == 'Invite User') {
                return __('has invited').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'User Assigned to the Task') {
                return __('has assigned task ').' - <b>'.$remark['task_name'].'</b> '.__(' to').
                ' - <b>'.$remark['member_name'].'</b>';
            } elseif ($this->log_type == 'User Removed from the Task') {
                return __('has removed ').' - <b>'.$remark['member_name'].'</b>'.__(' from task').
                ' - <b>'.$remark['task_name'].'</b>';
            } elseif ($this->log_type == 'Upload File') {
                return __('Upload new file').' - <b>'.$remark['file_name'].'</b>';
            } elseif ($this->log_type == 'Create Bug') {
                return __('Created new bug').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Create Milestone') {
                return __('Create new milestone').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Create Task') {
                return __('Create new Task').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Move Task') {
                return __('Moved the Task').' - <b>'.$remark['title'].'</b> '.__('from').' '.
                __(ucwords($remark['old_stage'])).' '.__('to').' '.__(ucwords($remark['new_stage']));
            } elseif ($this->log_type == 'Create Expense') {
                return __('Create new Expense').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Add Product') {
                return __('Add new Products').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Update Sources') {
                return __('Update Sources');
            } elseif ($this->log_type == 'Create Deal Call') {
                return __('Create new Deal Call');
            } elseif ($this->log_type == 'Create Deal Email') {
                return __('Create new Deal Email');
            } elseif ($this->log_type == 'Move') {
                return __('Moved the deal').' - <b>'.$remark['title'].'</b> '.__('from').' '
                .__(ucwords($remark['old_status'])).' '.__('to').' '.__(ucwords($remark['new_status']));
            } elseif ($this->log_type == 'Added New Consultant') {
                return __('Added new Consultant').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Updated Consultant') {
                return __('Updated Consultant').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Deleted Consultant') {
                return __('Deleted Consultant').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Added New RFIStatus') {
                return __('Added New RFIStatus').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Updated RFIStatus') {
                return __('Updated RFIStatus').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Deleted RFIStatus') {
                return __('Deleted RFIStatus').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Added New ProjectSpecification') {
                return __('Added New ProjectSpecification').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Updated ProjectSpecification') {
                return __('Updated ProjectSpecification').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Added New Variation Scope') {
                return __('Added New Variation Scope').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Updated Variation Scope') {
                return __('Updated Variation Scope').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Deleted Variation Scope') {
                return __('Deleted Variation Scope').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Added New ProcurementMaterial') {
                return __('Added New ProcurementMaterial').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Updated ProcurementMaterial') {
                return __('Updated ProcurementMaterial').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Deleted ProcurementMaterial') {
                return __('Deleted ProcurementMaterial').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Added New SiteReport') {
                return __('Added New SiteReport').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Updated SiteReport') {
                return __('Updated SiteReport').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Deleted SiteReport') {
                return __('Deleted SiteReport').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Added New ConcretePouring') {
                return __('Added New ConcretePouring').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Updated ConcretePouring') {
                return __('Updated ConcretePouring').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Deleted ConcretePouring') {
                return __('Deleted ConcretePouring').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Added New Task') {
                return __('Added New Task').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Updated Task') {
                return __('Updated Task').' - <b>'.$remark['title'].'</b>';
            } elseif ($this->log_type == 'Deleted Task') {
                return __('Deleted Task').' - <b>'.$remark['title'].'</b>';
            }

        } else {
            return $this->remark;
        }
    }
    public function logType()
    {
        $log_type=$this->log_type;
        if ($this->log_type == 'Added New Task') {
            $log_type =  __('Create');
        } elseif ($this->log_type == 'Updated Task') {
            $log_type = __('Update');
        } elseif ($this->log_type == 'Deleted Task') {
            $log_type = __('Delete');
        }
        return $log_type;
        
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
