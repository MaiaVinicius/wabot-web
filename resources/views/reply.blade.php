@extends('template.base')

@section('content')

    <div class="container-fluid">


        <div class="row">

            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title">Últimas respostas</h4>
                        <p class="card-category">Mensagens recebidas recentemente</p>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                            <tr>
                                <th>Projeto</th>
                                <th>Data e hora</th>
                                <th>Número</th>
                                <th>Tempo para resposta</th>
                                <th>Mensagem</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lastReplies as $reply)
                                <tr>
                                    <td><strong>{{$reply["projectName"]}}</strong></td>
                                    <td>{{$reply["datetime"]}}</td>
                                    <td><a href="{{route("interaction")."?phone={$reply["phone"]}"}}">{{$reply["phone"]}}</a></td>
                                    <td>{{$formatDelay($reply["delayTime"])}}</td>
                                    <td><small>{{$reply["message"]}}</small></td>
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