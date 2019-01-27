@extends('template.base')

@section('content')

    <div class="container-fluid">


        <div class="row">

            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title">Últimos envios</h4>
                        <p class="card-category">Mensagens disparadas recentemente</p>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                            <tr>
                                <th>Projeto</th>
                                <th>Data e hora</th>
                                <th>Número</th>
                                <th>Mensagem</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lastSent as $sentMessage)
                                <tr>
                                    <td><strong>{{$sentMessage["projectName"]}}</strong></td>
                                    <td>{{$sentMessage["datetime"]}}</td>
                                    <td>{{$sentMessage["phone"]}}</td>
                                    <td><small>{{$sentMessage["message"]}}</small></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="stats float-right">
                            <a href="#pablo">Ver todas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection