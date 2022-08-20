@extends('layouts.app')
<form method="POST" action="{{ route("getFarmer") }}" class="space-y-5 mt-5 card ml-5" >
    @csrf
    <h1 class="ml-5 pl-5"> Number</h1>
    <div class="card-body shadow w-50">
        <input name="farmer" type="text" class="w-full h-12 border border-gray-800 rounded px-3 w-50 ml-5" placeholder="Phone_number" />

{{--        @error('phone_number')--}}
{{--        <p class="text-red-500">{{ $message }}</p>--}}
{{--        @enderror--}}

        <button type="submit" class="text-center w-full bg-blue-900 rounded-md text-white py-3 font-medium w-50 ml-5 mt-3">Войти</button>
</div>

</form>
