<?php

namespace Keeper;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
	protected $fillable = array('id','first_name','last_name','address_line1', 'city','post_code');

}