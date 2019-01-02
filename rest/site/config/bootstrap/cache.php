<?php
/**
 * Important Explanation
 * 
 * All the models in Helium use Cache when the caching is enabled. Cache by default
 * used the file system - which has limitations.
 * 
 * For this basic site, we are just goign to stick with file cache.
 */
use prodigyview\util\Cache;

Cache::init(array());