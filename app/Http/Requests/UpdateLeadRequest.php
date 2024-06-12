<?php

namespace App\Http\Requests;

use App\Models\Lead;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
class UpdateLeadRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->checkPermission('lead_edit');
    }

    public function rules()
    {
        $lead_id = request()->input('lead_id');
        $project_id = request()->input('project_id');
        return [
            'name' => [
                'required'
            ],
            'email' => [
                auth()->user()->is_superadmin ? '' : 'required',
                auth()->user()->is_superadmin ? '' : 'email',
                Rule::unique('leads')->where(function ($query) use ($project_id) {
                    return $query->whereNotNull('email')->where('project_id', $project_id);
                })->ignore($lead_id),
            ],
            'phone' => [
                auth()->user()->is_superadmin ? '' : 'required',
                Rule::unique('leads')->where(function ($query) use ($project_id) {
                    return $query->whereNotNull('phone')->where('project_id', $project_id);
                })->ignore($lead_id),
            ],
            'project_id' => [
                'required',
                'integer',
            ]
        ];
    }
}
