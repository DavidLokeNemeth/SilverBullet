<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePropertyRequest;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Models\Property;
use Illuminate\Support\Str;
use DataTables;
use ImageResize;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $title = "Admin Page";

       return view('admin.index', compact('title'));
    }


    /**
     * Datatable ajax communication channel
     *
     * As see suppose to show the view page link, but commented out because I had no time finish it
     *
     * @param Request $request
     * @return mixed
     */
    public function getProperties(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('properties')
                ->join('property_types', 'property_types.id', '=', 'properties.property_type_id')
                ->select('properties.*', 'property_types.title');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
//                    $actionBtn = '<a href="'.route('admin.show', $row->uuid).'" class="edit btn btn-success btn-sm">View</a>';
                    $actionBtn =' <a href="'.route('admin.edit', $row->uuid).'" class="edit btn btn-primary btn-sm">Edit</a>';
                    $actionBtn .=' <a data-method="DELETE"  href="'.route('admin.destroy', $row->uuid).'" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function create()
    {
        $propertyType = PropertyType::pluck('title', 'id');
        $title = "Add New Property";
        return view('admin.create', compact('title', 'propertyType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePropertyRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreatePropertyRequest $request)
    {

        $image_full = 'None';
        $image_thumbnail = 'None';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid().'.'.$image->extension();

            //This part I should do as separate function I just realized when I tried upload to gitlab

            $img = ImageResize::make($image->path());
            $destinationPath = public_path('1000/400/city');
            $img->resize(1000, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$imageName);
            $image_full = '/1000/400/city/'.$imageName;


            $destinationPath = public_path('100/100/city');
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$imageName);
            $image_thumbnail = '/100/100/city/'.$imageName;

            //Until here public function saveImage($img, $width, $height)
        }

        Property::create(array_merge($request->all(), ['image_full' => $image_full, 'image_thumbnail' => $image_thumbnail ]));

        return redirect('/admin');

    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(string $id)
    {
        $property = Property::findOrFail($id);
        $title = $id;

        return view('admin.show', compact('title', 'property'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $id)
    {
        $propertyType = PropertyType::pluck('title', 'id');
        $property = Property::findOrFail($id);
        $title = $id;

        return view('admin.edit', compact('title', 'property', 'propertyType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreatePropertyRequest $request
     * @param string $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CreatePropertyRequest $request, string $id)
    {
        Property::findOrFail($id)->update($request->all());

        return redirect('/admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function destroy(string $id)
    {
        Property::findOrFail($id)->delete();

        return response('success', 200);
    }
}
