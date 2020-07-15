<?php
namespace Motniemtin\Auto;

use Exception;
class FileTool{
  public function ExtractGz($gzPath, $outPath){
      // open the gzip file
      $gz = gzopen($gzPath, 'rb');
      if (!$gz) {
          throw new \UnexpectedValueException(
              'Could not open gzip file'
          );
      }
      $dest = fopen($outPath, 'wb');
      if (!$dest) {
          gzclose($gz);
          throw new \UnexpectedValueException(
              'Could not open destination file'
          );
      }
      stream_copy_to_stream($gz, $dest);
      gzclose($gz);
      fclose($dest);
  }
}
