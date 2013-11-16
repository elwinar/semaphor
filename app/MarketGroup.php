<?php

class MarketGroup extends Illuminate\Database\Eloquent\Model
{
	protected $table = 'invMarketGroups';
	protected $primaryKey = 'marketGroupID';
	
	public function types()
	{
		return $this->hasMany('Type', 'marketGroupID');
	}
	
	public function childs()
	{
		return $this->hasMany('MarketGroup', 'parentGroupID');
	}
	
	public function parent()
	{
		return $this->belongsTo('MarketGroup', 'parentGroupID');
	}
};

?>