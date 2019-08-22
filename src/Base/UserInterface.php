<?php

namespace BOK\Base;

interface UserInterface
{
    public function getEmail();

    public function getUserId();

    public function getClassInstance();

    public function getFullNameAttribute();
}
