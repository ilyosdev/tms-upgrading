<?php

    namespace App\Http\Controllers;

    use App\Models\Expense;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\MessageBag as MessageBag;

    class ExpenseController extends Controller
    {
        public function index()
        {

            return view('admin.expense.list')->with('expenses', Expense::all());
        }

        public function create()
        {

            return view('admin.expense.add')->with('cashInHand', Expense::cashInHand());
        }

        public function store(Request $request)
        {
            $data = $request->all();

            $validation = Validator::make($data, [
                'description' => 'required|min:3',
                'memo'        => '',
                'amount'      => 'required|numeric',
                'quantity'    => 'required|numeric'
            ]);

            $errorMessages = new MessageBag;

            if ($validation->fails()) {
                $errorMessages->merge($validation->errors()->toArray());
            }

            //$cash = new Expense;

            $cashInHand = Expense::cashInHand();

            $ex = ($data['amount'] * $data['quantity']);

            if ($ex > $cashInHand) {
                $errorMessages->add('amount', 'You cannot make an expense exceeding cash in hand');
            }

            //return dd($errorMessages);
            //die;

            if (count($errorMessages) > 0) {
                return Redirect::route('getAddExpense')
                    ->withInput()
                    ->withErrors($errorMessages);
            } else {
                $expense = Expense::create([
                    'description' => $data['description'],
                    'amount'      => $data['amount'],
                    'memo'        => $data['memo'],
                    'quantity'    => $data['quantity']
                ]);

                if ($expense) {
                    return Redirect::route('getExpenses')->with('success', 'Expense added successfully');
                } else {
                    return Redirect::route('getExpenses')->with('fail', 'An error occured while saving the expense');
                }
            }
        }

        public function show($id)
        {
            //
        }

        public function edit($id)
        {

            return view('admin.expense.edit')->with('data', Expense::find($id))->with('cashInHand', Expense::cashInHand());
        }

        public function update(Request $request)
        {
            $id = $request->get('id');

            $validation = Validator::make($request->all(),
                [
                    'description' => 'required',
                    'memo'        => '',
                    'amount'      => 'required|numeric',
                    'quantity'    => 'required|numeric'
                ]);

            $errorMessages = new MessageBag;

            if ($validation->fails()) {
                $errorMessages->merge($validation->errors()->toArray());
            }

            $data = $request->all();

            $cashInHand = Expense::cashInHand();

            $ex = ($data['amount'] * $data['quantity']);

            if ($ex > $cashInHand) {
                $errorMessages->add('amount', 'You cannot make an expense exceeding cash in hand');
            }

            if (count($errorMessages) > 0) {
                return Redirect::route('getExpenses')
                    ->withInput()
                    ->withErrors($errorMessages)
                    ->with('modal', '#myModal');
            } else {
                $expense = Expense::find($id);

                $expense->description = $request->get('description');
                $expense->memo = $request->get('memo');
                $expense->amount = $request->get('amount');
                $expense->quantity = $request->get('quantity');

                if ($expense->save()) {
                    return Redirect::route('getExpenses')->with('success', 'Edited successfully');
                } else {
                    return Redirect::route('getExpenses')->with('fail', 'An error ocurred while editing the expense');
                }
            }
        }

        public function destroy($id)
        {
            $expense = Expense::find($id);

            $expense->delete();

            return Redirect::route('getExpenses')->with('success', 'Expense was deleted');
        }
    }
