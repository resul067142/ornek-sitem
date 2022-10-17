<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Uyeler;

class YetkiController extends Controller
{
    public function roller()
    {
        return response()
            ->json(Role::all());
    }

    public function rolEkle(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:100',
            ]
        );

        $role = Role::create(['name' => $request->name]);

        return $role;
    }

    public function rolSil(Request $request)
    {
        $request->validate(
            [
                'id' => 'required|integer|exists:roles,id',
            ]
        );

        Role::find($request->id)->delete();

        return response()->json([ 'status' => 'ok' ]);
    }

    public function rolYetkilendir(Request $request)
    {
        $request->validate(
            [
                'role_id' => 'required|integer',
                'permission_id' => 'required|integer',
            ]
        );

        $role = Role::findOrFail($request->role_id);
        $permission = Permission::findOrFail($request->permission_id);

        $role->givePermissionTo($permission->name);

        return response()->json([
            'role' => $role,
            'permission' => $permission
        ]);
    }

    public function kullaniciyaRolAta(Request $request)
    {
        $request->validate(
            [
                'role_id' => 'required|integer',
                'kullanici_id' => 'required|integer',
            ]
        );

        $role = Role::findOrFail($request->role_id);
        $kullanici = Uyeler::findOrFail($request->kullanici_id);

        $kullanici->assignRole($role);

        return response()->json([
            'role' => $role,
            'kullanici' => $kullanici
        ]);
    }

    public function kullanidanRolSil(Request $request)
    {
        $request->validate(
            [
                'role_id' => 'required|integer',
                'kullanici_id' => 'required|integer',
            ]
        );

        $role = Role::findOrFail($request->role_id);
        $kullanici = Uyeler::findOrFail($request->kullanici_id);

        $kullanici->removeRole($role);

        return response()->json([
            'role' => $role,
            'kullanici' => $kullanici
        ]);
    }

    public function kullaniciyaYetkiAta(Request $request)
    {
        $request->validate(
            [
                'permission_id' => 'required|integer',
                'kullanici_id' => 'required|integer',
            ]
        );

        $permission = Permission::findOrFail($request->permission_id);
        $kullanici = Uyeler::findOrFail($request->kullanici_id);

        $kullanici->givePermissionTo($permission->name);

        return response()->json([
            'role' => $permission,
            'kullanici' => $kullanici
        ]);
    }

    /**
     */

    public function yetkiler()
    {
        return response()->json(Permission::all());
    }

    public function yetkiEkle(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:100',
            ]
        );

        $permission = Permission::create(['name' => $request->name]);

        return response()->json($permission);
    }

    public function yetkiSil(Request $request)
    {
        $request->validate(
            [
                'id' => 'required|exists:permissions,id',
            ]
        );

        Permission::find($request->id)->delete();

        return response()->json([ 'status' => 'ok' ]);
    }


}
