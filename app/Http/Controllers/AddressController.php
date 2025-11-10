<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $emailValidator = $this->validateEmail();
        $addressValidator = $this->validateAddress();
        if ($emailValidator->fails() || $addressValidator->fails()) {
            return response()->json(['message' => 'Failed',
                'email' => $emailValidator->messages(),
                'address' => $addressValidator->messages()], 400);
        }

        $user = User::where('email', $request->get('email'))->firstOrFail();

        if ($user->address) {
            return response()->json(['message' => 'User already has an address', 'data' => null], 400);
        }

        $address = new Address($addressValidator->validate());

        if ($user->address()->save($address)) {
            return response()->json(['message' => 'Address Saved', 'data' => $address], 200);
        }

        return response()->json(['message' => 'Failed', 'data' => null], 400);


//        $validator = Validator::make($request->all(), [
//            'user_id' => ['required', 'numeric', 'exists:users,id'],
//            'country' => 'required|string|max:255',
//            'zipcode' => 'required|string|min:5|max:5',
//        ]);
//
//        $user = User::find($request->get('user_id'));
//
//        $address = new Address($addressValidator->validate());
//
//        if ($user->address()->save($address)) {
//
//        }
//
//        if ($validator->fails()) {
//            return response()->json($validator->messages(), 400);
//        }
//
//        $address = User::create([
//            'user_id' => $request->get('user_id'),
//            'country' => $request->get('country'),
//            'zipcode' => $request->get('zipcode'),
//        ]);
//
//        return response()->json(['message'=>'Address Created','data'=>$address],200);
    }

    public function show(Address $address)
    {
        return response()->json(['message'=>'Address shown','data'=>$address],200);
    }
    public function show_user(Address $address) {
        return response()->json(['message'=>'User shown','data'=>$address->user],200);
    }

    public function validateAddress() {
        return Validator::make(request()->all(), [
            'country' => 'required|string|min:1|max:25',
            'zipcode' => 'required|string|min:5|max:6'
        ]);
    }

    public function validateEmail() {
        return Validator::make(request()->all(), [
            'email' => 'required|email|max:255'
        ]);
    }
}
