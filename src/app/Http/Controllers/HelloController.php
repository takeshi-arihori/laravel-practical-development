<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
  public function index()
  {
    $data = [
      'msg' => 'this is sample message.',
    ];
    // resources/views/index.blade.php に $data を渡して表示
    return view('hello.index', $data);
  }
}
