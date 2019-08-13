<?php


namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Word;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Show page with all words
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        $categories = Category::all();
        $words = Word::where([["usable", "=", true], ["category_id", "=", null]])->get();
        return view('categories', ['categories' => $categories, 'words' => $words]);
    }

    /**
     * Set word as not usable
     *
     * @return \Illuminate\Http\Response
     */
    public function discardWordById($id)
    {
        $word = Word::where("id", "=", $id)->first();
        if($word != null){
            $word->usable = false;
            $word->save();
        }
        return redirect()->route('categories');
    }

    /**
     * Select category
     *
     * @return \Illuminate\Http\Response
     */
    public function useExistingCategory(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'word_id' => 'required',
        ]);
        $category = Category::find($request->category_id);
        $word = Word::find($request->word_id);
        $word->category()->associate($category);
        $word->save();
        return redirect()->route('categories');
    }

    /**
     * Create category
     *
     * @return \Illuminate\Http\Response
     */
    public function createNewCategory(Request $request)
    {
        $request->validate([
            'category' => 'required|max:30',
            'word_id' => 'required',
        ]);
        $category = Category::create(['name' => $request->category]);
        $word = Word::find($request->word_id);
        $word->category()->associate($category);
        $word->save();
        return redirect()->route('categories');
    }
}
