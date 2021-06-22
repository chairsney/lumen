<?php

namespace App\Http\Controllers;

use App\Traits\JsonTrait;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use JsonTrait;
}
