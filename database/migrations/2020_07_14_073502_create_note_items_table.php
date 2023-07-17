<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateNoteItemsTable
 */
class CreateNoteItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_items', function (Blueprint $table) {
            $table->id();
            /**
             * uuid field. Unique char(36) string. Refer to  ramsey/uuid  package for example
             */
            $table->uuid('uuid');
            /**
             * The title of the note item
             */
            $table->string('name', 50);
            /**
             * deleted_at column provide by the softDeletes scope trait
             */
            $table->softDeletes();
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
        Schema::dropIfExists('note_items');
    }
}
