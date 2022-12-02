<?php

namespace Lib\Utils;

function redirect(string $url): never
{
    header("Location: $url");
    exit();
}
