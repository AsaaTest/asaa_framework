<?php

namespace Asaa\Crypto;

interface Hasher
{
    public function hash(string $input): string;
    public function verify(string $input, string $hash): bool;
}
