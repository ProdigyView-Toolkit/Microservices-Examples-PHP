<?php 
use prodigyview\util\Validator;
/**
 * Format
 * 
 * This is a template extension is used for quickly formatting data into
 * readable data by the user. For example 2011-08-19 12:30:00  is not very readable to the user.
 * This class has a function to convert it 08/19/2011 12:30
 */
class Format {
	
	/**
	 * Formats a number into a dollar. Example, 1.3 becomes $1.30
	 * 
	 * @param string $number
	 * 
	 * @return string
	 */
	public function currency($number) : string {
		return '$' . money_format('%i', $number);
	}
	
	public function number($number) : double {
		return number_format($number);
	}
	
	/**
	 * Converts a string into a date/time, regardless if that string is a MongoTimestamp,
	 * integer or a string.
	 * 
	 * @param mixed $timestamp
	 * @param string $format The format to convert the string too
	 * @param string $timezone An optional option for converting time zones
	 */
	public function dateTime($timestamp, $format = 'F j, Y, g:i a', $timezone = null) : string {
		
		if(is_a($timestamp, 'MongoDate') || is_a($timestamp, 'stdClass')) {
			return date($format, $timestamp -> sec);
		} else if(is_a($timestamp, '\MongoDB\BSON\UTCDateTime')) {
			if($timezone) {
				return $timestamp -> toDateTime() -> setTimezone ( new DateTimeZone($timezone) ) ->  format($format); 
			}
			
			return $timestamp -> toDateTime() -> format($format); 
		} else if(Validator::isInteger($timestamp)) {
		
			return date($format, $timestamp/1000);

		} else if(is_string($timestamp)) {
			if($timezone) {
				
				$date = new DateTime($timestamp); 
				$date->setTimezone(new DateTimeZone($timezone)); 
				  
				return $date->format($format);
				
			} else {
				$date = new DateTime($timestamp); 
				  
				return $date->format($format);
			}
		} 
		
		return $timestamp;
	}
	
	public function timeElapsed($timestamp) {
		$time = time() - strtotime($timestamp);

	    $tokens = array (
	        31536000 => 'year',
	        2592000 => 'month',
	        604800 => 'week',
	        86400 => 'day',
	        3600 => 'hour',
	        60 => 'minute',
	        1 => 'second'
	    );
	
	    foreach ($tokens as $unit => $text) {
	        if ($time < $unit) continue;
	        $numberOfUnits = floor($time / $unit);
	        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
	    }
	}
	
	/**
	 * For potentially malformated urls, this function with convert it to a formatted url.
	 * 
	 * @param string $text The text to convert to a ur
	 * @param string $target an ahref target like _blank, _self, etc
	 */
	public function href($text, $target = '') : string {
		return preg_replace("/ <a(.*?)>/", '<a$1 target="'. $target .'"> ',  $text);
		
		// The Regular Expression filter
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

		// Check if there is a url in the text
		if (preg_match($reg_exUrl, $text, $url)) {
			// make the urls hyper links
			return preg_replace($reg_exUrl, '<a href="' . $url[0] . '" rel="nofollow" target="' . $target . '" >' . $url[0] . '</a>', $text);
		} else {
			// if no urls in the text just return the text
			return $text;
		}
	}
	
	/**
	 * If a file is stored locally and contains the full file path,
	 * remove the begining of thepage
	 */
	public function parseImage($file) {
		return str_replace(SITE_PATH.'/public_html', '', $file);
	}
	
	public function secondsToHHMMSS($input) {
		$t = round($input);
  		return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
	}
	
	public function ogTag($content) {
		
		$content = str_replace('"', '\'', $content);
		
		return strip_tags($content);
	}
}
