<?php

class Querier
{
	public $url = 'http://api.eve-central.com/api/marketstat';
	
	public function request($function, $parameters)
	{
		return file_get_contents('http://api.eve-central.com/api/'.$function.'?'.implode('&', $parameters));
	}
	
	public function marketstat($types, $system)
	{
		$data = [];
		$parameters = [];
		$parameters[] = 'usesystem='.$system->solarSystemID;
		for($i = 0; $i < count($types); $i++)
		{
			$parameters[] = 'typeid='.$types[$i]->typeID;
			if($i % 20 == 0)
			{
				$result = new SimpleXMLElement($this->request('marketstat', $parameters));
				foreach($result->marketstat->type as $type)
				{
					$data[] = $type;
				}
				$parameters = [];
				$parameters[] = 'usesystem='.$system->solarSystemID;
			}
		}
		return $data;
	}
};

?>