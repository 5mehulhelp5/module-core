<?php

namespace Commerce365\Core\Model\Config\Source;

class LogLevel implements \Magento\Framework\Option\ArrayInterface
{
 public function toOptionArray()
 {
  return [
    ['value' => '0', 'label' => 'EMERGENCY'],
    //['value' => '1', 'label' => 'ALERT'],
    ['value' => '2', 'label' => 'CRITICAL'],
    ['value' => '3', 'label' => 'ERROR'],
    ['value' => '4', 'label' => 'WARN'],
    //['value' => '5', 'label' => 'NOTICE'],
    ['value' => '6', 'label' => 'INFO'],
    ['value' => '7', 'label' => 'DEBUG']
  ];
 }
}
