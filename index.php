<?php
	# Web Programming using PHP
	# Pedro Dos Passos
	
	# The functions file is required a single time from the includes folder.
	require_once 'includes/functions.php';
	
	# Including the header from the includes folder.
	include 'includes/header.php';
	
	# Assigning data directory with our files to a variable.
	$dir = 'data';
	$sysError = '<p> Sorry there ahs been a System Error</p>';
	
	# Checking if the directory exists and is a valid directory.
	if (($dir) && (is_dir($dir))) {
		
		# Opening the directory and assigning it to a variable.
		$handle = opendir($dir);
		
		# Checking if opening the directory was successful else displaying error message.
		if ($handle === false){
			echo $sysError;
		} else {
			
			# After opening the directory we loop through the files in the directory.
			while(false !== ($entry = readdir($handle))){
				# We check if each file is a valid file and we are able to write to it then proceed to store the file name in an array.
				if ((file_exists('data/'.$entry)) && (is_file('data/'.$entry) && is_writable('data/'.$entry))){
					$cleanFiles[] = 'data/'.$entry;
				}
			}
			# Closing the directory as it has already served it's purpose.
			closedir($handle);
		}
	}else {
		echo $sysError;
	}

	# We loop through each of the valid files to extract the necessary data.
	foreach ($cleanFiles as $marks){
		
		# Opening our checked files for reading.
		$handle = fopen($marks, 'r');
		
		# Initialising our variables for later use.
		$students = 0;
		$distinction = 0;
		$merit = 0;
		$pass = 0;
		$fail = 0;
		$meanModeRange = [];
		$includedStudent = [];
		
		#Arrays with all possible values in regards to this assignment.
		$modCodes = ['PP', 'P1', 'DT'];
		$yearCodes = ['1516', '1617'];
		$termCodes = ['T1', 'T2', 'T3'];

		# While there are lines in the file we keep reading through them using a while loop and fgets to extract the data.
		while (($line = fgets($handle, 1024)) !== false) {
			
			# Exploding and triming the data then assigning to $details.
			# Note: array map returns an array of the exploded data and applies the "callback" or function
			# which is trim in our case to each element and then assigning it into our array instead of repeating trim several times.
			# https://secure.php.net/manual/en/function.array-map.php
			
			$details = array_map('trim', explode(',', $line));
			
			# Simple check to make sure we get the correct information from each line.
			# In this case we are making sure that the first element of our line is not just numbers meaning it is a module code.
			if(!ctype_digit($details[0])){
				$moduleCode = $details[0];
				
				# Dividing up the extracted code into module code, year and term each in it's own variable.
				$mCode = substr($moduleCode, 0, 2);
				$yCode = substr($moduleCode, 2, 4);
				$tCode = substr($moduleCode, 6, 8);
				# Here we are cheking that the module code is valid by checking the length and comparing it to our arrays with the allowed values we initialised earlier.
				if((strlen($moduleCode) != 8) || (!in_array($mCode, $modCodes)) || (!in_array($yCode, $yearCodes) || (!in_array($tCode, $termCodes)))){
					# If any of the checks fail we append the Error message to the variable.
					$moduleCode = $moduleCode . ':ERROR';
				}
				# We make use of the quickCheck function to make sure there is a module title and tutor else the error message is appended.
				$moduleTitle = quickCheck($details[1]);
				$tutor = quickCheck($details[2]);
				# The date is put into both markDate and validDate for seperate checks.
				# validDate is passed to the function validateDate to check it's valid and returns a boolean.
				# Followed by a a test for both something in the varaiable and a valid date(boolean from function).
				$markDate = $details[3];
				$validDate = validateDate($markDate, 'd/m/Y');
				if((!$markDate) || (!$validDate)){
						$markDate = $markDate . ':ERROR';
				}
				
				# Now we begin to print the extracted information after reading and processing.
				echo '<p>Module Header Data...</p>'. PHP_EOL;
				echo '<table>'. PHP_EOL;
				echo '<tr><td>File name: '.substr($marks, 5).'</td></tr>'. PHP_EOL;
				echo '<tr><td>Module Code: '.$moduleCode.'</td></tr>'. PHP_EOL;
				echo '<tr><td>Module Title: '.$moduleTitle.'</td></tr>'. PHP_EOL;
				echo '<tr><td>Tutor: '.$tutor.'</td></tr>'. PHP_EOL;
				echo '<tr><td>Marked Date: '.$markDate.'</td></tr>'. PHP_EOL;
				echo '</table>'. PHP_EOL;
				echo '<p>Student ID and Mark data read from file...</p>'. PHP_EOL;
				echo '<table>'. PHP_EOL;
				
			}else {
				# With the first line of the file processed we can proceed to the student numbers and grades.
				# Initialising variable for later.
				$error = false;
				$errorMsg = '';
				$studentNo = $details[0];
				$grade = $details[1];
				# The code here although repeated, would be longer over all if I had to use a function since we need the custom error message for each.
				# Here we are cheking both the length and whether it's all numbers.
				if ((strlen((string)$studentNo) == 8) && (ctype_digit($studentNo))){						
				}else {
					$error = true;
					$errorMsg = '- Incorrect student ID : not included';
				}
				# Here we are cheking both the length and whether it's all numbers.
				if ((strlen((string)$grade) <= 2) && (ctype_digit($grade))){
				}else {
					$error = true;
					$errorMsg = '- Incorrect mark : not included';
				}
				# Cheking for errors else proceeding to the grade classification.
				if ($error == false){
					
					echo '<tr><td>' . $studentNo . ':' . $grade . '</td></tr>'. PHP_EOL;
					# Adding student numbers and grades to an array that meet the criteria for use later.
					$includedStudent[] = $studentNo . ':' . $grade;
					if($grade > 69){
						$distinction = $distinction +1;
					}elseif ($grade > 59){
						$merit = $merit +1;
					}elseif ($grade > 39){
						$pass = $pass +1;
					}else {
						$fail = $fail +1;
					}
					# Array to use with the supplied function to calculate mean, mode and range.
					$meanModeRange[] = $grade;
					# Counter of students who have been correctly assessed.
					$students = $students +1;						
				}else {
					# Here we output the errors found earlier in either the student number or the grade.
					echo '<tr><td>' . $studentNo . ':' . $grade . $errorMsg . '</td></tr>'. PHP_EOL;
				}
				
			}
			
		# Closing the file as it is no longer necessary.
		}fclose($handle);		
		echo '</table>'. PHP_EOL;
		# We begin outputing the successfully assessed students here
		if($includedStudent){
			echo '<p>' . 'ID\'s and module marks to be included...' . '</p>'. PHP_EOL;
			# Looping through our $includedStudent array from earlier and displaying student number and grade.
			echo '<table>'. PHP_EOL;
			foreach ($includedStudent as $value){
				echo '<tr><td>' . $value . '</td></tr>'. PHP_EOL;
			}
			echo '</table>'. PHP_EOL;
			echo '<p>' . 'Statistical Analysis of module marks...' . '</p>'. PHP_EOL;
			
			#Using the supplied function to calculate mean,mode and range.
			$mean = mmmr($meanModeRange, 'mean');
			$mode = mmmr($meanModeRange, 'mode');
			$range = mmmr($meanModeRange, 'range');
			
			# Outputting the final results
			echo '<table>'. PHP_EOL;
			echo '<tr><td>Mean: ' . intCheck($mean) . '</td></tr>'. PHP_EOL;
			echo '<tr><td>Mode: ' . $mode . '</td></tr>'. PHP_EOL;
			echo '<tr><td>Range: ' . $range . '</td></tr>'. PHP_EOL;
			echo '<tr><td>#students: ' . $students . '</td></tr>'. PHP_EOL;
			echo '</table>'. PHP_EOL;
			echo '<p>Grade Distribution of module marks...</p>'. PHP_EOL;
			echo '<table>'. PHP_EOL;
			echo '<tr><td>Distinctions: ' . $distinction . '</td></tr>'. PHP_EOL;
			echo '<tr><td>Merit: ' . $merit . '</td></tr>'. PHP_EOL;
			echo '<tr><td>Pass: ' . $pass . '</td></tr>'. PHP_EOL;
			echo '<tr><td>Fail: ' . $fail . '</td></tr>'. PHP_EOL;
			echo '</table>'. PHP_EOL;
		}
	}	
	# Including our html footer from the includes folder.
	include 'includes/footer.php';
?>