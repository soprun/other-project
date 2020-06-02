<?php

/**
 * @param string $input
 * @return bool
 */
function isValid($input)
{
  static $brackets = [
    '{' => '}',
    '[' => ']',
    '(' => ')',
    '<' => '>',
  ];

  $length = mb_strlen($input);

  if ($length < 2) {
    throw new Exception(
      'An error occurred and the string length does not match the expected length.'
    );
  }

  $stack = new SplStack();

  foreach (str_split($input) as $current => $symbol) {
    if (array_key_exists($symbol, $brackets) === true) {
      $stack->push($brackets[$symbol]);
      continue;
    }

    if ($stack->count() === 0) {
      throw new RuntimeException('Validation error occurred, no open brackets.');
    }

    if ($stack->pop() !== $symbol) {
      throw new LengthException(
        "An error occurred and the symbol {$current} requires a closed bracket of the same type."
      );
    }
  }

  if ($stack->count() > 0) {
    throw new RuntimeException(
      "There are {$stack->count()} open brackets left."
    );
  }

  return true;
}

echo PHP_EOL;

try {
  var_dump(isValid('')); // return false
  var_dump(isValid('()')); // return true
//  var_dump(isValid('(){}')); // return true
//  var_dump(isValid('(){}[]')); // return true

  echo PHP_EOL;
//  var_dump(isValid('}')); // return false
//  var_dump(isValid('}{')); // return false
//  var_dump(isValid('{{()}}')); // return false
//  var_dump(isValid('(}{((((>){[{{{([])]<')); // return false
} catch (Exception $exception) {
  echo $exception->getMessage();
}

echo '';
