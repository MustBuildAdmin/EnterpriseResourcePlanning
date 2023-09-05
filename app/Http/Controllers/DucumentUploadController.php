<?php

namespace App\Http\Controllers;

use App\Models\DucumentUpload;
use App\Models\Utility;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DucumentUploadController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('manage document')) {
            if (\Auth::user()->type == 'company') {
                $documents = DucumentUpload::where('created_by', \Auth::user()->creatorId())->get();
            } else {
                $userRole = \Auth::user()->roles->first();
                $documents = DucumentUpload::whereIn(
                    'role', [
                        $userRole->id,
                        0,
                    ]
                )->where('created_by', \Auth::user()->creatorId())->get();
            }

            return view('hrm.doc_setup.hrm_doc_setup', compact('documents'));

            // return view('documentUpload.index', compact('documents'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create document')) {
            $roles = Role::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $roles->prepend('All', '0');

            return view('hrm.doc_setup.hrm_doc_setup_create', compact('roles'));
            // return view('documentUpload.create', compact('roles'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {

        if (\Auth::user()->can('create document')) {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|unique:ducument_uploads',
                    'document' => 'mimes:jpeg,png,jpg,svg,pdf,doc|max:20480',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $document = new DucumentUpload();
            $document->name = $request->name;
            // $document->document    = !empty($request->document) ? $fileNameToStore : '';
            if (! empty($request->inputimage)) {

                $fileName = time().'_'.$request->inputimage->getClientOriginalName();
                $document->document = $fileName;
                $dir = '/app/public/uploads/documentUpload';
                $path = Utility::upload_file($request, 'inputimage', $fileName, $dir, []);
                if ($path['flag'] == 0) {
                    return redirect()->back()->with('error', __($path['msg']));
                }
                $request->document = $fileName;
                $document->save();
            }
            $document->role = $request->role;
            $document->description = $request->description;
            $document->created_by = \Auth::user()->creatorId();
            $document->save();

            return redirect()->route('hrm_doc_setup.index')->with('success', __('Document successfully uploaded.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function show(DucumentUpload $ducumentUpload)
    {
        //
    }

    public function edit($id)
    {

        if (\Auth::user()->can('edit document')) {
            $roles = Role::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $roles->prepend('All', '0');

            $ducumentUpload = DucumentUpload::find($id);

            return view('hrm.doc_setup.hrm_doc_setup_edit', compact('roles', 'ducumentUpload'));
            // return view('documentUpload.edit', compact('roles', 'ducumentUpload'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit document')) {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'document' => 'mimes:jpeg,png,jpg,svg,pdf,doc|max:20480',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $document = DucumentUpload::find($id);
            $document->name = $request->name;
            $document->role = $request->role;
            $document->description = $request->description;
            if (! empty($request->inputimage)) {

                $filenameWithExt = $request->inputimage->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->inputimage->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                $document->document = $fileNameToStore;
                $dir = '/app/public/uploads/documentUpload';
                $image_path = $dir.$fileNameToStore;
                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $url = '';
                $path = \Utility::upload_file($request, 'inputimage', $fileNameToStore, $dir, []);
                if ($path['flag'] == 1) {
                    $url = $path['url'];
                } else {
                    return redirect()->back()->with('error', __($path['msg']));
                }

            }
            $document->save();

            return redirect()->route('hrm_doc_setup.index')->with('success', __('Document successfully uploaded.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (\Auth::user()->can('delete document')) {
            $document = DucumentUpload::find($id);
            if ($document->created_by == \Auth::user()->creatorId()) {
                $document->delete();

                $dir = storage_path('uploads/documentUpload/');

                //                if(!empty($document->document))
                //                {
                //                    unlink($dir . $document->document);
                //                }

                return redirect()->route('hrm_doc_setup.index')->with('success', __('Document successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function hrm_download_file(Request $request)
    {
        $id = $request->id;
        $ducumentUpload = DucumentUpload::find($id);
        $documentPath = \App\Models\Utility::get_file('uploads/documentUpload');

        $ducumentUpload = DucumentUpload::find($id);
        if ($ducumentUpload != null) {
            $file_path = $documentPath.'/'.$ducumentUpload->document;
            $filename = $ducumentUpload->document;

            return \Response::download($file_path, $filename, ['Content-Length: '.$file_path]);
        } else {
            return redirect()->back()->with('error', __('File is not exist.'));
        }
    }
}
