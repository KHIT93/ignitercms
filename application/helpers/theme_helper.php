<?php
function parse_info_file($filepath = NULL) {
    $info = array();

    if (!isset($info[$filepath])) {
      if (!file_exists($filepath)) {
        $info[$filepath] = array();
      }
      else {
        $data = file_get_contents($filepath);
        $info[$filepath] = parse_info_format($data);
      }
    }
    return $info[$filepath];
}
function parse_info_format($data) {
    $info = array();
    $constants = get_defined_constants();

    if (preg_match_all('
      @^\s*                           # Start at the beginning of a line, ignoring leading whitespace
      ((?:
        [^=;\[\]]|                    # Key names cannot contain equal signs, semi-colons or square brackets,
        \[[^\[\]]*\]                  # unless they are balanced and not nested
      )+?)
      \s*=\s*                         # Key/value pairs are separated by equal signs (ignoring white-space)
      (?:
        ("(?:[^"]|(?<=\\\\)")*")|     # Double-quoted string, which may contain slash-escaped quotes/slashes
        (\'(?:[^\']|(?<=\\\\)\')*\')| # Single-quoted string, which may contain slash-escaped quotes/slashes
        ([^\r\n]*?)                   # Non-quoted string
      )\s*$                           # Stop at the next end of a line, ignoring trailing whitespace
      @msx', $data, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            // Fetch the key and value string.
            $i = 0;
            foreach (array('key', 'value1', 'value2', 'value3') as $var) {
              $$var = isset($match[++$i]) ? $match[$i] : '';
            }
            $value = stripslashes(substr($value1, 1, -1)) . stripslashes(substr($value2, 1, -1)) . $value3;

            // Parse array syntax.
            $keys = preg_split('/\]?\[/', rtrim($key, ']'));
            $last = array_pop($keys);
            $parent = &$info;

            // Create nested arrays.
            foreach ($keys as $key) {
              if ($key == '') {
                $key = count($parent);
              }
              if (!isset($parent[$key]) || !is_array($parent[$key])) {
                $parent[$key] = array();
              }
              $parent = &$parent[$key];
            }

            // Handle PHP constants.
            if (isset($constants[$value])) {
              $value = $constants[$value];
            }

            // Insert actual value.
            if ($last == '') {
              $last = count($parent);
            }
            $parent[$last] = $value;
        }
    }
    return $info;
}
function isInfoFile($filepath) {
    return (pathinfo($filepath, PATHINFO_EXTENSION) == 'info') ? true : false;
}
function isRegistryFile($filepath) {
    return (pathinfo($filepath, PATHINFO_EXTENSION) == 'info') ? true : false;
}
function breadcrumb($uri_string) {
    $uri = array();
    foreach ($uri_string as $value) {
        $uri[] = ucfirst($value);
    }
    return '<ol class="breadcrumb">'."\n\x20\x20\x20\x20".'<li>'.implode('</li>'."\n\x20\x20\x20\x20".'<li>', $uri).'</li>'."\n\x20\x20\x20\x20".'</ol>';
}