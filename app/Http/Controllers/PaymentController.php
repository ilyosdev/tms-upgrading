<?php

    namespace App\Http\Controllers;

    use App\Models\Payment;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\MessageBag as MessageBag;

    class PaymentController extends Controller
    {

        public function index()
        {
            //$payments	=	Payment::fetchAll();

            $payments = Payment::all();

            return view('admin.payments.list')->with('payments', $payments);
        }

        public function create()
        {
            return view('admin.payments.add');
        }

        public function store(Request $request)
        {

            $validation = Validator::make($request->all(), [
                'client_id'    => 'required',
                'amount'       => 'required|numeric',
                'mode'         => 'required',
                'chequeName'   => '',
                'chequeNumber' => ''
            ]);

            $errorMessages = new MessageBag;


            if ($validation->fails()) {
                $errorMessages->merge($validation->errors()->toArray());
            }

            if ($request->has('mode')) {
                if ($request->get('mode') == 'cash') {
//                    if ($request->has('chequeNumber') || $request->has('chequeName')) {
//                        $errorMessages->add('mode', 'You cannot put cheque details on cash payments');
//                    }
                } else {
                    if ($request->get('chequeNumber') == '' || $request->get('chequeNumber') == null) {
                        $errorMessages->add('chequeNumber', 'Please enter the Cheque Number');
                    }

                    if ($request->get('chequeName') == '' || $request->get('chequeName') == null) {
                        $errorMessages->add('chequeName', 'Please enter the Cheque Name');
                    }
                }
            }

            if (count($errorMessages) > 0) {
                return Redirect::route('getAddPayment')
                    ->withErrors($errorMessages)
                    ->withInput();
            } else {
                $chequeNumber = ($request->get('chequeNumber') != '') ? $request->get('chequeNumber') : null;
                $chequeName = ($request->get('chequeName') != '') ? $request->get('chequeName') : null;

                $payment = Payment::create([
                    'client_id'    => $request->get('client_id'),
                    'mode'         => $request->get('mode'),
                    'amount'       => $request->get('amount'),
                    'chequeName'   => $chequeName,
                    'chequeNumber' => $chequeNumber
                ]);

                if ($payment) {
                    return Redirect::route('getPayments')->with('success', 'Payments saved successfully');
                }

            }
        }

        public function show($id)
        {
            //
        }

        public function edit($id)
        {

            return view('admin.payments.edit')->with('data', Payment::find($id));
        }

        public function update(Request $request)
        {

            $validation = Validator::make($request->all(), [
                'client_id_edit'    => 'required',
                'amount_edit'       => 'required|numeric',
                'mode_edit'         => 'required',
                'chequeName_edit'   => '',
                'chequeNumber_edit' => 'numeric'
            ]);

            $errorMessages = new MessageBag;


            if ($validation->fails()) {
                $errorMessages->merge($validation->errors()->toArray());
            }

            if ($request->has('mode_edit')) {
                if ($request->get('mode_edit') == 'cash') {
                    if ($request->has('chequeNumber_edit') || $request->has('chequeName_edit')) {
                        $errorMessages->add('chequeName_edit', 'You cannot put cheque details on cash payments');

                    }
                } else {
                    if ($request->get('chequeNumber_edit') == '' || $request->get('chequeNumber_edit') == null) {
                        $errorMessages->add('chequeNumber_edit', 'Please enter the Cheque Number');

                    }

                    if ($request->get('chequeName_edit') == '' || $request->get('chequeName_edit') == null) {
                        $errorMessages->add('chequeName_edit', 'Please enter the Cheque Name');

                    }
                }
            }

            $id = (int)$request->get('id_edit');

            if (count($errorMessages) > 0) {
                return Redirect::route('getEditPayment', $id)
                    ->withErrors($errorMessages)
                    ->withInput();
            } else {

                $chequeNumber = ($request->get('chequeNumber_edit') != '') ? $request->get('chequeNumber_edit') : null;
                $chequeName = ($request->get('chequeName_edit') != '') ? $request->get('chequeName_edit') : null;

                $payment = Payment::find($id);

                $payment->client_id = $request->get('client_id_edit');
                $payment->mode = $request->get('mode_edit');
                $payment->amount = $request->get('amount_edit');
                $payment->chequeName = $chequeName;
                $payment->chequeNumber = $chequeNumber;


                if ($payment->save()) {
                    return Redirect::route('getPayments')->with('success', 'Payments edited successfully');
                }

            }

        }

        public function destroy($id)
        {
            $payment = Payment::find($id);

            if ($payment->delete()) {
                return Redirect::route('getPayments')->with('success', 'Payment deleted successfully');
            }
        }


    }
