<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'full_name')) {
            // The base user migration already defines the required profile columns.
        }
    }

    public function down(): void
    {
        // Intentionally left blank for a no-op migration to keep fresh installs stable.
    }
};
