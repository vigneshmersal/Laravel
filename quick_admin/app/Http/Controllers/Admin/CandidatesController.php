<?php

namespace App\Http\Controllers\Admin;

use App\Candidate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCandidateRequest;
use App\Http\Requests\StoreCandidateRequest;
use App\Http\Requests\UpdateCandidateRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CandidatesController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('candidate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Candidate::query()->select(sprintf('%s.*', (new Candidate)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'candidate_show';
                $editGate      = 'candidate_edit';
                $deleteGate    = 'candidate_delete';
                $crudRoutePart = 'candidates';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('text', function ($row) {
                return $row->text ? $row->text : "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });
            $table->editColumn('radio', function ($row) {
                return $row->radio ? Candidate::RADIO_RADIO[$row->radio] : '';
            });
            $table->editColumn('select', function ($row) {
                return $row->select ? Candidate::SELECT_SELECT[$row->select] : '';
            });
            $table->editColumn('checkbox', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->checkbox ? 'checked' : null) . '>';
            });
            $table->editColumn('integer', function ($row) {
                return $row->integer ? $row->integer : "";
            });
            $table->editColumn('float', function ($row) {
                return $row->float ? $row->float : "";
            });
            $table->editColumn('money', function ($row) {
                return $row->money ? $row->money : "";
            });

            $table->editColumn('time', function ($row) {
                return $row->time ? $row->time : "";
            });
            $table->editColumn('file', function ($row) {
                return $row->file ? '<a href="' . $row->file->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('image', function ($row) {
                if ($photo = $row->image) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });

            $table->rawColumns(['actions', 'placeholder', 'checkbox', 'file', 'image']);

            return $table->make(true);
        }

        return view('admin.candidates.index');
    }

    public function create()
    {
        abort_if(Gate::denies('candidate_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.candidates.create');
    }

    public function store(StoreCandidateRequest $request)
    {
        $candidate = Candidate::create($request->all());

        if ($request->input('file', false)) {
            $candidate->addMedia(storage_path('tmp/uploads/' . $request->input('file')))->toMediaCollection('file');
        }

        if ($request->input('image', false)) {
            $candidate->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $candidate->id]);
        }

        return redirect()->route('admin.candidates.index');
    }

    public function edit(Candidate $candidate)
    {
        abort_if(Gate::denies('candidate_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.candidates.edit', compact('candidate'));
    }

    public function update(UpdateCandidateRequest $request, Candidate $candidate)
    {
        $candidate->update($request->all());

        if ($request->input('file', false)) {
            if (!$candidate->file || $request->input('file') !== $candidate->file->file_name) {
                $candidate->addMedia(storage_path('tmp/uploads/' . $request->input('file')))->toMediaCollection('file');
            }
        } elseif ($candidate->file) {
            $candidate->file->delete();
        }

        if ($request->input('image', false)) {
            if (!$candidate->image || $request->input('image') !== $candidate->image->file_name) {
                $candidate->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($candidate->image) {
            $candidate->image->delete();
        }

        return redirect()->route('admin.candidates.index');
    }

    public function show(Candidate $candidate)
    {
        abort_if(Gate::denies('candidate_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.candidates.show', compact('candidate'));
    }

    public function destroy(Candidate $candidate)
    {
        abort_if(Gate::denies('candidate_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidate->delete();

        return back();
    }

    public function massDestroy(MassDestroyCandidateRequest $request)
    {
        Candidate::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('candidate_create') && Gate::denies('candidate_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Candidate();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
