<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->decimal('labor_cost', 10, 2)->default(0)->after('total_value');   // mão de obra
            $table->decimal('material_cost', 10, 2)->default(0)->after('labor_cost'); // material
            $table->text('internal_notes')->nullable()->after('description');          // obs interna
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['labor_cost', 'material_cost', 'internal_notes']);
        });
    }
};
