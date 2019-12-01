@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-left">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Categorias</div>

                <div class="card-body">
                    <categorias />
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Articulos</div>

                <div class="card-body">
                    <articulos />
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
