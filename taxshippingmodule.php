<?php
	function getShippingTypes($conn)
	{
		$shipping_types = array();
		
		$sql = "SELECT * " . 
			   "FROM shipping_costs";
		
		mysql_query($sql, $conn)
			or die('Could not select shipping costs: ' . mysql_error());
		
		$result = mysql_query($sql, $conn);
		if (mysql_num_rows($result)>0)
		{
			while ($row = mysql_fetch_array($result))
			{
				$shipping_data = array(
					"name" => $row['name'],
					"description" => $row['description'],
					"cost" => $row['cost']
				);
				$shipping_types[] = $shipping_data;
			}
		}
		
		return $shipping_types;
	}

	function getTaxRate($state)
	{
		$state = strtoupper($state);
		switch ($state)
		{
			case 'AL':
				return 0.04;
				break;
			case 'AK':
				return 0.00;
				break;
			case 'AZ':
				return 0.066;
				break;
			case 'AR':
				return 0.06;
				break;
			case 'CA':
				return 0.075;
				break;
			case 'CO':
				return 0.029;
				break;
			case 'CT':
				return 0.0635;
				break;
			case 'DE':
				return 0.0;
				break;
			case 'FL':
				return 0.06;
				break;
			case 'GA':
				return 0.04;
				break;
			case 'HI':
				return 0.04;
				break;
			case 'ID':
				return 0.06;
				break;
			case 'IL':
				return 0.0625;
				break;
			case 'IN':
				return 0.07;
				break;
			case 'IA':
				return 0.06;
				break;
			case 'KS':
				return 0.063;
				break;
			case 'KY':
				return 0.06;
				break;
			case 'LA':
				return 0.04;
				break;
			case 'ME':
				return 0.05;
				break;
			case 'MD':
				return 0.06;
				break;
			case 'MA':
				return 0.0625;
				break;
			case 'MI':
				return 0.06;
				break;
			case 'MN':
				return 0.06875;
				break;
			case 'MS':
				return 0.07;
				break;
			case 'MO':
				return 0.04225;
				break;
			case 'MT':
				return 0.0;
				break;
			case 'NE':
				return 0.055;
				break;
			case 'NV':
				return 0.0685;
				break;
			case 'NH':
				return 0.0;
				break;
			case 'NJ':
				return 0.07;
				break;
			case 'NM':
				return 0.05125;
				break;
			case 'NY':
				return 0.085;
				break;
			case 'NC':
				return 0.0475;
				break;
			case 'ND':
				return 0.05;
				break;
			case 'OH':
				return 0.0575;
				break;
			case 'OK':
				return 0.045;
				break;
			case 'OR':
				return 0.0;
				break;
			case 'PA':
				return 0.06;
				break;
			case 'RI':
				return 0.07;
				break;
			case 'SC':
				return 0.06;
				break;
			case 'SD':
				return 0.04;
				break;
			case 'TN':
				return 0.07;
				break;
			case 'TX':
				return 0.0625;
				break;
			case 'UT':
				return 0.047;
				break;
			case 'VT':
				return 0.06;
				break;
			case 'VA':
				return 0.053;
				break;
			case 'WA':
				return 0.065;
				break;
			case 'WV':
				return 0.06;
				break;
			case 'WI':
				return 0.05;
				break;
			case 'WY':
				return 0.04;
				break;
		}
	}
?>