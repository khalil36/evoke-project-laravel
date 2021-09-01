@extends('layouts.client-pages')
@section('title', 'Provider')
@section('client-content')

    This is where hcp content will go.  The current team is {{ Auth::user()->currentTeam->name }}.

@endsection

