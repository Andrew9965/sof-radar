<?php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RemoteDataControler extends Controller
{
    public function get($name, Request $request)
    {
        $name = ucfirst($name);
        $call = eval("return new \App\Admin\Controllers\RemoteDataControllers\Remote{$name}Controller();");
        return $call->get($request, $name);
    }
    public function select($name, Request $request)
    {
        $name = ucfirst($name);
        $call = eval("return new \App\Admin\Controllers\RemoteDataControllers\Remote{$name}Controller();");
        return $call->select($request, $name);
    }
    public function insert($name, Request $request)
    {
        $name = ucfirst($name);
        $call = eval("return new \App\Admin\Controllers\RemoteDataControllers\Remote{$name}Controller();");
        return $call->insert($request, $name);
    }
    public function update($name, Request $request)
    {
        $name = ucfirst($name);
        $call = eval("return new \App\Admin\Controllers\RemoteDataControllers\Remote{$name}Controller();");
        return $call->update($request, $name);
    }
    public function delete($name, Request $request)
    {
        $name = ucfirst($name);
        $call = eval("return new \App\Admin\Controllers\RemoteDataControllers\Remote{$name}Controller();");
        return $call->delete($request, $name);
    }
}