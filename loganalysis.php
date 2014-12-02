<?php
	try {
		$files = glob('*.zip');

		$date = time();

		$g = $tg = 0;

		/*print "Found " . count($files) . " zip files in this directory\r\n";*/

		printf("Found %s zip files", number_format(count($files)));

		$headings = "date time s-ip cs-method cs-uri-stem cs-uri-query s-port cs-username c-ip cs(User-Agent) sc-status sc-substatus sc-win32-status time-taken" . PHP_EOL;

		foreach ($files as $file){

			$zip = new ZipArchive();

			$zip->open($file);

			$l = 0;

			for($i=0;$i<$zip->numFiles;$i++){
				$stat = $zip->statIndex($i);
				$innerfiles = array($stat['name']);

				foreach($innerfiles as $innerfile){
					print "\r\nProcessing " . $file . "#" . $innerfile . "\r\n";

					$innerfile = fopen("zip://./" . $file . "#" . $innerfile, "r");					

					if($innerfile){
						while(!feof($innerfile)){
			  				$line = fgets($innerfile);

			  				$l++;

			  				$googlebot = "Googlebot";

		  					if(strpos($line, $googlebot) !== FALSE){

			  					$g++;

			  					printf("\rFound %s Googlebot instances", $g);

			  					$tg++;

			  					if($tg===1){
			  						file_put_contents('output/'.$date.'googlebot.csv', $headings, FILE_APPEND);
			  					}

			  					file_put_contents('output/'.$date.'googlebot.csv', $line, FILE_APPEND);

			  				}

		  				}		  				
		  				
					}

					/*print "\r\nFound " . $g . " googlebot instances";*/

					$g=0;
					
				}

			}

		}

		print "\rFound " . $tg . " total googlebot instances";

	}	catch(Exception $e){
            print($e->getMessage());
            die($e->getMessage());
        }

?>