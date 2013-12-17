<?php
	function getTaxRate($state)
	{
		switch ($state)
		{
			case 'AL':
				return 1.04;
				break;
			case 'AK':
				return 1.00;
				break;
			case 'AZ':
				return 1.066;
				break;
			case 'AR':
				return 1.06;
				break;
			case 'CA':
				return 1.075;
				break;
			case 'CO':
				return 1.029;
				break;
			case 'CT':
				return 1.0635;
				break;
			case 'DE':
				return 1.0;
				break;
			case 'FL':
				return 1.06;
				break;
			case 'GA':
				return 1.04;
				break;
			case 'HI':
				return 1.04;
				break;
			case 'ID':
				return 1.06;
				break;
			case 'IL':
				return 1.0625;
				break;
			case 'IN':
				return 1.07;
				break;
			case 'IA':
				return 1.06;
				break;
			case 'KS':
				return 1.063;
				break;
			case 'KY':
				return 1.06;
				break;
			case 'LA':
				return 1.04;
				break;
			case 'ME':
				return 1.05;
				break;
			case 'MD':
				return 1.06;
				break;
			case 'MA':
				return 1.0625;
				break;
			case 'MI':
				return 1.06;
				break;
			case 'MN':
				return 1.06875;
				break;
			case 'MS':
				return 1.07;
				break;
			case 'MO':
				return 1.04225;
				break;
			case 'MT':
				return 1.0;
				break;
			case 'NE':
				return 1.055;
				break;
			case 'NV':
				return 1.0685;
				break;
			case 'NH':
				return 1.0;
				break;
			case 'NJ':
				return 1.07;
				break;
			case 'NM':
				return 1.05125;
				break;
			case 'NY':
				return 1.085;
				break;
			case 'NC':
				return 1.0475;
				break;
			case 'ND':
				return 1.05;
				break;
			case 'OH':
				return 1.0575;
				break;
			case 'OK':
				break;
			case 'OR':
				break;
			case 'PA':
				break;
			case 'RI':
				break;
			case 'SC':
				break;
			case 'SD':
				break;
			case 'TN':
				break;
			case 'TX':
				break;
			case 'UT':
				break;
			case 'VT':
				break;
			case 'VA':
				break;
			case 'WA':
				break;
			case 'WV':
				break;
			case 'WI':
				return $amount * 1.05;
				break;
			case 'WY':
				break;
		}
	}
?>