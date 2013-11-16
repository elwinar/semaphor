<?php

class Region extends Illuminate\Database\Eloquent\Model
{
	protected $table = 'mapRegions';
	protected $primaryKey = 'regionID';
	
	public function solarSystems()
	{
		return $this->hasMany('SolarSystem', 'regionID');
	}
};

?>