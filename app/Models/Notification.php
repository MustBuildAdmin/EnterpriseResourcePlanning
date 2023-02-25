<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'data',
        'is_read',
    ];

    public function toHtml()
    {
        $data       = json_decode($this->data);
        $link       = '#';
        $icon       = 'fa fa-bell';
        $icon_color = 'bg-primary';
        $text       = '';

        if(isset($data->updated_by) && !empty($data->updated_by))
        {
            $usr = User::find($data->updated_by);
        }

        if(!empty($usr))
        {
            // For Deals Notification
            if($this->type == 'assign_deal')
            {
                $link       = route('deals.show', [$data->deal_id,]);
                $text       = $usr->name . " " . __('Added you') . " " . __('in deal') . " <b class='font-weight-bold'>" . $data->name . "</b> ";
                $icon       = "fa fa-plus";
                $icon_color = 'bg-primary';
            }

            if($this->type == 'create_deal_call')
            {
                $link       = route('deals.show', [$data->deal_id,]);
                $text       = $usr->name . " " . __('Create new Deal Call') . " " . __('in deal') . " <b class='font-weight-bold'>" . $data->name . "</b> ";
                $icon       = "fa fa-phone";
                $icon_color = 'bg-info';
            }

            if($this->type == 'update_deal_source')
            {
                $link       = route('deals.show', [$data->deal_id,]);
                $text       = $usr->name . " " . __('Update Sources') . " " . __('in deal') . " <b class='font-weight-bold'>" . $data->name . "</b> ";
                $icon       = "fa fa-file-alt";
                $icon_color = 'bg-warning';
            }

            if($this->type == 'create_task')
            {
                $link       = route('deals.show', [$data->deal_id,]);
                $text       = $usr->name . " " . __('Create new Task') . " " . __('in deal') . " <b class='font-weight-bold'>" . $data->name . "</b> ";
                $icon       = "fa fa-tasks";
                $icon_color = 'bg-primary';
            }

            if($this->type == 'add_product')
            {
                $link       = route('deals.show', [$data->deal_id,]);
                $text       = $usr->name . " " . __('Add new Products') . " " . __('in deal') . " <b class='font-weight-bold'>" . $data->name . "</b> ";
                $icon       = "fa fa-dolly";
                $icon_color = 'bg-danger';
            }

            if($this->type == 'add_discussion')
            {
                $link       = route('deals.show', [$data->deal_id,]);
                $text       = $usr->name . " " . __('Add new Discussion') . " " . __('in deal') . " <b class='font-weight-bold'>" . $data->name . "</b> ";
                $icon       = "fa fa-comments";
                $icon_color = 'bg-info';
            }

            if($this->type == 'move_deal')
            {
                $link       = route('deals.show', [$data->deal_id,]);
                $text       = $usr->name . " " . __('Moved the deal') . " <b class='font-weight-bold'>" . $data->name . "</b> " . __('from') . " " . __(ucwords($data->old_status)) . " " . __('to') . " " . __(ucwords($data->new_status));
                $icon       = "fa fa-arrows-alt";
                $icon_color = 'bg-success';
            }
            // end deals

            // for estimations
            if($this->type == 'assign_estimation')
            {
                $link       = route('estimations.show', [$data->estimation_id,]);
                $text       = $usr->name . " " . __('Added you') . " " . __('in estimation') . " <b class='font-weight-bold'>" . $data->estimation_name . "</b> ";
                $icon       = "fa fa-plus";
                $icon_color = 'bg-primary';
            }
            // end estimations

            // For Leads Notification
            if($this->type == 'assign_lead')
            {
                $link       = route('leads.show', [$data->lead_id,]);
                $text       = $usr->name . " " . __('Added you') . " " . __('in lead') . " <b class='font-weight-bold'>" . $data->name . "</b> ";
                $icon       = "fa fa-plus";
                $icon_color = 'bg-primary';
            }

            if($this->type == 'create_lead_call')
            {
                $link       = route('leads.show', [$data->lead_id,]);
                $text       = $usr->name . " " . __('Create new Lead Call') . " " . __('in lead') . " <b class='font-weight-bold'>" . $data->name . "</b> ";
                $icon       = "fa fa-phone";
                $icon_color = 'bg-info';
            }

            if($this->type == 'update_lead_source')
            {
                $link       = route('leads.show', [$data->lead_id,]);
                $text       = $usr->name . " " . __('Update Sources') . " " . __('in lead') . " <b class='font-weight-bold'>" . $data->name . "</b> ";
                $icon       = "fa fa-file-alt";
                $icon_color = 'bg-warning';
            }

            if($this->type == 'add_lead_product')
            {
                $link       = route('leads.show', [$data->lead_id,]);
                $text       = $usr->name . " " . __('Add new Products') . " " . __('in lead') . " <b class='font-weight-bold'>" . $data->name . "</b> ";
                $icon       = "fa fa-dolly";
                $icon_color = 'bg-danger';
            }

            if($this->type == 'add_lead_discussion')
            {
                $link       = route('leads.show', [$data->lead_id,]);
                $text       = $usr->name . " " . __('Add new Discussion') . " " . __('in lead') . " <b class='font-weight-bold'>" . $data->name . "</b> ";
                $icon       = "fa fa-comments";
                $icon_color = 'bg-info';
            }

            if($this->type == 'move_lead')
            {
                $link       = route('leads.show', [$data->lead_id,]);
                $text       = $usr->name . " " . __('Moved the lead') . " <b class='font-weight-bold'>" . $data->name . "</b> " . __('from') . " " . __(ucwords($data->old_status)) . " " . __('to') . " " . __(ucwords($data->new_status));
                $icon       = "fa fa-arrows-alt";
                $icon_color = 'bg-success';
            }
            // end Leads

            $date = $this->created_at->diffForHumans();
            $html = '<a href="' . $link . '" class="list-group-item list-group-item-action">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <span class="avatar ' . $icon_color . ' text-white rounded-circle"><i class="' . $icon . '"></i></span>
                                    </div>
                                    <div class="flex-fill ml-3">
                                        <div class="h6 text-sm mb-0">' . $text . '</div>
                                        <small class="text-muted text-xs">' . $date . '</small>
                                    </div>
                                </div>
                            </a>';
        }
        else
        {
            $html = '';
        }

        return $html;
    }
}
