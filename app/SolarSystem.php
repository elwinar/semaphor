<?php

class SolarSystem extends Illuminate\Database\Eloquent\Model
{
	protected $table = 'mapSolarSystems';
	protected $primaryKey = 'solarSystemID';
	
	public function region()
	{
		return $this->belongsTo('Region', 'regionID');
	}
};

?>