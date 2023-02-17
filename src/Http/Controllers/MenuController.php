<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Menu;

class MenuController extends Controller
{
     /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Menu::class, 'menu');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $menus = Menu::all();
        return view('setting.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('setting.menus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $menu = Menu::create($request->all());
        return redirect()->route('setting.menus.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu): Response
    {
        return view('setting.menus.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu): Response
    {
        return view('setting.menu.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu): RedirectResponse
    {
        $menu->update($request->all());
        return redirect()->route('setting.menus.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu): RedirectResponse
    {
        $menu->delete();
        return back();
    }
}

