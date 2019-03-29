<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Upload;
use Smalot\PdfParser\Parser;

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
        // Parse pdf file and build necessary objects.
        $parser = new Parser();
        $pdf = $parser->parseFile($filename);
        // Retrieve all pages from the pdf file.
        $pages = $pdf->getPages();
        // Loop over each page to extract text.
        $text = "";
        foreach ($pages as $page) {
            $text .= $page->getText();
        }
        return $text;
        auth()->user()->files()->create([
            'filename'=>$request->get('file_toParse')
        ]);

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