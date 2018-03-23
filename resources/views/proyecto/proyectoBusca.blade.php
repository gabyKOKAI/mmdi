@extends('layouts.master')

@section('content')
    <h1>Search</h1>

    <form method='GET' action='/proyecto/busca'>

        <label for='searchTerm'>Busca por titulo:</label>
		<input type='text' name='searchTerm' id='searchTerm' value='{{ $searchTerm or '' }}'>

		<input type='checkbox' name='caseSensitive' {{ ($caseSensitive) ? 'CHECKED' : '' }} >
        <label>case sensitive</label>

        <br>
        <input type='submit' class='btn btn-primary btn-small'>

    </form>
	
	@if($searchTerm != null)
			<h2>Results for query: <em>{{ $searchTerm }}</em></h2>

			@if(count($searchResults) == 0)
				No matches found.
			@else
       
				@foreach($searchResults as $title => $proyecto)
				<div class='proyecto'>
					<h3>{{ $title }}</h3>
					<h4>by {{ $proyecto['author'] }}</h4>
					<img src='{{ $proyecto['cover_url'] }}'>
				</div>
				@endforeach
			@endif
	@endif
@endsection