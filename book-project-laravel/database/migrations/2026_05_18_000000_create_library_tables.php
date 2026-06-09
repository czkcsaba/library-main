<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('writers', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_hungarian_ci';

            $table->increments('id');
            $table->string('name', 50)->nullable();
            $table->string('bio', 400);
        });

        Schema::create('publishers', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_hungarian_ci';

            $table->increments('id');
            $table->string('name', 50);
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_hungarian_ci';

            $table->increments('id');
            $table->string('name', 50);
        });

        Schema::create('books', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_hungarian_ci';

            $table->increments('id');
            $table->unsignedInteger('writerId')->nullable();
            $table->unsignedInteger('publisherId')->nullable();
            $table->unsignedInteger('categoryId')->nullable();
            $table->string('title', 50);
            $table->binary('coverImage');
            $table->string('ISBN', 50);
            $table->integer('price');
            $table->string('content', 800);

            $table->index('writerId');
            $table->index('publisherId');
            $table->index('categoryId');
        });

        // Az eredeti SQL-ben MEDIUMBLOB volt, Laravelben ezt raw SQL-lel állítjuk pontosan ugyanarra.
        DB::statement('ALTER TABLE `books` MODIFY `coverImage` MEDIUMBLOB NOT NULL');

        Schema::create('reviews', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_hungarian_ci';

            $table->increments('id');
            $table->unsignedInteger('bookId');
            $table->integer('stars');

            $table->index('bookId');
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreign('writerId')
                ->references('id')
                ->on('writers')
                ->onDelete('cascade');

            $table->foreign('publisherId')
                ->references('id')
                ->on('publishers')
                ->onDelete('cascade');

            $table->foreign('categoryId')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign('bookId')
                ->references('id')
                ->on('books')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('books');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('publishers');
        Schema::dropIfExists('writers');
    }
};
