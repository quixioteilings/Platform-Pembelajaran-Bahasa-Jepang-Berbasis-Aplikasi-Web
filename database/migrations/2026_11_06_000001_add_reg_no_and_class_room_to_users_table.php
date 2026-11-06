<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'reg_no')) {
                $table->string('reg_no')->nullable()->after('avatar');
            }
            if (!Schema::hasColumn('users', 'class_room')) {
                $table->string('class_room')->nullable()->after('reg_no');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'reg_no')) {
                $table->dropColumn('reg_no');
            }
            if (Schema::hasColumn('users', 'class_room')) {
                $table->dropColumn('class_room');
            }
        });
    }
};

