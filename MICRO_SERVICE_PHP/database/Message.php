<?php
require "../app/settings.php";
use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('messages', function ($table) {

   $table->increments('id');
   
   $table->integer("user_id")->unsigned();
   
   $table->string('message');

   $table->rememberToken();

   $table->timestamps();

   $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
   });