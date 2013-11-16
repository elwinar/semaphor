<?php

class Type extends Illuminate\Database\Eloquent\Model
{
	protected $table = 'invTypes';
	protected $primaryKey = 'typeID';
	
	public function marketGroup()
	{
		return $this->belongsTo('MarketGroup', 'marketGroupID');
	}
};

?>