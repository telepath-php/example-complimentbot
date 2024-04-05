<?php

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

require __DIR__ . '/../../bootstrap.php';

Manager::schema()->create('compliments', function (Blueprint $table) {
    $table->id();

    $table->text('compliment');
    $table->unsignedBigInteger('created_by');

    $table->unsignedBigInteger('usage')->default(0);

    $table->timestamps();
});