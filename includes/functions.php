<?php
#Web Programming using PHP - Functions file to be included in the assignment web pages

function mmmr($array, $output = 'mean'){ 
    #Provides basic statistical functions - default is mean; other $output parammeters are; 'median', 'mode' and 'range'.
	#Ian Hollender 2016 - adapted from the following, as it was an inacurate solution
	#http://phpsnips.com/45/Mean,-Median,-Mode,-Range-Of-An-Array#tab=snippet
	#Good example of PHP overloading variables with different data types - see the Mode code
	if(!is_array($array)){ 
        echo '<p>Invalid parammeter to mmmr() function: ' . $array . ' is not an array</p>';
		return FALSE; #input parammeter is not an array
    }else{ 
        switch($output){ #determine staistical output required
            case 'mean': #calculate mean or average
                $count = count($array); 
                $sum = array_sum($array); 
                $total = $sum / $count; 
            break; 
            case 'median': #middle value in an ordered list; caters for odd and even lists
                $count = count($array); 
				sort($array); #sort the list of numbers
				if ($count % 2 == 0) { #even list of numbers
					$med1 = $array[$count/2];
					$med2 = $array[($count/2)-1];
					$total = ($med1 + $med2)/2;
				}
				else { #odd list of numbers
					$total = $array[($count-1)/2]; 	
				}				
            break; 
            case 'mode': #most frequent value in a list; N.B. will only find a unique mode or no mode; 
                $v = array_count_values($array); #create associate array; keys are numbers in array, values are counts
                arsort($v); #sort the list of numbers in ascending order				
				
				if (count(array_unique($v)) == 1) { #all frequency counts are the same, as array_unique returns array with all duplicates removed!
					return 'No mode';
				}				
				$i = 0; #used to keep track of count of associative keys processes
                $modes = '';
				foreach($v as $k => $v){ #determine if a unique most frequent number, or return NULL by only looking at first two keys and frequency numbers in the sorted array					
					if ($i == 0) { #first number and frequency in array
						$max1 = $v;	#highest frequency of first number in array
						$modes = $k . ' ';
						$total = $k; #first key is the most frequent number;
					}
					if ($i > 0) { #second number and frequency in array
						$max2 = $v;	#highest frequency of second number in array					
						if ($max1 == $max2) { #two or more numbers with same max frequency; return NULL
							$modes = $modes . $k . ' ';
						}
						else {
							break;  
						}
					}
					$i++; #next item in $v array to be counted
				}
				$total = $modes;				
            break; 
            case 'range': #highest value - lowest value
                sort($array); #find the smallest number
                $sml = $array[0]; 
                rsort($array); #find the largest number
                $lrg = $array[0]; 
                $total = $lrg - $sml; #calculate the range
            break; 
			default :
				echo '<p>Invalid parammeter to mmmr() function: ' . $output . '</p>';
				$total= 0;
				return FALSE;
        } 
        return $total; 
    }
}
# This function uses DateTime to validate a date and is from:
# https://secure.php.net/manual/en/function.checkdate.php#113205
# I pass the date variable and the format that the date should be in to the function for validation.
function validateDate($date, $format = 'd-m-Y'){
	$d = DateTime::createFromFormat($format, $date);
	# Returns true or false depending on the validity of the date given.
	return $d && $d->format($format) == $date;
}

# Simple function to check if the variable is not empty to avoid repitition in our files.
# Requires a variable for cheking and if it is empty it 
function quickCheck($tidbit){
	if(!$tidbit){
		return ' :ERROR';
	}else {
		return $tidbit;
	}
}

# This function checks if the provided argument is an integer, then returns it else changes the format to maximum one decimal place.
function intCheck($number){
	if (is_int($number)) {
		return $number;
	}elseif  (is_float($number)){
		$retInt =  number_format($number, 1);
		return $retInt;
	}
}

?>