<?php

namespace App\Http\Controllers;

use App\File;
use App\Imports\ProductsImport;
use App\Prices;
use App\TmpPrices;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Upload;
use Maatwebsite\Excel\Facades\Excel;
use thiagoalessio\TesseractOCR\TesseractOCR;


class FileController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function parse(Request $request)
    {
        $request->validate([
            'file_toParse'=>'required'
        ]);


        $filename = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix('files/'.$request->get('file_toParse'));
        $recognitionData='';
        if (!$filename || !file_exists($filename)) {
            return back()->with('message', 'Your file is Not submitted Successfully');
        }
        elseif (strpos(pathinfo($filename,PATHINFO_EXTENSION),'xls')!==false)
        {
            $recognitionData=$this->xlsParse($filename);
        }
        elseif (strpos(pathinfo($filename,PATHINFO_EXTENSION),'doc')!==false)
        {
            dd(pathinfo($filename,PATHINFO_EXTENSION));
        }
        elseif (strpos(pathinfo($filename,PATHINFO_EXTENSION),'pdf')!==false)
        {
            $recognitionData=$this->pdfParse($filename);
        }
        auth()->user()->files()->create([
            'filename'=>$request->get('file_toParse')
        ]);
        return view('table_corrector',compact('recognitionData'));
        return back()->with('message', 'Your file is submitted Successfully');
    }
    /**
     * XLS Parser function
     */
    private function xlsParse(string $path)
    {
        $lines=[];
        for ($i=0;$i<count(Excel::toArray(new ProductsImport, $path)[0]);$i++)
        {
            $lines[$i]=Excel::toArray(new ProductsImport, $path)[0][$i];
            $lines[$i][9]=Prices::whereRaw('? % product',[$lines[$i][2]])->get('pricekzt','pricerur','priceusd');
        }
        dd($lines);
        return $lines;
    }
    /**
     * PDF Parser function
     */

    private function pdfParse(string $path){

//        return '\"C:\Program Files\gs\gs9.27\bin\gswin64c.exe\" -dSAFER -sDEVICE=png16m -dINTERPOLATE -dNumRenderingThreads=8 -r400 -o \"'.pathinfo($filename,PATHINFO_DIRNAME)."/".pathinfo($filename,PATHINFO_FILENAME).'%d.png\" -c 30000000 setvmthreshold -f '.'\"'.$filename.'\"';
        exec('"C:\Program Files\gs\gs9.27\bin\gswin64c.exe" -dSAFER -sDEVICE=png16m -dINTERPOLATE -dNumRenderingThreads=8 -r400 -o "'.pathinfo($path,PATHINFO_DIRNAME)."/".pathinfo($path,PATHINFO_FILENAME).'%d.png" -c 30000000 setvmthreshold -f '.'"'.$path.'"');

        $files = glob(pathinfo($path,PATHINFO_DIRNAME)."/".pathinfo($path,PATHINFO_FILENAME)."*.png");
        $text="";
        $tessAPI=new TesseractOCR();
//            $tessAPI->executable('/path/to/tesseract')
        $tessAPI->lang('rus','eng');
        foreach ($files as $file)
        {
            $text.=$tessAPI->image($file)
                ->run();
            unlink($file);
        }
        $text=preg_replace("/(\s|\r|\n){2,}/","\n",$text);
//        get three_or_more char contains lines from $text
        $text = preg_replace('/^.{0,2}$[\r\n]*/m', '', $text);
        return explode("\n", $text);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function getUsers()
    {
        $users = User::all();

    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function updateUser(Request $request)
    {
        User::find($request->pk)->update([$request->name => $request->value]);
        return response()->json(['success'=>'done']);
    }

    public function upload(Request $request)
    {
        $uploadedFile = $request->file('file');
        $filename = time().$uploadedFile->getClientOriginalName();

        Storage::disk('local')->putFileAs(
            'files/',
            $uploadedFile,
            $filename
        );

        $upload = new Upload;
        $upload->filename = $filename;
        $upload->user()->associate(auth()->user());
        $upload->save();

        $resp_id=$upload->id;
        return response()->json([
            'id' => $upload->id,
            'filename'=>$filename,
        ]);
    }
}