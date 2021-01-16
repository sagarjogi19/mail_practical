<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\User;
use App\Http\Requests\StoreMailRequest;
use Illuminate\Support\Arr;
use DB;

class MailController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if ($request->ajax()) {
            $user_id=Auth::user()->id;
            $data = Mail::with('lastthread')->where('to_user_id',$user_id)->groupBy('parent_id')->orderBy('created_at', 'desc')->get();
            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('subject', function($row) use($user_id){
                                if(isset($row->lastthread)) {
                                        $id=$row->lastthread->id;
                                        $status=($row->lastthread->from_user_id==$user_id)?1:$row->lastthread->is_read;
                                        $subject=$row->subject;
                                } else {
                                        $id=$row->id;
                                        $status=$row->is_read;
                                       
                                }
                                 $subject=$row->subject;
                                    if($status==0)
                                        return '<a href="'.route('admin.inbox.show', be64($row->id)).'" style="color:black;"><b>'.$subject.'</b></a>';
                                    else
                                        return $subject;
                            })
                            ->addColumn('action', function($row) use($user_id) {
                                if(isset($row->lastthread)) {
                                        $id=$row->lastthread->id;
                                        $status=($row->lastthread->from_user_id==$user_id)?1:$row->lastthread->is_read;
                                } else {
                                        $id=$row->id;
                                        $status=$row->is_read;
                                }
                                $btn = '<a href="' . route('admin.inbox.show', be64($row->id)) . '" id="edit-mail" class="btn btn-xs btn-primary" title="view"><i class="glyphicon glyphicon-edit"></i>View</a>&nbsp;';
                                if($status==0)
                                    $text='Read';
                                else
                                    $text='Unread';
                                $btn .= '<a href="javascript:;" id="read-mail" data-id="'.be64($id).'"  data-status="'.$status.'" class="btn btn-xs btn-warning">Mark '.$text.'</a>';
                                return $btn;
                            })
                            ->rawColumns(['action','subject'])
                            ->make(true);
        }
        return view('admin.mails.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
         $users=User::all()->except(Auth::id());
         return view('admin.mails.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMailRequest $request) {
        $input = $request->all();
        $input = Arr::except($input, ['_token']);
        $input['from_user_id']=Auth::id();
        $mail = Mail::create($input);
        if(!isset($input['parent_id']))
            Mail::whereId('parent_id')->update(['parent_id' => $mail->id ]);
        return redirect()->route('admin.inbox.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        Mail::whereId(bd64($id))->update(['is_read' => '1']);
        $mails = Mail::with('from','thread','lastthread')->whereId(bd64($id))->first();
        //dd($mails);
        return view('admin.mails.show', ['mails' => $mails]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
    
    public function reply($mail_id) {
        $mails = Mail::with('from','to','thread')->whereId(bd64($mail_id))->first();
        return view('admin.mails.reply', ['mails' => $mails]);
    }
    
    public function sentItems(Request $request) {
        if ($request->ajax()) {
            $user_id=Auth::user()->id;
            $data = Mail::where('from_user_id',$user_id)->orderBy('id', 'desc')->get();

            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('subject', function($row) {
                                if($row->is_read==0)
                                    return '<a href="'.route('admin.inbox.show', be64($row->id)).'" style="color:black;"><b>'.$row->subject.'</b></a>';
                                else
                                    return $row->subject;
                            })
                            ->addColumn('action', function($row) {
                                $btn = '<a href="' . route('admin.inbox.show', be64($row->id)) . '" id="edit-mail" class="btn btn-xs btn-primary" title="view"><i class="glyphicon glyphicon-edit"></i>View</a>';
                                return $btn;
                            })
                            ->rawColumns(['action','subject'])
                            ->make(true);
        }
        return view('admin.mails.sent-items');
    }
    
     public function read(Request $request) {
            $id = bd64($request->id);
            $status = ($request->status=='0')?1:0;
            Mail::whereId($id)->update(['is_read'=>$status]);
            if($status){
                $message = __('global.mail_mark_read_successfully'); 
            }else{
                $message = __('global.mail_mark_unread_successfully'); 
            }

            return response()->success($message); 
     }

}
