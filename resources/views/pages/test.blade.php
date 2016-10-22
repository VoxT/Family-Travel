@extends('layouts.master')


@section('content')
{{
     printf('<pre>Data %s</pre>', print_r($result, true)) }}
@endsection