<?php

namespace App\Utils;

abstract class UserListEnum {
    const FOLLOWING  = "FOLLOWING";
    const FOLLOWERS  = "FOLLOWERS";
    const FOLLOWED   = "FOLLOWED";
    const LIKED      = "LIKED";
    const COMMENTED  = "COMMENTED";
}