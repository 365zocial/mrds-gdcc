<?php

namespace App\Http\Controllers\Wording;

use Auth;
use Response;
use Session;
use Illuminate\Http\Request;

use App\Model\AllMean;
use App\Model\System_Log;

use App\Model\PictureBox;

trait T_Picturebox {

    //Sorawit
    //Created : 21-2-60
    //Modified : -
    public function pictureBox(){
      $data = PictureBox::get();

      return view('staff.wording.picture_box.picture_box', compact('data'));
    }

    //Sorawit
    //Created : 21-2-60
    //Modified : -
    public function doUpdatePictureBox( Request $request, $id ){
      if ( $request->hasFile('picture_file') ) {

          // get old data for log
          $old_data = PictureBox::where('id', $id)->first();

          $file = $request->picture_file;
          $destinationPath = 'assets/images/first_page_record/';
          $fileName = 'login_page_'.uniqid().'.'.$file->getClientOriginalExtension();
          $file->move($destinationPath, $fileName);
          $path_pic = $fileName;

          $lastId = PictureBox::doUpdatePictureBox( $id, $path_pic );

          // get new data for log
          $new_data = PictureBox::where('id', $lastId)->first();


          if ( $lastId ) {
              System_Log::Loging( 'picture_boxes', // table_name
                                  $lastId, // row_id
                                  AllMean::defineEdit(),  // action
                                  $old_data->toArray(), // old_data
                                  $new_data->toArray() ); // new_data
          }
      }

      return redirect('staff/wording/pictureBox')->with('success', 'Update Success !!!');
    }

}