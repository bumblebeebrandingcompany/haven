<?php

namespace App\Http\Requests;

use App\Models\Project;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyProjectRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->checkPermission('project_delete');
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:projects,id',
        ];
    }
}
