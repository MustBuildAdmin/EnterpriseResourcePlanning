

        @php
            $i = 0;
        @endphp
        @forelse ($trackers as $key =>$track)
            @php
                $tracker = $trackers->toArray();
                $first_acc = 0;
                $data = $track->toArray();
                if(isset($data['0'])){
                    $year=$data['0']['start_time'];
                    $year = Date('Y',strtotime($year));
                }else{
                    $year = \Carbon\Carbon::now()->year;
                }
                $time = collect($track);
                $total = $time->sum('total_time');
                $day_group = $time->groupBy(function($date,$k) {
                    return \Carbon\Carbon::parse($date->start_time)->format('d');
               });
              $time = Utility::second_to_time($total);
              $year=date("Y");

              $date = Utility::getStartAndEndDate($key-1,$year);

              $currentWeek = date( 'W' );
                $today = strtotime( date( 'Y-m-d' ) ) - 7*24*60*60; // last week this day
                $lastWeek = date( 'W', $today );
            @endphp
            <div class="card">
                <div class="card-body timetracker_options">
                    <div class="clearfix">
                        <div class="float-left">
                            <h5  class="week-date">
                                @if($currentWeek == $key)
                                    {{__('This week')}}
                                @elseif($lastWeek == $key)
                                    {{__('Last week')}}
                                @else
                                    {{date('M d',strtotime($date['start_date']. ' +1 day'))}} - {{date('M d',strtotime($date['end_date']. ' +1 day'))}}
                                @endif
                            </h5>
                        </div>
                        <div class="float-right">
                            <div> {{ __('Week total') }} : <b> {{$time}}</b> </div>
                        </div>
                        <span class="clearfix"></span>
                    </div>
                    <div class="time-schrdule bg-white p-2 small">
                        <div class="row">
                            <div class="col-3"> <b> {{ __('Title') }} </b> </div>
                            <div class="col-1"> <b> {{ __('Project Name') }} </b> </div>
                            <div class="col-1"> <b> {{ __('User') }} </b> </div>
                            <div class="col-2"> <b> {{ __('Tags') }} </b> </div>
                            <div class="col-1"> <b> {{ __('Date') }} </b> </div>
                            <div class="col-1"> <b> {{ __('Start') }} </b> </div>
                            <div class="col-1"> <b> {{ __('End') }} </b> </div>
                            <div class="col-1"> <b> {{ __('Time') }} </b> </div>
                            <div class="col-1"> <b> </b> </div>
                        </div>
                        <div class="bb1"></div>
                        <div class="project-acc">
                            @foreach ($day_group->reverse() as $key =>$day_tracks)
                                @php
                                    $time_day = collect($day_tracks);
                                    $total_day = $time_day->sum('total_time');
                                    $total_day = Utility::second_to_time($total_day);
                                    $name_group = $time_day->groupBy('name');
                                    $class = 'open-accordion';
                                @endphp
                                @foreach ($name_group->reverse() as $key =>$name)
                                    @php
                                        $name_array =$name->toArray();
                                        $total_name = collect($name_array)->sum('total_time');
                                        $total_name = Utility::second_to_time($total_name);
                                        $sdates = collect($name_array)->pluck('start_time')->toArray();
                                        $edates = collect($name_array)->pluck('end_time')->toArray();
                                        $ttag = collect($name_array)->pluck('tag_id')->toArray();
                                        $strat_time =  min($sdates);
                                        $end_time = max($edates);
                                      $date = '';
                                      if(!empty($name)){
                                        $date = date("M-d-Y",strtotime($name[0]->start_time));
                                        $user_name = $name[0]->user_name;
                                        $project_name = $name[0]->project_name;
                                      }
                                      if($first_acc == 0){
                                        $class = 'open-accordion';
                                        $first_acc = 1;
                                        $aicon = 'fa-chevron-up';
                                        $disply = '';
                                        $arrow = 'close-acc';
                                      }else{
                                        $arrow = 'open-acc';
                                        $disply = 'none';
                                        $class= '';
                                        $aicon = 'fa-chevron-down';
                                      }
                                    @endphp
                                    <div class="row acc-mainmenu">
                                        <div class="col-3"> <i class="ti ti-plus accodian-plus"></i> {{$key}}</div>
                                        <div class="col-1">{{$project_name}}</div>
                                        <div class="col-1">{{$user_name}}</div>
                                        <div class="col-2">#</div>
                                        <div class="col-1">{{$date}}</div>
                                        <div class="col-1">{{date("H:i:s",strtotime($strat_time))}}</div>
                                        <div class="col-1">{{date("H:i:s",strtotime($end_time))}}</div>
                                        <div class="col-1">{{$total_name}}</div>
                                        <div class="col-1"></div>
                                    </div>
                                    @if(!empty($name))
                                    <div class="acc-sub-menu" style="display: none;">
                                        @foreach ($name as $key =>$t)
                                        <div class="row acc-sub-menu-div">
                                            <div class="col-3"> {{$t->name}}</div>
                                            <div class="col-1">{{$t->project_name}}</div>
                                            <div class="col-1">{{$t->user_name}}</div>
                                            <div class="col-2">
                                                @if(empty($t->tags_name))
                                                    <p>#</p>
                                                @else
                                                    <p>
                                                        @foreach($t->tags_name as $tag)
                                                            #{{$tag}},
                                                        @endforeach
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="col-1">{{date("M-d-Y",strtotime($t->start_time))}}</div>
                                            <div class="col-1">{{date("H:i:s",strtotime($t->start_time))}}</div>
                                            <div class="col-1">{{date("H:i:s",strtotime($t->end_time))}}</div>
                                            <div class="col-1">{{$t->total}}</div>
                                            <div class="col-1">
                                                <img alt="Image placeholder" src="{{ asset('assets/images/gallery.png')}}" class="avatar view-images rounded-circle avatar-sm" data-toggle="tooltip" data-original-title="{{__('View Screenshot images')}}" style="height: 25px;width:24px;margin-right:10px;cursor: pointer;" data-id="{{$t['id']}}" id="track-images-{{$t['id']}}">
                                                <i data-id="{{$t['id']}}" data-is_billable="{{$t['is_billable']}}" data-toggle="tooltip" data-original-title="{{$t['is_billable'] ==1? __('Click to Mark Non-Billable'):__('Click to Mark Billable')}}" class="change_billable ti ti-dollar-sign {{$t['is_billable'] ==1?'doller-billable':'doller-non-billable'}}"></i>
                                                <i class="ti ti-times text-danger mx-2 pointer remove-track " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-id="{{$t['id']}}" data-url=""></i>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

@empty
    <div class="timetracker_options card p-5">
        <div class="selected_date week_total text-center mx-auto">
            <span class="week-date"> {{__('Records not found')}}</span>
        </div>
    </div>
@endforelse
<script type="text/javascript">
    $('[data-type="times"]').timeEntry({
        show24Hours: true,
    });
</script>
