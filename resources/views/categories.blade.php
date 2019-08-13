@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th><strong> Word: </strong></th>
                    <th><strong> Select category: </strong></th>
                    <th><strong></strong></th>
                    <th><strong> New category: </strong></th>
                    <th><strong></strong></th>
                    <th><strong></strong></th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($words as $word)
                        <tr>
                            <td> {{$word->name}} </td>
                            <td>
                                <form id="select-form" class="form-inline" method="POST" action="{{ route('select_category') }}">
                                    @csrf
                                    <select id="category_id" name="category_id">
                                        <option value="" disabled selected hidden>Select category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="word_id" name="word_id" value={{ $word->id }}}>
                                </form>
                            </td>
                            <td>
                                <button type="submit" form="select-form" value="Submit" class="btn btn-success">Select</button>
                            </td>
                            <td>
                                <form id="create-form" class="form-inline" method="POST" action="{{ route('create_category') }}">
                                    @csrf
                                    <input type="text" id="category" name="category"><br>
                                    <input type="hidden" id="word_id" name="word_id" value={{ $word->id }}>
                                </form>
                            </td>
                            <td>
                                <button type="submit" form="create-form" value="Submit" class="btn btn-success">Create</button>
                            </td>
                            <td>
                                <a href="/discard_word/{{ $word->id }}" class="btn btn-danger">Discard</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
