<?php

class Investigator
{
	public function resolve($path)
	{
		$chunks = explode('/', $path);
		$old = [];
		foreach($chunks as $index => $chunk)
		{
			$result = [];
			if($chunk == '')
			{
				if($index == 0)
				{
					$result[] = new Market;
				}
			}
			else if($chunk == '*')
			{
				foreach($old as $group)
				{
					$childs = $group->childs()->get();
					for($i = 0; $i < count($childs); $i++)
					{
						$result[] = $childs[$i];
					}
				}
			}
			else if($chunk == '**')
			{
				$result = $old;
				for($i = 0; $i < count($result); $i++)
				{
					for($j = 0; $j < count($result[$i]->childs); $j++)
					{
						$result[] = $result[$i]->childs[$j];
					}
				}
			}
			else if(strpos($chunk, '%') !== false)
			{
				foreach($old as $group)
				{
					$childs = $group->childs()->where('marketGroupName', 'LIKE', $chunk)->get();
					for($i = 0; $i < count($childs); $i++)
					{
						$result[] = $childs[$i];
					}
				}
			}
			else
			{
				foreach($old as $group)
				{
					for($i = 0; $i < count($group->childs); $i++)
					{
						if($group->childs[$i]->marketGroupName == $chunk)
						{
							$result[] = $group->childs[$i];
						}
					}
				}
			}
			$old = $result;
		}
		return $result;
	}
	
	public function expand($groups, $name = null)
	{
		$result = [];
		for($i = 0; $i < count($groups); $i++)
		{
			for($j = 0; $j < count($groups[$i]->childs); $j++)
			{
				$groups[] = $groups[$i]->childs[$j];
			}
			if($name == null)
			{
				$types = $groups[$i]->types;
			}
			else
			{
				$types = $groups[$i]->types()->where('typeName', 'LIKE', $name)->get();
			}
			for($j = 0; $j < count($types); $j++)
			{
				$result[] = $types[$j];
			}
		}
		return $result;
	}
};

?>