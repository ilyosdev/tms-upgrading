<?php

    namespace App\Http\Controllers;
    use App\Models\Transport;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Validator;

    class TransportController extends Controller
    {
        public function index()
        {
            $transports = Transport::all();

            return view('admin.transport.list')->with('transports', $transports);

            //return $transports;
        }

        public function create()
        {
            return view('admin.transport.add');
        }

        public function store(Request $request)
        {
            $data = $request->all();

            $validation = Validator::make($data, [
                'client_id'   => 'required',
                'vehicle_id'  => 'required',
                'destination' => 'required',
                'description' => 'required',
                'tonnes'      => 'required|numeric',
                'charges'     => 'required|numeric',
                'memo'        => ''
            ]);

            if ($validation->fails()) {
                return Redirect::route('getAddTransport')->withErrors($validation)->withInput();

            } else {

                $transport = Transport::create([
                    'client_id'   => $request->get('client_id'),
                    'vehicle_id'  => $request->get('vehicle_id'),
                    'destination' => $request->get('destination'),
                    'description' => $request->get('description'),
                    'tonnes'      => $request->get('tonnes'),
                    'charges'     => $request->get('charges'),
                    'memo'        => $request->get('memo')
                ]);
                if ($transport) {
                    return Redirect::route('getTransport')->with('success', 'Transport added successfully');
                } else {
                    return Redirect::route('getTransport')->with('fail', 'An error occurred while creating a new transport');
                }
            }
        }

        public function show($id)
        {
            //
        }

        public function edit($id)
        {
            $transport = Transport::find($id);

            return view('admin.transport.edit')->with('transport', $transport);
        }

        public function update(Request $request)
        {

            $id = (int)$request->get('id_edit');

            $validation = Validator::make($request->all(), [
                'client_id'   => 'required',
                'vehicle_id'  => 'required',
                'destination' => 'required',
                'description' => 'required',
                'tonnes'      => 'required|numeric',
                'charges'     => 'required|numeric'
                //'memo'			=>	''
            ]);

            $transport = Transport::find($id);

            $transport->client_id = $request->get('client_id_edit');
            $transport->vehicle_id = $request->get('vehicle_id_edit');
            $transport->destination = $request->get('destination_edit');
            $transport->description = $request->get('description_edit');
            $transport->tonnes = $request->get('tonnes_edit');
            $transport->charges = $request->get('charges_edit');
            $transport->memo = $request->get('memo_edit');

            if ($transport->save()) {
                return Redirect::route('getTransport')->with('success', 'Transport edited successfully');
            } else {
                return Redirect::route('getTransport')->with('fail', 'There was an error editing the Transport');
            }
        }

        public function destroy($id)
        {
            $transport = Transport::find($id);

            $transport->delete();

            return Redirect::route('getTransport')->with('success', 'Transport deleted successfully');
        }


    }
