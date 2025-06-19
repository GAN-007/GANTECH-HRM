<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SupportTicket;
use App\Models\TicketComments;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupportTicketCommentController extends Controller {

	public function index(SupportTicket $ticket)
	{
		if (request()->ajax())
		{
			return datatables()->of(TicketComments::with('user:id,username','employee.department')->where('ticket_id',$ticket->id)->get())
				->setRowId(function ($comment)
				{
					return $comment->id;
				})
				->addColumn('user', function ($row) use ($ticket)
				{
					$username = $row->user->username;
                    $department_name = '';

                    if (isset($row->employee->department->department_name)) {
                        $department_name = ' (' .$row->employee->department->department_name. ')';
                    }
                    return $username . $department_name;

				})
				->addColumn('action', function ($data)
				{
                    if (Auth::user()->role_users_id == 1 || (Auth::user()->id == $data->user_id)) {
                        $button = '<button type="button" name="delete" id="' . $data->id . '" class="delete-comment btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                        return $button;
                    }
				})
				->rawColumns(['action'])
				->make(true);
		}
	}


	public
	function store(Request $request, SupportTicket $ticket)
	{

		$validator = Validator::make($request->only('ticket_comments'),
			[
				'ticket_comments' => 'required',
			]
		);


		if ($validator->fails())
		{
			return response()->json(['errors' => $validator->errors()->all()]);
		}

		$data = [];

		$data['ticket_comments'] = $request->get('ticket_comments');
		$data['user_id'] = auth()->user()->id;
		$data ['ticket_id'] = $ticket->id;

		TicketComments::create($data);

		return response()->json(['success' => __('Data Added successfully.')]);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return Response
	 */
	public
	function destroy($id)
	{

		TicketComments::whereId($id)->delete();

		return response()->json(['success' => __('Data is successfully deleted')]);
	}
}
