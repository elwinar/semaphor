<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Butler\Butler as Butler;
use Butler\Parameter as Parameter;

class App
{
	public function run()
	{
		/*
		|------------------------------------------------------------------
		| Start the database connection and the object relationnal mapper
		|------------------------------------------------------------------
		*/
		
		$capsule = new Capsule;
		$capsule->setAsGlobal();
		$capsule->addConnection([
			'driver'    => 'sqlite',
			'database'  => 'app/odyssey.sqlite',
		]);
		$capsule->bootEloquent();
		
		/*
		|------------------------------------------------------------------
		| Parse the command line parameters
		|------------------------------------------------------------------
		*/
		
		$butler = new Butler;
		$parameters = $butler->parse(array(
			'systems' => new Parameter('s', 'systems', Parameter::MULTIPLE, 'Jita'),
			'items' => new Parameter('i', 'items', Parameter::MULTIPLE),
			'percentile' => new Parameter('p', 'percentile', Parameter::COMMUTATOR),
		));
		
		/*
		|------------------------------------------------------------------
		| Resolve the types
		|------------------------------------------------------------------
		*/
		
		$investigator = new Investigator;
		$types = [];
		foreach($parameters['items'] as $item)
		{
			$chunks = explode('>', $item);
			$groups = $investigator->resolve($chunks[0]);
			if(count($chunks) == 2)
			{
				$types = array_merge($types, $investigator->expand($groups, $chunks[1]));
			}
			else
			{
				$types = array_merge($types, $investigator->expand($groups));
			}
		}
		$types = array_unique($types);
		
		/*
		|------------------------------------------------------------------
		| Query the market data
		|------------------------------------------------------------------
		*/
		
		$querier = new Querier;
		$prices = [];
		$systems = [];
		foreach($parameters['systems'] as $name)
		{
			$system = SolarSystem::where('solarSystemName', $name)->first();
			if($system != null)
			{
				$result = $querier->marketstat($types, $system);
				foreach($result as $type)
				{
					if($parameters['percentile'] == true)
					{
						$prices[intval($type['id'])][$name]['buy'] = $type->buy->percentile;
						$prices[intval($type['id'])][$name]['sell'] = $type->sell->percentile;
					}
					else
					{
						$prices[intval($type['id'])][$name]['buy'] = $type->buy->max;
						$prices[intval($type['id'])][$name]['sell'] = $type->sell->min;
					}
				}
			}
		}
		
		/*
		|------------------------------------------------------------------
		| Display the result
		|------------------------------------------------------------------
		*/
		
		foreach($prices as $id => $price)
		{
			echo $id;
			foreach($parameters['systems'] as $system)
			{
				if(isset($price[$system]))
				{
					echo "\t".$price[$system]['buy']."\t".$price[$system]['buy'];
				}
				else
				{
					echo "\t".'N/A'."\t".'N/A';
				}
			}
			echo PHP_EOL;
		}
	}
};

?>