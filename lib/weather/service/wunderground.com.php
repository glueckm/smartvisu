<?php
/**
 * -----------------------------------------------------------------------------
 * @package     smartVISU
 * @author      Martin Gleiß & Pierre-Yves
 * @copyright   2012
 * @license     GPL <http://www.gnu.de>
 * ----------------------------------------------------------------------------- 
 */


require_once '../../../config.php';
require_once const_path_system.'weather/weather.php';
require_once const_path_system.'class_cache.php';
    

/** 
 * This class generates a weather
 */   
class weather_wunderground extends weather
{

  /** 
	* retrieve the content
	*/     
    public function run()
    {
        // api call 
        $cache = new class_cache('wunderground_'.$this->location.'.json');
        
        if ($cache->hit())
            $parsed_json = json_decode($cache->read());
        else
        {
		    if (config_lang == 'fr')
	            	$url = 'http://api.wunderground.com/api/'.config_weather_key.'/conditions/forecast/lang:FR/q/'.$this->location.'.json';
		    elseif (config_lang == 'de')
		        $url = 'http://api.wunderground.com/api/'.config_weather_key.'/conditions/forecast/lang:DL/q/'.urlencode($this->location).'.json';
		    elseif (config_lang == 'de')
		        $url = 'http://api.wunderground.com/api/'.config_weather_key.'/conditions/forecast/lang:NL/q/'.urlencode($this->location).'.json';
		    else
		        $url = 'http://api.wunderground.com/api/'.config_weather_key.'/conditions/forecast/lang:EN/q/'.urlencode($this->location).'.json';
	    
            $parsed_json = json_decode($cache->write(file_get_contents($url)));
        }
        $this->debug($parsed_json);  
          
        if($parsed_json)
        {
            // today
            $this->data['city'] = (string)$parsed_json->{'current_observation'}->{'display_location'}->{'city'};
            
            if (config_lang == 'de')
                $this->data['current']['temp'] = (int)$parsed_json->{'current_observation'}->{'temp_c'}.'&deg;C';
            elseif (config_lang == 'nl')
                $this->data['current']['temp'] = (int)$parsed_json->{'current_observation'}->{'temp_c'}.'&deg;C';
            elseif (config_lang == 'fr')
                $this->data['current']['temp'] = (int)$parsed_json->{'current_observation'}->{'temp_c'}.'&deg;C';
            else
                $this->data['current']['temp'] = (int)$parsed_json->{'current_observation'}->{'temp_f'}.'&deg;F';
            
            $this->data['current']['conditions']   = (string)$parsed_json->{'current_observation'}->{'weather'};
            $this->data['current']['icon']         = $this->icon((string)$parsed_json->{'current_observation'}->{'icon'}, $this->icon_sm);

		 // get the good values by countries in km/h or mph for the wind and gusts
		if ((config_lang == 'de') || (config_lang == 'nl') || (config_lang == 'fr'))
		{
			$wind_speed = (int)$parsed_json->{'current_observation'}->{'wind_kph'};
			$wind_gust = (int)$parsed_json->{'current_observation'}->{'wind_gust_kph'};
			$unit = 'km/h';
		}
		else
		{
			$wind_speed = (int)$parsed_json->{'current_observation'}->{'wind_mph'};
			$wind_gust = (int)$parsed_json->{'current_observation'}->{'wind_gust_mph'};
			$unit = 'mph';
		}

		$wind_direction = translate((string)$parsed_json->{'current_observation'}->{'wind_dir'},'wunderground');

		// in french, there is a difference when the word stars with a vowel
	    // de (from) becomes d'
	    // can be use if a language has the same exception
	    if (config_lang == 'fr')
	    {
			if ((substr($wind_direction,0,1) == 'O') || (substr($wind_direction,0,1) == 'E'))
				$from=translate('fromEW','wunderground');
			else
				$from=translate('fromNS','wunderground');
	    }
	    else
			$from = translate('from','wunderground');

	    // when the wind has no fix direction from is blank
	    if ((string)$parsed_json->{'current_observation'}->{'wind_dir'} == 'Variable')
		$from = '';

            $this->data['current']['wind'] = translate('wind','wunderground')." ".$from." ".$wind_direction."&nbsp;&nbsp;".translate('wind_speed','wunderground')." ".$wind_speed."".$unit;
            if($wind_gust > 0)
            {
                $this->data['current']['wind'] = $this->data['current']['wind']."<P>".translate('wind_gust','wunderground').": ".$wind_gust."".$unit."</P>";
            }
            $this->data['current']['more'] = translate('humidity','wunderground').": ".(string)$parsed_json->{'current_observation'}->{'relative_humidity'};

            // forecast
            $i=0;
            foreach($parsed_json->{'forecast'}->{'simpleforecast'}->{'forecastday'} as $day)
            {
                $this->data['forecast'][$i]['date']        = (string)$day->{'date'}->{'year'}.'-'.(string)$day->{'date'}->{'month'}.'-'.(string)$day->{'date'}->{'day'};
                $this->data['forecast'][$i]['conditions']  = (string)$day->{'conditions'}; 
                $this->data['forecast'][$i]['icon']        = $this->icon((string)$day->{'icon'});
                $this->data['forecast'][$i]['temp']        = (int)$day->{'low'}->{'celsius'}.'&deg;/'.(int)$day->{'high'}->{'celsius'}.'&deg;';
                $i++;
            }
        }
        else
            $this->error('Weather: wounderground.com', 'Read request failed!');
    }


   /*
    * Icon-Mapper
    */
    function icon($name, $sm = 'sun_')
    {
        $ret = '';

		$icon['sunny']              = $sm.'1';
		$icon['mostlysunny']        = $sm.'2';
		$icon['clear']              = $sm.'2';
		$icon['partlycloudy']       = $sm.'3';
		$icon['mostlycloudy']       = $sm.'5';
		$icon['mist']               = $sm.'6';
		$icon['chancerain']         = $sm.'7';
		$icon['rain']               = 'cloud_8';
		$icon['chancestorm']        = $sm.'9';
		$icon['storm']              = $sm.'10';
		$icon['chancesnow']         = $sm.'11';
		$icon['snow']               = $sm.'12';

		$icon['cloudy']             = 'cloud_4';
		$icon['showers']            = 'cloud_8';
		$icon['chancetstorms']      = 'cloud_10';
		$icon['thunderstorm']       = 'cloud_10';
		$icon['tstorms']            = 'cloud_10';
		$icon['rain_snow']          = 'cloud_15';
		$icon['foggy']              = 'cloud_6';
		$icon['fog']                = 'cloud_6';
		$icon['icy']                = 'cloud_16';
		$icon['smoke']              = 'na';
		$icon['dusty']              = 'na';
		$icon['hazy']               = 'na';

		$ret = $icon[$name];
        
        return $ret;
    }   

}


// -----------------------------------------------------------------------------
// call the service
// -----------------------------------------------------------------------------

$service = new weather_wunderground(array_merge($_GET, $_POST));
echo $service->json();

?>
