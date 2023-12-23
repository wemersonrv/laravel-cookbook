<?php

use App\Models\Announcement;
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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(false);
            $table->string('banner_text');
            $table->string('banner_color');
            $table->string('title_text');
            $table->string('title_color');
            $table->text('content');
            $table->string('button_text');
            $table->string('button_link');
            $table->string('button_color');
            $table->timestamps();
        });

        Announcement::create([
            'is_active' => true,
            'banner_text' => 'This is the banner text',
            'banner_color' => '#0000ff',
            'title_text' => 'This is the Title',
            'title_color' => '#0000ff',
            'content' => 'This is the content',
            'button_text' => 'Call to Action',
            'button_link' => 'https://laracasts.com',
            'button_color' => '#0000ff',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
