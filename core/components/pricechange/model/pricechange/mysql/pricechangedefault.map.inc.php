<?php
$xpdo_meta_map['PriceChangeDefault']= array (
  'package' => 'pricechange',
  'version' => '1.1',
  'table' => 'pricechange_default',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'MyISAM',
  ),
  'fields' => 
  array (
    'type' => NULL,
    'tv_name' => NULL,
    'scope' => NULL,
    'categories' => NULL,
  ),
  'fieldMeta' => 
  array (
    'type' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
    ),
    'tv_name' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'scope' => 
    array (
      'dbtype' => 'int',
      'phptype' => 'integer',
      'null' => false,
    ),
    'categories' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
  ),
);
