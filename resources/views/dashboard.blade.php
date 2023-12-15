@extends('app')

@section('content')
<div class="row">       
    <div class="col-sm-6">
        <div class="card mb-4 text-white bg-success">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div class="col-7 px-1">
                    <div class="fw-500 h4">Realizar Pedido</div>
                </div>
                <div class="col-5 px-1 d-flex justify-content-end">
                    <img src="./img/realizar-pedido.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card mb-4 text-white bg-info">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div class="col-7 px-1">
                    <div class="fw-500 h4">Canjear Pedido</div>
                </div>
                <div class="col-5 px-1 d-flex justify-content-end">
                    <img src="./img/registrar-venta.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <dashboard></dashboard>
</div>
@endsection