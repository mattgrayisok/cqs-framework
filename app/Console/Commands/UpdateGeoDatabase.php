<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateGeoDatabase extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'updateGeoDB';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates or updates local geoDB';

	protected $progressStarted = false;
	protected $progressStep = 0;


	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{

		$this->output->section("Downloading New Database File");

		$url = "http://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz";
		$tempPath = storage_path().'/newgeo.gz';
		$tempPath2 = storage_path().'/newgeo';
		$finalPath = storage_path().'/geolite2city.mmdb';

		//Clean up any old files
		if(file_exists($tempPath)){
			unlink($tempPath);
		}
		if(file_exists($tempPath2)){
			unlink($tempPath2);
		}

		//Download new version
		set_time_limit(0);
		$fp = fopen ($tempPath, 'w+');
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, function($resource,$download_size, $downloaded, $upload_size, $uploaded){

			if($download_size == 0){
				return;
			}

			if(!$this->progressStarted){
				$this->output->progressStart($download_size);
				$this->progressStarted = true;
			}

			$this->output->progressAdvance($downloaded - $this->progressStep);
			$this->progressStep = $downloaded;

		});
		curl_setopt($ch, CURLOPT_NOPROGRESS, false);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);

		$this->output->newLine(2);
		$this->output->section("Extracting new DB file");

		//Extract GZ version
		$totalSize = filesize($tempPath);
		$buffer_size = 4096;
		$file = gzopen($tempPath, 'rb');
		$out_file = fopen($tempPath2, 'wb');
		$this->output->progressStart($totalSize);
		while(!gzeof($file)) {
			fwrite($out_file, gzread($file, $buffer_size));
			$this->output->progressAdvance($buffer_size);
		}

		fclose($out_file);
		gzclose($file);

		$this->output->newLine(2);
		$this->output->section("Replacing old version");

		//Replace existing DB with new one
		if(file_exists($finalPath)){
			unlink($finalPath);
		}
		rename($tempPath2, $finalPath);

		//Clean up
		if(file_exists($tempPath)){
			unlink($tempPath);
		}
		if(file_exists($tempPath2)){
			unlink($tempPath2);
		}

	}

}
