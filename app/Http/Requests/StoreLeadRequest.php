<?php

namespace App\Http\Requests;

use App\Models\Lead;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class StoreLeadRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->checkPermission('lead_create');
    }

    public function rules()
    {
        $project_id = request()->input('project_id');
        return [
       
            'email' => [
                auth()->user()->is_superadmin ? '' : 'required',
                auth()->user()->is_superadmin ? '' : 'email',
                Rule::unique('leads')->where(function ($query) use ($project_id) {
                    return $query->whereNotNull('email')->where('project_id', $project_id);
                }),
            ],
            'phone' => [
                auth()->user()->is_superadmin ? '' : 'required',
                Rule::unique('leads')->where(function ($query) use ($project_id) {
                    return $query->whereNotNull('phone')->where('project_id', $project_id);
                }),
            ],
        ];
    }
}
