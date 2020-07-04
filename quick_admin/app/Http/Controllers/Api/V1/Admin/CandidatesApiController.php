<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Candidate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCandidateRequest;
use App\Http\Requests\UpdateCandidateRequest;
use App\Http\Resources\Admin\CandidateResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CandidatesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('candidate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CandidateResource(Candidate::all());
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

        return (new CandidateResource($candidate))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Candidate $candidate)
    {
        abort_if(Gate::denies('candidate_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CandidateResource($candidate);
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

        return (new CandidateResource($candidate))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Candidate $candidate)
    {
        abort_if(Gate::denies('candidate_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $candidate->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
