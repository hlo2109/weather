<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('city_id');
            $table->string('city_name', 100);
            $table->json('json')->nullable();
            $table->timestamps();
        });
        $data = file_get_contents(__DIR__.'/../../storage/app/public/current.city.list.json');
        $data = json_decode($data);
        $citys  = \collect($data); 
        foreach ($citys as $item) {
            DB::insert('insert into cities (city_id, city_name, json) values (?, ?, ?)', [$item->id, $item->name, json_encode($item)]);
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city');
    }
}
