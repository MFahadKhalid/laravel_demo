<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use File;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Blog';
        $data['userBlogs'] = Blog::where('user_id' , auth()->user()->id)->orderBy('created_at' , 'DESC')->get();
        $data['blogs'] = Blog::orderBy('created_at' , 'DESC')->get();
        return view('pages.blog.index' ,$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'Create Blog';
        $data['blogs'] = Blog::get();
        $data['categories'] = Category::where('status',1)->get();
        return view('pages.blog.create' ,$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required|max:255',
            'short_description' => 'required|max:8000',
            'long_description' => 'required',
            'image' => 'required|image',
            'status' => 'required',
        ]);
        if($request->file('image')){
            $image = $request->file('image');
            $imageName = 'blog' . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/blog/', $imageName);
        }
        $store = Blog::create([
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'image' => $imageName,
            'status' => $request->status,
        ]);
        if(!empty($store->id)){
            return redirect()->route('blog.index')->with('success','Blog created');
        }
        else{
            return redirect()->back()->with('error','Something Went Wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data['title'] = 'View Blog';
        $data['blog'] = Blog::where('id',$id)->first();
        return view('pages.blog.show' ,$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['title'] = 'Edit Blog';
        $data['categories'] = Category::where('status',1)->get();
        $data['blog'] = Blog::where('id',$id)->firstorfail();
        return view('pages.blog.edit' ,$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request ,$id)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required|max:255',
            'short_description' => 'required|max:8000',
            'long_description' => 'required',
            'image' => 'image',
            'status' => 'required',
        ]);
        $imageData = Blog::where('id',$id)->firstorfail();
        $imageName = null;
        if ($request->hasFile('image')) {
            $path = 'storage/blog/'.$imageData->image;
            if(File::exists($path)){
                File::delete($path);
            }
            $image = $request->file('image');
            $imageName = 'blog'. '-'. time(). '.'. $image->getClientOriginalExtension();
            $image->move('storage/blog/',$imageName);
        } else {
            $imageName = $imageData->image;
        }

        $update = Blog::where('id',$id)->update([
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'image' => $imageName,
            'status' => $request->status,
        ]);
        if($update){
            return redirect()->route('blog.index')->with('success' , 'Blog updated');
        }else{
            return redirect()->back()->with('error' , 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        $path = 'storage/blog/'.$blog->image;
        if(File::exists($path)){
            File::delete($path);
        }
        $blog->delete();
        if($blog){
            return redirect()->back()->with('success' , 'Blog deleted');
        }else{
            return redirect()->back()->with('error' , 'Something went wrong');
        }
    }
}
