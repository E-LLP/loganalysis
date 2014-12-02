loganalysis
===========

Script to export googlebot instances from zipped log files. 

## Organising the files

The script supplied will only work if log files are zipped up, and only one zip file deep. Typically log files will come zipped from a client or webserver due to their large filesize. Ideally you will have:

* All log files are zipped, only one file deep
 * i.e. `logfiles.zip` contains `logfile1.log` `logfile2.log` `logfile3.log` etc
 * Or several zip files, i.e. `logfiles1.zip` contains `logfile1.log` and `logfiles2.zip` contains `logfile2.log` and `logfile3.log`
* Zip files containing logs are in a single folder
* Files have ".zip" filename, not .gzip or .rar or other (modify the script if using something other than zip)
* Create an empty folder called "output" in the same folder

## Writing and running the script

First install PHP for Windows so that you can execute your PHP script. Then paste the following into your favourite text processor, and save as "loganalysis.php" in the same folder as your zipped log files:

The command line should give you a series of interface feedbacks indicating it is finding instances of Googlebot in your log files. Once it is complete, it will export the found log files into your "output" folder, which you should be able to open within Excel.

## Verifying Googlebot instances

Once the script has exported all lines containing "googlebot" (that's all it does) then we need to ensure those instances are qualified, i.e. are actually coming from Google's servers. It's very common for crawlers and scrapers to mimic Googlebot's user agent when crawling a site (editing your own headers is very easy to do) and so we need to do a '''reverse DNS lookup''' in order to check they came from Google's official servers.


## Analysing the data 

Analysis is down to you, but some ideas to get you started:

* `COUNTIF` for wildcard matches of particular folder sets. For example, COUNTIF with criteria `*/shop/*` will give the number of times Googlebot hit that particular folder. Done for every folder on the site will give a good picture of where Googlebot hits most often
* Examine instances of 4xx and 3xx errors which may not appear in WMT
