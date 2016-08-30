<?php namespace AbuLoot\Acl\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $table = 'roles';

	public $timestamps = false;
	protected $fillable = ['name', 'description', 'rules'];
}