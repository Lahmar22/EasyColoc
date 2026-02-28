<?php

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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->decimal('amount', 8, 2);
            $table->date('expense_date');
            $table->foreignId('colocation_id')->constrained('colocations')->onDelete('cascade');
            $table->foreignId('utilisateur_id')->constrained('personnes')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('category')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
