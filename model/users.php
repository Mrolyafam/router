<?php
class users extends model
{
   protected static $table = "users";
   protected $fillable = ['id', 'userName', 'firstName', 'lastName', 'password', 'email', 'phoneNumber'];
}
