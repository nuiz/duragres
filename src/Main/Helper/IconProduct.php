<?php
namespace Main\Helper;

class IconProduct
{
  private static $dir = "icon";
  private static $icons = [];

  public static function getIcons()
  {
    $rii = new\ RecursiveIteratorIterator(new \RecursiveDirectoryIterator(self::$dir));
    $files = [];
    foreach ($rii as $file) {
      if ($file->isDir()){
        continue;
      }
      $files[] = $file->getFileName();
    }

    return $files;
  }
}
