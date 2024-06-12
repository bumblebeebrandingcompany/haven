<?php

use App\Models\SelldoUser;
use App\Utils\Util;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $selldouser = SelldoUser::all();
        if (count($selldouser) > 0) {
            $util = new Util();
            foreach ($selldouser as $selldousers) {
                $ref_num = $util->generateselldoRefNum($selldousers);
                $selldousers->ref_num = $ref_num;
                $selldousers->save();
            }
        }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selldo_users', function (Blueprint $table) {
            //
        });
    }
};
