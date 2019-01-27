@extends('template.base')

@section('content')

    <div class="container-fluid">


        <div class="row">

            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title">Interações com {{$phone}}</h4>
                        <p class="card-category">Mensagens enviadas e recebidas</p>
                    </div>
                    <div class="card-body table-responsive" style="padding-top: 30px">
                        <div class="">
                            @php($lastDate="")

                            @foreach($messages as $message)
                                @php($date=date("d/m/Y", strtotime($message["datetime"])))

                                @if($date!==$lastDate)

                                    <div class="text-center">
                                        <h4 class="text-center"><strong>{{$date}}</strong></h4>
                                    </div>
                                @endif

                                @php($lastDate=$date)

                                <div style="
                                        float: {{$message["from_me"] === 1 ? "right" : "left"}};
                                        margin-top: 20px;
                                        width: 60%;
                                        ">

                                    <div style="background-color: #f5f5f5;
                                        border-radius: 10px;
                                        padding: 20px ;">
                                        <div>
                                            <strong style="color: #363636">
                                                {{$message["from_me"] === 1 ? $message["projectName"] : $phone}}
                                            </strong>
                                            <br>
                                        </div>

                                        {{$message["message"]}}

                                    </div>

                                    <div style="
                                        float: right">
                                        <small style="color: #9f9f9f">{{date("H:i", strtotime($message["datetime"]))}}</small>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection