<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 03/28/2019
 * Time: 8:42 AM
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class WelcomeController extends Controller
{
    public function index()
    {
        return View::make('welcome');
    }
}