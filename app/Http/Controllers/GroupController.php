<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Tables\GroupTable;
use App\Tables\UserGroupTable;
use App\Tables\UserTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('group/index', [
            'table' => (new GroupTable())->setup()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Group $group)
    {
        return view('group/form', [
            'group' => $group
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Group::create($request->only((new Group())->getFillable()));
        return redirect()->route('groups.index')->with('success', 'Група успешно создана');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return view('group/show', [
            'group' => $group,
            'table' => (new UserGroupTable($group))->setup(),
            'users' => User::whereDoesntHave('groups', function ($query) use ($group) {
                $query->where('groups.id', $group->id);
            })->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('group/form', [
            'group' => $group
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $group->update($request->only((new Group())->getFillable()));
        return redirect()->route('groups.index')->with('success', 'Группа успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('groups.index')->with('success', 'Группа успешно удалена');
    }
}
