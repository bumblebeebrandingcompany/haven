<?php

namespace App\Http\Requests;

use App\Models\Source;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySourceRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->checkPermission('source_delete');
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:sources,id',
        ];
    }
}
