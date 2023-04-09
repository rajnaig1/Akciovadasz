<?php 
namespace Tests;
class TestUtilities{
    public static function getMethod($class,$name) {
        $class = new \ReflectionClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
      }
}
