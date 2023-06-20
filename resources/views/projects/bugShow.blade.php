
<div class="modal-body">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <b class="text-sm">{{ __('Title')}} :</b>
                <p class="m-0 p-0 text-sm">{{$bug->title}}</p>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <b class="text-sm">{{ __('Priority')}} :</b>
                <p class="m-0 p-0 text-sm">{{ucfirst($bug->priority)}}</p>
            </div>
        </div>

        <div class="col-6 ">
            <div class="form-group">
                <b class="text-sm">{{ __('Created Date')}} :</b>
                <p class="m-0 p-0 text-sm">{{$bug->created_at}}</p>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <b class="text-sm">{{ __('Assign to')}} :</b>
                <p class="m-0 p-0 text-sm">{{(!empty($bug->assignTo)?$bug->assignTo->name:'')}}</p>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <b class="text-sm">{{ __('Description')}} :</b>
                <p class="m-0 p-0 text-sm">{{$bug->description}}</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-primary btn-sm ml-1 active show" data-bs-toggle="tab"
                       href="#profile" role="tab" aria-selected="false">{{__('Comments')}}</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-primary btn-sm ml-1" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">{{__('Files')}}</a>
                </li>
            </ul>

            <div class="tab-content pt-4" id="myTabContent">
                <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="form-group m-0">
                        <form method="post" id="form-comment" data-action="{{route('bug.comment.store',[$bug->project_id,$bug->id])}}">
                            @csrf
                            <textarea class="form-control" name="comment" placeholder="{{ __('Write message')}}" id="example-textarea" rows="3" required></textarea>
                            <div class="text-end mt-1">
                                <div class="btn-group mb-2 ml-2 d-none d-sm-inline-block">
                                    <button type="button" class="btn btn-primary btn-sm ml-1 text-white">{{ __('Submit')}}</button>
                                </div>
                            </div>
                        </form>
                        <div class="comment-holder" id="comments">
                            @foreach($bug->comments as $comment)
                                <div class="media">
                                    <div class="media-body">
                                        <div class="d-flex justify-content-between align-items-end">
                                            <div>
                                                <h5 class="mt-0">{{(!empty($comment->user)?$comment->user->name:'')}}</h5>
                                                <p class="mb-0 text-xs">{{$comment->comment}}</p>
                                            </div>
                                            <a href="#" class="btn btn-sm red btn-danger delete-comment" data-url="{{route('bug.comment.destroy',$comment->id)}}">
                                                <i class="ti ti-trash"></i>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="form-group m-0">
                        <form method="post" id="form-file" enctype="multipart/form-data" data-url="{{ route('bug.comment.file.store',$bug->id) }}">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                <div class="choose-file form-group">
                                    <label for="file" class="form-label">
                                        <div>{{__('file here')}}</div>
                                        <input type="file" class="form-control" name="file" id="file" data-filename="file_update">
                                    </label>
                                    <p class="file_update"></p>
                                </div>
                                    <span class="invalid-feedback" id="file-error" role="alert"></span>
                                </div>
                                <div class="col-4">
                                    <div class="btn-group  ml-2 mt-4 d-none d-sm-inline-block">
                                        <button type="submit" class="btn btn-primary btn-sm ml-1 text-white">{{ __('Upload')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row mt-3" id="comments-file">
                            @foreach($bug->bugFiles as $file)
                                <div class="col-8 mb-2 file-{{$file->id}}">
                                    <h5 class="mt-0 mb-1 font-weight-bold text-sm"> {{$file->name}}</h5>
                                    <p class="m-0 text-xs">{{$file->file_size}}</p>
                                </div>
                                <div class="col-4 mb-2 file-{{$file->id}}">
                                    <div class="comment-trash" style="float: right">
                                        <a download href="{{asset(Storage::url('bugs/'.$file->file))}}" class="btn btn-sm btn-primary">
                                            <i class="ti ti-download"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm red btn-danger delete-comment-file m-0 px-2" data-id="{{$file->id}}" data-url="{{route('bug.comment.file.destroy',[$file->id])}}">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{--<div class="modal-footer">--}}
{{--    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">--}}
{{--</div>--}}




