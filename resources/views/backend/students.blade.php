@extends('backend.master')

@section('content')
<div class="container" id="app">
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Vue.js DataTable Tutorial</h3>
                </div>
            </div>
            <students-index></students-index>
        </div>
    </div>
</div>
@endsection
