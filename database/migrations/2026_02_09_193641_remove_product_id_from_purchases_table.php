<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            if (Schema::hasColumn('purchases', 'product_id')) {
                // إذا كان المفتاح موجودًا، احذفه
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $foreignKeys = $sm->listTableForeignKeys('purchases');
                foreach ($foreignKeys as $fk) {
                    if ($fk->getLocalColumns()[0] === 'product_id') {
                        $table->dropForeign($fk->getName());
                    }
                }
                // ثم احذف العمود نفسه
                $table->dropColumn('product_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');

        });
    }
};
