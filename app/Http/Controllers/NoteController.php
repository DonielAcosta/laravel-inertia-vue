<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
  
  /**
   * It returns an Inertia view called `Notes/Index` and passes it an array of notes that are the
   * latest and match the search query
   * 
   * @param Request request The request object.
   * 
   * @return Inertia::render('Notes/Index', [
   *           'notes' => Note::latest()
   *               ->where('excerpt', 'LIKE', "%->q%")
   *               ->get()
   *       ]);
   */
  public function index(Request $request){

    return Inertia::render('Notes/Index', [
        'notes' => Note::latest()
            ->where('excerpt', 'LIKE', "%$request->q%")
            ->get()
    ]);
  }

 /**
  * It returns a view called `Notes/Create`
  * 
  * @return Inertia::render('Notes/Create')
  */
  public function create(){
      return Inertia::render('Notes/Create');
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'excerpt' => 'required',
            'content' => 'required',
        ]);

        $note = Note::create($request->all());

        return redirect()->route('notes.edit', $note->id)->with('status', 'Nota creada');
    }

 
  /**
   * It returns a view called `Notes/Show` and passes the `` variable to the view
   * 
   * @param Note note This is the note that we're going to show.
   * 
   * @return Inertia::render('Notes/Show', compact('note'));
   */
  public function show(Note $note){

    return Inertia::render('Notes/Show', compact('note'));
  }


  /**
   * It returns the Inertia view for the edit page, passing in the note
   * 
   * @param Note note The note object that we're editing.
   * 
   * @return Inertia::render('Notes/Edit', compact('note'));
   */
  public function edit(Note $note){

    return Inertia::render('Notes/Edit', compact('note'));
  }

  /**
   * It receives a request, validates it, updates the note and redirects the user to the notes index
   * page with a status message
   * 
   * @param Request request The request object.
   * @param Note note This is the model that we're going to use to retrieve the note that we want to
   * update.
   * 
   * @return The note is being updated with the new information.
   */
    
  public function update(Request $request, Note $note){

    $request->validate([
        'excerpt' => 'required',
        'content' => 'required',
    ]);

    $note->update($request->all());

    return redirect()->route('notes.index')->with('status', 'Nota actualizada');
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('notes.index')->with('status', 'Nota eliminada');
    }
}
