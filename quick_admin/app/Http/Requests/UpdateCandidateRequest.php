<?php

namespace App\Http\Requests;

use App\Candidate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateCandidateRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('candidate_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'text'      => [
                'min:2',
                'max:100',
                'required',
            ],
            'email'     => [
                'required',
                'unique:candidates,email,' . request()->route('candidate')->id,
            ],
            'integer'   => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'float'     => [
                'min:1',
                'max:100',
            ],
            'date'      => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'date_time' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'time'      => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
