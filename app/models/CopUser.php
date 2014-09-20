<?php

class CopUser extends \Eloquent {
    protected $fillable =['username','password'];

   //database table used by model
    protected $table ='cop_user';

}