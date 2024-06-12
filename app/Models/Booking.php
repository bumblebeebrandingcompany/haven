<?php
// app/Models/Form.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    // Define the table associated with the model
    protected $table = 'booking';
    protected $dates = [
      'created_at',
      'updated_at',
  ];

    // Define the fillable fields for mass assignment
    protected $fillable = ['name', 
    'aadhar_no',
     'pan',
      'phone',
       'secondary_phone',
        'email', 
        'secondary_email',
         'payment_mode',
          'total_amount',
           'advance_amount', 
           'pending_amount',
            'discount_value_sqft_based',
             'discount_amount_sqft_based', 

               'cheque_no',
                'credit/not_credit',
                 'plot_id',
                  'status_id',
                  'remarks',
                  'user_type',
                  'per_sqft_based_price'];
                  public function plot()
                  {
                      return $this->belongsTo(PlotDetail::class, 'plot_id');
                  }
}
