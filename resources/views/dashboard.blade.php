@extends('template.base')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">playlist_play</i>
                        </div>
                        <p class="card-category">Fila de envio</p>
                        <h3 class="card-title">{{ $totalSentToday }}/{{$totalQueueToday}}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-primary">info</i>
                            <a href="{{route("queue")}}">Ver todas...</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">monetization_on</i>
                        </div>
                        <p class="card-category">Ganhos</p>
                        <h3 class="card-title">R$ {{$amountProfit}}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> Últimas {{$quantitySentInterval}} horas
                            &nbsp;<a href="{{route("sent")}}"><strong>({{$quantitySent24hours}})</strong></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">error</i>
                        </div>
                        <p class="card-category">Erros recentes</p>
                        <h3 class="card-title">{{$lastErrors ? "{$lastErrors} erro".($lastErrors>1 ? "s": "") : "Nenhum erro"}}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-danger">warning</i>
                            <a href="{{route("logs")}}">Ver logs</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">reply</i>
                        </div>
                        <p class="card-category">Taxa de resposta</p>
                        <h3 class="card-title">{{$avgRespond}}%</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">update</i> Últimas {{$quantitySentInterval}} horas &nbsp;<a
                                    href="{{route("reply")}}"><strong>({{$quantityRespond}})</strong></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="display: none">
            <div class="col-md-4">
                <div class="card card-chart">
                    <div class="card-header card-header-primary">
                        <div class="ct-chart" id="dailySalesChart"></div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Mensagens enviadas</h4>
                        <p class="card-category">
                            <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> aumento na taxa
                            de envio</p>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">access_time</i> Atualizado 4 minutos atrás
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-chart">
                    <div class="card-header card-header-warning">
                        <div class="ct-chart" id="websiteViewsChart"></div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Respostas recebidas</h4>
                        <p class="card-category">Desde o início</p>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">access_time</i> Atualizado há 4 minutos
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-chart">
                    <div class="card-header card-header-success">
                        <div class="ct-chart" id="completedTasksChart"></div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Rendimento total</h4>
                        <p class="card-category">Soma dos rendimentos</p>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">access_time</i> Atualizado há 4 minutos
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title">Principais campanhas</h4>
                        <p class="card-category">Listagem dos clientes</p>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-info">
                            <tr>
                                <th></th>
                                <th>Projeto</th>
                                <th>Número</th>
                                <th>Status</th>
                                <th>Número de envios</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($projects as $project)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value=""
                                                        {{$project["active"] === 1 ? "checked" : ""}}
                                                >
                                                <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{$project["label"]}}</td>
                                    <td>{{$project["phone"]}}</td>
                                    <td>{{$project["statusName"]}}</td>
                                    <td>{{$project["numberSent"]}}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm"><i class="fa fa-edit"></i></button>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
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
                                    <td>
                                        <a href="{{route("interaction")."?phone={$sentMessage["phone"]}"}}">{{$sentMessage["phone"]}}</a>
                                    </td>
                                    <td>{{substr($sentMessage["message"], 0, 16) . "..."}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="stats float-right">
                            <a href="{{route("sent")}}">Ver todas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection