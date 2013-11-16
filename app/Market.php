<?php

class Market
{
	public function childs()
	{
		return MarketGroup::whereNull('parentGroupID');
	}
	
	public function __get($name)
	{
		if($name == 'childs')
		{
			return $this->childs()->get();
		}
	}
};

?>