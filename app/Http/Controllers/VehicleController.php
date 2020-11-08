<?php

    namespace App\Http\Controllers;
    use App\Models\Transport;
    use App\Models\Vehicle;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Validator;

    class VehicleController extends Controller
    {

        public function index()
        {
            $vehicles = Vehicle::all();
            return view('admin.vehicles.list')->with('vehicles', $vehicles);
        }

        public function showReport($id)
        {
            $transport = Transport::all();
            $vehicle = Vehicle::find((int)$id);

            return view('admin.vehicles.report')->with('transport', $transport)->with('vehicle', $vehicle);

        }

        public function create()
        {
            return view('admin.vehicles.add');
        }

        public function store(Request $request)
        {
            $data = $request->all();

            $validation = Validator::make($data, [
                'plateNumber' => 'required',
                'capacity'    => 'required'
            ]);

            if ($validation->fails()) {
                return Redirect::route('getAddVehicle')->withErrors($validation)->withInput();
            } else {

                $vehicle = vehicle::create([
                    'plateNumber' => $request->get('plateNumber'),
                    'capacity'    => $request->get('capacity')
                ]);
                if ($vehicle) {
                    return Redirect::route('getVehicles')->with('success', 'Vehicle added successfully');
                } else {
                    return Redirect::route('getVehicles')->with('fail', 'An error occurred while creating a new vehicle');
                }
            }
        }

        public function show($id)
        {
            //
        }

        public function edit($id)
        {

            return view('admin.vehicles.edit')->with('data', Vehicle::find($id));
        }

        public function update(Request $request)
        {

            $id = (int)$request->get('id_edit');

            $validation = Validator::make($request->all(), [
                'plateNumber_edit' => 'required',
                'capacity_edit'    => 'required'
            ]);

            if ($validation->fails()) {
                return Redirect::route('getEditVehicle', $id)->withErrors($validation)->withInput();

            } else {
                $vehicle = Vehicle::find($id);

                $vehicle->plateNumber = $request->get('plateNumber_edit');
                $vehicle->capacity = $request->get('capacity_edit');

                if ($vehicle->save()) {
                    return Redirect::route('getVehicles')->with('success', 'Vehicle edited successfully');
                } else {
                    return Redirect::route('getVehicles')->with('fail', 'There was an error editing the vehicle');
                }

            }


        }

        public function destroy($id)
        {
            $vehicle = Vehicle::find($id);

            $vehicle->delete();

            return Redirect::route('getVehicles')->with('success', 'Vehicle deleted successfully');
        }


    }
