<?php 
	// auto-generated by the phing olson task at 11/03/2006 07:32:19
	return array (
  'types' => 
  array (
    0 => 
    array (
      'rawOffset' => 39600,
      'dstOffset' => 0,
      'name' => 'MHT',
    ),
    1 => 
    array (
      'rawOffset' => -43200,
      'dstOffset' => 0,
      'name' => 'KWAT',
    ),
    2 => 
    array (
      'rawOffset' => 43200,
      'dstOffset' => 0,
      'name' => 'MHT',
    ),
  ),
  'rules' => 
  array (
    0 => 
    array (
      'time' => -2177492960,
      'type' => 0,
    ),
    1 => 
    array (
      'time' => -7988400,
      'type' => 1,
    ),
    2 => 
    array (
      'time' => 745848000,
      'type' => 2,
    ),
  ),
  'finalRule' => 
  array (
    'type' => 'static',
    'name' => 'MHT',
    'offset' => 43200,
    'startYear' => 1994,
  ),
  'name' => 'Pacific/Kwajalein',
)
?>