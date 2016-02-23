<?php

namespace Exceptions;


use Components\TCollection;

class MultiException extends \Exception implements \ArrayAccess, \Iterator
{
    use TCollection;
}