@extends('template.base')

@section('content')

    <div class="container-fluid">


        <div class="row">

            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title">Fila de envio -  <strong>{{count($queue)}} mensagens</strong></h4>
                        <p class="card-category">Mensagens aguardando a serem enviadas</p>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                            <tr>
                                <th>Projeto</th>
                                <th>Data</th>
                                <th>Hora</th>
                                <th>Número</th>
                                <th>Mensagem</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($queue as $mesage)
                                <tr>
                                    <td><strong>{{$mesage["projectName"]}}</strong></td>
                                    <td>{{$mesage["send_date"]}}</td>
                                    <td>{{$mesage["send_time"]}}</td>
                                    <td><a href="{{route("interaction")."?phone={$mesage["phone"]}"}}">{{$mesage["phone"]}}</a></td>
                                    <td><small>{{$mesage["message"]}}</small></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection