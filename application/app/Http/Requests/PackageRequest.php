<?php

namespace App\Http\Requests;

use App\Package;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

// php artisan make:request StoreBlogPost
class PackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        # get comment id from -> Route::post('comment/{comment}');
        $comment = Comment::find($this->route('comment'));
        return $comment && $this->user()->can('update', $comment);

        // or

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        if ($this->method() == "POST")
        {
            return [
                'package_name' => 'required|string|max:255|unique:packages',
            ];
        }
        else // PATCH
        {
            $rule = [
                'package_name' => 'required|string|max:255|unique:packages,package_name,'.$request->id,
            ];

            if ($request->filled('password')) {
                $rule['password'] = 'required|string|min:6|confirmed';
            }

            return $rule;
        }
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'body.required'  => 'A message is required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'phone' => 'mobile',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->slug),
        ]);
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->somethingElseIsInvalid()) {
                $validator->errors()->add('field', 'Something is wrong with this field!');
            }
        });
    }
}
