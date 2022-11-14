<?php
class StringTools
{
  public static function convertForLog($variable) {
    if ($variable === null) {
      return 'null';
    }
    if ($variable === false) {
      return 'false';
    }
    if ($variable === true) {
      return 'true';
    }
    if (is_array($variable)) {
      return json_encode($variable);
    }
    return $variable ? $variable : "";
  }

  public static function toAsciiTable($array, $fields, $wrapLength) {
    // get max length of fields
    $fieldLengthMap = [];
    foreach ($fields as $field) {
      $fieldMaxLength = 0;
      foreach ($array as $item) {
        $value = self::convertForLog($item[$field]);
        $length = strlen($value);
        $fieldMaxLength = $length > $fieldMaxLength ? $length : $fieldMaxLength;
      }
      $fieldMaxLength = $fieldMaxLength > $wrapLength ? $wrapLength : $fieldMaxLength;
      $fieldLengthMap[$field] = $fieldMaxLength;
    }

    // create table
    $asciiTable = "";
    $totalLength = 0;
    foreach ($array as $item) {
      // prepare next line
      $valuesToLog = [];
      foreach ($fieldLengthMap as $field => $maxLength) {
        $valuesToLog[$field] = self::convertForLog($item[$field]);
      }

      // write next line
      $lineIsWrapped = true;
      while ($lineIsWrapped) {
        $lineIsWrapped = false;
        foreach ($fieldLengthMap as $field => $maxLength) {
          $valueLeft = $valuesToLog[$field];
          $valuesToLog[$field] = "";
          if (strlen($valueLeft) > $maxLength) {
            $valuesToLog[$field] = substr($valueLeft, $maxLength);
            $valueLeft = substr($valueLeft, 0, $maxLength);
            $lineIsWrapped = true;
          }
          $asciiTable .= "| {$valueLeft} " . str_repeat(" ", $maxLength - strlen($valueLeft));
        }
        $totalLength = $totalLength === 0 ? strlen($asciiTable) + 1 : $totalLength;
        $asciiTable .= "|\n";
      }
    }

    // add lines before and after
    $horizontalLine = str_repeat("-", $totalLength);
    $asciiTable = "{$horizontalLine}\n{$asciiTable}{$horizontalLine}\n";
    return $asciiTable;
  }
};
?>
<?php
class tes {
    
public function handle() {
    $array = [
        ["name" => "something here", "description" => "a description here to see", "value" => 3],
        ["name" => "and a boolean", "description" => "this is another thing", "value" => true],
        ["name" => "a duck and a dog", "description" => "weird stuff is happening", "value" => "truly weird"],
        ["name" => "with rogue field", "description" => "should not show it", "value" => false, "rogue" => "nie"],
        ["name" => "some kind of array", "description" => "array i tell you", "value" => [3, 4, 'banana']],
        ["name" => "can i handle null?", "description" => "let's see", "value" => null],
    ];
    $table = StringTools::toAsciiTable($array, ["name", "value", "description"], 50);
    print_r($table);
  }

}