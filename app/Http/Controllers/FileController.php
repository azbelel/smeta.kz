<?php

namespace App\Http\Controllers;

use App\Prices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Upload;
use Org_Heigl\Ghostscript\Ghostscript;
use thiagoalessio\TesseractOCR\TesseractOCR;

class FileController extends Controller
{
    public function parse(Request $request)
    {
        $request->validate([
            'file_toParse'=>'required'
        ]);

        $filename = Storage::disk('local')->getDriver()->getAdapter()->applyPathPrefix('files/'.$request->get('file_toParse'));

        if (!$filename || !file_exists($filename)) {
            return back()->with('message', 'Your file is Not submitted Successfully');
        }
//        return '\"C:\Program Files\gs\gs9.27\bin\gswin64c.exe\" -dSAFER -sDEVICE=png16m -dINTERPOLATE -dNumRenderingThreads=8 -r400 -o \"'.pathinfo($filename,PATHINFO_DIRNAME)."/".pathinfo($filename,PATHINFO_FILENAME).'%d.png\" -c 30000000 setvmthreshold -f '.'\"'.$filename.'\"';
        exec('"C:\Program Files\gs\gs9.27\bin\gswin64c.exe" -dSAFER -sDEVICE=png16m -dINTERPOLATE -dNumRenderingThreads=8 -r400 -o "'.pathinfo($filename,PATHINFO_DIRNAME)."/".pathinfo($filename,PATHINFO_FILENAME).'%d.png" -c 30000000 setvmthreshold -f '.'"'.$filename.'"');
//            $gs=new Ghostscript();
//            Ghostscript::setGsPath('C:\Program Files\gs\gs9.26\bin\gswin64c.exe');
//            $gs->setDevice('png')
//                ->setInputFile($filename)
//                ->setOutputFile(pathinfo($filename,PATHINFO_FILENAME)."%d.png")
//                ->setResolution(200, 200)
//                ->setTextAntiAliasing(Ghostscript::ANTIALIASING_HIGH);
//            //$gs->getDevice()->setQuality(300);
//            $gs->render();
        $files = glob(pathinfo($filename,PATHINFO_DIRNAME)."/".pathinfo($filename,PATHINFO_FILENAME)."*.png");
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
        dd($text);
        foreach ((explode("\n", $text)) as $line)
        {
            $price= Prices::whereRaw(" '".$line."' % \"pricekzt\"")->get();
        }
        auth()->user()->files()->create([
            'filename'=>$request->get('file_toParse')
        ]);

        return view('');
        return back()->with('message', 'Your file is submitted Successfully');
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