<?php
class StrlenCustomRule {

    public function isValid($value, $parameters): bool {
        return strlen((string) $value) > $parameters[0];
    }
}