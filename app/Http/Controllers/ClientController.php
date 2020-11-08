<?php

    namespace App\Http\Controllers;

    use App\Models\Client;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Validator;

    class ClientController extends Controller
    {

        /**
         * Display a listing of the resource.
         *
         * @return Response
         */

        public function index()
        {
            $clients = Client::all();
            return view('admin.clients.list')->with('clients', $clients);
        }

        public function showReport($id)
        {

            $client = Client::find($id);

            $total_payments = $client->allPayments();

            $total_charges = $client->allCharges()->charges;

            $balance = $client->balance();

            return view('admin.clients.report')
                ->with('client', $client)
                ->with('total_payments', $total_payments)
                ->with('total_charges', $total_charges)
                ->with('balance', $balance);
        }

        public function create()
        {
            return view('admin.clients.add');
        }

        public function store(Request $request)
        {
            $data = $request->all();

            $validation = Validator::make($data, [
                'clientName' => 'required|min:3',
                'phone'      => 'required|min:6',
                'address'    => 'required'
            ]);

            if ($validation->fails()) {
                return Redirect::route('getAddClient')->withErrors($validation)->withInput();

            } else {
                $client = Client::create([
                    'name'    => $request->get('clientName'),
                    'phone'   => $request->get('phone'),
                    'address' => $request->get('address')
                ]);
                if ($client) {
                    return Redirect::route('getClients')->with('success', 'Client added successfully');
                } else {
                    return Redirect::route('getClients')->with('fail', 'An error occurred while creating a new client');
                }
            }
        }

        public function show($id)
        {
            //
        }

        public function edit($id)
        {
            $client = Client::find($id);

            return view('admin.clients.edit')->with('data', $client);
        }

        public function update(Request $request)
        {
            $id = (int)$request->get('id_edit');

            $validation = Validator::make($request->all(), [
                'clientName_edit' => 'required|min:5',
                'phone_edit'      => 'required|min:6',
                'address_edit'    => 'required'
            ]);

            if ($validation->fails()) {
                return Redirect::route('getEditClient', $id)->withInput()->withErrors($validation);
            }

            $client = Client::find($id);

            $client->name = $request->get('clientName_edit');
            $client->phone = $request->get('phone_edit');
            $client->address = $request->get('address_edit');

            if ($client->save()) {
                return Redirect::route('getClients')->with('success', 'Client edited successfully');
            } else {
                return Redirect::route('getClients')->with('fail', 'There was an error editing the client');
            }
        }

        public function destroy($id)
        {
            $client = Client::find($id);

            if ($client->balance() > 0) {
                return Redirect::route('getClients')->with('fail', 'Deletion failed. The client has outstanding balance of Ksh: ' . $client->balance());
                die;
            }

            $client->transport()->delete();

            $client->payment()->delete();

            $client->delete();

            return Redirect::route('getClients')->with('success', 'Client deleted successfully');

        }


    }
