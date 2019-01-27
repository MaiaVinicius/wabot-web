@extends('template.base')

@section('content')

    <div class="container-fluid">


        <div class="row">

            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title">Log de ações</h4>
                        <p class="card-category">Detalhamento as ações realizadas</p>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-info">
                            <tr>
                                <th>Projeto</th>
                                <th>Data e hora</th>
                                <th>Tipo</th>
                                <th>Mensagem</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td><strong>{{$log["projectName"]}}</strong></td>
                                    <td>{{$log["datetime"]}}</td>
                                    <td>{{$log["type"]}}</td>
                                    <td><small>{{$log["message"]}}</small></td>
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