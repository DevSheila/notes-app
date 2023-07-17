<?php

namespace App\Http\Controllers;

use App\NoteItem;
use Illuminate\Http\Request;

/**
 * Class NoteItemController
 * @package App\Http\Controllers
 */
class NoteItemController extends Controller
{
    /**
     * Show the notes page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('notes');
    }

    /**
     * Returns notes as json response
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function notes(Request $request)
    {
        return response()->json(NoteItem::all());
    }

    /**
     * Creates and stores noteItem to database.
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        /**
         * Valiate the name
         */
        $this->validate($request, [
            'name' => ['required',  'string', 'min:5', 'max:50', 'unique:note_items,name']
        ]);

        $noteItem = new NoteItem();
        $noteItem->name = $request->name;
        $noteItem->save();

        return $noteItem;
    }

    /**
     * Updates a note item
     * @param Request $request
     * @param NoteItem $noteItem
     * @return NoteItem
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, NoteItem $noteItem)
    {
        /**
         * Validate the request,
         * Exempt the current NoteItem if the name has not changed
         */
        $this->validate($request, [
            'name' => ['required', 'string', 'min:5', 'max:50', 'unique:note_items,name,' . $noteItem->id]
        ]);

        $noteItem->name = $request->name;
        $noteItem->save();

        return $noteItem;
    }

    public function destroy(Request $request, NoteItem $noteItem)
    {
        $noteItem->delete();
        return response()->json(null, 204);
    }
}
