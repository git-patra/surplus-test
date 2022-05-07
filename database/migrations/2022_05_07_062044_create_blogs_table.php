<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Base\Utils\StatusEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
//            $table->uuid('id')->default(DB::raw('(UUID())'));
            $table->id();
            $table->string('title')->nullable();
            $table->longText('text')->nullable();
            $table->enum('status', collect(StatusEnum::cases())->map(function ($enum) {
                return $enum->value;
            })->toArray())->nullable();
            $table->foreignId('creator_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
};
