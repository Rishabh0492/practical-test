<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Product::create([
            "name"=>$request->name,
            "quantity"=>$request->quantity,
            "manufacture_date"=>$request->manufactureDate,
        ]);
        Session::flash('message', 'Product is stored successfully!');
        return redirect('/all-products');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=Product::find($id);
        return view('product.edit',compact('product'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product = Product::find($request->id);
        $product->name=$request->name;
        $product->quantity=$request->quantity;
        $product->manufacture_date=$request->manufactureDate;
        $product->save();
        Session::flash('message', 'Product is updated successfully!');
        return redirect('/all-products');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item =Product::find($id);
        $item->delete();

        Session::flash('message', 'Product is deleted successfully'); 
        return redirect('/all-products');

    }

    public function getItemData(Request $request)
    {
       
     $columns = array( 
                            0 =>'id', 
                            1 =>'name',
                            2=> 'quantity',
                            3=> 'manufacture_date',
                            4=> 'created_at',
                        );
  
        $totalData = Product::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        { 
            $posts = Product::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        } else {
            $search = $request->input('search.value');
            $posts =  Product::where('name','LIKE',"%{$search}%")
                            ->orWhere('quantity', 'LIKE',"%{$search}%")
                            ->orWhere('manufacture_date', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered = Product::where('name','LIKE',"%{$search}%")
                            ->orWhere('quantity', 'LIKE',"%{$search}%")
                            ->orWhere('manufacture_date', 'LIKE',"%{$search}%")
                             ->count();
        }
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['quantity'] = $post->quantity;
                $nestedData['manufacture_date'] = $post->manufacture_date;
                $nestedData['created_at'] =$post->created_at->format('Y-m-d'); 
                // $nestedData['image'] = "<img src=".$post->image.">";
                // $nestedData['action']="<a>Delete</a>";
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        

   }
}
