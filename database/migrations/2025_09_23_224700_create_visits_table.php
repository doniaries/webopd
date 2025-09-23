<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 45)->index();
            $table->string('session_id', 100)->index();
            $table->text('user_agent')->nullable();
            $table->timestamp('visited_at')->index();
            $table->timestamp('last_activity')->nullable()->index();
            $table->string('url', 512)->nullable();
            $table->timestamps();

            $table->index(['session_id', 'visited_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
