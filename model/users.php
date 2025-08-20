<?php
class users extends model
{
   protected $table = "users";
   protected $fillable = ['id', 'userName', 'firstName', 'lastName', 'password', 'email', 'phoneNumber'];
}
