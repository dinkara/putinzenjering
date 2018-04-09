<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
        <style>
            .padding-bottom-0{
                padding-bottom:0px;
            }
            .border-bottom{
                border-bottom:2px solid black;
            }
            .mr20{
                margin-right: 20px;
            }
            .ml20{
                margin-left: 20px;
            }
            @page {
                header: page-header;
                footer: page-footer;
            }
            body {
                font-family: DejaVu Sans;
            }
            
            .no-border, .no-border tr, .no-border td {
                border:none !important;
            }
            .page-break {
                page-break-after: always;
            }
        </style>
    </head>
    <body>
        @foreach ($reviews as $review)
        <div class="container is-fullwidth">
            <htmlpageheader name="page-header">
                <div class="columns">
                    <div class="column has-text-left" style="margin-top: 20px;margin-left: 20px">
                        <figure class="">
                          <img src="http://putinzenjering.com/wp-content/uploads/2017/10/Logo-putinzenjering.jpg">
                        </figure>
                    </div>
                </div>
            </htmlpageheader>
            <div class="has-text-centered">
                <p class="title is-3" style="margin-bottom: 10px">Ček lista ispravnosti bloka</p>
            </div>
          
            <table class="ml20 table is-fullwidth no-border">                    
                    <tbody>
                        <tr>                            
                          <td>Naziv elementa/oznaka: <b>{{$review->order->description . " / " . $review->position}}</b></td>                            
                            <td>Datum: <b>{{Carbon\Carbon::parse($review->created_at)->format('d-m-Y')}}</b></td>
                        </tr>
                        <tr>
                            <td>Za objekat: <b>{{$review->order->project->name}}</b></td>                            
                            <td>Oznaka: <b>{{Carbon\Carbon::parse($review->created_at)->format('d.m')}}</b></td>
                        </tr>
                    </tbody>
            </table>
          
            <div style="margin: 20px">
                <table class="table is-fullwidth is-bordered">
                    <thead>
                        <tr>
                            <th>Pitanje</th>
                            <th>Ispravnost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($review->questions as $question)
                            <tr>
                                <th>{{$question->text}}</th>
                                <td>{{$question->pivot->status ? 'Ispravno' : 'Neispravno'}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>            

            <div style="margin: 20px">
                <label class="label is-title is-3">Komentar</label>
                <table class="table is-fullwidth is-bordered">                   
                    <tbody>
                        <tr>                                
                            <td class="has-text-justified">{{$review->description}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

          <div class="columns ml20 mr20">
                <div class="column is-12 is-pulled-right">
                  <p class="label is-title is-3">Ček listu popunio</p>                  
                  <p>{{$review->user->profile->name}}</p>
                </div>                
          </div>
        </div>
        <div class="page-break"></div>
        @endforeach
    </body>
</html>