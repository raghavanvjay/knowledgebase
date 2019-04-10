<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Author;
use App\Entry;
use App\Tag;
use DB;

class EntryController extends Controller
{
    public function entry_submit(Request $request)
    {
        $this->validate($request, [
            'author' => 'required',
            'title' => 'required',
            'description'  => 'required',
        ]);

        $author_name = $this->escape_input($request['author']);

        //add entry to the author table
        $author = Author::firstOrCreate(['name' => $author_name]);

        //Next insert/update the entry in the entry table
        if( !empty($request['ei']) )
        {
            $entry = Entry::find($request['ei']);
            if(empty($entry))
                $entry = new Entry();
        }
        else
            $entry = new Entry();
        $entry->title = $this->escape_input($request['title']);
        $entry->description = $this->escape_input($request['description']);
        $entry->solution = $this->escape_input($request['solution']);
        $author->entries()->save($entry);
        $tags = $this->escape_input($request['tags_attached']);

        if(!empty($tags))
        {
            $entry->tags()->detach();
            $tag_ids = explode(',',$tags);
            foreach($tag_ids as $tag_id)
                $entry->tags()->attach($tag_id);

        }
        if(Auth::check())
            return redirect()->route('entry_add',['ei'=>$entry->id])->with(['success'=>'Entry saved!']);
        return redirect()->route('entry_list')->with(['success'=>'Entry saved!']);

    }

    public function escape_input( $input)
    {
        $input = addslashes(strip_tags($input, '<br><p><b><i>'));
        return trim($input);
    }

    public function get_author_entries($s)
    {
        $entries = Entry::WhereHas('author',function($query) use($s){
                        $query->where('name',$s);
                })->paginate(5);

        $tags = Tag::orderBy('name')->get();
        $tag_classes = array('btn-primary', 'btn-default', 'btn-warning', 'btn-info');
        return view('entries.list',['entries' => $entries, 's' => $s, 'tags'=>$tags, 'tag_classes' => $tag_classes]);

    }

    public function get_tag_entries($ti)
    {
        $entries = Entry::WhereHas('tags',function($query) use($ti){
                        $query->where('tags.id',$ti);
                })->paginate(5);

        $tag = Tag::find($ti);
        $s = $tag ? $tag->name : '';
        $tags = Tag::orderBy('name')->get();

        $tag_classes = array('btn-primary', 'btn-default', 'btn-warning', 'btn-info');
        return view('entries.list',['entries' => $entries, 's' => $s, 'tags'=>$tags, 'tag_classes' => $tag_classes]);

    }

    public function get_entries_to_list($request, $per_page = 5)
    {
        if(!empty(trim($request['s'])))
        {
            $keywords = $this->sanitize_split_keywords($request['s']);
            if($request['search_deep'])
            {
                $entries = Entry::orWhereHas('author',function($query) use($keywords){
                    foreach($keywords as $i=>$keyword)
                    {
                        if($i==0)
                            $query->where('name',$keyword);
                        else
                            $query->orWhere('name',$keyword);
                    }
                })
                ->orwhere(function($query) use($keywords){
                    foreach($keywords as $i=>$keyword)
                    {
                        if($i==0)
                            $query->where('title',$keyword);
                        else
                            $query->orWhere('title',$keyword);
                    }
                })
                ->orwhere(function($query) use($keywords){
                    foreach($keywords as $i=>$keyword)
                    {
                        if($i==0)
                            $query->where('description','LIKE', '%'.$keyword.'%');
                        else
                            $query->orWhere('description','LIKE','%'.$keyword.'%');
                    }
                })
                ->orwhere(function($query) use($keywords){
                    foreach($keywords as $i=>$keyword)
                    {
                        if($i==0)
                            $query->where('solution','LIKE', '%'.$keyword.'%');
                        else
                            $query->orWhere('solution','LIKE', '%'.$keyword.'%');
                    }
                })
                ->paginate($per_page);
            }
            else
            {
                $entries = Entry::where(function($query) use($keywords){
                    foreach($keywords as $i=>$keyword)
                    {
                        if($i==0)
                            $query->where('title','like','%'.$keyword.'%');
                        else
                            $query->orWhere('title','like','%'.$keyword.'%');
                    }
                })
                ->orWhereHas('author',function($query) use($keywords){
                    foreach($keywords as $i=>$keyword)
                    {
                        if($i==0)
                            $query->where('name',$keyword);
                        else
                            $query->orWhere('name',$keyword);
                    }
                })
                ->paginate($per_page);
            }
        }
        else
        {
            $entries = Entry::with('author','tags')->orderBy('created_at','DESC')->paginate($per_page);
        }
        return $entries;
    }

    public function get_entries(Request $request)
    {
        $entries = $this->get_entries_to_list($request);
        $tags = Tag::orderBy('name')->get();
        $tag_classes = array('btn-primary', 'btn-default', 'btn-warning', 'btn-info');
        return view('entries.list',['entries' => $entries, 's' => $request['s'], 'tags'=>$tags, 'tag_classes' => $tag_classes]);
    }

    public function get_manage_entries(Request $request)
    {
        $entries = $this->get_entries_to_list($request, 10);

        return view('entries.manage_list',['entries' => $entries, 's' => $request['s']]);
    }

    public function sanitize_split_keywords($keywords)
    {
        //remove commas
        $patterns[1] = '/\s+/';
        $replacements[1] = ' ';
        $patterns[0] = '/,/';
        $replacements[0] = '';

        $keywords = preg_replace($patterns,$replacements,trim($keywords));
        //strip tags
        $keywords = strip_tags($keywords);
        //add slashes
        $keywords = addslashes($keywords);

        //split by spaces
        return array_filter(explode(' ',$keywords));

    }

    public function view_add_entry($ei = 0)
    {
        $entry = false;
        $tagids_attached = array();
        $tag_classes = array('btn-primary', 'btn-default', 'btn-warning', 'btn-info');

        if(!empty($ei))
        {
            $entry = Entry::find($ei);
            if(!$entry)
                return redirect()->route('manage_entry_list')->with(['fail'=>'Entry not found!']);

            foreach($entry->tags as $tag)
                $tagids_attached[] = $tag->id;
        }

        $tags = Tag::whereNotIn('id', $tagids_attached)->orderBy('name','asc')->get();

        return view('entries.add',['entry'=>$entry, 'tags' => $tags, 'tag_classes' => $tag_classes]);
    }

    public function entry_delete($ei)
    {
        if(!Auth::check())
        {
            return redirect()->route('entry_list')->with(['fail'=>'Unauthorized access!']);
        }
        $entry = Entry::find($ei);
        if(!$entry)
            return redirect()->route('manage_entry_list')->with(['fail'=>'Entry not found!']);
        $entry->delete();
        return redirect()->route('manage_entry_list')->with(['success'=>'Entry deleted!']);

    }
}
