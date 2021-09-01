@extends('layouts.client-pages')
@section('title', 'Predict')
@section('client-content')

    This is where Predict content will go.  The current team is {{ Auth::user()->currentTeam->name }}.

@endsection

