<?php

namespace App\Utils;

use App\Models\Campaign;
use App\Models\Lead;
use App\Models\LeadEvents;
use App\Models\Project;
use App\Models\Source;
use App\Models\SubSource;
use App\Models\Srd;
use App\Models\Insta;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Str;
use Google\Client as googleClient;
use Google\Service\Sheets;

class Util
{
    public function getUserProjects($user)
    {
        $query = new Project();

        if (auth('web')->check() && ($user->is_channel_partner || $user->is_client || $user->is_agency)) {
            $cp_project_ids = $user->project_assigned ?? [];
            $query = $query->where(function ($q) use ($user, $cp_project_ids) {
                if ($user->is_channel_partner) {
                    $q->whereIn('id', $cp_project_ids);
                } else {
                    $q->where('created_by_id', $user->id)
                        ->orWhere('client_id', $user->client_id);
                }
            });
        }

        $project_ids = $query->pluck('id')->toArray();

        return $project_ids;
    }

    public function getCampaigns($user, $project_ids = [])
    {
        $query = new Campaign();
        if (auth('web')->check() ) {
            if ($user->is_agency) {
                $query = $query->where(function ($q) use ($user) {
                    $q->where('agency_id', $user->agency_id);
                });
            }

            if ($user->is_client) {
                $query = $query->where(function ($q) use ($project_ids) {
                    $q->whereIn('project_id', $project_ids);
                });
            }
        }

        $campaign_ids = $query->pluck('id')->toArray();

        return $campaign_ids;
    }

    public function getSource($user, $project_ids = [], $campaign_ids = [])
    {
        $query = new Source();

        if (count($campaign_ids) > 0) {
            $query = $query->where(function ($q) use ($campaign_ids) {
                $q->whereIn('campaign_id', $campaign_ids);
            });
        }

        if (count($project_ids) > 0) {
            $query = $query->where(function ($q) use ($project_ids) {
                $q->whereIn('project_id', $project_ids);
            });
        }

        $campaign_ids = $query->pluck('id')->toArray();

        return $campaign_ids;
    }

    public function generateWebhookSecret()
    {
        $webhookSecret = (string) Str::uuid();
        return $webhookSecret;
    }

    
    public function createLead($subsource, $payload)
    {
        // Fetch project, campaign, and source information using the subsource details
        $project = Project::where('id', $subsource->project_id)->first();
        $campaign = Campaign::where('id', $subsource->campaign_id)->first();
        $source = $subsource->source;
    
        // Extract system fields from payload
        $systemFields = [];
        if (is_array($subsource->system_fields)) {
            foreach ($subsource->system_fields as $field) {
                $nestedKeys = explode('[', str_replace(']', '', $field['name_key']));
                $value = $payload;
    
                foreach ($nestedKeys as $nestedKey) {
                    if (isset($value[$nestedKey])) {
                        $value = $value[$nestedKey];
                    } else {
                        $value = null;
                        break;
                    }
                }
    
                $systemFields[$field['name_data']] = $value;
            }
        }
    
        // Extract essential fields from payload
        $essentialFields = [];
        if (is_array($subsource->essential_fields)) {
            foreach ($subsource->essential_fields as $field) {
                $nestedKeys = explode('[', str_replace(']', '', $field['name_key']));
                $value = $payload;
    
                foreach ($nestedKeys as $nestedKey) {
                    if (isset($value[$nestedKey])) {
                        $value = $value[$nestedKey];
                    } else {
                        $value = null;
                        break;
                    }
                }
    
                $essentialFields[$field['name_data']] = $value;
            }
        }
    
        // Extract sales fields from payload
        $salesFields = [];
        if (is_array($subsource->sales_fields)) {
            foreach ($subsource->sales_fields as $field) {
                $nestedKeys = explode('[', str_replace(']', '', $field['name_key']));
                $value = $payload;
    
                foreach ($nestedKeys as $nestedKey) {
                    if (isset($value[$nestedKey])) {
                        $value = $value[$nestedKey];
                    } else {
                        $value = null;
                        break;
                    }
                }
    
                $salesFields[$field['name_data']] = $value;
            }
        }
    
        // Extract sell do fields from payload
        $sellDoFields = [];
        if (is_array($subsource->sell_do_fields)) {
            foreach ($subsource->sell_do_fields as $field) {
                $nestedKeys = explode('[', str_replace(']', '', $field['name_key']));
                $value = $payload;
    
                foreach ($nestedKeys as $nestedKey) {
                    if (isset($value[$nestedKey])) {
                        $value = $value[$nestedKey];
                    } else {
                        $value = null;
                        break;
                    }
                }
    
                $sellDoFields[$field['name_data']] = $value;
            }
        }
    
        // Set the 'Sell Do Stage' to 'incoming'
        $sellDoFields['Sell Do Stage'] = 'incoming';
    
        // Extract custom fields from payload
        $customFields = [];
        if (is_array($subsource->custom_fields)) {
            foreach ($subsource->custom_fields as $field) {
                $nestedKeys = explode('[', str_replace(']', '', $field['name_key']));
                $value = $payload;
    
                foreach ($nestedKeys as $nestedKey) {
                    if (isset($value[$nestedKey])) {
                        $value = $value[$nestedKey];
                    } else {
                        $value = null;
                        break;
                    }
                }
    
                $customFields[$field['name_data']] = $value;
            }
        }
    
        // Extract inbox fields from payload
        $inboxFields = [];
        if (is_array($subsource->inbox_fields)) {
            foreach ($subsource->inbox_fields as $field) {
                $nestedKeys = explode('[', str_replace(']', '', $field['name_key']));
                $value = $payload;
    
                foreach ($nestedKeys as $nestedKey) {
                    if (isset($value[$nestedKey])) {
                        $value = $value[$nestedKey];
                    } else {
                        $value = null;
                        break;
                    }
                }
    
                $inboxFields[$field['name_data']] = $value;
            }
        }
    
        // Define other lead attributes
        $name = !empty($subsource->name_key) ? ($payload[$subsource->name_key] ?? '') : ($payload['name'] ?? '');
        $email = !empty($subsource->email_key) ? ($payload[$subsource->email_key] ?? '') : ($payload['email'] ?? '');
        $additionalEmail = !empty($subsource->additional_email_key) ? ($payload[$subsource->additional_email_key] ?? '') : '';
        $phone = !empty($subsource->phone_key) ? ($payload[$subsource->phone_key] ?? '') : ($payload['phone'] ?? '');
        $secondaryPhone = !empty($subsource->secondary_phone_key) ? ($payload[$subsource->secondary_phone_key] ?? '') : '';
    
        // Convert arrays to JSON strings
        $systemFieldsString = json_encode($systemFields);
        $essentialFieldsString = json_encode($essentialFields);
        $salesFieldsString = json_encode($salesFields);
        $sellDoFieldsString = json_encode($sellDoFields);
        $customFieldsString = json_encode($customFields);
        $inboxFieldsString = json_encode($inboxFields);
    
        $project = $subsource->project;
        $campaign = $subsource->source->campaign;
        $source = $subsource->source;
    
        $systemFields = array_merge([
            'Project Id' => $project->id ?? null,
            'Project' => $project->name ?? null,
            'Campaign Name' => $campaign->campaign_name ?? null,
            'Source Name' => $source->name ?? null,
            'Sub Source' => $subsource->name ?? null,
            'Lead Date' => null,
            'Lead Time' => null,
            'Form id' => null,
            'Form Name' => null,
            'Form Url' => null,
            'Ip Address' => null,
            'Utm Term' => null,
            'Time Spent' => null,
            'Utm Source' => null,
            'Utm Medium' => null,
            'Utm Campaign' => null,
            'Browser' => null,
            'Traffic Source' => null,
        ], $systemFields);
    
        $essentialFields = array_merge([
            'Full Name' => null,
            'Phone Number' => null,
            'Email' => null,
            'Addl Email' => null,
            'Addl Number' => null,
            'Gender' => null,
            'City' => null,
            'Message' => null,
        ], $essentialFields);
    
        $sellDoFields = array_merge([
            'Sell Do Id' => null,
            'Sell Do Stage' => null,
            'Sell Do Status' => null,
            'Sell Do Date' => null,
            'Sell Do Time' => null,
            'Notes' => null,
            'Tags' => null,
            'Funding Source' => null,
            'Site Visit Status' => null,
            'Site Visit Scheduled On' => null,
            'Hotness' => null,
            'Min Budget' => null,
            'Max Budget' => null,
            'Medium Type' => null,
            'Medium Value' => null,
            'Medium Id' => null,
        ], $sellDoFields);
    
        $salesFields = array_merge([
            'Sales Id' => null,
            'Team Id' => null,
            'Team Name' => null,
            'Lead Pickup date' => null,
            'Lead Pickup Time' => null,
            'Sales Name' => null,
        ], $salesFields);
    
        $inboxFields = array_merge([
            'Inbox User Id' => null,
            'Data Id' => null,
        ], $inboxFields);
    
        // Convert arrays to JSON strings
        $systemFieldsString = json_encode($systemFields);
        $essentialFieldsString = json_encode($essentialFields);
        $salesFieldsString = json_encode($salesFields);
        $sellDoFieldsString = json_encode($sellDoFields);
        $customFieldsString = json_encode($customFields);
        $inboxFieldsString = json_encode($inboxFields);
    
        // Define other lead attributes
        $name = !empty($subsource->name_key) ? ($payload[$subsource->name_key] ?? '') : ($payload['name'] ?? '');
        $email = !empty($subsource->email_key) ? ($payload[$subsource->email_key] ?? '') : ($payload['email'] ?? '');
        $additionalEmail = !empty($subsource->additional_email_key) ? ($payload[$subsource->additional_email_key] ?? '') : '';
        $phone = !empty($subsource->phone_key) ? ($payload[$subsource->phone_key] ?? '') : ($payload['phone'] ?? '');
        $secondaryPhone = !empty($subsource->secondary_phone_key) ? ($payload[$subsource->secondary_phone_key] ?? '') : '';
    
        // Create the lead with all the attributes
        $lead = Lead::create([
            'subsource_id' => $subsource->id,
            'name' => $name ?? '',
            'email' => $email ?? '',
            'additional_email' => $additionalEmail ?? '',
            'phone' => $phone ?? '',
            'secondary_phone' => $secondaryPhone ?? '',
            'project_id' => $subsource->project_id,
            'campaign_id' => $subsource->campaign_id,
            'lead_details' => $payload,
            'system_fields' => $systemFieldsString,
            'essential_fields' => $essentialFieldsString,
            'sales_fields' => $salesFieldsString,
            'sell_do_fields' => $sellDoFieldsString,
            'custom_fields' => $customFieldsString,
            'inbox_fields' => $inboxFieldsString,
            'otp_verified_or_not' => $subsource->otp_verified_or_not, // Assign otp_verified_or_not from SubSource
        ]);
    
        // Generate and save the lead reference number
        $lead->ref_num = $this->generateLeadRefNum($lead);
        $lead->save();
    
        // Store unique webhook fields
        $this->storeUniqueWebhookFields($lead);
    
        // Send API webhook and return the response
        $response = $this->sendApiWebhook($lead->id);
    
        return $response;
    }

    // public function sendWebhook($id)
    // {
    //     try {

    //         $lead = Lead::findOrFail($id);
    //         $source = Source::findOrFail($lead->source_id);

    //         if(
    //             !empty($source) &&
    //             !empty($source->outgoing_webhook) &&
    //             !empty($lead) &&
    //             !empty($lead->lead_details)
    //         ) {
    //             foreach ($source->outgoing_webhook as $webhook) {
    //                 if(!empty($webhook['url'])) {
    //                     if(!empty($webhook['secret_key'])) {
    //                         WebhookCall::create()
    //                             ->useSecret($webhook['secret_key'])
    //                             ->useHttpVerb($webhook['method'])
    //                             ->url($webhook['url'])
    //                             ->payload($lead->lead_details)
    //                             ->dispatch();
    //                     }

    //                     if(empty($webhook['secret_key'])) {
    //                         WebhookCall::create()
    //                             ->doNotSign()
    //                             ->useHttpVerb($webhook['method'])
    //                             ->url($webhook['url'])
    //                             ->payload($lead->lead_details)
    //                             ->dispatch();
    //                     }
    //                 }
    //             }
    //         }

    //         $output = ['success' => true, 'msg' => __('messages.success')];
    //     } catch (\Exception $e) {
    //         $output = ['success' => false, 'msg' => __('messages.something_went_wrong')];
    //     }
    //     return $output;
    // }
    public function sendGoogleSheet($lead) {
        $sell_do_response = json_decode($lead->sell_do_response, true);
        $lead_event_webhook_response = json_decode($lead->lead_event_webhook_response, true);
        $sales_fields = json_decode($lead->sales_fields, true);
        $insta = Insta::where('team_id', @$sales_fields['Team Id'])->first();

        $serviceAccountFilePath = 'json/service-account-file.json';
        $spreadsheetId = '18kKzlC9_zqz9pJIjuz8bPkEklpt4z2538TPa2vhC9S8';
        $range = 'Sheet1!A1:Z1';
        $date = date('d/m/Y', strtotime(@$sell_do_response['selldo_lead_details']['last_campaign_created_at']));
        $time = date('H:i', strtotime(@$sell_do_response['selldo_lead_details']['last_campaign_created_at']));
        $values = [
            [$date ?? '-', $time ?? '-', $lead->ref_num ?? '-', @$lead->sell_do_lead_id ?? '-', @$lead->campaign->campaign_name ?? '-', @$lead->source->name ?? '-', @$lead->subsources->name ?? '-', @$lead->project->name ?? '-', $lead->name, '-', '-', '-', '-', '-', @$insta->user_id ?? '-', '-', '-', '-', $sell_do_response['selldo_lead_details']['last_sv_conducted_on'] ?? '-', '-', '-', '-', '-', '-', '-', '-']
        ];
                
        $client = new googleClient();
        $client->setAuthConfig($serviceAccountFilePath);
        $client->addScope(Sheets::SPREADSHEETS);
        $service = new Sheets($client);
        $body = new Sheets\ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => 'RAW',
            'insertDataOption' => 'INSERT_ROWS'
        ];
        try {
            // Append the data to the spreadsheet
            $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function sendInstaMsg($lead) {
        $this->sendGroupMsg($lead);
        $body = [];
        $webhook_response = $lead->webhook_response;
        $sell_do_response = json_decode($lead->sell_do_response, true);
        $sales_fields = json_decode($lead->sales_fields, true);

        $insta = Insta::where('team_id', @$sales_fields['Team Id'])->first();
        if ($insta) {
            $bot = $insta->box_api;
            $chatId = $insta->chat_id;
            // $box = "7292482513:AAG8q_123MD4kOS66JPZWQZCfjI7hqkUgbw";
            // $chatId = "5592307888";
            $text = "<b>Name:</b>".$lead->name."\n";
            // $text .= "<b>Phone:</b>".$lead->phone."\n";
            // $text .= "<b>Email:</b>".$lead->email."\n";
            $text .= "<b>Project:</b>".@$lead->project->name."\n";
            $text .= "<b>Source:</b>".@$lead->source->name."\n";
            $text .= "<b>Campaign:</b>".@$lead->campaign->campaign_name."\n";
            $text .= "<b>Sub Source:</b>".@$lead->subsource->name."\n";
            $text .= "<b>Message:</b>".@$lead->comments."\n";
            $text .= "<b>Selldo ID:</b>".@$lead->sell_do_lead_id."\n";
            $text .= "<b>Sales Name:</b>".@$insta->user_id."\n";
            $text .= "<b>Date:</b>".date('d/m/Y H:i', strtotime(@$sell_do_response['selldo_lead_details']['last_campaign_created_at']))."\n";
            $headers = array(
                'Accept: application/json',
            );
            // $url = "https://api.telegram.org/bot".$bot."/sendMessage?chat_id=".$chatId."&text=".$text;
            $url = "https://api.telegram.org/bot".$bot."/sendMessage";
            $data = [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML'
            ];
            
            // Use cURL to send the HTTP POST request
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            
            // Execute the request and get the response
            $response = curl_exec($ch);
            
            // Check for errors
            if (curl_errno($ch)) {
                return false;
            } else {
                return true;
            }
        }
        return false;
    }


    public function sendGroupMsg($lead) {
        $body = [];
        $webhook_response = $lead->webhook_response;
        $sell_do_response = json_decode($lead->sell_do_response, true);
        $lead_event_webhook_response = json_decode($lead->lead_event_webhook_response, true);

        if ($insta) {
            $bot = "7116036373:AAEhOZSXaXgqfQseFGJ74mrGyobHHVic8e4";
            $chatId = "4242746499";
            // $box = "7292482513:AAG8q_123MD4kOS66JPZWQZCfjI7hqkUgbw";
            // $chatId = "5592307888";
            $text = "<b>Name:</b>".$lead->name."\n";
            $text .= "<b>Phone:</b>".$lead->phone."\n";
            $text .= "<b>Email:</b>".$lead->email."\n";
            $text .= "<b>Project:</b>".@$lead->project->name."\n";
            $text .= "<b>Source:</b>".@$lead->source->name."\n";
            $text .= "<b>Campaign:</b>".@$lead->campaign->campaign_name."\n";
            $text .= "<b>Sub Source:</b>".@$lead->subsource->name."\n";
            $text .= "<b>Message:</b>".@$lead->comments."\n";
            $text .= "<b>Selldo ID:</b>".@$lead->sell_do_lead_id."\n";
            $text .= "<b>Date:</b>".date('d/m/Y H:i', strtotime(@$sell_do_response['selldo_lead_details']['last_campaign_created_at']))."\n";
            $headers = array(
                'Accept: application/json',
            );
            // $url = "https://api.telegram.org/bot".$bot."/sendMessage?chat_id=".$chatId."&text=".$text;
            $url = "https://api.telegram.org/bot".$bot."/sendMessage";
            $data = [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML'
            ];
            
            // Use cURL to send the HTTP POST request
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            
            // Execute the request and get the response
            $response = curl_exec($ch);
            
            // Check for errors
            if (curl_errno($ch)) {
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

    public function createautomation($lead)
    {
        $inbox_fields = json_decode($lead->inbox_fields, true);
        if (@$inbox_fields["Inbox User Id"]) {
            return false;
        }
        $essential_fields = json_decode($lead->essential_fields, true);
        $system_fields = json_decode($lead->system_fields, true);
        // $webhook_response = $lead->webhook_response;
        $webhook_response = json_decode($lead->lead_event_webhook_response, true);

        $sell_do_response = json_decode($lead->sell_do_response, true);
        $sellDoFields = json_decode($lead->sell_do_fields, true);
        $srd = Srd::where('sell_do_project_id', @$webhook_response['payload']['campaign_responses'][0]['project_id'])
        ->where('campaign_name', @$system_fields[0]['Campaign Name'])
        ->where('source', @$system_fields[0]['Source Name'])
        ->where('sub_source', @$system_fields[0]['Sub Source'])
        ->first();
        // Check if decoding was successful and if "Phone Number" exists
        // if ($essential_fields && isset($essential_fields->{'Phone Number'})) {
        //     $phone_number = $essential_fields->{'Phone Number'};
        // } else {
            // Handle the case where "Phone Number" is not found or decoding fails
            // You may log an error, throw an exception, or handle it in another appropriate way
        //     return false;
        // }
        $postdata = [
            "phone" => $lead->phone,
            "first_name" => $lead->name,
            "last_name" => "",
            "gender" => "",
            "actions" => [
                [
                    "action" => "send_flow",
                    "flow_id" => 11111,
                ],
                [
                    "action" => "add_tag",
                    "tag_name" => "YOU_TAG_NAME",
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "Email",
                    "value"=> $lead->email
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "alter_email",
                    "value"=> $lead->additional_email
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "alter_phone",
                    "value"=> $lead->secondary_phone
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "campaign_name",
                    "value"=> @$system_fields[0]['Campaign Name']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "funding_source",
                    "value"=> ""
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "hotness",
                    "value"=> @$webhook_response['payload']['hotness']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "lms_cp_comments",
                    "value"=> $lead->cp_comments
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "lms_enquiry_browser",
                    "value"=> ""
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "lms_enquiry_city",
                    "value"=> "0"
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "lms_enquiry_comments",
                    "value"=> $lead->comments
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "lms_enquiry_os",
                    "value"=> "0"
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "lms_enquiry_remarks",
                    "value"=> "0"
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "lms_form_id",
                    "value"=> @$system_fields[0]['Form id']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "lms_form_name",
                    "value"=> @$system_fields[0]['Form Name']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "lms_form_url",
                    "value"=> @$system_fields[0]['Form Url']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "lms_ip_address",
                    "value"=> "0"
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "lms_lead_date",
                    "value"=> $lead->created_at
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "lms_lead_time",
                    "value"=> $lead->created_at
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "lms_notes",
                    "value"=> $lead->comments
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "lms_project_id",
                    "value"=> $lead->project_id
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "lms_ref_num",
                    "value"=> $lead->ref_num
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "max_budget",
                    "value"=> $sellDoFields['Max Budget']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "min_budget",
                    "value"=> $sellDoFields['Min Budget']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "notes",
                    "value"=> $lead->comments
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "presales_sales_agent",
                    "value"=> @$webhook_response['payload']['sales_name']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "presales_sales_agent_phone",
                    "value"=> ""
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "project_name",
                    "value"=> @$system_fields[0]['Project']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "selldo_lead_id",
                    "value"=> @$sell_do_response['sell_do_lead_id']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "selldo_lead_pickup_date",
                    "value"=> @$webhook_response['payload']['recieved_on']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "selldo_lead_pickup_time",
                    "value"=> @$webhook_response['payload']['recieved_on']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "selldo_medium",
                    "value"=> "weebhook"
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "selldo_medium_value",
                    "value"=> ""
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "selldo_project_id",
                    "value"=> @$webhook_response['payload']['campaign_responses'][0]['project_id']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "selldo_stage",
                    "value"=> @$webhook_response['payload']['stage']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "selldo_status",
                    "value"=> @$webhook_response['payload']['status']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "selldo_team_id",
                    "value"=> @$webhook_response['payload']['team_id']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "selldo_team_name",
                    "value"=> @$webhook_response['payload']['team_name']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "selldo_time",
                    "value"=> @$webhook_response['payload']['recieved_on']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "selldo_user_id",
                    "value"=> ""
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "site_visit_schedule_on",
                    "value"=> @$webhook_response['payload']['meta']['next_site_visit_scheduled_on']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "site_visit_status",
                    "value"=> ""
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "source_name",
                    "value"=> @$system_fields[0]['Source Name']
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "srd_id",
                    "value"=> @$srd->srd
                ],
                [
                    "action" => "set_field_value",
                    "field_name"=> "sub_source",
                    "value"=> @$system_fields[0]['Sub Source']
                ]
            ],
        ];
        $token = '1907249.XtqlzdA7ZDUu5Hr2SQnzO0lN8yuEhYiudCGELk8Dm';
        $headers = array(
            'X-ACCESS-TOKEN: ' . $token,
            'Accept: application/json',
        );
        $url = "https://inbox.thebumblebee.in/api/users";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            json_encode($postdata));

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        curl_close($ch);

        // $url = "https://inbox.thebumblebee.in/api/users";
        // $method = "post";
        // $server_output = $this->postWebhook($url, $method, $headers, $postdata);

        $server_output = json_decode($server_output, true);
        $id = $server_output['data']['id'];
        // dd($id);
        $inboxFields = [
            'Inbox User Id' => $id,
            'Data Id' => $server_output['data'],
        ];
        $lead = Lead::find($lead->id);
        $lead->inbox_fields = json_encode($inboxFields);
        $lead->save();
        return true;
    }
    public function updateCustomField($lead, $id, $value)
    {
        $inbox_fields = json_decode($lead->inbox_fields, true);
        if (@$inbox_fields["Inbox User Id"]) {
            return false;
        }
        $postdata = [
            "value" => $value
        ];
        $token = '1907249.XtqlzdA7ZDUu5Hr2SQnzO0lN8yuEhYiudCGELk8Dm';
        $headers = array(
            'X-ACCESS-TOKEN: ' . $token,
            'Accept: application/json',
        );
        $url = "https://inbox.thebumblebee.in/api/users/".$inbox_fields["Inbox User Id"]."/custom_fields/".$id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
        http_build_query($postdata));

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        curl_close($ch);

        // $url = "https://inbox.thebumblebee.in/api/users";
        // $method = "post";
        // $server_output = $this->postWebhook($url, $method, $headers, $postdata);

        $server_output = json_decode($server_output, true);
        $id = $server_output['data']['id'];
        return true;
    }
    public function sendApiWebhook($id)
    {
        $webhook_responses = [];
        $request_body = null;
        $lead = Lead::findOrFail($id);
        $project = Project::findOrFail($lead->project_id);

        $is_sell_do_executed = false;


        if ($lead->sell_do_lead_id) {
            $existing_system_fields = json_decode($lead->system_fields, true);

            $date = @$system_fields[0]['Lead Date'];
            $exist_an_hour = false;
            if ($date) {
                $hourdiff = (strtotime(date('Y-m-d H:i:s')) - strtotime($date))/3600;
                if ($hourdiff > 1) {
                    $exist_an_hour = true;
                }
            }
            
            if (!empty($lead) && $exist_an_hour) {
                $output = ['success' => false, 'msg' => "Sell Do already updated"];
                return $output;
            }

        }
        // if ($lead->sell_do_lead_id) {
        //     $output = ['success' => false, 'msg' => "Sell Do already updated"];
        //     return $output;
        // }
        try {
            if (
                !empty($project) &&
                !empty($project->outgoing_apis) &&
                !empty($lead)
            ) {
                $sell_do_response = !empty($lead->sell_do_response) ? json_decode($lead->sell_do_response, true) : [];
                foreach ($project->outgoing_apis as $api) {
                    $headers = !empty($api['headers']) ? json_decode($api['headers'], true) : [];
                    $request_body = $this->replaceTags($lead, $api);
                    if (!empty($api['url'])) {
                        $headers['secret-key'] = $api['secret_key'] ?? '';
                        $constants = $this->getApiConstants($api);
                        $request_body = array_merge($request_body, $constants);

                        //merge query parameter into request body
                        $queryString = parse_url($api['url'], PHP_URL_QUERY);
                        parse_str($queryString, $queryArray);
                        $request_body = array_merge($request_body, $queryArray);

                        $response = $this->postWebhook($api['url'], $api['method'], $headers, $request_body);
                        if (
                            (
                                !$is_sell_do_executed &&
                                empty($sell_do_response) &&
                                empty($lead->sell_do_lead_id)
                            ) ||
                            (
                                !$is_sell_do_executed &&
                                !empty($sell_do_response) &&
                                !empty($sell_do_response['error'])
                            )
                        ) {
                            if (strpos($api['url'], 'app.sell.do') !== false) {
                                if (!empty($response['sell_do_lead_id'])) {

                                    $lead->sell_do_is_exist = isset($response['selldo_lead_details']['lead_already_exists']) ? $response['selldo_lead_details']['lead_already_exists'] : false;

                                    $lead->sell_do_lead_created_at = isset($response['selldo_lead_details']['lead_created_at']) ? $response['selldo_lead_details']['lead_created_at'] : null;

                                    $lead->sell_do_lead_id = isset($response['sell_do_lead_id']) ? $response['sell_do_lead_id'] : null;

                                    $lead->sell_do_response = json_encode($response);

                                    $lead->sell_do_status = isset($response['selldo_lead_details']['status']) ? $response['selldo_lead_details']['status'] : null;

                                    $lead->sell_do_stage = isset($response['selldo_lead_details']['stage']) ? $response['selldo_lead_details']['stage'] : null;

                                    $lead->save();

                                }
                            }
                        }
                        $webhook_responses[] = [
                            'input' => $request_body,
                            'response' => $response,
                        ];
                    }
                }
            }
            $output = ['success' => true, 'msg' => __('messages.success')];
        } catch (RequestException $e) {
            $webhook_responses[] = [
                'input' => $request_body,
                'response' => $e->getMessage(),
            ];
            $output = ['success' => false, 'msg' => __('messages.something_went_wrong')];
        }

        /*
         * Save webhook responses
         */
        if (!empty($lead->webhook_response) && is_array($lead->webhook_response)) {
            $webhook_responses = array_merge($lead->webhook_response, $webhook_responses);
        }
        $lead->webhook_response = $webhook_responses;
        $lead->save();

        if ($lead->sell_do_lead_id) {
            $data = $this->createautomation($lead);
            // $data = $this->sendInstaMsg($lead);
            // $this->sendGoogleSheet($lead);
        }
        return $output;
    }

    public function replaceTags($lead, $api)
    {
        $request_body = $api['request_body'] ?? [];
        if (empty($request_body)) {
            return $lead->lead_details;
        }

        $tag_replaced_req_body = [];
        $source = $lead->source;
        foreach ($request_body as $value) {
            if (!empty($value['key']) && !empty($value['value'])) {
                if (count($value['value']) > 1) {
                    $arr_value = [];
                    foreach ($value['value'] as $field) {
                        if (isset($lead->lead_info[$field]) && !empty($lead->lead_info[$field])) {
                            $arr_value[] = $lead->lead_info[$field];
                        } else {
                            $arr_value[] = $this->getPredefinedValue($field, $lead, $source);
                        }
                    }
                    $empty_replaced_values = array_values(array_filter($arr_value));
                    $tag_replaced_req_body[$value['key']] = implode(' | ', $empty_replaced_values);
                } else {
                    $data_value = '';
                    if (
                        !empty($value['value']) &&
                        !empty($value['value'][0])
                    ) {
                        $data_value = $this->getPredefinedValue($value['value'][0], $lead, $source);
                    }
                    $tag_replaced_req_body[$value['key']] = $lead->lead_info[$value['value'][0]] ?? $data_value;
                }
            }
        }
        return $tag_replaced_req_body;
    }

    public function getPredefinedValue($field, $lead, $source = null)
    {
        if (
            (
                !empty($source->email_key) &&
                !empty($field) &&
                ($source->email_key == $field)
            ) ||
            (
                !empty($field) &&
                !empty($lead->email) &&
                in_array($field, ['email', 'Email', 'EMAIL'])
            )
        ) {
            return $lead->email ?? '';
        } else if (
            (
                !empty($source->phone_key) &&
                !empty($field) &&
                ($source->phone_key == $field)
            ) ||
            (
                !empty($field) &&
                !empty($lead->phone) &&
                in_array($field, ['phone', 'Phone', 'PHONE'])
            )
        ) {
            return $lead->phone ?? '';
        } else if (
            (
                !empty($source->name_key) &&
                !empty($field) &&
                ($source->name_key == $field)
            ) ||
            (
                !empty($field) &&
                !empty($lead->name) &&
                in_array($field, ['name', 'Name', 'NAME'])
            )
        ) {
            return $lead->name ?? '';
        } else if (
            !empty($field) &&
            in_array($field, ['predefined_comments'])
        ) {
            return $lead->comments ?? '';
        } else if (
            !empty($field) &&
            in_array($field, ['predefined_cp_comments'])
        ) {
            return $lead->cp_comments ?? '';
        } else if (
            !empty($field) &&
            in_array($field, ['predefined_created_by'])
        ) {
            return optional($lead->createdBy)->name ?? '';
        } else if (
            !empty($field) &&
            in_array($field, ['predefined_created_at'])
        ) {
            return $lead->created_at ?? '';
        } else if (
            !empty($field) &&
            in_array($field, ['predefined_source_name'])
        ) {
            if (!empty($lead->createdBy) && $lead->createdBy->user_type == 'ChannelPartner') {
                return 'Channel Partner';
            } else {
                return optional($lead->source)->source_name ?? '';
            }
        } else if (
            !empty($field) &&
            in_array($field, ['predefined_campaign_name'])
        ) {
            return optional($lead->campaign)->campaign_name ?? '';
        } else if (
            !empty($field) &&
            in_array($field, ['predefined_agency_name']) &&
            !empty($lead->campaign) &&
            !empty($lead->campaign->agency) &&
            !empty($lead->campaign->agency->name)

        ) {
            return $lead->campaign->agency->name ?? '';
        } else if (
            !empty($field) &&
            in_array($field, ['predefined_additional_email']) &&
            !empty($lead->additional_email)
        ) {
            return $lead->additional_email ?? '';
        } else if (
            !empty($field) &&
            in_array($field, ['predefined_secondary_phone']) &&
            !empty($lead->secondary_phone)
        ) {
            return $lead->secondary_phone ?? '';
        } else if (
            !empty($field) &&
            in_array($field, ['predefined_source_field1'])
        ) {
            return optional($lead->source)->source_field1 ?? '';
        } else if (
            !empty($field) &&
            in_array($field, ['predefined_source_field2'])
        ) {
            return optional($lead->source)->source_field2 ?? '';
        } else if (
            !empty($field) &&
            in_array($field, ['predefined_source_field3'])
        ) {
            return optional($lead->source)->source_field3 ?? '';
        } else if (
            !empty($field) &&
            in_array($field, ['predefined_source_field4'])
        ) {
            return optional($lead->source)->source_field4 ?? '';
        } else if (
            !empty($field) &&
            in_array($field, ['predefined_lead_ref_no'])
        ) {
            return $lead->ref_num ?? '';
        }
    }

    public function getLeadTags($id)
    {
        $lead = Lead::where('source_id', $id)
            ->latest()
            ->first();

        $tags = !empty($lead->lead_info) ? array_keys($lead->lead_info) : [];

        return $tags;
    }

    /*
     * return sources
     *
     * @param $for_cp: is channel partner
     *
     * @return array
     */
    public function getSources($for_cp = false)
    {
        $sources = Source::with(['project', 'campaign'])
            ->get();

        if ($for_cp) {
            $sources_arr = [];
            foreach ($sources as $source) {
                $title = '';
                if (!empty($source->project)) {
                    $title = $source->project->name . ' | ';
                }

                if (!empty($source->campaign)) {
                    $title .= $source->campaign->campaign_name . ' | ';
                }

                $title .= $source->name;

                $sources_arr[$source->id] = $title;
            }
            return $sources_arr;
        }

        return $sources->pluck('name', 'id')->toArray();
    }

    public function postWebhook($url, $method, $headers = [], $body = [])
    {
        if (in_array($method, ['get'])) {

            $client = new Client();
            $response = $client->get($url, [
                'query' => $body,
                'headers' => $headers,
            ]);

            return json_decode($response->getBody(), true);
        }
        if (in_array($method, ['post'])) {

            $client = new Client();
            $response = $client->post($url, [
                'headers' => $headers,
                'json' => $body,
            ]);

            return json_decode($response->getBody(), true);
        }
    }

    /*
     * return project dropdown
     *
     * @param $for_cp: is channel partner
     *
     * @return array
     */
    public function getProjectDropdown($for_cp = false)
    {
        $projects = Project::with(['client'])
            ->get();

        if ($for_cp) {
            $projects_arr = [];
            foreach ($projects as $project) {
                $projects_arr[$project->id] = $project->client->name . ' | ' . $project->name;
            }
            return $projects_arr;
        }

        return $projects->pluck('name', 'id')->toArray();
    }

    public function getApiConstants($api)
    {
        if (isset($api['constants']) && !empty($api['constants'])) {
            $constants = [];
            foreach ($api['constants'] as $value) {
                if (!empty($value['key']) && !empty($value['value'])) {
                    $constants[$value['key']] = $value['value'];
                }
            }
            return $constants;
        }
        return [];
    }

    public function getGlobalClientsFilter()
    {
        $__global_clients_filter = session('__global_clients_filter');

        return $__global_clients_filter ?? [];
    }

    /*
     * return project ids for
     * clients
     *
     * @return array
     */
    public function getClientsProjects($client_ids = [])
    {
        $client_ids = empty($client_ids) ? $this->getGlobalClientsFilter() : $client_ids;
        if (empty($client_ids)) {
            return [];
        }

        $projects = Project::whereIn('client_id', $client_ids)
            ->pluck('id')->toArray();

        return $projects;
    }

    /*
     * return campaign ids for
     * clients
     *
     * @return array
     */
    public function getClientsCampaigns($client_ids = [])
    {
        $project_ids = $this->getClientsProjects($client_ids);

        if (empty($project_ids)) {
            return [];
        }

        $campaign_ids = Campaign::whereIn('project_id', $project_ids)
            ->pluck('id')->toArray();

        return $campaign_ids;
    }

    public function getWebhookFieldsTags($id)
    {
        $project = Project::findOrFail($id);

        $db_fields = Lead::DEFAULT_WEBHOOK_FIELDS;
        $tags = !empty($project->webhook_fields) ? array_merge($project->webhook_fields, $db_fields) : $db_fields;

        return array_unique($tags);
    }

    public function storeUniqueWebhookFields($lead)
    {
        if ($lead->project_id) {
            $project = Project::findOrFail($lead->project_id);
            $fields = !empty($lead->lead_info) ? array_keys($lead->lead_info) : [];
            $webhook_fields = !empty($project->webhook_fields) ? array_merge($project->webhook_fields, $fields) : $fields;
            $unique_webhook_fields = array_unique($webhook_fields);
            $project->webhook_fields = array_values($unique_webhook_fields);
            $project->save();
        }
    }

    public function getClientProjects($id)
    {
        $projects = Project::where('client_id', $id)
            ->pluck('name', 'id')
            ->toArray();

        return $projects;
    }

    /**
     * generate lead ref no
     *
     * @param  $project_id
     */
    public function generateReferenceNumber($ref_count, $ref_prefix)
    {
        $ref_digits = str_pad($ref_count, 4, 0, STR_PAD_LEFT);
        return $ref_prefix . $ref_digits;
    }

    public function generateLeadRefNum($lead)
    {
        // $this->createinboxautomation($lead);
        return $this->generateReferenceNumber($lead->id, 'LE');
    }

    // public function createinboxautomation($lead) {
    //     $postdata = [
    //         "phone"=> $lead->phone,
    //         "first_name"=> $lead->name,
    //         "last_name"=> "",
    //         "gender"=> "",
    //         "actions"=> [
    //         [
    //             "action"=> "send_flow",
    //             "flow_id"=> 11111
    //         ],
    //         [
    //             "action"=> "add_tag",
    //             "tag_name"=> "YOU_TAG_NAME"
    //         ],
    //         [
    //             "action"=> "set_field_value",
    //             "field_name"=> "YOU_CUSTOM_FIELD_NAME",
    //             "value"=> "ANY_VALUE"
    //         ]
    //         ]
    //     ];
    //     $token = '1907249.XtqlzdA7ZDUu5Hr2SQnzO0lN8yuEhYiudCGELk8Dm';
    //     $header = array(
    //         'X-ACCESS-TOKEN: '.$token,
    //         'Accept: application/json'
    //     );
    //     $url = "https://inbox.thebumblebee.in/api/users";
    //     $client = new Client();
    //     $response = $client->post($url, [
    //         'headers' => $headers,
    //         'json' => $postdata,
    //     ]);
    //     $server_output = json_decode($response->getBody(), true);

    //     // $ch = curl_init();
    //     // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    //     // curl_setopt($ch, CURLOPT_URL,$url);
    //     // curl_setopt($ch, CURLOPT_POST, 1);
    //     // curl_setopt($ch, CURLOPT_POSTFIELDS,
    //     //             json_encode($postdata));

    //     // // Receive server response ...
    //     // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     // $server_output = curl_exec($ch);
    //     $id = $server_output['data']['id'];
    //     $this->sendMessage($id);
    //     // curl_close($ch);

    //     return true;
    // }

    public function sendMessage($id)
    {
        $postdata = [
            "text" => "This is a text message",
            "channel" => "messenger",
        ];
        $text = "This is a text message";
        $channel = "messenger";
        $token = '1907249.XtqlzdA7ZDUu5Hr2SQnzO0lN8yuEhYiudCGELk8Dm';
        $header = array(
            'X-ACCESS-TOKEN: ' . $token,
            'Accept: application/json',
        );
        $url = "https://inbox.thebumblebee.in/api/users/" . $id . "/send/text";
        $client = new Client();
        $response = $client->post($url, [
            'headers' => $header,
            'json' => $postdata,
        ]);

        return true;
    }

    public function generateUserRefNum($user)
    {
        $prefixes = [
            'Superadmin' => 'SU',
            'Admin' => 'AD',
            'Client' => 'CL',
            'Agency' => 'AG',
            'ChannelPartner' => 'CP',
            'ChannelPartnerManager' => 'CPM',
            'EEPLMgmt' => 'EEPL',
            'PresalesHead' => 'PSH',
            'Presales' => 'PS',
            'Sales' => 'SA',
            'CRMTeam' => 'CRMT',
            'CRMHead' => 'CRMH',
            'LegalTeam' => 'LET',
            'BankingTeam' => 'BAT',
            'Customer' => 'CUST',
            'SiteExecutive' => 'SE',
            'Merlom' => "MER",
        ];
        return $this->generateReferenceNumber($user->id, $prefixes[$user->user_type]);
    }
    public function generateselldoRefNum($selldouser)
    {
        $prefixes = [
            'Superadmin' => 'SU',
            'Admin' => 'AD',
            'Client' => 'CL',
            'Agency' => 'AG',
            'ChannelPartner' => 'CP',
            'ChannelPartnerManager' => 'CPM',
            'EEPLMgmt' => 'EEPL',
            'PresalesHead' => 'PSH',
            'Presales' => 'PS',
            'Sales' => 'SA',
            'CRMTeam' => 'CRMT',
            'CRMHead' => 'CRMH',
            'LegalTeam' => 'LET',
            'BankingTeam' => 'BAT',
            'Customer' => 'CUST',
            'SiteExecutive' => 'SE',
            'Merlom' => "MER",
        ];
        return $this->generateReferenceNumber($selldouser->id, $prefixes[$selldouser->user_type]);
    }
    public function getFIlteredLeads($request)
    {
        $user = auth()->user();
        $__global_clients_filter = $this->getGlobalClientsFilter();
        if (!empty($__global_clients_filter)) {
            $project_ids = $this->getClientsProjects($__global_clients_filter);
            $campaign_ids = $this->getClientsCampaigns($__global_clients_filter);
        } else {
            $project_ids = $this->getUserProjects($user);
            $campaign_ids = $this->getCampaigns($user, $project_ids);
        }

        $query = Lead::with(['project', 'campaign', 'source', 'createdBy'])
            ->select(sprintf('%s.*', (new Lead)->table));

        if ($request->has('leads_status')) {
            $leads_status = $request->get('leads_status');

            if ($leads_status == 'duplicate') {
                $query->where('sell_do_is_exist', 1);
            }

            if ($leads_status == 'new') {
                $query->where('sell_do_is_exist', 0);
            }
        }

        if ($user->is_channel_partner_manager) {
            $query = $query->whereHas('createdBy', function ($q) use ($user) {
                $q->where('user_type', '=', 'ChannelPartner')
                    ->orWhere('leads.created_by', $user->id);
            });
        } else {
            $query = $query->where(function ($q) use ($project_ids, $campaign_ids, $user) {
                if ($user->is_channel_partner) {
                    $q->where('leads.created_by', $user->id);
                } else {
                    $q->whereIn('leads.project_id', $project_ids)
                        ->orWhereIn('leads.campaign_id', $campaign_ids);
                }
            });
        }

        $query->groupBy('id');

        //filter leads
        if (!empty($request->input('project_id'))) {
            $query->where('leads.project_id', $request->input('project_id'));
        }

        if (!empty($request->input('campaign_id'))) {
            $query->where('leads.campaign_id', $request->input('campaign_id'));
        }

        if (!empty($request->input('source'))) {
            $query->where('leads.source_id', $request->input('source'));
        }

        if (!empty($request->input('no_lead_id')) && $request->input('no_lead_id') === 'true') {
            $query->whereNull('leads.sell_do_lead_id');
        }

        if (!empty($request->input('start_date')) && !empty($request->input('end_date'))) {
            $query->whereDate('leads.created_at', '>=', $request->input('start_date'))
                ->whereDate('leads.created_at', '<=', $request->input('end_date'));
        }

        return $query;
    }

    public function getLeadBySellDoLeadId($sell_do_id)
    {
        // Assuming 'sell_do_fields' is a JSON column
        $lead = Lead::whereJsonContains('sell_do_fields->Sell Do Id', $sell_do_id)
            ->first();
        // var_dump($lead);

        return $lead;
    }

    public function generateCpWalkinRefNum($cpLead)
    {
        return $this->generateReferenceNumber($cpLead->id, 'ME');
    }
    public function getProjectBySellDoProjectId($campaign)
    {
        $sell_do_project_id = $campaign['project_id'] ?? '';

        if (empty($sell_do_project_id)) {
            return [];
        }

        $project = Project::where('sell_do_project_id', $sell_do_project_id)
            ->first();

        return $project;
    }
    public function getSubSourceBySrd($subsource)
    {
        $sell_do_sub_source_id = $subsource['r_id'] ?? '';

        if (empty($sell_do_sub_source_id)) {
            return [];
        }

        $subsource = SubSource::where('srd', $sell_do_sub_source_id)
            ->first();

        return $subsource;
    }

    public function generateGuestDocumentViewUrl($id)
    {
        return config('constants.DOCUMENT_URL') . "/document/{$id}/view";
    }

    public function logActivity($lead, $type, $webhook_data, $source = "leads_system")
    {
        LeadEvents::create([
            'source' => $source,
            'lead_id' => $lead->id,
            'sell_do_lead_id' => $lead->sell_do_lead_id,
            'event_type' => $type,
            'webhook_data' => $webhook_data,
        ]);
    }

    public function getNestedKeysAndValues($array, $prefix = '')
    {
        $keysAndValues = [];
        foreach ($array as $key => $value) {
            $currentKey = $prefix === '' ? $key : $prefix . '[' . $key . ']';
            if (is_array($value)) {
                $nestedKeysAndValues = $this->getNestedKeysAndValues($value, $currentKey);
                $keysAndValues = array_merge($keysAndValues, $nestedKeysAndValues);
            } else {
                $keysAndValues[$currentKey] = $value;
            }
        }
        return $keysAndValues;
    }

    public function storeUniqueWebhookFieldsWhenCreatingWebhook($project)
    {
        $outgoing_apis = $project->outgoing_apis;
        $fields = [];
    
        foreach ($outgoing_apis as &$outgoing_api) {
            $body = $outgoing_api['request_body'] ?? [];
            foreach ($body as $details) {
                if (is_array($details['key']) && is_array($details['value']) && count($details['key']) === count($details['value'])) {
                    foreach ($details['key'] as $index => $key) {
                        if (isset($details['value'][$index])) {
                            $fields[] = [
                                'key' => $key,
                                'value' => $details['value'][$index]
                            ];
                        }
                    }
                } elseif (isset($details['key'], $details['value'])) {
                    $fields[] = [
                        'key' => $details['key'],
                        'value' => $details['value']
                    ];
                }
            }
            unset($outgoing_api['request_body']);
            $outgoing_api['request_body'] = !empty($outgoing_api['request_body']) ? array_merge($outgoing_api['request_body'], $fields) : $fields;
        }
    
        $project->outgoing_apis = $outgoing_apis;
        $project->save();
    }

}
