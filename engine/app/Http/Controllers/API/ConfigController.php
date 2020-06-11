<?php

namespace App\Http\Controllers\API;

use App\Config;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConfigCollection;
use App\Http\Resources\ConfigItem;
use Illuminate\Http\Request;

class ConfigController extends Controller
{

    private $_success_status = 200;
    private $_not_found_status = 400;
    private $_folder;

    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->_folder = storage_path('app\\public\\configs');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ConfigCollection(Config::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Config::rules(false));
        
        $cek = Config::where('header','LIKE',"'%%'")->first();
        
        $header_name = str_replace(" ", "_", $request->header->getClientOriginalName());
        $footer_name = str_replace(" ", "_", $request->footer->getClientOriginalName());

        if (!$cek) {

            $create = Config::create([
                'header' => $header_name,
                'header_original_name' => $request->header->getClientOriginalName(),
                'footer' => $footer_name,
                'footer_original_name' => $request->footer->getClientOriginalName(),
            ]);

            $request->header->move($this->_folder, $header_name);
            $request->footer->move($this->_folder, $footer_name);

            if (!$create) {
                return [
                    'message' => 'Bad Request',
                    'code' => $this->_not_found_status,
                ];
            } else {
                return [
                    'message' => 'OK',
                    'code' => $this->_success_status,
                ];
            }
        } else {
            
            //Hapus data header sebelumnya
            if($cek->header != null ){
                try {
                    unlink($this->_folder.'/'.$cek->header);
                } catch (\Throwable $th) {
                    //throw $th;
                }    
            }

            //Hapus data footer sebelumnya
            if($cek->footer != null ){
                try {
                    unlink($this->_folder.'/'.$cek->footer);
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }

            //Fill data yang mau di update
            $cek->header = $header_name;
            $cek->footer = $footer_name;
            $cek->header_original_name = $request->header->getClientOriginalName();
            $cek->footer_original_name = $request->footer->getClientOriginalName();
            
            //Mindahin data baru buat header sama footer
            $request->header->move($this->_folder, $header_name);
            $request->footer->move($this->_folder, $footer_name);

            //Save data yang di update
            if (!$cek->save()) {
                return [
                    'message' => 'Bad Request',
                    'code' => $this->_not_found_status,
                ];
            } else {
                return [
                    'message' => 'OK',
                    'code' => $this->_success_status,
                ];
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Config $config
     * @return \Illuminate\Http\Response
     */
    public function show(Config $config)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Config $config
     * @return \Illuminate\Http\Response
     */
    public function edit(Config $config)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Config $config)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Config $config
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Config::find($id);

        if (!$delete) {
            return [
                'message' => 'Bad Request',
                'code' => $this->_not_found_status,
            ];
        } else {
            
            //Hapus data header sebelumnya
            if($delete->header != null ){
                try {
                    unlink($this->_folder.'/'.$delete->header);
                } catch (\Throwable $th) {
                    //throw $th;
                }    
            }

            //Hapus data footer sebelumnya
            if($delete->footer != null ){
                try {
                    unlink($this->_folder.'/'.$delete->footer);
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }

            //Hapus data
            $delete->delete();

            return [
                'message' => 'OK',
                'code' => $this->_success_status,
            ];
        }
    }

    /**
     * Download the specified image resource from storage.
     *
     * @param  Filename $filename
     * @return \Illuminate\Http\Response
     */
    public function download($filename)
    {
        return response()
            ->file($this->_folder."/$filename");
    }
}
