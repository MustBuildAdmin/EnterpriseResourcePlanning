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

    public function getRemark()
    {
        $remark = json_decode($this->remark, true);

        if($remark)
        {
            $user_name = $this->user ? $this->user->name : '';

            if($this->log_type == 'Invite User')
            {
                return $user_name . ' ' . __('has invited') . ' <b>' . $remark['title'] . '</b>';
            }
            elseif($this->log_type == 'User Assigned to the Task')
            {
                return $user_name . ' ' . __('has assigned task ') . ' <b>' . $remark['task_name'] . '</b> ' . __(' to') . ' <b>' . $remark['member_name'] . '</b>';
            }
            elseif($this->log_type == 'User Removed from the Task')
            {
                return $user_name . ' ' . __('has removed ') . ' <b>' . $remark['member_name'] . '</b>' . __(' from task') . ' <b>' . $remark['task_name'] . '</b>';
            }
            elseif($this->log_type == 'Upload File')
            {
                return $user_name . ' ' . __('Upload new file') . ' <b>' . $remark['file_name'] . '</b>';
            }
            elseif($this->log_type == 'Create Bug')
            {
                return $user_name . ' ' . __('Created new bug') . ' <b>' . $remark['title'] . '</b>';
            }
            elseif($this->log_type == 'Create Milestone')
            {
                return $user_name . ' ' . __('Create new milestone') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == 'Create Task')
            {
                return $user_name . ' ' . __('Create new Task') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == 'Move Task')
            {
                return $user_name . ' ' . __('Moved the Task') . " <b>" . $remark['title'] . "</b> " . __('from') . " " . __(ucwords($remark['old_stage'])) . " " . __('to') . " " . __(ucwords($remark['new_stage']));
            }
            elseif($this->log_type == 'Create Expense')
            {
                return $user_name . ' ' . __('Create new Expense') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == 'Create Task')
            {
                return $user_name . ' ' . __('Create new Task') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == 'Add Product')
            {
                return $user_name . ' ' . __('Add new Products') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == 'Update Sources')
            {
                return $user_name . ' ' . __('Update Sources');
            }
            elseif($this->log_type == 'Create Deal Call')
            {
                return $user_name . ' ' . __('Create new Deal Call');
            }
            elseif($this->log_type == 'Create Deal Email')
            {
                return $user_name . ' ' . __('Create new Deal Email');
            }
            elseif($this->log_type == 'Move')
            {
                return $user_name . " " . __('Moved the deal') . " <b>" . $remark['title'] . "</b> " . __('from') . " " . __(ucwords($remark['old_status'])) . " " . __('to') . " " . __(ucwords($remark['new_status']));
            }
            elseif($this->log_type == "Added New Consultant"){
                return $user_name . ' ' . __('Added new Consultant') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Updated Consultant"){
                return $user_name . ' ' . __('Updated Consultant') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Deleted Consultant"){
                return $user_name . ' ' . __('Deleted Consultant') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Added New RFIStatus"){
                return $user_name . ' ' . __('Added New RFIStatus') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Updated RFIStatus"){
                return $user_name . ' ' . __('Updated RFIStatus') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Deleted RFIStatus"){
                return $user_name . ' ' . __('Deleted RFIStatus') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Added New ProjectSpecification"){
                return $user_name . ' ' . __('Added New ProjectSpecification') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Updated ProjectSpecification"){
                return $user_name . ' ' . __('Updated ProjectSpecification') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Added New Variation Scope"){
                return $user_name . ' ' . __('Added New Variation Scope') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Updated Variation Scope"){
                return $user_name . ' ' . __('Updated Variation Scope') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Deleted Variation Scope"){
                return $user_name . ' ' . __('Deleted Variation Scope') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Added New ProcurementMaterial"){
                return $user_name . ' ' . __('Added New ProcurementMaterial') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Updated ProcurementMaterial"){
                return $user_name . ' ' . __('Updated ProcurementMaterial') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Deleted ProcurementMaterial"){
                return $user_name . ' ' . __('Deleted ProcurementMaterial') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Added New SiteReport"){
                return $user_name . ' ' . __('Added New SiteReport') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Updated SiteReport"){
                return $user_name . ' ' . __('Updated SiteReport') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Deleted SiteReport"){
                return $user_name . ' ' . __('Deleted SiteReport') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Added New ConcretePouring"){
                return $user_name . ' ' . __('Added New ConcretePouring') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Updated ConcretePouring"){
                return $user_name . ' ' . __('Updated ConcretePouring') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Deleted ConcretePouring"){
                return $user_name . ' ' . __('Deleted ConcretePouring') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Added New Task"){
                return $user_name . ' ' . __('Added New Task') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Updated Task"){
                return $user_name . ' ' . __('Updated Task') . " <b>" . $remark['title'] . "</b>";
            }
            elseif($this->log_type == "Deleted Task"){
                return $user_name . ' ' . __('Deleted Task') . " <b>" . $remark['title'] . "</b>";
            }
            
        }
        
        else
        {
            return $this->remark;
        }
    }

    public function logIcon($type = '')
    {
        $icon = '';

        if(!empty($type))
        {
            if($type == 'Invite User')
            {
                $icon = 'user';
            }
            else if($type == 'User Assigned to the Task')
            {
                $icon = 'user-check';
            }
            else if($type == 'User Removed from the Task')
            {
                $icon = 'user-x';
            }
            else if($type == 'Upload File')
            {
                $icon = 'upload-cloud';
            }
            else if($type == 'Create Milestone')
            {
                $icon = 'crop';
            }
            else if($type == 'Create Bug')
            {
                $icon = 'alert-triangle';
            }
            else if($type == 'Create Task')
            {
                $icon = 'list';
            }
            else if($type == 'Move Task')
            {
                $icon = 'command';
            }
            else if($type == 'Create Expense')
            {
                $icon = 'clipboard';
            }
            else if($type == 'Move')
            {
                $icon = 'move';
            }
            elseif($type == 'Add Product')
            {
                $icon = 'shopping-cart';
            }
            elseif($type == 'Upload File')
            {
                $icon = 'file';
            }
            elseif($type == 'Update Sources')
            {
                $icon = 'airplay';
            }
            elseif($type == 'Create Deal Call')
            {
                $icon = 'phone-call';
            }
            elseif($type == 'Create Deal Email')
            {
                $icon = 'voicemail';
            }
            elseif($type == 'Create Invoice')
            {
                $icon = 'file-plus';
            }
            elseif($type == 'Add Contact')
            {
                $icon = 'book';
            }
            elseif($type == 'Create Task')
            {
                $icon = 'list';
            }
        }

        return $icon;
    }
}
