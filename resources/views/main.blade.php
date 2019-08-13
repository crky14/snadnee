@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th><strong> Sender Account: </strong></th>
                    <th><strong> Receiver Account: </strong></th>
                    <th><strong> Price: </strong></th>
                    <th><strong> Currency: </strong></th>
                    <th><strong> Date: </strong></th>
                    <th><strong> KS: </strong></th>
                    <th><strong> VS: </strong></th>
                    <th><strong> SS: </strong></th>
                    <th><strong> Category: </strong></th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td> {{$transaction->sender_account}} </td>
                            <td> {{$transaction->receiver_account}} </td>
                            <td> {{$transaction->price}} </td>
                            <td> {{$transaction->currency}} </td>
                            <td> {{$transaction->datetime}} </td>
                            <td> {{$transaction->KS}} </td>
                            <td> {{$transaction->VS}} </td>
                            <td> {{$transaction->SS}} </td>
                            @if($transaction->word->category)
                                <td> {{$transaction->word->category->name}} </td>
                            @else
                                <td> not selected </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
