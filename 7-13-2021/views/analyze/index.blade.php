@extends('layouts.client-pages')
@section('title', 'Analyze')
@section('client-content')

    This is where analyze content will go.  The current team is {{ Auth::user()->currentTeam->name }}.

@endsection

