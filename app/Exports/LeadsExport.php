<?php

namespace App\Exports;

use App\Models\Lead;
use App\Utils\Util;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LeadsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    protected $request;
    protected $util;
    protected $additional_columns;

    public function __construct($request)
    {
        $this->request = $request;
        $this->additional_columns = !empty($request->get('additional_columns')) ? explode(',', $request->get('additional_columns')) : [];
        $this->util = new Util();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->util->getFIlteredLeads($this->request)->get();
    }
    

    public function map($row): array
{
    // Decode JSON fields
    $essential_fields = json_decode($row->essential_fields, true);
    $system_fields = json_decode($row->system_fields, true);
    $sales_fields = json_decode($row->sales_fields, true);

    // Convert arrays to strings


    $row_values = [
        $row->ref_num,
        $row->name,
       
        $row->email,
        $row->additional_email,
        $row->phone,
        $row->secondary_phone,
        $row->sell_do_is_exist ? 'Duplicate' : 'New',
        !empty($row->sell_do_lead_created_at) ? Carbon::parse($row->sell_do_lead_created_at)->format('d/m/Y') : '',
        !empty($row->sell_do_lead_created_at) ? Carbon::parse($row->sell_do_lead_created_at)->format('h:i A') : '',
        $row->sell_do_status,
        $row->sell_do_stage,
        $row->sell_do_lead_id,
        $row->project ? $row->project->name : '',
        $row->campaign ? $row->campaign->campaign_name : '',
        $row->source ? $row->source->name : '',
        $row->comments,
        $row->cp_comments,
        $row->createdBy ? $row->createdBy->name : '',
        Carbon::parse($row->created_at)->toDayDateTimeString(),
    ];

    if (is_array($essential_fields)) {
        foreach ($essential_fields as $field) {
            $row_values[] = $field;
        }
    } else {
        $row_values[] = $essential_fields;
    }

    // Add system fields to row values
    if (is_array($system_fields)) {
        foreach ($system_fields as $field) {
            $row_values[] = $field;
        }
    } else {
        $row_values[] = $system_fields;
    }

    // Add sales fields to row values
    if (is_array($sales_fields)) {
        foreach ($sales_fields as $field) {
            $row_values[] = $field;
        }
    } else {
        $row_values[] = $sales_fields;
    }

    // Add additional columns if they exist
    if (!empty($this->additional_columns) && !empty($row->lead_info)) {
        foreach ($this->additional_columns as $column) {
            $row_values[] = $row->lead_info[$column] ?? '';
        }
    }

    return $row_values;
}


    
public function headings(): array
{
    // Base headings
    $headings_arr = [
        __('messages.ref_num'),
        __('messages.name'),
        __('messages.email'),
        __('messages.additional_email_key'),
        __('messages.phone'),
        __('messages.alternate_phone'),
        __('messages.status'),
        __('messages.sell_do_date'),
        __('messages.sell_do_time'),
        __('messages.sell_do_status'),
        __('messages.sell_do_stage'),
        __('messages.sell_do_lead_id'),
        __('cruds.lead.fields.project'),
        __('cruds.lead.fields.campaign'),
        __('messages.source'),
        __('messages.customer_comments'),
        __('messages.cp_comments'),
        __('messages.added_by'),
        __('messages.created_at')
    ];

    // Add keys from essential_fields, system_fields, and sales_fields
    $collection = $this->collection();
    if ($collection->isNotEmpty()) {
        $essentialFieldKeys = $this->getKeysFromFirstRow($collection, 'essential_fields');
        $systemFieldKeys = $this->getKeysFromFirstRow($collection, 'system_fields');
        $salesFieldKeys = $this->getKeysFromFirstRow($collection, 'sales_fields');

        foreach ($essentialFieldKeys as $key) {
            $headings_arr[] =  $key;
        }

        foreach ($systemFieldKeys as $key) {
            $headings_arr[] =  $key;
        }

        foreach ($salesFieldKeys as $key) {
            $headings_arr[] = $key;
        }
    }

    // Add additional columns if they exist
    if (!empty($this->additional_columns)) {
        $headings_arr = array_merge($headings_arr, array_values($this->additional_columns));
    }

    return $headings_arr;
}

private function getKeysFromFirstRow($collection, $field)
{
    $firstRow = $collection->first();
    $decodedField = json_decode($firstRow->$field, true);
    return is_array($decodedField) ? array_keys($decodedField) : [];
}

    
}
