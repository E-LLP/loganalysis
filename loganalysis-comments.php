<?php
	try { //useful way of reporting errors if it goes wrong

		$files = glob('*.zip'); //creates a simple array containing a list of all .zip files in the current folder

		$date = time(); //creates a timestamp for the output file

		$g = $tg = 0; //declaring and initialising variables we will later use for counting

		printf("Found %s zip files", number_format(count($files))); //formatted output to the command line to tell us it has found zip files

		$headings = "date time s-ip cs-method cs-uri-stem cs-uri-query s-port cs-username c-ip cs(User-Agent) sc-status sc-substatus sc-win32-status time-taken" . PHP_EOL; //the headings for the output file for later, you may need to change this depending on your server output setup

		foreach ($files as $file){ //start looping through the list of zip files

			$zip = new ZipArchive(); //initiate the ZipArchive class, built into PHP which helps us unzip files

			$zip->open($file); //open the zip file

			$l = 0; //initialise a line counting variable

			for($i=0;$i<$zip->numFiles;$i++){ //start looping through files within the zip archive

				$stat = $zip->statIndex($i); //get the file number within the zip archive

				$innerfiles = array($stat['name']); //get list of files within zip archive

				foreach($innerfiles as $innerfile){ //start looping through files within zip archive

					print "\r\nProcessing " . $file . "#" . $innerfile . "\r\n"; //Output feedback to command line to monitor progress

					$innerfile = fopen("zip://./" . $file . "#" . $innerfile, "r");	//Unzip and open the log file		

					if($innerfile){ //only progress if we successfully opened the file

						while(!feof($innerfile)){ //start looping through each line of the log file until it ends (not file end of file)

			  				$line = fgets($innerfile); //assign the line being processed to a variable

			  				$l++; //increment our line counter (not actually used)

			  				$googlebot = "Googlebot"; //set the string we are searching for

		  					if(strpos($line, $googlebot) !== FALSE){ //try and find the string we are searching for within the line, only proceed if found

			  					$g++; //increment the counter of googlebot instances within this file

			  					printf("\rFound %s Googlebot instances", $g); //print that number to the command line

			  					$tg++; //increment the total number of googlebot instances

			  					if($tg===1){ //on the first one we find, we can create the file with the headings first (prevents creating blank files)
			  						file_put_contents('output/'.$date.'googlebot.csv', $headings, FILE_APPEND);
			  					}

			  					file_put_contents('output/'.$date.'googlebot.csv', $line, FILE_APPEND); //output the line to our output file (if it contains googlebot)

			  				}

		  				}		  				
		  				
					}

					$g=0; //reset our googlebot counter
					
				}

			}

		}

		print "\rFound " . $tg . " total googlebot instances"; //output to command line when processing is finished

	}	catch(Exception $e){ //error reporting
            print($e->getMessage());
            die($e->getMessage());
        }

?>